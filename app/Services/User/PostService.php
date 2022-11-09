<?php

namespace App\Services\User;

use App\Models\Post;
use App\Models\PostUser;
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
        $postQuery = Post::with(['user:id,name,image', 'comments' => function($query) {
            return $query->orderBy('created_at', 'DESC')->limit(LIMIT_COMMENT_OVERVIEW)->with('users');
        }], 'comments.users')
            ->withCount('reactionUser')
            ->orderBy('created_at', 'DESC')
            ->limit(LIMIT);
        if ($offset) {
            $postQuery = $postQuery->offset($offset);
        }
        $data = $postQuery->get()->toArray();
        if ($data) {
            $newOffset = $data[0]['id'];
        }
        return array('data' => $data, 'offset' => $newOffset ?? null);
    }

    public function stream(String $fileName)
    {
        $video_path = Storage::path('videos/' . $fileName);
        $tmp = new VideoStream($video_path);
        $tmp->start();
    }

    public function getImageCKFinder(String $fileName)
    {
        return $this->storageService->getImage('ckfinder/' . $fileName);
    }

    public function reactToPost($data)
    {
        $userId = auth()->id();
        if ($data['like'] == true) {
            $reaction = PostUser::firstOrCreate([
                'user_id' => $userId,
                'post_id' => $data['postId']
            ]);
            return $reaction;
        } else {
            $reaction = PostUser::where([
                'user_id' => $userId,
                'post_id' => $data['postId']
            ])->first();
            $result = $reaction->delete();
            return $result;
        }
    }

    public function getPost(int $id) {
        $post = Post::with(['user:id,name,image'])
            ->withCount('reactionUser')
            ->first($id);
        return $post;
    }
}
