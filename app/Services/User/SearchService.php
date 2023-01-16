<?php

namespace App\Services\User;

use App\Models\HistorySearch;
use App\Models\Post;
use App\Models\User;

class SearchService
{
    public function searchHistory($keyword, $offset = 0)
    {
        $userId = auth()->id();
        if ($userId) {
            $result = HistorySearch::where([
                ['keyword', 'like', '%' . $keyword . '%'],
                ['user_id', '=', $userId]
            ])->orderBy('created_at', 'DESC')
                ->limit(10)->offset($offset)->get();
            return $result;
        }
        return [];
    }

    public function insertHistory($keyword, $result_type = null, int $result_id = null)
    {
        $userId = auth()->id();
        if ($userId) {
            $dataKeywordSearch = [
                'keyword' => $keyword,
                'user_id' => $userId,
                'result_type' => null,
                'result_id' => null
            ];
            $isExist = HistorySearch::where($dataKeywordSearch)->count();
            if ($result_type && $result_id) {
                HistorySearch::create([
                    'keyword' => $keyword,
                    'user_id' => $userId,
                    'result_type' => $result_type,
                    'result_id' => $result_id
                ]);
                if ($isExist) {
                    HistorySearch::where($dataKeywordSearch)->delete();
                }
            } else if (!$isExist) {
                HistorySearch::create([
                    'keyword' => $keyword,
                    'user_id' => $userId
                ]);
            }
        }
        return true;
    }

    public function searchAll($keyword, $offset)
    {
        self::insertHistory($keyword);
        $postQuery = Post::with(['user:id,name,image', 'community'])
            ->withCount('reactionUser', 'comments')
            ->where('title', 'like', '%' . $keyword . '%')
            ->orWhere('post_description', 'like', '%' . $keyword . '%')
            ->orWhereHas('community', function ($query) use ($keyword) {
                return $query->where('community_name', 'like', '%' . $keyword . '%');
            })
            ->orderBy('created_at', 'DESC')
            ->limit(LIMIT);
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
        return array('posts' => $posts, 'offset' => $newOffset ?? null);
    }

    public function searchPosts($keyword, $offset = 0)
    {
        $posts = Post::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('post_description', 'like', '%' . $keyword . '%')
            ->orderBy('created_at', 'DESC')
            ->limit(LIMIT)->offset($offset)->get();
        if (count($posts)) {
            $newOffset = count($posts) + LIMIT;
        }
        $result = [
            'posts' => $posts,
            'offset' => $newOffset
        ];
        return $result;
    }

    public function searchUser($keyword, $offset)
    {
        $users = User::where('name', 'like', '%' . $keyword . '%');
    }

    public function searchCommunity($keyword, $offset)
    {
    }
}
