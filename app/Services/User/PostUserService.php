<?php
namespace App\Services\User;

use App\Models\PostUser;

class PostUserService {
    public function getNumberLikeByPost(int $postId) {
        return PostUser::where('post_id', $postId)->count();
    }
}