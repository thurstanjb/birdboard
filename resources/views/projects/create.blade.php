@extends('layouts.app')

@section('content')
    <h1>Create a Project</h1>
    <div>
        <form method="post" action="/projects" class="form">
            @csrf
            <div class="form-group">
                <label for="title" class="control-label">Title</label>
                <input type="text" class="form-control" name="title">
            </div>
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea class="form-control" name="description"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
                <a href="/projects">Cancel</a>
            </div>
        </form>
    </div>
@endsection