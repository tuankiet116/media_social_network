<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\CommunityService;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Support\Renderable;
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

    public function getCommunity(int $communityId) {
        
    }
}
