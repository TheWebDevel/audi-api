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

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: PUT, POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Requested-With');
header('Access-Control-Allow-Credentials: true');

// Public routes
Route::get('/info',  ['uses' => 'AuthenticationsController@index', 'as' => 'api.info']);
Route::post('/auth/cookie', ['uses' => 'AuthenticationsController@cookie', 'as' => 'auth.verify']);
Route::post('/auth/login', ['uses' => 'AuthenticationsController@login', 'as' => 'users.login']);

// Authenticated Routes
Route::group(['middleware' => ['api', 'auth.api']], function ()
{
    Route::post('/book_audi', ['uses' => 'EventsController@events', 'as' => 'book.audi']);
    Route::post('/cancel_event/{id}', ['uses' => 'EventsController@cancel_booking', 'as' => 'cancel.booking']);
    Route::post('/timeline', ['uses' => 'EventsController@timeline', 'as' => 'audi.timeline']);
    Route::get('/event_details/{id}', ['uses' => 'EventsController@event_details', 'as' => 'event.details']);
    Route::post('/change_password', ['uses' => 'EventsController@change_password', 'as' => 'change.password']);
    Route::post('/send', ['uses' => 'EmailController@send', 'as' => 'email.send']);

});
