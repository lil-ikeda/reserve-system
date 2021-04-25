<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected $userRoute = 'user.login';
    protected $adminRoute = 'admin.login';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     * 未ログイン時に認証が必要なページにアクセスした時のリダイレクト先
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (Route::is('admin*')) {
                return route($this->adminRoute);
            } elseif (Route::is('user*')) {
                return route($this->userRoute);
            } else {
                return route($this->userRoute);
            }
        }
    }
}
