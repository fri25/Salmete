<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'type', 'full_name', 'organization', 'email', 'phone',
        'profile', 'message', 'status', 'admin_note',
    ];

    public const STATUS = [
        'nouveau' => 'Nouveau',
        'en_cours' => 'En cours de traitement',
        'accepte' => 'Acceptée',
        'refuse' => 'Refusée',
    ];

    public const TYPES = [
        'participant' => 'Participant (atelier / bourse jeune)',
        'exposant' => 'Exposant (stand / sponsor)',
    ];

    public function statusBadge(): string
    {
        return match ($this->status) {
            'accepte' => 'success',
            'en_cours' => 'warning',
            'refuse' => 'danger',
            default => 'secondary',
        };
    }
}
