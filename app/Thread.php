<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;
    protected $guarded =[];

    protected $with = ['creator','channel'];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount',function ($builder){
           $builder->withCount('replies');
        });

        static::deleting(function ($thread){
            $thread->replies->each->delete();
        });

        static::deleting(function ($thread){
            $thread->activity()->delete();
        });

        static::created(function ($thread){
            $thread->recordActivity('created');
        });


//        static::addGlobalScope('creator',function ($builder){
//            $builder->with('creator');
//        });

    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }
    /**
     * A thread may have many replies
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function scopeFilter($query,$filters)
    {
        return $filters->apply($query);
    }



}
