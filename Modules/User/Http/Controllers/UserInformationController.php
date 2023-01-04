<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\UserService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserInformationController extends Controller
{
    use ApiResponse;

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getProfile()
    {
        $data = $this->userService->getProfile();
        return $this->responseData($data);
    }

    public function getUserProfile(int $userID)
    {
        $data = $this->userService->getUserProfile($userID);
        return $this->responseData($data);
    }

    public function followUser($userId)
    {
    }

    public function getFollowers()
    {
    }

    public function getFollowed()
    {
    }

    public function updateInformation(Request $request)
    {
        try {
            $data = $request->all();
            $userId = auth()->id();
            $this->userService->updateProfile($data);
            return $this->getUserProfile($userId);
        } catch (Exception $e) {
            return $this->responseData(array('error' => $e, 500));
        }
    }

    public function getListUserImageDefault()
    {
        return $this->userService->getListUserImageDefault();
    }

    public function getBackgroundDefault()
    {
        return $this->userService->getBackgroundDefault();
    }

    public function updateAvatar(Request $request)
    {
        $myProfile = $this->userService->updateAvatar($request->file('avatar'), $request->get('default'));
        return $this->responseData($myProfile);
    }

    public function updateBackground(Request $request)
    {
        $myProfile = $this->userService->updateBackground($request->file('background'));
        return $this->responseData($myProfile);
    }

    public function updatePassword()
    {

    }
}
