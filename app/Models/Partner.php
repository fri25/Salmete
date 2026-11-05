<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name', 'category', 'description', 'logo', 'url', 'sort_order', 'is_visible',
    ];

    protected $casts = ['is_visible' => 'boolean'];
}
