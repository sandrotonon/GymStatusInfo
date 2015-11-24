<?php

namespace App\Http\Controllers;

use App\Location;
use App\Timeslot;
use App\Http\Requests\LocationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show index page
     *
     * @return Response
     */
    public function index($date = null)
    {
        $date = $this->getBestDate($date);
        $timeslots = $this->getTimeslotsForDate($date);

        $locations = $this->getLocations($timeslots);

        $locations = $this->associateTimes($locations, $timeslots);


        $showNav = true;


        /*

            $relevantDates should be:
            $relevantDates = array of GYMS
            GYMS = array of TIMES
            TIMES = array of TIMESLOTIDs and its USER_ID

            $relevantDates = array(
                'Sporthalle Stühlingen' => array(
                    'city' => 'Stühlingen',
                    'street' => 'Straße 1',
                    'times' => array(
                        '16:00' => array(
                            array('id' => '1', 'user_id' => '1'),
                            array('id' => '2' => 'user_id' => '1'),
                        ),
                        '17:00' => array(
                            array('id' => '3', 'user_id' => 1),
                            array('id' => '4' => 'user_id' =>1),
                        )
                    )
                ),
                'Sporthalle Eggingen' => array(
                    'city' => 'Stühlingen',
                    'street' => 'Straße 1',
                    'times' => array(
                        '16:00' => array(
                            array('id' => '5', 'user_id' => '1'),
                        ),
                        '17:00' => array(
                            array('id' => '6', 'user_id' => null),
                            array('id' => '7' => 'user_id' => null),
                        )
                    )
                )
            );

        */

        return view('index', compact('locations', 'showNav', 'timeslots', 'relevantLocations'));
    }

    /**
     * Helper function to get the best matching date to display
     *
     * @param $date null or given date
     * @return date
     */
    private function getBestDate($date)
    {
        if ($date == null) {
            $date = Timeslot::oldest('date')->first()->date;
        }

        return $date;
    }

    /**
     * Helper function to get an array of slots for the given date
     *
     * @param $date date at which the slots are
     * @return collection
     */
    private function getTimeslotsForDate($date)
    {
        $timeslots = Timeslot::where('date', $date->format('Y-m-d'))->get();

        return $timeslots;
    }

    /**
     * Helper class that collects the locations of timeslots
     *
     * @param $timeslots
     * @return collection Collection of Location => LocationID pairs
     */
    private function getLocations($timeslots)
    {
        $locations = array();

        foreach ($timeslots->all() as $timeslot) {
            $locations = array_add($locations, $timeslot->location->name, null);
        }

        $locations = collect($locations);

        return $locations;
    }

    /**
     * Helper class that associates times to locations
     *
     * @param $timeslots
     * @return array
     */
    private function associateTimes($locations, $timeslots)
    {
        $tmp = array();

        // TODO


        return $tmp;
    }
}
