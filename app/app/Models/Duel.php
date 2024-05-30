<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Duel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // relations
    public function map(): BelongsTo  {
        return $this->belongsTo(Map::class, 'maps_id', 'id');
    }

    public function gamemode(): BelongsTo  {
        return $this->belongsTo(Gamemode::class, 'gamemodes_id', 'id');
    }

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'users_duels', 'duels_id', 'users_id');
    }
}
