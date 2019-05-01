<?php

namespace Tests\Unit;

use App\Project;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function _a_project_can_return_its_path()
    {
        $project = factory(Project::class)->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /**
     * @test
     */
    public function _a_project_has_an_owner()
    {
        $project = factory(Project::class)->create();

        $this->assertInstanceOf(User::class , $project->owner);
    }

    /**
     * @test
     */
    public function _it_can_add_a_task()
    {
        $project = factory(Project::class)->create();

        $task = $project->addTask('Test Task');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
}
