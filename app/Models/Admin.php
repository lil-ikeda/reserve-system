<?php

namespace App\Models;

// use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminPasswordResetNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Password;


class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * パスワードリセットに使われるブローカの取得
     */
    protected function broker()
    {
        return Password::broker('admins');
    }

    /**
     * パスワードリセット通知の送信
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(app(AdminPasswordResetNotification::class, ['token' => $token]));
    }
}
