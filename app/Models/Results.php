<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Results extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'player_id',
        'points',
        'position',
    ];

    protected $attributes = [
        'points' => 0,
        'position' => 'N/A',
    ];

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
