<?php

namespace Modules\User\Http\Controllers;

use App\Services\User\SearchService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SearchController extends Controller
{
    use ApiResponse;
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }
    public function searchHistory(Request $request)
    {
        $keyword = $request->query('keyword');
        $offset = $request->query('offset') ?? 0;
        $result = $this->searchService->searchHistory($keyword, $offset);
        return $this->responseData($result);
    }

    public function searchAll(Request $request)
    {
        $keyword = $request->query('keyword');
        $offset = $request->query('offset');
        $result = $this->searchService->searchAll($keyword, $offset);
        return $this->responseData($result);
    }

    public function searchPost(Request $request)
    {
        $keyword = $request->query('keyword');
        $offset = $request->query('offset');
        $result = $this->searchService->searchPost($keyword, $offset);
        return $this->responseData($result);
    }

    public function searchUser(Request $request)
    {
        $keyword = $request->query('keyword');
        $offset = $request->query('offset');
        $result = $this->searchService->searchUser($keyword, $offset);
        return $this->responseData($result);
    }

    public function searchCommunity(Request $request)
    {
        $keyword = $request->query('keyword');
        $offset = $request->query('offset');
        $result = $this->searchService->searchCommunity($keyword, $offset);
        return $this->responseData($result);
    }

    public function insertHistoryResult(Request $request) {
        
    }
}
