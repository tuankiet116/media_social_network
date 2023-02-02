<?php

namespace App\Services\User;

use App\Models\Post;
use App\Models\PostUser;
use App\Models\UserNotification;
use App\Services\Inf\StorageService;
use App\Services\Inf\VideoStream;
use Illuminate\Support\Facades\Storage;
use Modules\User\Events\NotificationEvent;

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
        $postId = $req['postId'];
        $data = [
            'user_id' => $userId,
            'post_id' => $postId
        ];
        $post = Post::where('id', $postId)->first();
        $liked = PostUser::where($data)->first();
        if ($liked && $req['like'] == false) {
            PostUser::where($data)->delete();
        } else {
            PostUser::create($data);
            if ($post->user_id != $userId) {
                $notification = UserNotification::create([
                    'user_id' => $post->user_id,
                    'user_sender_id' => $userId,
                    'post_id' => $postId,
                    'type' => NOTIFICATION_USER_REACT_POST
                ]);
    
                NotificationEvent::dispatch($notification);
            }
        }
        $amountReaction = PostUser::where('post_id', $postId)->count();
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

    public function deletePost(Post $post)
    {
        $result = $post->delete();
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
