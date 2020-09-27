<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Entry;

class Event extends Model
{

    protected $fillable = [
        'name', 'description', 'date', 'open_time', 'close_time', 'place', 'price', 'image'
    ];

    // JSONに含める属性
    protected $visible = [
        'id', 'name', 'description', 'date', 'open_time', 'close_time', 'place', 'price'
    ];

    // カスタムキャスト
    // protected $casts = [
    //     'entryUsers' => 'array'
    // ];

    // アソシエーション
    public function users()
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }

    /**
     * イベントにエントリー中のユーザーを取得
     */
    // public function getEntryUsersAttribute()
    // {
    //     // dd('OK');
    //     $entries = Entry::where('event_id', $this->id);
    //     $entryUsers = [];
    //     foreach ($entryUsers as $entryUser) {
    //         $entryUsers[] = $entryUser->user_id;
    //     }

    //     return $entryUsers;
    // }
}
