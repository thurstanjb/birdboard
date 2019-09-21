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
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));
    }

    /**
     * @param Project $project
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Project $project){
        $this->authorize('update', $project);

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
     * @return mixed
     */
    public function store(){
        $project = auth()->user()->projects()->create($this->validateRequest());

        if(request()->wantsJson()){
            return ['message' => $project->path()];
        }

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
     * @param Project $project
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Project $project){
        $this->authorize('manage', $project);

        $project->delete();

        return redirect()->route('projects.index');
    }

    /**
     * @return array
     */
    protected function validateRequest()
    {
        $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required|max:200',
            'notes' => 'nullable'
        ]);
        return $attributes;
    }

}
