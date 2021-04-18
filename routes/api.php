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
Route::get('/events', 'User\EventController@index')->name('event.index');
Route::post('/events', 'User\EventController@store');
Route::get('/events/{id}', 'User\EventController@show')->name('event.show');
Route::get('/events/{id}/entry', 'User\EventController@entry')->name('event.entry');
Route::get('/events/{id}/entry/confirm', 'User\EventController@entryConfirm')->name('event.entry.confirm');
Route::get('/events/{id}/cancel', 'User\EventController@cancel')->name('event.cancel');
Route::get('/events/{id}/cancel/confirm', 'User\EventController@cancelConfirm')->name('event.cancel.confirm');
Route::post('/events/{id}/cancel/sendmail', 'User\EventController@cancelSendMail')->name('event.cancel.sendmail');
Route::get('/events/{id}/pay', 'User\EventController@pay')->name('event.pay');
Route::put('/events/{event}', 'User\EventController@update');
Route::delete('/events/{event}', 'User\EventController@destroy');
Route::put('/events/{event}/join', 'User\EventController@join')->name('event.join');
Route::delete('/events/{event}/join', 'User\EventController@unjoin')->name('event.unjoin');

// Auth関連
// Route::post('/register', 'User\Auth\RegisterController@register')->name('register');
// Route::post('/login', 'User\Auth\LoginController@login')->name('login');
// Route::post('/logout', 'User\Auth\LoginController@logout')->name('logout');

Route::get('/entry/{id}', 'User\EntryController@get')->name('entry.get');

// Route::middleware('verified')->group(function () {
// });

//Route::namespace('User')->name('')->group(function () {
//    Auth::routes(['verify' => true]);
//    Route::get('/register/mail', 'User\Auth\RegisterController@registermail')->name('register.mail');
//    Auth::routes();
//});

// ログイン中なのかどうか判別するため
// Route::namespace('Api')->name('api')->group(function () {
//     Route::get('/user', function () {
//         return Auth::user();
//     })->name('user');
// });
