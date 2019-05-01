<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'project_id', 'body', 'completed'
    ];

    protected $touches = [
        'project'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }
}
