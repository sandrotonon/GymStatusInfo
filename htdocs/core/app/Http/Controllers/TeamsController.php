<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\TeamRequest;
use App\Http\Controllers\Controller;
use App\User;
use \Auth;
use \Validator;

class TeamsController extends Controller
{
    /**
     * Constructor function
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('teams.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teams.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TeamRequest $request)
    {
        User::create($request->all());

        // TODO: Send notification mail to user

        return redirect(route('Teams.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $user = User::where('slug', $slug)->first();

        return view('teams.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update($slug, TeamRequest $request)
    {
        $user = User::where('slug', $slug)->first();

        $user->update($request->all());


        return redirect(route('Teams.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // TODO: timeslots constraints

        $user->delete();

        return redirect(route('Teams.index'));
    }

    /**
     * Show view to change pw.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function editProfile($slug)
    {
        $user = User::where('slug', $slug)->first();

        return view('teams.profile', compact('user'));
    }

    /**
     * Update the users pw in the storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required',
            'newpassword' => 'required|min:6|confirmed',
            'newpassword_confirmation' => 'required|min:6',
        ]);

        $check = auth()->validate([
            'email'    => Auth::user()->email,
            'password' => $request->oldpassword
        ]);

        if ($validator->fails()) {
            return redirect('profile.{id}.edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $slug = User::find($id)->slug;

        if (!$check) {
            return redirect(route('profile.{slug}.edit', $slug))->withErrors(['"Aktuelles Passwort" ist falsch']);
        }

        $user = User::find($id)->first();

        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect(route('index'));
    }
}
