<?php

namespace App\Http\Controllers;

use App\Services\User\UserService;

class FileCdnController extends Controller
{
    public $userService;
    
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function getUserAvatar($fileName) {
        return $this->userService->getAvatar($fileName);
    }

    public function getUserBackground($fileName) {
        return $this->userService->getBackground($fileName);
    }
}
