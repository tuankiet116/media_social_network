<?php

namespace App\Services\User;

use App\Models\Follower;

class FollowService
{
    public function getFollower(int $userId, int $offset)
    {
        $followers = Follower::with('follower:id,name,image,banner')
            ->where('user_id', $userId)
            ->orderBy('created_at')
            ->limit(20)
            ->offset($offset)->get();
        if ($followers->count()) {
            $newOffset = $followers->count() + $offset;
        }
        return [
            'followers' => $followers,
            'offset' => $newOffset ?? null
        ];
    }

    public function getFollowing($userId, $offset)
    {
        $followers = Follower::with('following:id,name,image,banner')
            ->where('follower_id', $userId)
            ->orderBy('created_at')
            ->limit(20)
            ->offset($offset)->get();
        if ($followers->count()) {
            $newOffset = $followers->count() + $offset;
        }
        return [
            'following' => $followers,
            'offset' => $newOffset ?? null
        ];
    }
}
