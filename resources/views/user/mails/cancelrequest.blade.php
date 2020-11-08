<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
</head>
    <body>
        <p>
            {{$userName}} が【<a href="{{ route('admin.events.show', $eventId) }}">{{$eventName}}</a>】へのエントリーキャンセルを希望しています。
            <br>
            @if($paid === true)
                支払ステータスは<strong>【支払済】</strong>です。必ず返金処理をしてください。
            @elseif($paid === false)
                支払ステータスは【未払い】です。キャンセル確定処理をしてください。
            @endif
        </p>
    </body>
</html>
