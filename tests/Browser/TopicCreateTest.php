<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Chrome;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TopicCreateTest extends DuskTestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function testUserCanCreateATopic()
    {
        $user = \App\User::first();

        $this->browse(function($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertSee($user->name);
        });
    }
}
