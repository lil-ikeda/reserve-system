<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Invite extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mails.invite')
        ->text('admin.mails.invite')
        ->from('noreply@skillhack.com')
        ->subject('Welcome to Skill Hack！！')
        ->with([
            'text' => "以下のリンクよりアカウント登録を行ってください。",
        ]);
    }
}
