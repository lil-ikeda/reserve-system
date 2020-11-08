<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
</head>
    <body>
        <p>
            {{ $userName }} 様
        </p>
        <p>
            【{{ $eventName }}】へのエントリーが完了しました。
            <br>
            開催日前日までに必ずエントリー費のお支払いをしていただきますようお願いいたします。
            <br>
            <br>
            ■イベント情報
            <br>
            日程：{{ $date }}<br>
            時間：{{ $openTime }} 〜 {{ $endTime }}<br>
            場所：{{ $price }}<br>
            エントリー費：{{ $price }}<br>
            @if($paymentMethod === config('const.payment_method.bank.id'))
                支払い方法：口座振込<br><br>
                ■振込先<br>
                銀行名：三菱東京UFJ<br>
                口座種別：----<br>
                口座番号：----<br>
            @elseif($paymentMethod === config('const.payment_method.paypay.id'))
                支払い方法：PayPay<br>
            @endif
        </p>
        <p>
            //////////////////////
            <br>
            スキルハック運営事務局
            <br>
            example@skillhack.com
            <br>
            //////////////////////
        </p>
    </body>
</html>
