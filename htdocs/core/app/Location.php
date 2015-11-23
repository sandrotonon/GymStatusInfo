<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'country',
        'city',
        'street'
    ];

    /**
     * A location can hold many timeslots
     *
     * @return HasMany
     */
    public function timelots()
    {
        return $this->hasMany('App\Timeslot');
    }
}
