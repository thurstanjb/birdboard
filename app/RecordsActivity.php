<?php


namespace App;


use Illuminate\Support\Arr;

trait RecordsActivity
{

    /**
     * Store the old attributes for comparison
     *
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait.
     */
    public static function bootRecordsActivity(){
        foreach(self::recordableEvents() as $event){
            static::$event(function($model) use($event){

                $model->recordActivity($model->activityDescription($event));
            });

            if($event === 'updated'){
                static::updating(function($model){
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    protected function activityDescription($description){
        return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * Return the events the model will be using.
     *
     * @return array
     */
    public static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }

        return ['created', 'updated'];
    }

    /**
     * Return the activity for the model
     *
     * @return mixed
     */
    public function activity(){
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    /**
     * Record the activity for the Project
     *
     * @param $description
     */
    public function recordActivity($description)
    {

        $this->activity()->create([
            'user_id' => auth()->id(),
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    /**
     * Return the differences if the model has changed.
     *
     * @return array
     */
    protected function activityChanges(){
        if($this->wasChanged()){
            return [
                'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }
}
