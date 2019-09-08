<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'project_id', 'description', 'changes', 'user_id'
    ];

    protected $casts = [
        'changes' => 'array'
    ];

    public function subject(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userName(){
        if(auth()->check() && auth()->id() === $this->user_id){
            return 'You';
        }

        return $this->user->name;
    }
}
