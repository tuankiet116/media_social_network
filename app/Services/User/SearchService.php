<?php

namespace App\Services\User;

use App\Models\Community;
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
                $resultExist = false;
                if ($result_type == SEARCH_TYPE_COMMUNITY) {
                    $resultExist = Community::where('id', $result_id)->first() ? true : false;
                } else if ($result_type == SEARCH_TYPE_USER) {
                    $resultExist = User::where('id', $result_id)->first() ? true : false;
                }

                if ($resultExist) {
                    if ($isExist) {
                        $history = HistorySearch::where($dataKeywordSearch)->first();
                        $history->result_id = $result_id;
                        $history->result_type = $result_type;
                        $history->save();
                    } else {
                        HistorySearch::create([
                            'keyword' => $keyword,
                            'user_id' => $userId,
                            'result_type' => $result_type,
                            'result_id' => $result_id
                        ]);
                    }
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
            ->orWhereHas('user', function ($query) use ($keyword) {
                return $query->where('name', 'like', '%' . $keyword . '%');
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

    public function searchPost($keyword, $offset = 0)
    {
        self::insertHistory($keyword);
        $postQuery = Post::with(['user:id,name,image', 'community'])
            ->withCount('reactionUser', 'comments')
            ->where('title', 'like', '%' . $keyword . '%')
            ->orWhere('post_description', 'like', '%' . $keyword . '%')
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

    public function searchUser($keyword, $offset)
    {
        $userId = auth()->id();
        $users = User::where('name', 'like', '%' . $keyword . '%');
        if ($userId) {
            $users = $users->where('id', '!=', $userId);
        }
        $users = $users->limit(LIMIT)->offset($offset)
            ->orderBy('created_at', 'DESC')->get();
        $newOffset = 0;
        if (count($users)) {
            $newOffset = count($users) + LIMIT;
        }
        return array(
            'users' => $users,
            'offset' => $newOffset
        );
    }

    public function searchCommunity($keyword, $offset)
    {
        $communities = Community::where('community_name', 'like', '%' . $keyword . '%')
            ->limit(LIMIT)->offset($offset)
            ->orderBy('created_at', 'DESC')->get();
        $newOffset = 0;
        if (count($communities)) {
            $newOffset = count($communities) + LIMIT;
        }
        return array(
            'communities' => $communities,
            'offset' => $newOffset
        );
    }
}
