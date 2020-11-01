<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelCompleted extends Mailable
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
            ->view('admin.mails.cancelcompleted')
            ->text('admin.mails.cancelcompleted')
            ->subject('【イベント名】のキャンセルを完了しました')
            ->with([
                'text' => "
                【ユーザー名】様\n\n
                【イベント名】のキャンセルを完了いたしました。\n
                ご入金いただいていた場合はご返金処理も完了していますので、ご確認のほどお願いいたします。\n
                万が一ご返金の確認ができない場合は以下のメールアドレスまでご連絡をお願いいたします。\n\n
                //////////\n
                【スキルハック運営事務局】n.ikeda@arsaga.jp
                //////////\n
                ",
            ]);
    }
}
