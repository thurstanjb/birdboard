<?php

namespace Tests\Unit;

use App\Project;
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
}
