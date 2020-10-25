<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class AdminPasswordResetNotification extends Notification
{
    use Queueable;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function via()
    {
        return ['mail'];
    }

    public function toMail()
    {
        return app(MailMessage::class)
            ->subject('パスワードリセット')
            ->view('emails.admin.auth.password_reset')
            ->action('パスワードリセット', url('admin/password/reset', $this->token));
    }
}