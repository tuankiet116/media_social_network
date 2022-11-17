<?php

namespace App\Services\User;

use App\Models\Comment;
use App\Models\CommentUser;

class CommentService
{
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
        $comment = $this->getComment($result->id);
        return $comment;
    }

    public function getComment(int $id)
    {
        $comment = Comment::with('users')->find($id);
        return $comment;
    }

    public function getComments(int $postId, int $offset)
    {
        $comments = Comment::with('users:id,name,image')
            ->withCount('likes')
            ->where('post_id', $postId)
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
        $userId = auth()->id();
        $comment = Comment::where(['id' => $commentId, 'user_id' => $userId])->first();
        $result = $comment->delete();
        return $result;
    }

    public function likeComment($res)
    {
        $userId = auth()->id();
        $data = array(
            'user_id' => $userId,
            'comment_id' => $res['comment_id']
        );
        $liked = CommentUser::where($data)->first();
        if (!$liked && $res['like'] == true) {
            CommentUser::create($data);
        } else {
            $liked->delete();
        }
        $numberLikes = CommentUser::where('comment_id', $res['comment_id'])->count();
        return $numberLikes;
    }
}
