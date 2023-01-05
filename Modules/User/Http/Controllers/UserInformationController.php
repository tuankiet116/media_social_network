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

    public function followUser(Request $request)
    {
        $idFollow = $request->get('user_id');
        $result = $this->userService->followUser($idFollow);
        return $this->responseData(['follower_count' => $result]);
    }

    public function unfollowUser(Request $request)
    {
        $idFollow = $request->get('user_id');
        $result = $this->userService->unfollowUser($idFollow);
        return $this->responseData(['follower_count' => $result]);
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
            $result = $this->userService->updateProfile($data);
            return $this->responseData($result);
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
}
