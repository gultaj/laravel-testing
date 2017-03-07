<?php

namespace Tests\Feature;

use App\Group;
use App\Task;
use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\TestCase;

class HomeTaskTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanSeeAllTasks()
    {
        $groups = factory(Group::class, 5)->make();

        $this->user->groups()->saveMany($groups);

        $tasks = collect()->push($this->task);

        $groups->each(function($group) use ($tasks) {
            $task = factory(Task::class)->make();
            $group->tasks()->save($task);
            $tasks->push($task);
        });
        $groups->push($this->group);

        $this->actingAs($this->user)
            ->visit('/home');

        $tasks->each(function($task) {
            $this->see($task->body)
                ->seeInElement('.tasks>li', $task->group->title);
        });
    }
}
