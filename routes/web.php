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
        Route::resource('users', 'UserController')->only(['show', 'destroy']);
    });
});


// Route::get('admin', function() {
//     return view('adminlite');
// });

// 一般ユーザー
// Route::get('/{any?}', function () {
//     return view('index');
// })->where('any', '.+');
