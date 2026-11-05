<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = ['title', 'image', 'category', 'sort_order', 'is_visible'];

    protected $casts = ['is_visible' => 'boolean'];
}
