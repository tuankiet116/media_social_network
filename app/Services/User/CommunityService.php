<?php

namespace App\Services\User;

use App\Models\Community;
use App\Models\CommunityUser;
use App\Models\Post;
use App\Models\UserNotification;
use App\Services\Inf\StorageService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\User\Events\NotificationEvent;

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

        $community = Community::create($data);
        CommunityUser::create([
            'user_id' => $userId,
            'community_id' => $community->id
        ]);
        return $community;
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

    public function getCommunityMember($communityId, $offset)
    {
        $members = CommunityUser::where('community_id', $communityId)
            ->orderBy('created_at')->limit(20)
            ->offset($offset)->get();
        return $members;
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
        $postQuery->where('community_id', $communityId);
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

    public function getCommunitiesJoinedByUser($search, $offset = 0)
    {
        $userId = auth()->id();
        $communities = CommunityUser::with(['community' => function ($q) use ($search) {
            return $q->where('community_name', 'LIKE', '%' . $search . '%');
        }])->where('user_id', $userId)->limit(10)->offset($offset)->get();
        return $communities;
    }

    public function updateCommunityInfo($data, Community $community)
    {
        $community->community_name = $data['community_name'];
        $community->rule = $data['rule'];
        $community->save();
        return $community;
    }

    public function updateAvatar($community, $image)
    {
        $fileName =  $community->id . '_' . time() . '.png';
        $this->storageService->saveToLocalStorage('community/avatar', $image, false, $fileName);
        $community = Community::where('id', $community->id)->first();
        $community->image = $fileName;
        $community->save();
        return $community;
    }

    public function updateBackground($community, $image)
    {
        $fileName =  $community->id . '_' . time() . '.png';
        $this->storageService->saveToLocalStorage('community/background', $image, false, $fileName);
        $community->background = $fileName;
        $community->save();
        return $community;
    }

    public function joinCommunity(Community $community)
    {
        $userId = auth()->id();
        if ($community->user_id != $userId) {
            CommunityUser::create([
                'community_id' => $community->id,
                'user_id' => $userId
            ]);
            $notification = UserNotification::create([
                'user_id' => $community->user_id,
                'user_sender_id' => $userId,
                'community_sender_id' => $community->id,
                'type' => NOTIFICATION_JOIN_COMMUNITY
            ]);
            NotificationEvent::dispatch($notification);

            return true;
        }
        return false;
    }

    public function unjoinCommunity(Community $community)
    {
        $userId = auth()->id();
        if ($community->user_id != $userId) {
            $communityUser = CommunityUser::where([
                'community_id' => $community->id,
                'user_id' => $userId
            ])->first();
            $communityUser->delete();

            $notification = UserNotification::create([
                'user_id' => $community->user_id,
                'user_sender_id' => $userId,
                'community_sender_id' => $community->id,
                'type' => NOTIFICATION_LEAVE_COMMUNITY
            ]);
            NotificationEvent::dispatch($notification);

            return true;
        }
        return false;
    }

    public function  getMembers(Community $community, int $offset)
    {
        $members = CommunityUser::with('user')->where('community_id', $community->id)
            ->orderBy('created_at', 'DESC')->offset($offset)->limit(20)->get();
        $newOffset = null;
        if (count($members)) {
            $newOffset = $offset + count($members);
        }
        return array(
            'members' => $members,
            'offset' => $newOffset
        );
    }

    public function  deleteMember(Community $community, int $userId)
    {
        try {
            CommunityUser::where([
                'community_id' => $community->id,
                'user_id' => $userId
            ])->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function deleteCommunity(Community $community)
    {
        DB::beginTransaction();
        $id = $community->id;
        try {
            Post::where('community_id', $id)->delete();
            CommunityUser::where('community_id', $id)->delete();
            $community->delete();
            DB::commit();
        } catch (Exception $e) {
            Log::error('[Delete] Community:' . $e->getMessage());
            DB::rollBack();
            return false;
        }
        return true;
    }
}
