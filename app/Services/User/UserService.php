<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    public function getProfile() {
        $userId = auth()->id();
        $information = User::where('id', $userId)->first();
        return $information;
    }

    public function getUserProfile(int $userId) {
        $information = User::where('id', $userId)->first();
        return $information;
    }

    public function followUser() {
        
    }
}
