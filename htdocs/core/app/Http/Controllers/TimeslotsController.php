<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Timeslot;
use App\Location;
use \Auth;

class TimeslotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Book a timeslot
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function book($id, Request $request)
    {
        $_request = null;
        if ($request->ajax()) {
            // falls buchung okay:
            $data = array('status' => 'error');

            // Falls buchung nicht okay:
            // $data = array('status' => 'success', 'message' => 'Fehlermeldung');

            return $data;
        }

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
}
