<?php

namespace App\Services\User;

use App\Models\Comment;
use App\Models\CommentUser;
use App\Models\Post;
use App\Models\UserNotification;
use Illuminate\Support\Facades\Log;
use Modules\User\Events\NotificationEvent;

class CommentService
{
    public function getCommentOfUser(int $id)
    {
        $userID = auth()->id();
        return Comment::where([
            'id' => $id,
            'user_id' => $userID
        ])->first();
    }

    public function createComment($data)
    {
        $parentId = $data['parent_id'];
        $data_create = [
            'post_id' => $data['post_id'],
            'content' => $data['content'],
            'user_id' => auth()->id()
        ];
        if ($parentId) {
            $data_create = $data_create + array('parent_id' => $parentId);
        }
        $result = Comment::create($data_create);
        $comment = Comment::with('users')->find($result->id);
        $userId = auth()->id();
        $post = Post::where('id', $data['post_id'])->first();
        if ($post->user_id != $userId) {
            $notification = UserNotification::create([
                'user_id' => $post->user_id,
                'user_sender_id' => $userId,
                'community_sender_id' => null,
                'comment_id' => $comment->id,
                'post_id' => $post->id,
                'type' => NOTIFICATION_USER_COMMENT_POST
            ]);
            NotificationEvent::dispatch($notification);
        }
        return $comment;
    }

    public function getComments(int $postId, int $offset)
    {
        $comments = Comment::with('users:id,name,image')
            ->withCount('likes')
            ->where([
                'post_id' => $postId,
                'belong_id' => null
            ])
            ->orderBy('created_at', 'DESC');
        if ($offset) {
            $comments = $comments->offset($offset);
        }
        $comments = $comments->limit(LIMIT)->get();
        $lengthComment = $comments->count();
        $newOffset = $offset + $lengthComment;
        return [
            'comments' => $comments,
            'offset' => $newOffset
        ];
    }

    public function deleteComment(int $commentId)
    {
        $comment = $this->getCommentOfUser($commentId);
        Comment::where('belong_id', $commentId)->delete();
        $result = $comment->delete();
        return $result;
    }

    public function likeComment($res)
    {
        $userId = auth()->id();
        $commentId = $res['comment_id'];
        $data = array(
            'user_id' => $userId,
            'comment_id' => $commentId
        );
        $liked = CommentUser::where($data)->first();
        if (!$liked && $res['like'] == true) {
            CommentUser::create($data);
            $comment = Comment::where('id', $commentId)->first();
            if ($comment->user_id != $userId) {
                $notification = UserNotification::create([
                    'user_id' => $comment->user_id,
                    'user_sender_id' => $userId,
                    'community_sender_id' => null,
                    'comment_id' => $commentId,
                    'post_id' => $comment->post_id,
                    'type' => NOTIFICATION_USER_REACT_COMMENT
                ]);
                NotificationEvent::dispatch($notification);
            }
        } else {
            $liked->delete();
        }
        $numberLikes = CommentUser::where('comment_id', $commentId)->count();
        return $numberLikes;
    }

    public function replyComment($req)
    {
        $userID = auth()->id();
        $data = array(
            'content' => $req['content'],
            'belong_id' => $req['belong_id'],
            'user_id' => $userID,
            'post_id' => $req['post_id']
        );
        $comment = Comment::create($data);
        $commentParent = Comment::where('id', $req['belong_id'])->first();
        $post = Post::where('id', $req['post_id'])->first();
        if ($commentParent->user_id != $userID) {
            $notiCommentOwner = UserNotification::create([
                'user_id' => $commentParent->user_id,
                'user_sender_id' => $userID,
                'community_sender_id' => null,
                'comment_id' => $req['belong_id'],
                'post_id' => $comment->post_id,
                'type' => NOTIFICATION_USER_REPLY_COMMENT
            ]);

            NotificationEvent::dispatch($notiCommentOwner);
        }

        if ($post->user_id !== $userID) {
            $notiPostOwner = UserNotification::create([
                'user_id' => $post->user_id,
                'user_sender_id' => $userID,
                'community_sender_id' => null,
                'comment_id' => $req['belong_id'],
                'post_id' => $comment->post_id,
                'type' => NOTIFICATION_USER_REPLY_COMMENT_IN_POST
            ]);

            NotificationEvent::dispatch($notiPostOwner);
        }
        return Comment::with('users')->where('id', $comment->id)->first();
    }

    public function getReplyComments(int $commentId, int $offset = 0)
    {
        $replies = Comment::with('users:id,name,image')
            ->withCount('likes')->where('belong_id', $commentId)->orderBy('created_at')
            ->limit(LIMIT_COMMENT)->offset($offset)->get();
        $ammountReplies = count($replies);
        $newOffset = $offset + $ammountReplies;
        return array('replies' => $replies, 'offset' => $newOffset);
    }

    public function updateComment($req)
    {
        $comment = $this->getCommentOfUser($req['id']);
        if ($comment) {
            $comment->fill([
                'content' => $req['content']
            ]);
            $comment->save();
            return true;
        }
        return false;
    }
}
