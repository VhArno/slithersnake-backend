<?php

namespace Database\Seeders;

use App\Models\Gamemode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GamemodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gamemode::create([
            'name' => 'standard',
            'image' => 'storage/mode_standaard.png',
        ]);

        Gamemode::create([
            'name' => 'power-ups',
            'image' => 'storage/mode_power-ups.png',
        ]);

        Gamemode::create([
            'name' => 'limited-time',
            'image' => 'storage/mode_limited-time.png',
        ]);

        Gamemode::create([
            'name' => 'unlimited-time',
            'image' => 'storage/mode_unlimited-time.png',
        ]);
    }
}