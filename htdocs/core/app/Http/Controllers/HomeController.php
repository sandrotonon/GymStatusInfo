<?php

namespace App\Http\Controllers;

use App\Location;
use App\Timeslot;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Constructor function
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'filter']]);
    }

    /**
     * Show index page
     *
     * @return Response
     */
    public function index()
    {
        $showNav = true;
        $availableDates = $this->getAvailableDates();

        if (Session::get('date') === null) {
            $date = $this->getBestDate();
        } else {
            $date = Session::get('date');
        }

        $date = Carbon::createFromFormat('Y-m-d', $date);

        $timeslotsAll = $this->getTimeslotsForDate($date);

        $locations = $this->getLocations($timeslotsAll);

        // Collect times for each location
        foreach ($locations as $location) {
            $times = collect();

            $timeslots = Timeslot::where('date', '=', $date->format('Y-m-d'))
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
            $location->times = $times;
        }

        $locations = $this->associateTimes($locations, $timeslotsAll);

        // dd($locations);

        return view('index', compact('locations', 'date', 'showNav', 'availableDates'));
    }

    /**
     * Set date to filter locations
     *
     * @return Response
     */
    public function filter(Request $request)
    {
        $date = Carbon::createFromFormat('d.m.Y', $request['date']);
        Session::put('date', $date->format('Y-m-d'));

        return redirect()->action('HomeController@index');
    }

    /**
     * Book a timeslot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function book($id, Request $request)
    {
        $timeslot = Timeslot::find($request['timeslot']);
        $timeslot->user_id = Auth::user()->id;
        $timeslot->save();

        return redirect(route('index'));
    }

    /**
     * Unbook a booked timeslot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unbook($id, Request $request)
    {
        $timeslots = Location::find($id)->timeslots;
        $timeslots->each(function($item, $key) {
            if (Auth::user()->id === $item->user_id) {
                $item->user_id = null;
                $item->save();
            }
        });

        return redirect(route('index'));
    }

    /**
     * Helper function to get different dates at which Timeslots are
     *
     * @return array
     */
    private function getAvailableDates()
    {
        $timeslots = Timeslot::where('date', '>=', Carbon::now()->format('Y-m-d'))->groupBy('date')->get();

        $timeslots->transform(function ($item, $key) {
            return $item->date->format('d.m.Y');
        });

        return $timeslots->all();
    }

    /**
     * Helper function to get the best matching date to display
     *
     * @return date
     */
    private function getBestDate()
    {
        // $now = Carbon::now();
        $date = Timeslot::where('date', '>=', Carbon::now()->format('Y-m-d'))->orderBy('date')->first()->date->format('Y-m-d');
        Session::put('date', $date);

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
            )
        );
        */

        foreach ($locations as $key => $location) {
            $times = $location->times;

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
                                $location->freeslots = $location->freeslots + 1;
                            }
                    }
                }
                array_add($time, 'freeslots', $freeslots);
                array_add($time, 'totalslots', $count);
            }
            $location->times = $times;
        }

        return $locations;
    }
}
