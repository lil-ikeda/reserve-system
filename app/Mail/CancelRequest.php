<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CancelRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    public $eventId;

    public $eventName;

    public $paid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $userName, int $eventId, string $eventName, bool $paid)
    {
        $this->userName = $userName;
        $this->eventId = $eventId;
        $this->eventName = $eventName;
        $this->paid = $paid;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('user.mails.cancelrequest')
            ->text('user.mails.cancelrequest')
            ->subject('【' . $this->eventName . '】のキャンセル希望')
            ->with([
                'userName' => $this->userName,
                'eventName' => $this->eventName,
                'eventId' => $this->eventId,
                'paid' => $this->paid,
            ]);
    }
}
