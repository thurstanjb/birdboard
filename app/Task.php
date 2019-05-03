<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Task extends Model
{
    use RecordsActivity;

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

    public static $recordableEvents = ['created', 'deleted'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function path(){
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete(){
        $this->update(['completed' => true]);

        $this->recordActivity('completed_task');
    }

    public function incomplete(){
        $this->update(['completed' => false]);

        $this->recordActivity('uncompleted_task');
    }
}
