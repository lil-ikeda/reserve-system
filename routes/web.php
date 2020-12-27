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
        Route::get('events/{id}/mail', 'EventController@mail')->name('events.create.mail');
        Route::post('events/{id}/mail', 'EventController@sendMail')->name('events.send.mail');
        Route::delete('entry/{id}', 'EntryController@destroy')->name('entry.destroy');
        Route::post('entry/{id}', 'EntryController@paid')->name('entry.paid');
//        Route::get('users/{id}', 'UserController@show')->name('users.show');
        Route::resource('users', 'UserController')->only(['index', 'show']);
        Route::delete('admins', 'AdminController@destroy')->name('admins.destroy');
        Route::get('admins/show', 'AdminController@show')->name('admins.show');
        Route::get('admins/index', 'AdminController@index')->name('admins.index');
        Route::get('admins/invite', 'AdminController@invite')->name('admins.invite');
        Route::post('admins/invite', 'AdminController@sendInviteMail')->name('admins.send.invitemail');
        Route::get('admins/pay', 'PayPayController@paypay')->name('admins.paypay');
    });
});

// 一般ユーザー
Route::prefix('users')->namespace('User')->name('users.')->group(function () {
    Route::get('events/{id}/paid', 'EventController@paid')->name('event.paid');
//    Auth::routes(
//        [
//        'verify' => true,
//        'login' => false,
//        'logout' => false,
//        'register' => false,
//        ]
//    );
});

//Route::middleware('auth:web')->group(function () {
    Route::get('/{any?}', function () {
        return view('user.index');
    })->where('any', '.+');
//});
