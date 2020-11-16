<?php

return [
    // S3表示のためのパス
    's3' => 'https://sh-reserve.s3.ap-northeast-1.amazonaws.com',

    'skillhack_mail' => env('SKILLHACK_MAIL'),

    // 性別
    'sex' => [
        'do_not_answer' => [
            'id' => 0
        ],
        'male' => [
            'id' => 1
        ],
        'female' => [
            'id' => 2
        ],
    ],

    // 支払方法
    'payment_method' => [
        'free' => [
            'id' => 0,
        ],
        'bank' => [
            'id' => 1
        ],
        'paypay' => [
            'id' => 2,
        ],
    ],

    // 支払ステータス
    'shipping_status' => [
        'unpaid' => [
            'id' => 0,
        ],
        'paid' => [
            'id' => 1,
        ],
    ],

    'paypay' => [
        'apikey' => env('PAYPAY_APIKEY'),
        'secret' => env('PAYPAY_SECRET'),
        'merchant' => env('PAYPAY_MERCHANT_ID'),
    ],
];
