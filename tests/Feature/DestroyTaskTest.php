<?php

namespace Tests\Feature;

use App\User;
use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\TestCase;

class DestroyTaskTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanDestroyATask()
    {
        $this->actingAs($this->user)
            ->visit('/groups/' . $this->group->id)
            ->press('destroy-task-' . $this->task->id);

        $this->dontSee($this->task->body)
            ->see('Task deleted successfully')
            ->dontSeeInDatabase('tasks', $this->task->toArray());
    }

    public function testUserCannotDestroyanotherUserTask()
    {
        $anotherUser = factory(User::class)->create();

        $this->actingAs($anotherUser)
            ->visit('/home')
            ->call('delete', '/groups/' . $this->group->id . '/tasks/' . $this->task->id);

        $this->assertResponseStatus(403);
    }
}
