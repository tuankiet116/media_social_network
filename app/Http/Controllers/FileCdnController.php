<?php

namespace App\Http\Controllers;

use App\Services\User\CommunityService;
use App\Services\User\UserService;

class FileCdnController extends Controller
{
    public $userService;
    public $communityService;

    public function __construct(UserService $userService, CommunityService $communityService)
    {
        $this->userService = $userService;
        $this->communityService = $communityService;
    }

    public function getUserAvatar($fileName)
    {
        return $this->userService->getAvatar($fileName);
    }

    public function getUserBackground($fileName)
    {
        return $this->userService->getBackground($fileName);
    }

    public function getCommunityAvatar($fileName)
    {
        return $this->communityService->getAvatar($fileName);
    }

    public function getCommunityBackground($fileName)
    {
        return $this->communityService->getBackground($fileName);
    }
}
