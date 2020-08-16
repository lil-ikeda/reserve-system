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
Route::get('/events', 'EventController@index');
// Route::get('/events/create', 'EventController@create');
Route::post('/events', 'EventController@store');
Route::get('/events/{id}', 'EventController@show');
Route::put('/events/{event}', 'EventController@update');
Route::delete('/events/{event}', 'EventController@destroy');

// Auth関連
// 会員登録
Route::post('/register', 'Auth\RegisterController@register')->name('register');
// ログイン
Route::post('/login', 'Auth\LoginController@login')->name('login');
// ログアウト
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/user', function() {
  return Auth::user();
})->name('user');