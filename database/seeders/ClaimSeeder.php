<?php

namespace Database\Seeders;

use App\Models\Claim;
use Illuminate\Database\Seeder;

class ClaimSeeder extends Seeder
{
    public function run()
    {
        Claim::create([
            'user_id' => 2,
            'item_id' => 1,
            'description' => 'Ini milik saya, ada kartu pelajar di dalamnya.'
        ]);
    }
}

