<?php

use Illuminate\Support\Facades\Route;

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

// 管理者ページ
Route::prefix('admin')->group(function() {
    Route::get('login', 'Auth\LoginController@adminLogin');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('register', 'Auth\LoginController@adminRegister');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('home', 'HomeController@index');
    Route::get('logout', 'Auth\LoginController@logout');
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('settings', 'HomeController@settings');
    
    Route::get('/events', 'EventController@adminIndex')->name('admin.events.index');
    Route::get('/events/create', 'EventController@adminCreate')->name('admin.events.create');
    Route::post('/events/{id}', 'EventController@adminStore')->name('admin.events.store');
    Route::get('/events/{id}', 'EventController@adminShow')->name('admin.events.show');
    Route::post('/events/{id}/update', 'EventController@adminUpdate')->name('admin.events.update');

    
    Route::get('/users/{id}', 'UsersController@adminShow')->name('admin.users.show');
});


// Route::get('admin', function() {
//     return view('adminlite');
// });

// 一般ユーザー
Route::get('/{any?}', function() {
    return view('index');
})->where('any', '.+');
