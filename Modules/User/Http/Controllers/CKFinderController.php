<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\PostService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class CKFinderController extends Controller
{
    use ApiResponse;
    private $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function upload(Request $request)
    {
        $file = $request->file('upload');
        $result = $this->postService->uploadImageCkEditor($file);
        $dataResponse = [
            'fileName' => $result,
            'uploaded' => 1,
            'url' => Storage::url($result)
        ];
        return $this->responseData($dataResponse, 200);
    }
}
