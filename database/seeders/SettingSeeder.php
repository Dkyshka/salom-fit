<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'markup' => [
                'greetings' => "Salom!<br><br>Saidazim telegram botiga xush kelibsiz!<br><br>Bu yerda siz SalomFit mahsulotlarini sotib olishingiz mumkin.<br><br>Mahsulotlarni ko‘rish uchun quyidagi tugmani bosing.",
                'payment' => "Qulay to'lov turini tanlang:<br><br>*keyingi – siz obunangizni Bot menyusida boshqarishingiz mumkin<br>*Siz obuna tugaguniga qadar bildirishnomalarni olasiz",
//                'public_offer_title' => 'Taklif shartnomasi',
//                'public_offer' => 'https://simplit.io/pdfs/oferta_ru.pdf',
//                'public_offer' => 'https://poddomen.aquabox-client.uz/assets/oferta_tayyor.pdf',
                'tariff_description' => "1 oylik obuna 75 000 so'm<br>3 oylik obuna <s>225 000 so'm</s> 200 000 so'm<br>6 oylik obuna <s>450 000 so'm</s> 400 000 so'm<br>12 oylik obuna <s>900 000 so'm</s> 750 000 so'm<br>",
                'products_description' => "Keto menyu narxi 69 000 so'm<br>Menyuni quyidagi tugma orqali harid qilishingiz mumkin",
                'manager' => 'https://t.me/kelyanmedia_admin',
//                'youtube_link' => 'https://youtu.be/NrCDW4cMCMY?feature=shared',
//                'video_link' => 'https://cdn.coverr.co/videos/coverr-premium-woman-traces-on-sand/720p.mp4',
            ]
        ]);
    }
}
