<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(?User $user, Post $post)
    {
        $post->load('community');
        $community = $post->community;
        return $post->user_id == $user->id || $community && $community->user_id == $user->id
            ? Response::allow()
            : Response::deny('You have no permission to this community');
    }
}
