<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        Location::create([
            'name' => 'Kampus A',
            'description' => 'Gedung utama kampus A'
        ]);

        Location::create([
            'name' => 'Perpustakaan',
            'description' => 'Perpustakaan pusat kampus'
        ]);
    }
}

