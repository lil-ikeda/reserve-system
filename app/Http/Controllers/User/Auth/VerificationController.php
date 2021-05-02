<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Contracts\Repositories\UserRepositoryContract;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::USER_TOP;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('user.auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param Request $request
     * @param UserRepositoryContract $userRepository
     * @return void
     */
    public function verify(Request $request, UserRepositoryContract $userRepository)
    {
        $user = $userRepository->findById($request->route('id'));
        
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }
        Log::debug(1);

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }
        Log::debug(2);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        Log::debug(3);

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * メール認証完了後
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        return redirect(route('user.verification.complete'));
    }

    /**
     * 認証確認メールの再送
     *
     * @param Request $request
     * @return void
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();
        return back()->with('user.resent', true);
    }

    /**
     * 新規登録時のメールアドレス認証完了画面
     *
     * @return View
     */
    public function complete(): View
    {
        return view('user.auth.verify_complete');
    }

    /**
     * メールアドレス認証後の遷移先
     *
     * @return string
     */
    public function redirectTo(): string
    {
        return route('user.verification.complete');
    }
}
