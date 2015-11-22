<?php

namespace App\Http\Controllers;

use App\Location;
use App\Http\Requests\LocationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    /**
     * Constructor function
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Show all locations
     *
     * @return Response
     */
    public function index()
    {
        $showNav = true;
        $locations = Location::orderBy('name')->get();

        return view('index', compact('locations', 'showNav'));
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

        return redirect('/');
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

        return redirect('/');
    }
}
