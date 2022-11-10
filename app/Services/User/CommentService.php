<?php

namespace App\Services\User;

use App\Models\Comment;

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
        $comments = Comment::with('users')
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
}
