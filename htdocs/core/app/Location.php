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
    protected $times;

    /**
     * A location can hold many timeslots
     *
     * @return HasMany
     */
    public function timeslots()
    {
        return $this->hasMany('App\Timeslot');
    }

    public function setTimes($times)
    {
        $this->times = $times;
    }

    public function getTimes()
    {
        return $this->times;
    }
}
