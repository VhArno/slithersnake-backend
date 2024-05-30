<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gamemode extends Model
{
    use HasFactory;

    public $timestamps = false;

    // relations
    public function duels(): HasMany {
        return $this->hasMany(Duel::class);
    }
}
