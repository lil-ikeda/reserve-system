<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $eventName;

    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $eventName, string $userName)
    {
        $this->eventName = $eventName;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('admin.mails.cancelcompleted')
            ->text('admin.mails.cancelcompleted')
            ->subject('【' . $this->eventName . '】のキャンセルを完了しました')
            ->with([
                "userName" => $this->userName,
                "eventName" => $this->eventName,
            ]);
    }
}
