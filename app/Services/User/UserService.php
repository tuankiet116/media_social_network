<?php

namespace App\Services\User;

use App\Models\Community;
use App\Models\Follower;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\UserSchool;
use App\Services\Inf\StorageService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{
    private $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function getProfile()
    {
        $userId = auth()->id();
        $information = User::with(['userSchool', 'userInformation', 'groups'])
            ->withCount(['follower', 'following'])->where('id', $userId)->first();
        return $information;
    }

    public function getUserProfile(int $userId)
    {
        $information = User::with(['userSchool', 'userInformation'])
            ->withCount(['follower', 'following'])->where('id', $userId)->first();
        return $information;
    }

    public function followUser($idFollow)
    {
        $followerId = auth()->id();
        $isFollowed = Follower::where(['user_id' => $idFollow, 'follower_id' => $followerId])->first();
        $userFollow = User::where('id', $idFollow)->first();
        if (!$isFollowed && $userFollow && $followerId !== $idFollow) {
            Follower::create([
                'user_id' => $idFollow,
                'follower_id' => $followerId
            ])->save();
        }
        return $this->countFollower($idFollow);
    }

    public function unfollowUser($idFollow)
    {
        $followerId = auth()->id();
        $isFollowed = Follower::where(['user_id' => $idFollow, 'follower_id' => $followerId])->first();
        $isFollowed->delete();
        return $this->countFollower($idFollow);
    }

    public function countFollower($userId) {
        return Follower::where('user_id', $userId)->count();
    }

    public function getAvatar($fileName)
    {
        return $this->storageService->getImage('/user/avatar/' . $fileName);
    }

    public function getBackground($fileName)
    {
        return $this->storageService->getImage('/user/background/' . $fileName);
    }

    public function getFollower()
    {
    }

    public function getGroupsByMe()
    {
        $userId = auth()->id();
        return Community::where('user_id', $userId)->get();
    }

    public function updateProfile($data)
    {
        try {
            $userId = auth()->id();
            $user = User::where('id', $userId)->first();
            $user->name = $data['name'];
            $user->save();

            $information = UserInformation::where('user_id', $userId)->first();
            $information->living_place = $data['living_place'];
            $information->working_place = $data['working_place'];
            $information->gender = $data['gender'];
            $information->save();

            $schools = UserSchool::where('user_id', $userId)->get();
            $highschools = $schools->where('school_type', SCHOOLE_HIGHSCHOOL);
            $universities = $schools->where('school_type', SCHOOLE_UNIVERSITY);
            $this->createSchoolData(SCHOOLE_HIGHSCHOOL, $highschools, $data['highschool'], $userId);
            $this->createSchoolData(SCHOOLE_UNIVERSITY, $universities, $data['university'], $userId);
            return $this->getProfile();
        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e);
        }
    }

    public function createSchoolData($type, $dataExist, $data, $userId)
    {
        try {
            $idExist = $dataExist->pluck('id')->toArray();
            $idData = collect($data)->pluck('id')->toArray();
            $idDelete = array_diff($idExist, $idData);
            if ($idDelete) UserSchool::whereIn('id', $idDelete)->delete();
            foreach ($data as $d) {
                if ($d['id']) {
                    $record = UserSchool::where(['id' => $d['id'], 'user_id' => $userId])->first();
                    if ($record) {
                        $record->school_name = $d['school_name'];
                        $record->start_year = $d['start_year'];
                        $record->end_year = $d['end_year'];
                        $record->save();
                    }
                } else {
                    $dataCreate = array(
                        "school_name" => $d['school_name'],
                        "start_year" => $d['start_year'],
                        "end_year" => $d['end_year'],
                        "school_type" => $type,
                        'user_id' => $userId
                    );
                    UserSchool::create($dataCreate);
                }
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function getListUserImageDefault()
    {
        $files = collect(Storage::allFiles('public/defaults/avatars'))->map(function ($file) {
            return Storage::url($file);
        });
        return $files;
    }

    public function getBackgroundDefault()
    {
        $files = collect(Storage::allFiles('public/defaults/background'))->map(function ($file) {
            return Storage::url($file);
        });
        return $files;
    }

    public function updateAvatar($avatarImage = null, $fileNameDefault = null)
    {
        $userId = auth()->id();
        $user = User::where('id', $userId)->first();
        if ($avatarImage) {
            $fileName = $this->storageService->saveToLocalStorage('/user/avatar/', $avatarImage, false);
            $user->image = $fileName;
        } else if ($fileNameDefault) {
            $fileName = $this->storageService->copyImagePublicStorage('/user/avatar/', '/defaults/avatars/' . $fileNameDefault);
            $user->image = $fileName;
        }
        $user->save();
        return $this->getProfile();
    }

    public function updateBackground($background = null)
    {
        $userId = auth()->id();
        $user = User::where('id', $userId)->first();
        if ($background) {
            $fileName = $this->storageService->saveToLocalStorage('/user/background/', $background, false);
            $user->banner = $fileName;
        }
        $user->save();
        return $this->getProfile();
    }
}
