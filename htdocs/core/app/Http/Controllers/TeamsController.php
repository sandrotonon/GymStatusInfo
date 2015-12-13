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

        // Hide admin accounts with starting teamname 'verwaltung'-x
        $users = $users->filter(function ($user) {
            return substr($user->slug, 0, 10) !== 'verwaltung';
        });

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
            session()->flash('error', trans('messages.email_error'));
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
        $user->detachRoles($user->roles);

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

        // The default admin user can not delete himself
        if(in_array($user->id, [1, 2, 3])) {
            session()->flash('error', trans('messages.delete_admin_error', ['team' => $user->team]));

            return redirect(route('Teams.index'));
        }

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

        $slug = User::find($id)->slug;

        if ($validator->fails()) {
            return redirect(route('profile.{slug}.edit', $slug))
                        ->withErrors($validator)
                        ->withInput();
        }

        if (!$check) {
            return redirect(route('profile.{slug}.edit', $slug))->withErrors([trans('messages.authentication_error')]);
        }

        $user = User::find($id);

        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect(route('index'));
    }
}
