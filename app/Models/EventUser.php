<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EventUser extends Model
{
    protected $table = 'event_user';

    protected $fillable = [
        'event_id', 'user_id',
    ];

    
}
