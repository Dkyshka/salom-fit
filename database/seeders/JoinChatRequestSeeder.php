<?php

namespace Database\Seeders;

use App\Models\JoinChatRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JoinChatRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JoinChatRequest::create([
            'user_id' => '13473069',
            'chat_id' => '-1002352538275'
        ]);

        JoinChatRequest::create([
            'user_id' => '13473069',
            'chat_id' => '-1002476535435'
        ]);
    }
}
