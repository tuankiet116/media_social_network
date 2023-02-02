<?php

namespace App\Policies;

use App\Models\Community;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommunityPolicy
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

    public function update(?User $user, Community $community)
    {
        return $community->user_id === auth()->id()
            ? Response::allow()
            : Response::deny('You have no permission to this community');
    }

    public function join(?User $user, Community $community)
    {
        return $community->user_id !== auth()->id()
            ? Response::allow()
            : Response::deny('You cannot join to this community');
    }

    public function unjoin(?User $user, Community $community)
    {
        return $community->user_id !== auth()->id()
            ? Response::allow()
            : Response::deny('You cannot unjoin to this community');
    }

    public function delete(?User $user, Community $community)
    {
        return $community->user_id === auth()->id()
            ? Response::allow()
            : Response::deny('You have no permission to this community');
    }
}
