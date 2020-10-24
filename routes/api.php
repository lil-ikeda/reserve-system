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
Route::get('/events', 'EventController@index')->name('event.index');
Route::post('/events', 'EventController@store');
Route::get('/events/{id}', 'EventController@show')->name('event.show');
Route::put('/events/{event}', 'EventController@update');
Route::delete('/events/{event}', 'EventController@destroy');
Route::put('/events/{event}/join', 'EventController@join')->name('event.join');
Route::delete('/events/{event}/join', 'EventController@unjoin')->name('event.unjoin');

// Auth関連
// 会員登録
// Route::post('/register', 'Auth\RegisterController@register')->name('register');
// // ログイン
// Route::post('/login', 'Auth\LoginController@login')->name('login');
// // ログアウト
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Route::get('/user', function () {
//     return Auth::user();
// })->name('user');

Route::namespace('Api')->name('api')->group(function() {

});