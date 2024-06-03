<?php

namespace Database\Seeders;

use App\Models\Skin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skin::create([
            'name' => 'skin 1',
            'image_head' => '/storage/skin1_head.svg',
            'image_body' => '/storage/skin1_body.svg',
            'featured' => 1
        ]);

        Skin::create([
            'name' => 'skin 2',
            'image_head' => '/storage/skin2_head.svg',
            'image_body' => '/storage/skin2_body.svg',
            'featured' => 2
        ]);

        Skin::create([
            'name' => 'skin 3',
            'image_head' => '/storage/skin3_head.svg',
            'image_body' => '/storage/skin3_body.svg',
            'featured' => 3
        ]);

        Skin::create([
            'name' => 'skin 4',
            'image_head' => '/storage/skin4_head.svg',
            'image_body' => '/storage/skin4_body.svg',
            'featured' => 4
        ]);
    }
}
