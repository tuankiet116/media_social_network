<?php

namespace Modules\User\Http\Controllers;

use App\Models\Community;
use App\Services\User\CommunityService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommunitySettingController extends Controller
{
    use ApiResponse;
    private $communityService;

    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }

    public function updateInformation(Request $request, Community $community) {
        $data = $request->all();
        $community = $this->communityService->updateCommunityInfo($data, $community);
        return $this->responseData($community);
    }

    public function updateAvatar(Request $request, Community $community) {
        $image = $request->file('avatar');
        if ($image) {
            $community = $this->communityService->updateAvatar($community, $image);
            return $this->responseData($community);
        }
    }

    public function updateBackground(Request $request, Community $community) {
        $image = $request->file('background');
        if ($image) {
            $community = $this->communityService->updateBackground($community, $image);
            return $this->responseData($community);
        }
    }
}
