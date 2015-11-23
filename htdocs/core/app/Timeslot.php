<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    protected $fillable = [
        'date',
        'time',
        'available'
    ];

    protected $dates = ['date'];

    /**
     * A timeslot is booked by a user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A timeslot is located at a location
     *
     * @return BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
