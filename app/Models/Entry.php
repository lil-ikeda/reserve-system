<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Entry extends Model
{
    protected $table = 'entries';

    protected $fillable = [
        'event_id', 'user_id', 'payment_method', 'paid', 'cancellation_request'
    ];

    // アソシエーション
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
