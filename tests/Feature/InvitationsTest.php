<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
   use RefreshDatabase;
   
   /**
    * @test
    */
   public function _project_can_invite_a_user()
   {
       $project = ProjectFactory::create();

       $project->invite($newUser = factory(User::class)->create());

       $this->signIn($newUser);

       //Then, that new user will have permissions to add tasks.
       $this->post(action('ProjectTasksController@store', $project), $task = [
            'body' => 'Test Task'
           ]);

       $this->assertDatabaseHas('tasks', $task);
   }
}
