<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        dd(Auth::guard($guard)->check());
//        dd(Auth::guard($guard)->check());

        if (Auth::guard($guard)->check()) {
            if ($guard == 'admin') {
                return redirect(RouteServiceProvider::ADMIN_TOP);
            } else {
                // ログインユーザー返却用APIへ
                return redirect()->route('user');
            }
        }
//        dd($request);
        return $next($request);
    }
}
