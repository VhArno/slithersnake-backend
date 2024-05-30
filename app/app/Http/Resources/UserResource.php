<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'level' => $this->level,
            'highscore' => $this->highscore,
            'games_played' => $this->games_played,
            'games_won' => $this->games_won,
            'players_killed' => $this->players_killed,
            'duels' => DuelResource::collection($this->duels),
        ];
    }
}
