<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'owner_id', 'notes'
    ];

    public function path(){
        return "/projects/{$this->id}";
    }

    public function owner(){
        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function activity(){
        return $this->hasMany(Activity::class);
    }

    public function addTask($body){
        return $this->tasks()->create(compact('body'));
    }

    /**
     * Record the activity for the Project
     *
     * @param $type
     */
    public function recordActivity($type){
        Activity::create([
            'project_id' => $this->id,
            'description' => $type
        ]);
    }
}
