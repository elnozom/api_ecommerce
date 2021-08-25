<?php

use App\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            [
                'key' => 'logo',
                'value_ar' => 'settings/logo.png',
                'type' => 'image',
                'value' => 'settings/logo.png'
            ],
            [
                'key' => 'address',
                'value' => '3 Ibrahem Soliman from Shehab St, Mohndssen, Giza',
                'value_ar' => '3 ابراهيم سليمان , متفرع من شارع شهاب , المهندسين , الجيزة',
                'type' => 'text',
            ],
            [
                'key' => 'phone',
                'value_ar' => '02 33041499',
                'type' => 'text',
                'value' => ' 02 33041499 '
            ],
            [
                'key' => 'email',
                'value_ar' => 'info@elnozom.com',
                'type' => 'email',
                'value' => ' info@elnozom.com'
            ],
            [
                'key' => 'about',
                'value' => 'A distinguished company and entity established in 1994 and has a leading role in the Egyptian market with distinguished solutions and programs that are easy to use in all retail and wholesale sectors.',
                'value_ar' =>"شركة و كيان مميز أنشئت عام 1994 ولها دور رائد في السوق المصري بحلول وبرامج متميزة سهلة الاستخدام فى جميع قطاعات التجزئة و الجملة.",
                'type' => 'textarea',
            ],
            [
                'key' => 'facebook',
                'value_ar' => 'https://www.facebook.com/ElNozomSystems/',
                'type' => 'text',
                'value' => 'https://www.facebook.com/ElNozomSystems/'
            ],
            [
                'key' => 'instagram',
                'value_ar' => 'https://www.instagram.com/elnozomeg/',
                'type' => 'text',
                'value' => 'https://www.instagram.com/elnozomeg/
                '
            ],

        ];
        Setting::insert($settings);
    }
}
