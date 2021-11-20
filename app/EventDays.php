<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventDays extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_days';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function eventTimes() {
        return $this->hasMany('App\EventTimes', 'event_day_id');
    }

    public function seminars() {
        return $this->hasManyThrough('App\Seminars', 'App\EventTimes', 'event_day_id', 'event_time_id', 'id');
    }
}