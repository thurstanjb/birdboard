<?php

namespace Tests\Feature;

use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function _creating_a_project()
    {
        $this->signIn();
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_project', $activity->description);

            $this->assertNull($activity->changes);

        });
    }
    
    /**
     * @test
     */
    public function _updating_a_project()
    {
        $this->signIn();
        $project = ProjectFactory::create();
        $originalTitle = $project->title;

        $project->update(['title' => 'changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) use($originalTitle){
            $this->assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'changed']
            ];

            $this->assertEquals($expected, $activity->changes);

        });

    }

    /**
     * @test
     */
    public function _creating_a_new_task()
    {
        $this->signIn();
        $project = ProjectFactory::create();

        $project->addTask('New task');

        $this->assertCount(2, $project->activity);


        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('New task', $activity->subject->body);
        });
    }

    /**
     * @test
     */
    public function _completing_a_task()
    {
        $this->signIn();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'Updating task',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);
        tap($project->activity->last(), function($activity){
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /**
     * @test
     */
    public function _incompleting_a_task()
    {

        $this->signIn();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'Updating task',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
                'body' => 'Updating task',
                'completed' => false
            ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('uncompleted_task', $activity->description);
        });

    }

    /**
     * @test
     */
    public function _deleting_a_task()
    {
        $this->signIn();
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function($activity){
            $this->assertEquals('deleted_task', $activity->description);
        });


    }
}
