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
        $timeslot = Timeslot::find($id);
        $timeslot->user_id = Auth::user()->id;
        $saved = $timeslot->save();

        if ($request->ajax()) {
            if ($saved) {
                $data = array('status' => 'success', 'message' => 'Reservierung erfolgreich!');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unbook($id, Request $request)
    {
        $timeslot = Timeslot::find($id);
        $timeslot->user_id = null;
        $saved = $timeslot->save();

        if ($request->ajax()) {
            if ($saved) {
                $data = array('status' => 'success', 'message' => 'Reservierung gelöscht!');
            } else {
                $data = array('status' => 'error', 'message' => 'Löschen fehlgeschlagen!');
            }

            return $data;
        }

        return redirect(route('index'));
    }
}
