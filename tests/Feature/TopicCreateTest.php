<?php

namespace Tests\Feature;

use App\Topic;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\BrowserKitTesting\DatabaseTransactions;

class TopicCreateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @param User $user
     * @param null $title
     * @return Topic
     */
    private function createTopic(User $user, $title = null, $spam = false)
    {
        $attributes = is_null($title) ? [] : ['title' => $title];
        $attributes = array_merge($attributes, ['spam' => $spam]);

        $topic = factory(Topic::class)->make($attributes);

        $this->actingAs($user)->visit('/topics/create')
            ->type($topic->title, 'title')
            ->press('Post topic');

        return $topic;
    }

    public function testNotAuthUser()
    {
        $this->visit('/topics/create')->see('/login');
    }

    public function testUserCanCreateATopic()
    {
        $user = factory(User::class)->create();
        $topic = $this->createTopic($user);

        $this->seePageIs('/topics')->see($topic->title)->see($user->name);
    }

    public function testCreateAInvalidTopic()
    {
        $user = factory(User::class)->create();

        $this->createTopic($user, '');

        $this->seePageIs('/topics/create')->see('The title field is required');
    }

    public function testOrderTopicsListByDate()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        factory(Topic::class, 5)->create([
            'user_id' => $user1->id,
            'created_at' => \Carbon\Carbon::now()->subDays(2)
        ]);

        $topic = $this->createTopic($user2);

        $this->visit('/topics')
            ->seeInElement('.topic:first-child', $topic->title);

    }

    public function testNotShowingSpamTopic()
    {
        $user = factory(User::class)->create();

        factory(Topic::class, 3)->create(['user_id' => $user->id]);

        $spamTopic = factory(Topic::class)->create(['user_id' => $user->id, 'spam' => true]);

        $this->visit('/topics')
            ->dontSee($spamTopic->title);
    }
}
