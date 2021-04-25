<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;

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
        if (Auth::guard($guard)->check()) {
            if ($guard === Admin::ADMIN_ROLE) {
                return redirect(RouteServiceProvider::ADMIN_TOP);
            } elseif ($guard === User::USER_ROLE) {
                return redirect(RouteServiceProvider::USER_TOP);
            }
        }
        return $next($request);
    }
}
