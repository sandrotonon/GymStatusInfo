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
     * Number of places to be displayed in the view.
     *
     * @var integer
     */
    protected $places = 0;
    
    /**
     * Database state of the current timeslot.
     * 1 - Added, 2 - Removed, 0 - Default
     * @var integer
     */
    protected $dbState = 0;

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
