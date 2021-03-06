<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Entry extends Model
{
    protected $table = 'entries';

    protected $guarded = [];

    // アソシエーション
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
