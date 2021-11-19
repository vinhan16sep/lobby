<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seminars extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seminars';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function eventDay()
    {
        return $this->belongsTo(EventDays::class, 'event_day_id');
    }

    public function eventTime()
    {
        return $this->belongsTo(EventTimes::class, 'event_time_id');
    }
}