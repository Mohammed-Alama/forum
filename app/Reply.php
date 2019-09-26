<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable,RecordsActivity;
    protected static function boot()
    {
        parent::boot();
        static::created(function (Reply $reply) {
            $reply->recordActivity('created');
        });

        static::deleting(function ($reply){
            $reply->activity()->delete();
        });
    }
    protected $guarded =[];

    protected $with = ['owner','favorites'];

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
//        return 'A7A';
        return $this->thread->path()."#reply-{$this->id}";
    }


}
