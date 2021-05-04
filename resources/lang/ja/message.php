<?php
return [
    'success' => [
        'event' => [
            'create' => 'イベントの登録が完了しました。',
            'update' => 'イベントの更新が完了しました。',
            'delete' => 'イベントの削除が完了しました。',
        ],
        'sendmail' => [
            'to_all' => 'イベントの参加者全員へのメール送信が完了しました。'
        ],
        'admin' => [
            'invite' => '管理者の招待メールを送信しました。',
        ],
        'pay' => 'お支払い処理が正常に完了いたしました。'
    ],
    'error' => [
        'event' => [
            'create' => 'イベントの登録に失敗しました。',
            'update' => 'イベントの更新に失敗しました。',
            'update' => 'イベントの削除に失敗しました。',
        ],
        'sendmail' => [
            'to_all' => 'イベントの参加者全員へのメール送信が失敗しました。'
        ],
        'admin' => [
            'invite' => '管理者の招待メール送信に失敗しました。',
        ],
        'pay' => 'お支払い処理に失敗いたしました。'
    ]
];