<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::create([
            'name' => 'Hair course',
            'link' => 'https://t.me/+iggd0HPOX2kyYjhi',
            'chat_id' => '-1002352538275'
        ]);

        Chat::create([
            'name' => 'Ketto menu',
            'link' => 'https://t.me/+JIwIf9dQB8wwMWI6',
            'chat_id' => '-1002476535435'
        ]);
    }
}
