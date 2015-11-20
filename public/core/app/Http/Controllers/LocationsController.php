<?php

namespace App\Http\Controllers;

use App\Location;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;

class LocationsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $locations = Location::orderBy('name', 'asc')->get();

        return view('indexNew', compact('locations'));
    }

    public function show($slug)
    {
        $location = Location::where('slug', $slug)->first();

        return view('location', compact('location'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store()
    {
        $input = Request::all();

        Location::create($input);

        return redirect('hallen');
    }
}
