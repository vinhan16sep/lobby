<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSeminar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_seminar';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seminar()
    {
        return $this->belongsTo(Seminars::class, 'seminar_id');
    }
}