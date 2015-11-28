<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Home routes
|--------------------------------------------------------------------------
*/
Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
Route::post('/', ['as' => 'index.filter', 'uses' => 'HomeController@filter']);


/*
|--------------------------------------------------------------------------
| Authentication routes
|--------------------------------------------------------------------------
*/
Route::get('auth/login',  ['as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('auth/login',  ['as' => 'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout',  ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::controllers([
   'password' => 'Auth\PasswordController',
]);


/*
|--------------------------------------------------------------------------
| Location routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'sporthallen', 'as' => 'Locations.'], function() {

    Route::get('/', ['as' => 'index', 'uses' => 'LocationsController@index']);
    // Save new location
    Route::post('/', ['as' => 'store', 'uses' => 'LocationsController@store']);

    Route::get('/neu', ['as' => 'create', 'uses' => 'LocationsController@create']);

    Route::get('/{slug}/bearbeiten',  ['as' => '{slug}.edit', 'uses' => 'LocationsController@edit']);
    // Save edited location
    Route::patch('/{slug}', ['as' => 'update', 'uses' => 'LocationsController@update']);

    Route::delete('/{id}', ['as' => 'destroy', 'uses' => 'LocationsController@destroy']);
});


/*
|--------------------------------------------------------------------------
| Team routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'mannschaften', 'as' => 'Teams.'], function() {

    Route::get('/', ['as' => 'index', 'uses' => 'TeamsController@index']);
    // Save new team
    Route::post('/', ['as' => 'store', 'uses' => 'TeamsController@store']);

    Route::get('/neu', ['as' => 'create', 'uses' => 'TeamsController@create']);

    Route::get('/{slug}/bearbeiten',  ['as' => '{slug}.edit', 'uses' => 'TeamsController@edit']);
    // Save edited location
    Route::patch('/{slug}', ['as' => 'update', 'uses' => 'TeamsController@update']);

    Route::delete('/{slug}', ['as' => 'destroy', 'uses' => 'TeamsController@destroy']);
});


/*
|--------------------------------------------------------------------------
| Profile routes
|--------------------------------------------------------------------------
*/
Route::get('/profil/{slug}/bearbeiten', ['as' => 'profile.{slug}.edit', 'uses' => 'TeamsController@editProfile']);
Route::patch('/profil/{id}', ['as' => 'profile.update', 'uses' => 'TeamsController@updateProfile']);


/*
|--------------------------------------------------------------------------
| Timeslot routes
|--------------------------------------------------------------------------
*/
Route::patch('timeslot/{id}/book', ['as' => 'book', 'uses' => 'TimeslotsController@book']);
Route::patch('timeslot/{id}/unbook', ['as' => 'unbook', 'uses' => 'TimeslotsController@unbook']);


/*
|--------------------------------------------------------------------------
| Password forgotten routes
|--------------------------------------------------------------------------
*/
// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');