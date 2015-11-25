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
        $showNav = true;
        $date = $this->getBestDate($date);
        $timeslots = $this->getTimeslotsForDate($date);

        $locations = $this->getLocations($timeslots);

        $locations->each(function ($location, $key) {
            $times = collect();

            $location->timeslots->each(function ($timeslot, $id) use ($times) {
                array_add($times, $timeslot->time, collect([]));

                // Check if current user already booked a slot at this time
                if (\Auth::check() &&
                    $timeslot->user !== null &&
                    \Auth::user()->team === $timeslot->user->team) {
                    array_add($times->get($timeslot->time), 'booked', true);
                } else {
                    array_add($times->get($timeslot->time), 'booked', false);
                }

                // TODO: sort times
            });
            $location->setTimes($times);
        });

        $locations = $this->associateTimes($locations, $timeslots);

        // dd($locations);

        return view('index', compact('locations', 'showNav'));
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
     * @return collection Collection of LocationName => Location pairs
     */
    private function getLocations($timeslots)
    {
        $locations = collect([]);

        foreach ($timeslots->all() as $timeslot) {
            $locations->put($timeslot->location->name, $timeslot->location)->unique();
        }

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
        /*
        Generates array like:

        $relevantDates should be:

        $relevantDates = array(
            'Sporthalle Stühlingen' => array(
                'city' => 'Stühlingen',
                'street' => 'Straße 1',
                'times' => array(
                    '16:00' => array(
                        array('id' => '1', 'user_id' => '1'),
                        array('id' => '2', 'user_id' => '1'),
                    ),
                    '17:00' => array(
                        array('id' => '3', 'user_id' => 1),
                        array('id' => '4', 'user_id' =>1),
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
                        array('id' => '7', 'user_id' => null),
                    )
                )
            )
        );
        */

        foreach ($locations as $key => $location) {
            $locationtimes = $location->getTimes();

            foreach ($timeslots as $timeslot) {
                foreach ($locationtimes as $locationtime => $content) {
                    if ($content->get('timeslots') === null) {
                        $content->put('timeslots', collect([]));
                    }
                    if ($timeslot->location->name === $key &&
                        $timeslot->time === $locationtime) {
                            // $content->get('timeslots')->put($timeslot->id, $timeslot);
                            // $content->get('timeslots')->unique();
                            array_add($content->get('timeslots'), $timeslot->id, $timeslot);
                    }
                }
            }
            $location->setTimes($locationtimes);
        }

        return $locations;
    }
}
