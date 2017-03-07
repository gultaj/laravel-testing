<?php

namespace Tests\Feature;

use App\Group;
use App\Task;
use App\User;
use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\TestCase;


class CreateTaskTest extends TestCase
{
    use DatabaseTransactions;

    private $success = 'Task created successfully';


    public function testUserCanCreateATask()
    {
        $task = factory(Task::class)->make();

        $this->actingAs($this->user)
            ->visit('/groups/' . $this->group->id)
            ->type($task->body, 'body')
            ->press('submit-task');

        $this->see($task->body)
            ->see($this->success)
            ->seeInDatabase('tasks', $task->toArray());
    }

    public function testUserCantCreateEmptyTask()
    {
        $this->actingAs($this->user)
            ->visit('/groups/' . $this->group->id)
            ->type('', 'body')
            ->press('submit-task');

        $this->dontSee($this->success)
            ->dontSeeInDatabase('tasks', ['body' => '']);
    }

    public function testUserCantCreateATaskInAnotherUserGroup()
    {
        $anotherUser = factory(User::class)->create();
        $task = factory(Task::class)->make();
        $this->group->tasks()->save($task);

        $this->actingAs($anotherUser)
            ->post('/groups/' . $this->group->id . '/tasks', [
                'body' => $task->body
            ]);

        $this->assertResponseStatus(403);
    }
}
