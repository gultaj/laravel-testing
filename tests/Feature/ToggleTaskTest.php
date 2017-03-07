<?php

namespace Tests\Feature;

use App\User;
use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\TestCase;

class ToggleTaskTest extends TestCase
{
    use DatabaseTransactions;

    public function testUserCanMarkTaskAsCompleted()
    {
        $this->actingAs($this->user)
            ->visitRoute('groups.show', $this->group)
            ->press('toggle-task-' . $this->task->id);

        $this->see('Task marked as completed')
            ->seeInDatabase('tasks', [
                'body' => $this->task->body,
                'completed' => true
            ]);
    }

    public function testUserCanMarkTaskAsNotCompleted()
    {
        $this->task->update(['completed' => true]);

        $this->actingAs($this->user)
            ->visitRoute('groups.show', $this->group)
            ->press('toggle-task-' . $this->task->id);

        $this->see('Task marked as not completed')
            ->seeInDatabase('tasks', [
                'body' => $this->task->body,
                'completed' => false
            ]);
    }

    public function testUserCannotToggleAnotherUserTask()
    {
        $anotherUser = factory(User::class)->create();

        $this->actingAs($anotherUser)
            ->call('patch', '/groups/' . $this->group->id . '/tasks/' . $this->task->id . '/toggle');

        $this->assertResponseStatus(403);
    }
}
