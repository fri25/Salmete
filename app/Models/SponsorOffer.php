<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorOffer extends Model
{
    protected $fillable = [
        'name', 'audience', 'price', 'price_note', 'description',
        'features', 'badge', 'sort_order', 'is_visible',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_visible' => 'boolean',
    ];
}
