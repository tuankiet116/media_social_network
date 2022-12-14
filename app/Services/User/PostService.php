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
            'community_id' => $request->get('community'),
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

    public function getPosts($offset = 0, int $userId = null)
    {
        $postQuery = Post::with(['user:id,name,image', 'community'])
            ->withCount('reactionUser', 'comments')
            ->orderBy('created_at', 'DESC')
            ->limit(LIMIT);
        if ($userId) {
            $postQuery->where('user_id', $userId);
        }
        if ($offset) {
            $postQuery = $postQuery->offset($offset);
        }
        $posts = $postQuery->get();

        $posts->each(function ($post) {
            $post->load(['comments' => function ($q) {
                return $q->withCount('likes')->where('belong_id', null)->orderBy('created_at', 'DESC')->limit(LIMIT_COMMENT_OVERVIEW)->with('users');
            }]);
        });

        if ($posts) {
            $newOffset = $posts->count() + $offset;
        }
        return array('data' => $posts, 'offset' => $newOffset ?? null);
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

    public function reactToPost($req)
    {
        $userId = auth()->id();
        $data = [
            'user_id' => $userId,
            'post_id' => $req['postId']
        ];
        $liked = PostUser::where($data)->first();
        if ($liked && $req['like'] == false) {
            PostUser::where($data)->delete();
        } else {
            PostUser::create($data);
        }
        $amountReaction = PostUser::where('post_id', $req['postId'])->count();
        return $amountReaction;
    }

    public function getPost(int $id)
    {
        $post = Post::with(['user:id,name,image', 'community'])
            ->withCount('reactionUser', 'comments')
            ->where('id', $id)
            ->first();
        return $post;
    }

    public function deletePost(int $id)
    {
        $userId = auth()->id();
        $result = Post::where(['id' => $id, 'user_id' => $userId])->delete();
        return $result;
    }

    public function update($data)
    {
        $userId = auth()->id();
        $post = Post::where([
            'id' => $data['id'],
            'user_id' => $userId
        ])->first();
        $result = false;
        if ($post) {
            $result = $post->update(array(
                'title' => $data['title'],
                'post_description' => $data['post_description']
            ));
        }
        return $result;
    }
}
