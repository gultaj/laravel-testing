<?php

namespace Tests\Feature;

use App\Group;
use App\User;
use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateGroupTest extends TestCase
{
   use DatabaseTransactions;

   private $success = 'Group created successfully';

   public function testUserCanCreateGroup()
   {
       //$user = factory(User::class)->create();
       $gr = factory(Group::class)->make();

       $this->actingAs($this->user)
           ->visit('/home')
           ->type($gr->title, 'title')
           ->press('submit-group');

       $this->see($this->success)
           ->see($gr->title)
           ->seeInDatabase('groups', $gr->toArray());
   }

   public function testUserCannotCreateEmptyGroup()
   {
       $this->actingAs($this->user)
           ->visit('/home')
           ->type('', 'title')
           ->press('submit-group');

       $this->dontSee($this->success)
           ->dontSeeInDatabase('groups', ['title' => '']);
   }
}
