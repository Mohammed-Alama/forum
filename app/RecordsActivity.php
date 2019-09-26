<?php


namespace App;


trait RecordsActivity
{
    protected static function bootRecordActivity()
    {
        //test it_records_activity_when_a_thread_is_created
        //is not working when comment out this lines in Thread Model

        if (auth()->guest()) return;

        foreach (static::getActivitiesToRecord() as $event){
         static::$event(function ($model) use ($event){
             $model->recordActivity($event);
         });
        };

//        static::deleting(function ($thread){
//            $thread->replies->each->delete();
//        });

////     static::created(function ($model){
////          $model->recordActivity('created');
////        });

//        static::deleting(function ($model){
//            $model->activity()->delete();
//        });


    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    public function activity()
    {
        return $this->morphMany('App\Activity','subject');
    }

    /**
     * @param $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType($event): string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
    /**
     * @param
     * @throws
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
//
//        Activity::create([
//            'user_id' => auth()->id(),
//            'type' => $this->getActivityType($event),
//            'subject_id' => $this->id,
//            'subject_type' => get_class($this)
//        ]);
    }
}