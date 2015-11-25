<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeslot extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timeslots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'user_id',
        'location_id',
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
