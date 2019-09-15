@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-6 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-muted font-light">
                <a href="/projects" class="text-muted no-underline hover:underline">My Projects</a> / {{$project->title}}
            </p>
            <div class="flex items-center">
                @foreach($project->members as $member)
                       <img
                               src="{{gravatar_url($member->email)}}"
                               alt="{{$member->name}}"
                               class="rounded-full w-8 mr-2">
                @endforeach
                    <img
                            src="{{gravatar_url($project->owner->email)}}"
                            alt="{{$project->owner->name}}"
                            class="rounded-full w-8 mr-2">

                    <a href="{{$project->path().'/edit'}}" class="button ml-4">Edit Project</a>
            </div>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-muted font-light text-lg mb-3">Tasks</h2>

                    {{--tasks--}}
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{$task->path()}}" method="post">
                                @method('patch')
                                @csrf
                                <div class="flex">
                                    <input name="body" value="{{$task->body}}" class="bg-card text-default w-full {{$task->completed ? 'text-default' : ''}}">
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{$task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form method="post" action="{{$project->path() . '/tasks'}}">
                            @csrf
                            <input name="body" placeholder="Add a new task..." class="bg-card text-default w-full">
                        </form>
                    </div>

                </div>


                <h2 class="text-muted font-light text-lg mb-3">General Notes</h2>

                {{--General notes--}}
                <form method="post" action="{{$project->path()}}">
                    @method('patch')
                    @csrf
                    <textarea
                            class="card w-full mb-4 text-default"
                            style="min-height: 200px"
                            name="notes"
                            placeholder="Anthing you want to take note of..."
                    >{{$project->notes}}</textarea>

                    <button type="submit" class="button">Save</button>
                </form>

                @include('errors')

            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
                @include('projects.activity.card')

                @can('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>

        </div>
    </main>

@endsection
