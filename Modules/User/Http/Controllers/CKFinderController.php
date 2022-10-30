<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\PostService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CKFinderController extends Controller
{
    use ApiResponse;
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function uploadImage(Request $request)
    {
        $file = $request->file('upload');
        $result = $this->postService->uploadImageCkEditor($file);
        $dataResponse = [
            'fileName' => $result,
            'uploaded' => 1,
            'url' => $result
        ];
        return $this->responseData($dataResponse, 200);
    }

    public function getImage(String $fileName)
    {
        return $this->postService->getImageCKFinder($fileName);
    }
}
