<?php

namespace Modules\User\Http\Controllers;

use App\Models\Community;
use App\Services\User\CommunityService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CommunityController extends Controller
{
    use ApiResponse;

    private $communityService;

    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }

    public function createCommunity(Request $request)
    {
        $result = $this->communityService->createCommunity($request->get('community_name'));
        if ($result) {
            return $this->responseData($result, 200);
        }
        return $this->responseData(null, 500);
    }

    public function getInfo(int $communityId)
    {
        try {
            $community = $this->communityService->getCommunity($communityId);
        } catch (Exception $e) {
            abort(404);
        }
        return $this->responseData($community, 200);
    }

    public function getPosts(int $communityId, int $offset = 0)
    {
        $result = $this->communityService->getPosts($communityId, $offset);
        return $this->responseData($result, 200);
    }

    public function getListCommunityJoined(Request $request) {
        $keySearch = $request->get('search');
        $offset = $request->get('offset');
        $result = $this->communityService->getCommunitiesJoinedByUser($keySearch, $offset);
        return $this->responseData($result, 200);
    }

    public function joinCommunity(Community $community) {
        $result = $this->communityService->joinCommunity($community);
        return $this->responseData($result);
    }

    public function unjoinCommunity(Community $community) {
        
    }
}
