<?php

namespace App\Services\User;

use App\Models\Post;
use App\Services\Inf\StorageService;

class PostService
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    public function uploadImageCkEditor($file)
    {
        $result = $this->storageService->saveToLocalStorage('public/ckfinder', $file);
        return $result;
    }

    public function uploadPost($request)
    {
        $data = [
            'title' => $request->get('title'),
            'user_id' => auth()->id(),
            'group_id' => 0,
            'post_description' => $request->get('description'),
            'thumbnail_src' => '',
            'src' => ''
        ];
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $result = $this->videoUpload($video);
            $data['src'] = $result;
        }
        $post = Post::create($data);
        return $post;
    }

    public function videoUpload($file)
    {
        $result = $this->storageService->saveToLocalStorage('public/videos', $file);
        return $result;
    }

    public function getPosts($offset = null)
    {
        if (!$offset) {
            $data = Post::with('user')->orderBy('created_at', 'DESC')->limit(LIMIT)->get()->toArray();
        } else {
            $data = Post::with('user')->orderBy('created_at', 'DESC')->limit(LIMIT)->offset($offset)->get()->toArray();
        }
        $newOffset = $data[0]['id'];
        return array('data' => $data, 'offset' => $newOffset);
    }
}
