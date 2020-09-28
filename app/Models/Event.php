<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Entry;
use Illuminate\Support\Facades\Auth;


class Event extends Model
{

    protected $fillable = [
        'name', 'description', 'date', 'open_time', 'close_time', 'place', 'price', 'image'
    ];

    // JSONに含める属性
    protected $visible = [
        'id', 'name', 'description', 'date', 'open_time', 'close_time', 'place', 'price', 'joined_by_user', 'users'
    ];

    // アソシエーション
    public function users()
    {
        return $this
            ->belongsToMany('App\Models\User')
            ->withTimestamps();
    }

    // カスタムキャスト
    protected $appends = [
        'joined_by_user'
    ];

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
