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

    /**
     * Holds the state if the authenticated user has booked a time at this location
     */
    public $booked = false;

    public $freeslots = 0;

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
