<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'chat_id' => 13473069,
            'name' => 'Andrew',
            'email' => 'dkyshka25@gmail.com',
            'password' => 'password',
            'in_auth' => 1,
            'role_id' => 2,
        ]);
    }
}
