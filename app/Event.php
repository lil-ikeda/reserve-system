<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Event extends Model
{
    protected $fillable = [
        'name', 'description', 'date', 'open_time', 'close_time', 'place', 'price'
    ];

    // アソシエーション
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
