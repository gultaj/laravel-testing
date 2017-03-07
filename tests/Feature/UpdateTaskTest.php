<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanEditTask()
    {
        $this->actingAs($this->user)
            ->visitRoute('groups.show', $this->group)
            ->click('update-task-' . $this->task->id);

        $this->seeRouteIs('tasks.edit', [$this->group, $this->task])
            ->see('Edit task: ' . $this->task->body)
            ->seeInField('body', $this->task->body);
    }

    public function testUserCanUpdateTask()
    {
        $newTask = factory(Task::class)->make();

        $this->actingAs($this->user)
            ->visitRoute('tasks.edit', [$this->group, $this->task])
            ->type($newTask->body, 'body')
            ->press('Save task');

        $this->seeRouteIs('groups.show', $this->group)
            ->see('Task was updated')
            ->see($newTask->body)
            ->seeInDatabase('tasks', $newTask->toArray());
    }

    public function testUserCanUpdateTaskWithEmptyBody()
    {
        $this->actingAs($this->user)
            ->visitRoute('tasks.edit', [$this->group, $this->task])
            ->type('', 'body')
            ->press('Save task');

        $this->seeRouteIs('tasks.edit', [$this->group, $this->task])
            ->dontSeeInDatabase('tasks', ['body' => '']);
    }

    public function testUserCannotUpdateAnotherUserTask()
    {
        $anotherUser = factory(User::class)->create();
        $newBody = 'New body';

        $this->actingAs($anotherUser)
            ->call('patch', '/groups/' . $this->group->id . '/tasks/' . $this->task->id, ['body' => $newBody]);

        $this->assertResponseStatus(403);
    }

    public function testUserCannotSeeUpdatePageAnotherUserTask()
    {
        $anotherUser = factory(User::class)->create();

        $this->actingAs($anotherUser)
            ->call('get', '/groups/' . $this->group->id . '/tasks/' . $this->task->id . '/edit');

        $this->assertResponseStatus(403);
    }
}

