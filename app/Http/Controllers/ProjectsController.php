<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ProjectsController extends Controller
{
    public function index(){
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    /**
     * @param Project $project
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Project $project){

        $this->authorize('show', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * @return Factory|View
     */
    public function create(){
        return view('projects.create');
    }

    /**
     * @param Project $project
     * @return Factory|View
     */
    public function edit(Project $project){
        return view('projects.edit', compact('project'));
    }

    /**
     * @return RedirectResponse|Redirector
     */
    public function store(){
        $project = auth()->user()->projects()->create($this->validateRequest());

        return redirect($project->path());
    }

    /**
     * @param Project $project
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Project $project){
        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());

    }

    /**
     * @return array
     */
    public function validateRequest()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required|max:100',
            'notes' => 'min:3'
        ]);
        return $attributes;
    }

}
