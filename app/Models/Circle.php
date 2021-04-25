<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Circle extends Model
{
    protected $guarded = [];

    // アソシエーション
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
