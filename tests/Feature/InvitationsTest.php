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
   public function _non_owners_cannot_invite_users()
   {
       $this->signIn();

       $project = ProjectFactory::create();
       $user = factory(User::class)->create();

       $this->actingAs($user)
           ->post($project->path() . '/invitations')
           ->assertStatus(403);
   }
   
   /**
    * @test
    */
   public function _a_project_owner_can_invite_a_user()
   {
       $this->signIn();
       $project = ProjectFactory::create();

       $userToInvite = factory(User::class)->create();

       $this->actingAs($project->owner)->post($project->path() .'/invitations', [
           'email' => $userToInvite->email
       ])
           ->assertRedirect($project->path());

       $this->assertTrue($project->members->contains($userToInvite));

   }
   
   /**
    * @test
    */
   public function _invited_users_may_update_project_details()
   {
       $this->signIn();

       $project = ProjectFactory::create();

       $project->invite($newUser = factory(User::class)->create());

       $this->signIn($newUser);

       //Then, that new user will have permissions to add tasks.
       $this->post(action('ProjectTasksController@store', $project), $task = [
            'body' => 'Test Task'
           ]);

       $this->assertDatabaseHas('tasks', $task);
   }
   
   /**
    * @test
    */
   public function _the_email_must_be_associated_with_a_valid_birdboard_account()
   {
       $user = $this->signIn();
       $project = ProjectFactory::create();

       $this->actingAs($project->owner)
           ->post($project->path() .'/invitations', [
               'email' => 'notauser@example.com'
           ])
           ->assertSessionHasErrors([
               'email' => 'The user you are inviting must have a Birdboard account.'
           ]);
   }
}
