<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'country',
        'city',
        'street'
    ];

    /**
     * Collection with times at this location
     *
     * @var string
     */
    public $times;

    public $booked = false;

    public $freeslots = 0;

    /**
     * Temporary filled with dates for the timeslots, named timeslotdates cuz dates is reserved
     */
    public $timeslotdates;

    /**
     * A location can hold many timeslots
     *
     * @return HasMany
     */
    public function timeslots()
    {
        return $this->hasMany('App\Timeslot');
    }
}
