<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Map extends Model
{
    use HasFactory;

    public $timestamps = false;

    // relations
    public function duels(): HasMany {
        return $this->hasMany(Duel::class);
    }
}
