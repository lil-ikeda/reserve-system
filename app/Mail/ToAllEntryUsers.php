<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ToAllEntryUsers extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    public $subject;

    public $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        string $userName,
        string $subject,
        string $text
    ) {
        $this->userName = $userName;
        $this->subject = $subject;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('admin.mails.toallentries')
            ->text('admin.mails.toallentries')
            ->subject($this->subject)
            ->with([
                'userName' => $this->userName,
                'text' => $this->text
            ]);
    }
}
