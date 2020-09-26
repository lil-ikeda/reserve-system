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

// 管理者ページ
Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Auth関連
    Auth::routes();

    Route::middleware('auth:admin')->group(function () {
        // トップページ
        Route::get('home', 'HomeController@index')->name('home');
        // イベント関連
        Route::resource('events', 'EventController');
    });
    Route::get('settings', 'HomeController@settings');

//    Route::get('/events', 'EventController@adminIndex')->name('admin.events.index');
//    Route::get('/events/create', 'EventController@adminCreate')->name('admin.events.create');
//    Route::post('/events/{id}', 'EventController@adminStore')->name('admin.events.store');
//    Route::get('/events/{id}', 'EventController@adminShow')->name('admin.events.show');
//    Route::post('/events/{id}/update', 'EventController@adminUpdate')->name('admin.events.update');


//    Route::get('/users/{id}', 'UsersController@adminShow')->name('admin.users.show');
});


// Route::get('admin', function() {
//     return view('adminlite');
// });

// 一般ユーザー
Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');
