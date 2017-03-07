<?php

namespace Tests\Feature;

use App\Group;
use App\Task;
use App\User;
use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\TestCase;

class ViewGroupTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanSeeListOfGroups()
    {
        $groups = factory(Group::class, 5)->make();
        $this->user->groups()->saveMany($groups);

        $this->actingAs($this->user)
            ->visit('/home');

        $groups->each(function($group) {
            $this->see($group->body);
        });
    }

    public function testUserCanViewTasksInAGroup()
    {
        $group = factory(Group::class)->make();
        $tasks = factory(Task::class, 10)->make();

        $this->user->groups()->save($group);
        $group->tasks()->saveMany($tasks);

        $this->actingAs($this->user)
            ->visit('/groups/' . $group->id)
            ->see('Tasks in group: ' . $group->title);

        $tasks->each(function($task) {
            $this->see($task->body);
        });
    }

    public function testUserCannotSeeGroupTheyDoNotOwn()
    {
        $group = factory(Group::class)->make();
        $this->user->groups()->save($group);
        $anotherUser = factory(User::class)->create();

        $this->actingAs($anotherUser)
            ->get('/groups/' . $group->id);

        $this->assertResponseStatus(403);
    }
}
