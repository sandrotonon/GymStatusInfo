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
Route::get('/{date?}', ['as' => 'index', 'uses' => 'HomeController@index']);


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

    Route::delete('/{slug}', ['as' => 'destroy', 'uses' => 'LocationsController@destroy']);

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
| Timeslot routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'zeitpunkt', 'as' => 'Timeslot.'], function() {

    // Save booked timeslot
    Route::patch('/{timeslot}/buchen', ['as' => '{timeslot}.book', 'uses' => 'TeamsController@book']);

});
