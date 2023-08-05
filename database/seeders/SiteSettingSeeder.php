<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SiteSetting::create([
            'name'=>'adres',
            'data'=>'Erzincan adres bilgilerim burada..',
        ]);


        SiteSetting::create([
            'name'=>'phone',
            'data'=>'0531 895 16 34',
        ]);

        SiteSetting::create([
            'name'=>'email',
            'data'=>'test@domain.com',
        ]);

        SiteSetting::create([
            'name'=>'harita',
            'data'=>null,
        ]);

        SiteSetting::create([
            'name' => 'facebook',
            'data' => 'https://www.facebook.com/kullaniciadi',
        ]);

        SiteSetting::create([
            'name' => 'twitter',
            'data' => 'https://twitter.com/kullaniciadi',
        ]);

        SiteSetting::create([
            'name' => 'instagram',
            'data' => 'https://www.instagram.com/kullaniciadi',
        ]);

        SiteSetting::create([
            'name' => 'linkedin',
            'data' => 'https://www.linkedin.com/in/kullaniciadi',
        ]);

    }
}
