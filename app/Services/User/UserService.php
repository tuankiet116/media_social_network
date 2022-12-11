<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\Inf\StorageService;

class UserService
{
    private $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function getProfile()
    {
        $userId = auth()->id();
        $information = User::with(['userSchool', 'userInformation'])->where('id', $userId)->first();
        return $information;
    }

    public function getUserProfile(int $userId)
    {
        $information = User::with(['userSchool', 'userInformation'])->where('id', $userId)->first();
        return $information;
    }

    public function followUser($userIdFollow)
    {
    }

    public function getAvatar($fileName)
    {
        return $this->storageService->getImage('/user/avatar/' . $fileName);
    }

    public function getBackground($fileName)
    {
        return $this->storageService->getImage('/user/background/' . $fileName);
    }
}
