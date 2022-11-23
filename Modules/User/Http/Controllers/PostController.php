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

    public function stream(String $fileName)
    {
        $this->postService->stream($fileName);
    }

    public function reaction(Request $request)
    {
        $data = $request->all();
        $amountReaction = $this->postService->reactToPost($data);
        return $this->responseData(array('amount_reaction' => $amountReaction), 200);
    }

    public function getPost(int $id)
    {
        $data = $this->postService->getPost($id);
        if ($data) {
            return $this->responseData($data, 200);
        }
        // return $this->responseData($data, 404);
    }

    public function delete(int $postId)
    {
        $result = $this->postService->deletePost($postId);
        return $this->responseData($result, 200);
    }

    public function update(Request $request) {
        $data = $request->all();
        $result = $this->postService->update($data);
        return $this->responseData($result, 200);
    }
}
