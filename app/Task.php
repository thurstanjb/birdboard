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

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function activity(){
        return $this->morphMany(Activity::class, 'subject')->latest();
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

    /**
     * Record the activity for the Project
     *
     * @param $description
     */
    public function recordActivity($description){
        $this->activity()->create([
            'project_id' => $this->project->id,
            'description' => $description
        ]);
    }
}
