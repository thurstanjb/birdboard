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
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($body){
        return $this->tasks()->create(compact('body'));
    }

    /**
     * Record the activity for the Project
     *
     * @param $description
     */
    public function recordActivity($description){
        $this->activity()->create(compact('description'));
    }
}
