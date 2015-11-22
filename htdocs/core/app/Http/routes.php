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

// Authentication routes
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::controllers([
   'password' => 'Auth\PasswordController',
]);

// Location routes
Route::get('/', 'LocationsController@index');
Route::post('sporthallen', 'LocationsController@store'); // Save new location
Route::get('sporthallen/neu', 'LocationsController@create');
Route::get('sporthallen/{slug}/bearbeiten', 'LocationsController@edit');
Route::patch('sporthallen/{slug}', 'LocationsController@update'); // Save edited location

// Team routes
Route::get('mannschaften', 'TeamsController@index');
Route::get('mannschaften/neu', 'TeamsController@create');
