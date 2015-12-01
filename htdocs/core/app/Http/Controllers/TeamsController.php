<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\TeamRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
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
        // I think it's also possible in PHP to define $roles as property and access this from view
        // like this we have duplicate code :-(
        $roles = array('' => 'Bitte Rolle wählen') + Role::lists('display_name', 'id')->all();
        $role = "Bitte Rolle wählen";

        return view('teams.create', compact('role'))->with('roles', $roles);
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

        /**
        * Find last inserted user and attach the selected role.
        */
        $insertedUser = User::where('email', '=', $request->email)->first();

        $role = Input::get('role');
        $insertedUser->attachRole($role);

        /**
        * Prepare data we would like to bind in our welcome email template.
        */
        $viewInputData = [
           'name' => Input::get('name'),
           'team' => Input::get('team'),
           'email' => Input::get('email'),
           'password' => Input::get('password'),
           'role' => Role::find($role)->name
        ];

        try {
            // Send an notification email to the newly created user
            Mail::send('emails.welcome', $viewInputData, function($message) {
                $message->to(Input::get('email'), Input::get('name'))->subject('Willkommen zur Hallenbuchung des TTF Stühlingen!');
            });
        } catch(Exception $ex) {
            // Inform the user that the welcome email has not been sent. But the user was created anyway.
            // [TODO]
        }

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
        // I think it's also possible in PHP to define $roles as property and access this from view
        // like this we have duplicate code :-(
        $roles = array('' => 'Bitte Rolle wählen') + Role::lists('display_name', 'id')->all();
        $user = User::where('slug', $slug)->first();

        $role = User::find( $user->id )->roles->first()->id;

        return view('teams.edit', compact('user', 'role'))->with('roles', $roles);
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

        // Delete all role references from user
        $user->update($request->all());
        $user>detachRoles($user->roles);

        // Attach new role to user
        $role = Input::get('role');
        $user->attachRole($role);

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
