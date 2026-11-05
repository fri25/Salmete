<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramComponent extends Model
{
    protected $table = 'program_components';

    protected $fillable = ['title', 'icon', 'summary', 'description', 'sort_order', 'is_visible'];

    protected $casts = ['is_visible' => 'boolean'];
}
