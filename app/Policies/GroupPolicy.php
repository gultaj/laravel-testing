<?php

namespace App\Policies;

use App\Group;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Group $group)
    {
        return $user->id === $group->user_id;
    }

    public function affect(User $user, Group $group)
    {
        return $user->id === $group->user_id;
    }
}
