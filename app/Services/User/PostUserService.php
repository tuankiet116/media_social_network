<?php

namespace App\Services\User;

use App\Models\PostUser;

class PostUserService
{
    public function getNumberLikeByPost(int $postId)
    {
        return PostUser::where('post_id', $postId)->count();
    }

    public function getUserLikesByPost(int $postId, int $offset = 0)
    {
        $likes = PostUser::with('user:id,name,image')->where('post_id', $postId)
            ->orderBy('created_at', 'DESC')->limit(LIMIT)->offset($offset)->get();
        $newOffset = count($likes) == LIMIT ? $offset + LIMIT : null;
        return array(
            'likes' => $likes,
            'offset' => $newOffset
        );
    }
}
