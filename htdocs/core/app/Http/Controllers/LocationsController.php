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
        $timeSlots = Timeslot::where('location_id', '=', $location->id)->groupBy('date', 'time', 'location_id')->get();
        
        foreach ($timeSlots as $timeSlot) {
                $timeSlot->places = 
                    Timeslot::where('location_id', '=', $location->id)
                        ->where('date', '=', $timeSlot->date)
                        ->where('time', '=', $timeSlot->time)
                        ->groupBy('date', 'time', 'location_id')->count();
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

    private function editDates($dates, $id)
    {
        $json = json_decode($dates);
        
        foreach($json as $entry) {
            if($entry->id == 0) {
                for($i = 0; $i < $entry->places; $i++) {
                DB::table('timeslots')->insert(
                    array('date' => $entry->date, 'time' => $entry->time, 'location_id' => $id)
                );
                }
            }
        }                
    }
    
    /**
     * @param $id ID of the location to get its corresponding dates
     */
    private function getDates($id)
    {
        // TODO: Return dates as JSON
    }
}
