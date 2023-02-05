<?php

namespace App\Services\User;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\UserNotification;
use App\Services\Inf\StorageService;
use App\Services\Inf\VideoStream;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\User\Events\NotificationEvent;

use function PHPUnit\Framework\isEmpty;

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
        $result = explode(env('APP_URL'), route('ckfinder.get_image', ['fileName' => $result]))[1];
        return $result;
    }

    public function uploadPost($data)
    {
        $userId = auth()->id();
        $dataInsert = [
            'user_id' => $userId,
            'community_id' => $data['community'] ?? 0,
            'share_id' => $data['share'] ?? null,
            'post_description' => $data['description'],
            'thumbnail_src' => '',
            'src' => ''
        ];

        if ($data['video'] && !$data['share']) {
            $result = $this->videoUpload($data['video']);
            $dataInsert['src'] = $result;
        }

        $post = Post::create($dataInsert);

        $postShare = Post::find($data['share'] ?? null);
        if (isset($data['share']) && $postShare && $userId != $postShare->user_id) {
            $notification = UserNotification::create([
                'user_id' => $postShare->user_id,
                'user_sender_id' => $userId,
                'post_id' => $post->id,
                'type' => NOTIFICATION_USER_SHARE_POST
            ]);

            NotificationEvent::dispatch($notification);
        }

        $community = Community::find($data['community'] ?? 0);
        if (isset($data['community']) && $community && $userId != $community->user_id) {
            $notification = UserNotification::create([
                'user_id' => $community->user_id,
                'user_sender_id' => $userId,
                'post_id' => $post->id,
                'community_id' => $community->id,
                'type' => NOTIFICATION_INSERT_POST_COMMUNITY
            ]);

            NotificationEvent::dispatch($notification);
        }
        return $post;
    }

    public function videoUpload($file)
    {
        $fileName = $this->storageService->saveToLocalStorage('videos', $file, false);
        return $fileName;
    }

    public function getPosts($offset = 0, int $userId = null)
    {
        $postQuery = Post::with(['user:id,name,image', 'community', 'share', 'share.user:id,name,image', 'share.community'])
            ->withCount('reactionUser', 'comments', 'shared')
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
        $post = Post::with(['user:id,name,image', 'community', 'share', 'share.user:id,name,image', 'share.community'])
            ->withCount('reactionUser', 'comments', 'shared')
            ->where('id', $id)
            ->first();
        return $post;
    }

    public function deletePost(Post $post)
    {
        $userId = auth()->id();
        DB::beginTransaction();
        try {
            Comment::where('post_id', $post->id)->delete();
            PostUser::where('post_id', $post->id)->delete();
            $result = $post->delete();

            if ($post->user_id != $userId) {
                $notification = UserNotification::create([
                    'user_id' => $post->user_id,
                    'community_sender_id' => $post->community_id,
                    'community_id' => $post->community_id,
                    'type' => NOTIFICATION_COMMUNITY_DEL_POST
                ]);

                NotificationEvent::dispatch($notification);
            }
            DB::commit();

            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error delete post: ' . $post->id);
            return 0;
        }
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
                'post_description' => $data['post_description']
            ));
        }
        return $result;
    }
}
