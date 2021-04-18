<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

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
            if ($request->is('admin*')) {
                return route($this->adminRoute);
            } else {
                return route($this->userRoute);
            }
        }
    }
}
