<?php

namespace App\Services\User;

use App\Models\Community;
use App\Models\CommunityUser;
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
            'community_name' => $communityName,
            'user_id' => $userId,
            'background' => $fileName,
            'image' => $fileName
        ];

        $group = Community::create($data);
        return $group;
    }

    public function joinGroup(int $groupId) {
        $userId = auth()->id();
        $member = CommunityUser::where('user_id', $userId)->first();
        if($member && $member->banned == 1) {
            
        }
    }

    public function getGroupByOwner() {
        $userId = auth()->id();
        $groups = Community::where('user_id', $userId)->get();
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
