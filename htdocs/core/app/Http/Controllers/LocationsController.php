<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LocationRequest;
use App\Http\Controllers\Controller;
use App\Location;
use App\Timeslot;

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
        return view('locations.create');
    }

    /**
     * Save new location
     *
     * @param CreateLocationRequest $request
     * @return Response
     */
    public function store(LocationRequest $request)
    {
        Location::create($request->all());

        $this->editDates($request['timeslotdates']);

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
        $timeSlots = Timeslot::where('location_id', '=', $location->id)->get();

        // timeslotdates sind die Termine (Datum und Uhrzeit) in JSON Format
        // $location->timeslotdates = $this->getDates($location->id);

        return view('locations.edit', compact('location', 'timeSlots'));
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

        $this->editDates($request['timeslotdates']);

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
                array_add($tmp, $timeslot->time, $timeslot->id);
            }

            $location->times = $tmp;
        }

        return $locations;
    }

    private function editDates($dates)
    {
        // TODO: JSON_decode and save/delete in database
    }

    /**
     * @param $id ID of the location to get its corresponding dates
     */
    private function getDates($id)
    {
        // TODO: Return dates as JSON
    }
}
