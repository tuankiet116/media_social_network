<?php

namespace App\Services\User;

use App\Models\Group;
use App\Models\GroupUser;
use App\Services\Inf\StorageService;
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
        $bannerImage = Storage::copy('/public/defaults/community/background.png', '/community/background/' . $fileName);
        $image = Storage::copy('/public/defaults/community/community_avatar.png', '/community/avatar/' . $fileName);
        $data = [
            'group_name' => $communityName,
            'user_id' => $userId,
            'banner' => $fileName,
            'image' => $fileName
        ];

        $group = Group::create($data);
        return $group;
    }

    public function joinGroup(int $groupId) {
        $userId = auth()->id();
        $member = GroupUser::where('user_id', $userId)->first();
        if($member && $member->banned == 1) {
            
        }
    }

    public function getGroupByOwner() {
        $userId = auth()->id();
        $groups = Group::where('user_id', $userId)->get();
        return $groups;
    }

    public function getGroupJoined() {

    }

    public function getBannedMember() {

    }

    public function getGroupMember() {

    }

    public function getAvatar($fileName) {
        return $this->storageService->getImage('/community/avatar/' . $fileName); 
    }

    public function getBackground($fileName) {
        return $this->storageService->getImage('/community/background/' . $fileName); 
    }
}
