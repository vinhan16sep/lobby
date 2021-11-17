<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventTimes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'event_times';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}