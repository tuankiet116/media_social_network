<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\PostService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CKFinderController extends Controller
{
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
            'url' => route('get_file', $result)
        ];
        return $this->responseData($dataResponse, 200);
    }

    public function getImage($fileName) {
        
    }
}
