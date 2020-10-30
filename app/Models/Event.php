<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date',
        'open_time',
        'close_time',
        'place',
        'price',
        'image',
    ];

    // JSONに含める属性
    protected $visible = [
        'id',
        'name',
        'description',
        'date',
        'open_time',
        'close_time',
        'place',
        'price',
        'joined_by_user',
        'users',
        'image',
    ];

    // アソシエーション
    public function users()
    {
        return $this
            ->belongsToMany(User::class, 'entries', 'event_id', 'user_id');
    }

    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    // カスタムキャスト
    protected $appends = [
        'joined_by_user'
    ];

    // ログイン中のユーザーがエントリー済かどうかチェック
    public function getJoinedByUserAttribute()
    {
        // 未ログインならfalseを返す
        if (Auth::guest()) {
            return false;
        }

        return $this->users->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }
}
