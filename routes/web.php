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
        Route::delete('entry/{id}', 'EntryController@destroy')->name('entry.destroy');
//        Route::get('users/{id}', 'UserController@show')->name('users.show');
        Route::resource('users', 'UserController')->only(['index', 'show']);
        Route::delete('admins', 'AdminController@destroy')->name('admins.destroy');
        Route::get('admins/show', 'AdminController@show')->name('admins.show');
        Route::get('admins/invite', 'AdminController@invite')->name('admins.invite');
        Route::post('admins/invite', 'UserController@sendInviteMail')->name('admins.send.invitemail');
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
