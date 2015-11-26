<?php

namespace App\Http\Controllers;

use App\Location;
use App\Timeslot;
use App\Http\Requests\LocationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;

class HomeController extends Controller
{
    /**
     * Constructor function
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Show index page
     *
     * @return Response
     */
    public function index($date = null)
    {
        $showNav = true;

        if (Session::get('date') === null) {
            $date = $this->getBestDate($date);
        } else {
            $date = Session::get('date');
        }

        $timeslotsAll = $this->getTimeslotsForDate($date);

        $locations = $this->getLocations($timeslotsAll);

        // Collect times for each location
        foreach ($locations as $location) {
            $times = collect();

            $timeslots = Timeslot::where('date', '>=', $date->format('Y-m-d'))
                                    ->where('location_id', $location->id)
                                    ->get();

            foreach ($timeslots as $timeslot) {
                array_add($times, $timeslot->time, collect([]));

                // Check if current user already booked a slot at this location
                if (Auth::check() &&
                    $timeslot->user !== null &&
                    Auth::user()->id === $timeslot->user->id) {
                    $location->booked = true;
                }

                // TODO: sort times
            }
            $location->setTimes($times);
        }

        $locations = $this->associateTimes($locations, $timeslotsAll);

        // dd($locations);

        return view('index', compact('locations', 'date', 'showNav'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function book($id, $type, Request $request)
    {
        if ($type === 'book') {
            $timeslot = Timeslot::find($request['timeslot']);
            $timeslot->user_id = Auth::user()->id;
            $timeslot->save();
        } elseif ($type === 'unbook') {
            $timeslots = Location::find($id)->timeslots;
            $timeslots->each(function($item, $key) {
                if (Auth::user()->id === $item->user_id) {
                    $item->user_id = null;
                    $item->save();
                }
            });
        }

        return redirect(route('index'));
    }

    /**
     * Helper function to get the best matching date to display
     *
     * @param $date null or given date
     * @return date
     */
    private function getBestDate($date)
    {
        if ($date === null) {
            // $now = Carbon::now();
            $date = Timeslot::oldest('date')->first()->date;
            Session::put('date', $date);
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

        foreach ($timeslots as $timeslot) {
            array_add($locations, $timeslot->location->name, $timeslot->location);
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
            $times = $location->getTimes();

            foreach ($times as $timestring => $time) {
                $count = 0;
                $freeslots = 0;
                foreach ($timeslots as $timeslot) {
                    array_add($time, 'timeslots', collect([]));
                    if ($timeslot->location->name === $key &&
                        $timeslot->time === $timestring) {
                            array_add($time->get('timeslots'), $count, $timeslot);
                            $count++;
                            if ($timeslot->user_id === null) {
                                $freeslots++;
                            }
                    }
                }
                array_add($time, 'freeslots', $freeslots);
                array_add($time, 'totalslots', $count);
            }
            $location->setTimes($times);
        }

        return $locations;
    }
}
