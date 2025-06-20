<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        Notification::create([
            'user_id' => 2,
            'title' => 'Item kamu diklaim',
            'message' => 'Dompet Coklat kamu telah diklaim oleh seseorang.',
            'is_read' => false
        ]);
    }
}

