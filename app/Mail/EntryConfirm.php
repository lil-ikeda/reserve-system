<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EntryConfirm extends Mailable
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
            ->view('admin.mails.entryconfirm')
            ->text('admin.mails.entryconfirm')
            ->subject('【イベント名】へのエントリーが完了しました！')
            ->with([
                'text' => "
                【ユーザー名】様\n\n
                【イベント名】へのエントリーが完了しました。\n
                ご入金いただいていた場合はご返金処理も完了していますので、ご確認のほどお願いいたします。\n
                万が一ご返金の確認ができない場合は以下のメールアドレスまでご連絡をお願いいたします。\n\n
                ---------------\n
                日程：【date】\n
                時間：【opne_time】〜 【end_time】\n
                場所：【place】\n
                エントリー費：【price】（支払済）\n
                支払い方法：【payment_method】\n
                ---------------\n\n
                ご不明点などあれば下記メールアドレスまでお問い合わせください。\n
                //////////\n
                【スキルハック運営事務局】n.ikeda@arsaga.jp
                //////////\n
                ",
            ]);
    }
}
