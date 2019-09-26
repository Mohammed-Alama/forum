<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;

    protected static function boot()
    {
        parent::boot();
        static::created(function (Favorite $favorite) {
            $favorite->recordActivity('created');
        });
    }
    protected $guarded = [];

    protected function favorited()
    {
        return $this->morphTo();
    }
}
