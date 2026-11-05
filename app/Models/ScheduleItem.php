<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleItem extends Model
{
    protected $fillable = [
        'day_label', 'day_date', 'start_time', 'end_time',
        'title', 'description', 'location', 'sort_order', 'is_visible',
    ];

    protected $casts = [
        'day_date' => 'date',
        'is_visible' => 'boolean',
    ];

    public function getTimeRangeAttribute(): string
    {
        $start = str_replace(':', 'h', $this->start_time);

        if ($this->end_time) {
            return $start . ' – ' . str_replace(':', 'h', $this->end_time);
        }

        return $start;
    }
}
