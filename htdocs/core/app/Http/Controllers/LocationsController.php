<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LocationRequest;
use App\Http\Controllers\Controller;
use App\Location;
use App\Timeslot;
use Auth;
use Carbon\Carbon;

class LocationsController extends Controller
{
    /**
    * Constructor function
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show all locations
    *
    * @return Response
    */
    public function index()
    {
        $locations = Location::orderBy('name')->get();

        $locations = $this->countTimes($locations);

        return view('locations.index', compact('locations'));
    }

    /**
    * Show page to create a new location
    *
    * @return Response
    */
    public function create()
    {
        $timeSlots = [];
        $timeslotdates = "[]";

        return view('locations.create', compact('timeSlots', 'timeslotdates'));
    }

    /**
    * Save new location
    *
    * @param CreateLocationRequest $request
    * @return Response
    */
    public function store(LocationRequest $request)
    {
        $location = Location::create($request->all());

        $this->editDates($request['timeslotdates'], $location->id);

        return redirect(route('Locations.index'));
    }

    /**
    * Show page to edit a location
    *
    * @param Location's slug $slug
    * @return Response
    */
    public function edit($slug)
    {
        $location = Location::where('slug', $slug)->first();
        $timeSlots = Timeslot::where('location_id', '=', $location->id)->where('date', '>=', Carbon::now()->format('Y-m-d'))->groupBy('date', 'time', 'location_id')->get();

        foreach ($timeSlots as $timeSlot) {
            $timeSlot->places =
            Timeslot::where('location_id', '=', $location->id)
            ->where('date', '=', $timeSlot->date)
            ->where('time', '=', $timeSlot->time)
            ->groupBy('date', 'time', 'location_id')->count();
            $timeSlot->dbState = 0;
        }

        // Convert to json and initialize hidden field.
        $timeslotdates = $timeSlots->toJson();

        return view('locations.edit', compact('location', 'timeSlots', 'timeslotdates'));
    }

    /**
    * Save edited location
    *
    * @param Locations's slug $slug, Request $request
    * @return Response
    */
    public function update($slug, LocationRequest $request)
    {
        $location = Location::where('slug', $slug)->first();

        $this->editDates($request['timeslotdates'], $location->id);

        $location->update($request->all());

        return redirect(route('Locations.index'));
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        $location->delete();

        return redirect(route('Locations.index'));
    }

    /**
    * Helper function to get the different times of timeslots for a location
    *
    * @param $locations
    * @return $locations
    */
    private function countTimes($locations)
    {
        foreach ($locations as $location) {
            $tmp = collect([]);

            foreach ($location->timeslots as $timeslot) {
                array_add($tmp, $timeslot->date->format('d-m-Y'), $timeslot->id);
            }

            $location->times = $tmp;
        }

        return $locations;
    }

    private function editDates($dates, $id)
    {
        $json = json_decode($dates);

        foreach($json as $entry) {
            switch($entry->dbState) {
                case 0:
                    // We are not interested in this!
                    break;
                case 1:
                    // Add new timeslot
                    for($i = 0; $i < $entry->places; $i++) {
                        $dbTimeSlot = TimeSlot::
                        create(array('date' => $entry->date, 'time' => $entry->time, 'location_id' => $id));
                    }
                    break;
                case 2:
                    // remove timeslot
                    Timeslot::where('location_id', '=', $id)
                    ->where('date', '=', $entry->date)
                    ->where('time', '=', $entry->time)->delete();
                    break;
                default:
                    // Should never happen, but when, we really want to know this
                    throw new Exception('TimeSlot with DbState: 0');
                    break;
            }
        }
    }

    /**
     * Book a timeslot
     *
     * @param  \Illuminate\Http\Request  $id ID of the location where to book
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function book($id, Request $request)
    {
        // id is currently not used, maybe check if the timeslots of the request
        // are timeslots of the location with id $id
        $success = true;

        if ($request->ajax()) {
            $toBook = $request->timeslots;
        } else {
            $toBook = $request->except(['_method', '_token']);
        }

        foreach ($toBook as $timeslot) {
            if (Timeslot::find($timeslot)->user !== null) {
                $success = false;
                break;
            }
            if (!Timeslot::find($timeslot)->book(Auth::user()->id)) {
                $success = false;
            }
        }

        if ($request->ajax()) {
            if ($success) {
                $data = array('status' => 'success', 'message' => 'Reservierung gebucht!');
            } else {
                $data = array('status' => 'error', 'message' => 'Reservieren fehlgeschlagen!');
            }

            return $data;
        }

        return redirect(route('index'));
    }

    /**
     * Unbook a booked timeslot
     *
     * @param  \Illuminate\Http\Request  $id ID of the location to unbook the timeslots
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unbook($id, Request $request)
    {
        $timeslots = Location::find($id)->timeslots;
        $success = true;

        foreach ($timeslots as $timeslot) {
            if ($timeslot->user_id === Auth::user()->id) {
                $success = $timeslot->unbook();
            }
        }

        if ($request->ajax()) {
            if ($success) {
                $data = array('status' => 'success', 'message' => 'Reservierung gelöscht!');
            } else {
                $data = array('status' => 'error', 'message' => 'Löschen fehlgeschlagen!');
            }

            return $data;
        }

        return redirect(route('index'));
    }
}