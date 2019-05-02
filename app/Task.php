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

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function($task){
            $task->project->recordActivity('created_task');
        });
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete(){
        $this->update(['completed' => true]);

        $this->project->recordActivity('completed_task');

    }

    public function incomplete(){
        $this->update(['completed' => false]);

//        $this->project->recordActivity('')
    }
}
