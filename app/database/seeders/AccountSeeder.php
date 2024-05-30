<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'Azerty123',
            'level' => 0,
            'highscore' => 0,
            'games_played' => 0,
            'games_won' => 0,
            'players_killed' => 0,
        ]);
    }
}
