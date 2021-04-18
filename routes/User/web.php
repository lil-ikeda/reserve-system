<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('User')->name('user.')->group(function () {
    Auth::routes();

    Route::prefix('events')->name('events.')->group(function () { 
        Route::get('/', 'EventController@index')->name('index');
        Route::get('/{id}', 'EventController@show')->name('show');
        Route::get('/{id}/paid', 'EventController@paid')->name('paid');
    });
});