<?php

use App\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sliders = [
            ['image' => 'clothes/sliders/01.webp'],
            ['image' => 'clothes/sliders/02.webp'],
            ['image' => 'clothes/sliders/03.webp'],
        ];
        $banners = [
            ['image' => 'clothes/banners/01.webp', 'type' => 1],
            ['image' => 'clothes/banners/02.webp', 'type' => 1],
        ];

        Banner::insert($sliders);
        Banner::insert($banners);
        
    }
}
