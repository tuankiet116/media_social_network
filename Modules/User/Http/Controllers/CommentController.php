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
        return $this->responseData($result, 500);
    }

    public function getComments(int $postID, int $offset = 0)
    {
        $data = $this->commentService->getComments($postID, $offset);
        return $this->responseData($data, 200);
    }

    public function deleteComment(int $commentId)
    {
        $result = $this->commentService->deleteComment($commentId);
        return $this->responseData($result, 200);
    }

    public function likeComment(Request $request)
    {
        $data = $request->all('comment_id', 'like');
        $result = $this->commentService->likeComment($data);
        $dataResponse = [
            'likes_number' => $result
        ];
        return $this->responseData($dataResponse, 200);
    }

    public function reply(Request $request)
    {
        $data = $request->all();
        $comment = $this->commentService->replyComment($data);
        return $this->responseData($comment, 200);
    }

    public function getReplies(int $commentId, int $offset)
    {
        $result = $this->commentService->getReplyComments($commentId, $offset);
        return $this->responseData($result, 200);
    }

    public function update(Request $request) {
        $data = $request->all();
        $result = $this->commentService->updateComment($data);
        return $this->responseData($result, 200);
    }
}
