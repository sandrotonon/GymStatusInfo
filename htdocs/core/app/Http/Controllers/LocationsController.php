<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\LocationRequest;
use App\Http\Controllers\Controller;
use App\Location;

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

        return view('locations.edit', compact('location'));
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

        // TODO: timeslots constraints

        $location->delete();

        return redirect(route('Locations.index'));
    }
}
