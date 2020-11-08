<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntryConfirm extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    public $eventName;

    public $date;

    public $openTime;

    public $closeTime;

    public $price;

    public $paymentMethod;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        string $userName,
        string $eventName,
        string $date,
        string $openTime,
        string $closeTime,
        int $price,
        int $paymentMethod
    ) {
        $this->userName = $userName;
        $this->eventName = $eventName;
        $this->date = $date;
        $this->openTime = $openTime;
        $this->closeTime = $closeTime;
        $this->price = $price;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->view('user.mails.entryconfirm')
            ->text('user.mails.entryconfirm')
            ->subject('【' . $this->eventName .'】へのエントリーが完了しました！')
            ->with([
                'userName' => $this->userName,
                'eventName' => $this->eventName,
                'date' => $this->date,
                'openTime' =>  $this->openTime,
                'endTime' => $this->closeTime,
                'price' => $this->price,
                'paymentMethod' => $this->paymentMethod,
            ]);
    }
}
