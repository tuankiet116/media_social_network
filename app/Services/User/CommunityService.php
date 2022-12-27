<?php

namespace App\Services\User;

use App\Models\Community;
use App\Models\CommunityUser;
use App\Models\Post;
use App\Services\Inf\StorageService;
use Exception;
use Illuminate\Support\Facades\Storage;

class CommunityService
{
    private $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function createCommunity($communityName)
    {
        $userId = auth()->id();
        $fileName = $userId . '_' . time() . '.png';
        $backgroundImage = Storage::copy('/public/defaults/community/background.png', '/community/background/' . $fileName);
        $image = Storage::copy('/public/defaults/community/community_avatar.png', '/community/avatar/' . $fileName);
        $data = [
            'community_name' => $communityName,
            'user_id' => $userId,
            'background' => $fileName,
            'image' => $fileName
        ];

        $group = Community::create($data);
        return $group;
    }

    public function joinGroup(int $groupId)
    {
        $userId = auth()->id();
        $member = CommunityUser::where('user_id', $userId)->first();
        if ($member && $member->banned == 1) {
        }
    }

    public function getGroupByOwner()
    {
        $userId = auth()->id();
        $groups = Community::where('user_id', $userId)->get();
        return $groups;
    }

    public function getBannedMember()
    {
    }

    public function getCommunityMember()
    {
    }

    public function getAvatar($fileName)
    {
        return $this->storageService->getImage('/community/avatar/' . $fileName);
    }

    public function getBackground($fileName)
    {
        return $this->storageService->getImage('/community/background/' . $fileName);
    }

    public function getCommunity($id)
    {
        $community = Community::where('id', $id)->first();
        if (!$community) throw new Exception('NOT FOUND');
        return $community;
    }

    public function getPosts($communityId, $offset)
    {
        $postQuery = Post::with(['user:id,name,image'])
            ->withCount('reactionUser', 'comments')
            ->orderBy('created_at', 'DESC')
            ->limit(LIMIT);
        $postQuery->where('group_id', $communityId);
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

    public function getListByUser($search, $offset = 0)
    {
        $userId = auth()->id();
        Community::where([
            ['user_id', '=', $userId]
        ])->limit(10)->get();
    }
}
