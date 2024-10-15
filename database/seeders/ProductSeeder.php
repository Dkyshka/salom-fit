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
//        Product::create([
//            'name' => 'Hair course',
//            'description' => 'Курсы по волосам',
//            'video' => 'files/videos/nlo.mp4',
//            'price' => 1000,
//            'chat_id' => 1
//        ]);

        $product = Product::create([
            'name' => 'Keto menyu',
            'description' => "Keto menyu narxi 69 000 so'm<br>Menyuni quyidagi tugma orqali harid qilishingiz mumkin",
            'price' => 69000,
            'chat_id' => 1
        ]);

        $product->pictures()->create([
//            'orig' => '/storage/photos/shares/hair.jpg'
            'orig' => 'files/pictures/chetam.jpg'
        ]);
    }
}
