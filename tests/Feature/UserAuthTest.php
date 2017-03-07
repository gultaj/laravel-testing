<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\BrowserKitTesting\DatabaseTransactions;


class UserAuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testSeeNameAfterSignedIn()
    {
        $user = factory(User::class)->create();

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->press('Login');

        $this->seePageIs('/home');
    }

    public function testRegisterUser()
    {
        $user = factory(User::class)->make();

        $this->visit('/register')
            ->type($user->name, 'name')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->press('Register');

        $this->seeInDatabase('users', $user->toArray());
    }
}
