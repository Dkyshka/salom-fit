<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Hair course',
            'description' => 'Курсы по волосам',
            'video' => 'files/videos/nlo.mp4',
            'price' => 1000,
            'chat_id' => 1
        ]);

        $product = Product::create([
            'name' => 'Ketto menu',
            'description' => 'Кетто меню для быстрого похудения',
            'price' => 1500,
            'chat_id' => 2
        ]);

        $product->pictures()->create([
//            'orig' => '/storage/photos/shares/hair.jpg'
            'orig' => 'files/pictures/chetam.jpg'
        ]);
    }
}
