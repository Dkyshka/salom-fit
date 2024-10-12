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
            'video' => 'https://cdn.coverr.co/videos/coverr-temp-raycun-clip-01-mp4-4037/720p.mp4',
            'price' => 1000,
            'chat_id' => 1
        ]);

        $product = Product::create([
            'name' => 'Ketto menu',
            'description' => 'Кетто меню для быстрого похудения',
            'price' => 1000,
            'chat_id' => 2
        ]);

        $product->pictures()->create([
//            'orig' => '/storage/photos/shares/hair.jpg'
            'orig' => 'https://dfstudio-d420.kxcdn.com/wordpress/wp-content/uploads/2019/06/digital_camera_photo-1080x675.jpg'
        ]);
    }
}
