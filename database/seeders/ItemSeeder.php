<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        Item::create([
            'user_id' => 2,
            'location_id' => 1,
            'name' => 'Dompet Coklat',
            'description' => 'Tertinggal di ruang 101',
            'status' => 'lost',
            'date_reported' => now(),
            'image_url' => 'dompet.jpg'
        ]);
    }
}

