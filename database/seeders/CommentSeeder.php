<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run()
    {
        Comment::create([
            'user_id' => 2,
            'item_id' => 1,
            'content' => 'Saya menemukan barang ini di kantin.'
        ]);
    }
}

