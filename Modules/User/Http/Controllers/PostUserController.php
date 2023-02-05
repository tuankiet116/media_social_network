<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\PostUserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\PostUser\PostUserListRequest;

class PostUserController extends Controller
{
    use ApiResponse;
    private $postUserService;

    public function __construct(PostUserService $postUserService)
    {
        $this->postUserService = $postUserService;
    }

    public function getNumberLikePost(int $postId)
    {
        $result = $this->postUserService->getNumberLikeByPost($postId);
        return $this->responseData($result, 200);
    }

    public function getReactions(PostUserListRequest $request, int $postId)
    {
        $data = $request->validated();
        $result = $this->postUserService->getUserLikesByPost($postId, $data['offset']);
        return $this->responseData($result);
    }
}
