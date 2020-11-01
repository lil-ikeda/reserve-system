<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Canceled extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('admin.mails.canceled')
            ->text('admin.mails.canceled')
            ->subject('【イベント名】のキャンセル希望')
            ->with([
                'text' => "【ユーザー名】がキャンセルの希望をしています。\n支払いステータスは【支払済/未払い】です。",
            ]);
    }
}
