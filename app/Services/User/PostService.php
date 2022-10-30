<?php

namespace App\Services\User;

use App\Models\Post;
use App\Services\Inf\StorageService;
use App\Services\Inf\VideoStream;
use Illuminate\Support\Facades\Storage;

class PostService
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }
    public function uploadImageCkEditor($file)
    {
        $result = $this->storageService->saveToLocalStorage('ckfinder', $file, false);
        return route('ckfinder.get_image', ['fileName' => $result]);
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
        $fileName = $this->storageService->saveToLocalStorage('videos', $file, false);
        return $fileName;
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

    public function stream(String $fileName)
    {
        $video_path = Storage::path('videos/'.$fileName);
        $tmp = new VideoStream($video_path);
        $tmp->start();
    }

    public function getImageCKFinder(String $fileName) {
        return $this->storageService->getImage('ckfinder/'.$fileName);
    }
}
