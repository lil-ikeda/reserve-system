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
    // 認証
    Auth::routes([
        'register' => true,
        'reset' => true,
        'verify' => true,
    ]);
    // メール認証完了画面
    Route::get('/email/verify/complete', 'Auth\VerificationController@complete')->name('verification.complete');
    
    // イベント一覧ページ（未ログインでもアクセス可能）
    Route::get('/', 'EventController@index')->name('events.index');

    Route::middleware('verified', 'auth:user')->group(function() {
        // イベント関連
        Route::prefix('events')->name('events.')->group(function () { 
            Route::get('/{id}', 'EventController@show')->name('show');
            Route::get('/{id}/entry', 'EventController@entryPage')->name('entry_page');
            Route::get('/{id}/cancel', 'EventController@cancelPage')->name('cancel_page');
            Route::post('/{id}/entry', 'EventController@entry')->name('entry');
            Route::get('/{id}/paid', 'EventController@paid')->name('paid');
        });
    });
});