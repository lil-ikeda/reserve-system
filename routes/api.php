<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Event関連
// Route::get('/events', 'User\EventController@index')->name('event.index');
// Route::post('/events', 'User\EventController@store');
// Route::get('/events/{id}', 'User\EventController@show')->name('event.show');
// Route::get('/events/{id}/entry', 'User\EventController@entry')->name('event.entry');
// Route::get('/events/{id}/entry/confirm', 'User\EventController@entryConfirm')->name('event.entry.confirm');
// Route::get('/events/{id}/cancel', 'User\EventController@cancel')->name('event.cancel');
// Route::get('/events/{id}/cancel/confirm', 'User\EventController@cancelConfirm')->name('event.cancel.confirm');
// Route::post('/events/{id}/cancel/sendmail', 'User\EventController@cancelSendMail')->name('event.cancel.sendmail');
// Route::get('/events/{id}/pay', 'User\EventController@pay')->name('event.pay');
// Route::put('/events/{event}', 'User\EventController@update');
// Route::delete('/events/{event}', 'User\EventController@destroy');
// Route::put('/events/{event}/join', 'User\EventController@join')->name('event.join');
// Route::delete('/events/{event}/join', 'User\EventController@unjoin')->name('event.unjoin');
Route::middleware('api')->namespace('Api')->name('api.')->group(function () {
//     Route::middleware('auth:user')->group(function() {
        // イベント関連
        Route::prefix('events')->name('events.')->group(function () { 
            Route::post('/{id}/entry', 'EventController@entry')->name('entry');
        });
//     });
});