<?php

namespace App\Policies;

use App\Task;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    public function change(User $user, Task $task)
    {
        return $user->canDestroyTask($task);
    }

}
