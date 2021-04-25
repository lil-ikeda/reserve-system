<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next, $redirectRoute = null)
    {
        $user = Auth::guard(User::USER_ROLE)->user();

        if ($user) {
            if ($user instanceof MustVerifyEmail &&
                ! $user->hasVerifiedEmail()) {
                    return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : Redirect::route('user.verification.notice');
            }
        }

        return $next($request);
    }
}