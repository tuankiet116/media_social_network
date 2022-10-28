<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\PostService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    use ApiResponse;
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function create(Request $request)
    {
        $result = $this->postService->uploadPost($request);
        return $this->responseData($result, 200);
    }

    public function getPosts(int $offset = null)
    {
        $data = $this->postService->getPosts($offset);
        return $this->responseData($data, 200);
    }

    public function stream(String $fileName) {
        $this->postService->stream($fileName);
    }
}
