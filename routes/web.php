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
        Route::resource('events', 'EventController');
        Route::get('users/invite', 'UserController@invite')->name('users.invite');
        Route::post('users/invite', 'UserController@sendInviteMail')->name('users.send');
        Route::resource('users', 'UserController')->only(['show', 'destroy']);
    });
});

// 一般ユーザー
//Route::get('/', function () {
//    return view('user.index');
//});
//Route::middleware('auth:web')->group(function () {
    Route::get('/{any?}', function () {
        return view('user.index');
    })->where('any', '.+');
//});
