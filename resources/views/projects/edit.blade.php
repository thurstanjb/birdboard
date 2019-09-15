@extends('layouts.app')

@section('content')
    <div class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 rounded shadow">

        <h1 class="text-2xl font-normal mb-10 text-center">
            Edit your project
        </h1>

        <form method="post" action="{{$project->path()}}">

            @method('patch')
            @include('projects.form', [
            'buttonText' => 'Update Project'
            ])

        </form>

    </div>
@endsection