<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\FollowService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FollowController extends Controller
{
    use ApiResponse;
    private $followService;

    public function __construct(FollowService $followService)
    {
        $this->followService = $followService;
    }

    public function getFollower(Request $request)
    {
        $userId = $request->query('userId');
        $offset = $request->query('offset');
        $result = $this->followService->getFollower($userId, $offset);
        return $this->responseData($result);
    }

    public function getFollowing(Request $request)
    {
        $userId = $request->query('userId');
        $offset = $request->query('offset');
        $result = $this->followService->getFollowing($userId, $offset);
        return $this->responseData($result);
    }
}
