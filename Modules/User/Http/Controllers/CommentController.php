<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\CommentService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommentController extends Controller
{
    use ApiResponse;

    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $result = $this->commentService->createComment($data);
        
        if ($result) {
            return $this->responseData($result, 200);
        }
    }

    public function getComments(int $postID, int $offset = 0) {
        $data = $this->commentService->getComments($postID, $offset);
        return $this->responseData($data, 200);
    }
}
