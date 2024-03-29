<?php

namespace Modules\User\Http\Controllers;

use App\Models\Post;
use App\Services\User\PostService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Http\Requests\Post\PostCreateRequest;

class PostController extends Controller
{
    use ApiResponse;
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function create(PostCreateRequest $request)
    {
        $data = $request->validated();
        $result = $this->postService->uploadPost($data);
        return $this->responseData($result, 200);
    }

    public function getPosts(int $offset = null, int $userId = null)
    {
        $data = $this->postService->getPosts($offset, $userId);
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
        return $this->responseData($data, 404);
    }

    public function delete(Post $post)
    {
        $result = $this->postService->deletePost($post);
        return $this->responseData($result, 200);
    }

    public function update(Request $request) {
        $data = $request->all();
        $result = $this->postService->update($data);
        return $this->responseData($result, 200);
    }
}
