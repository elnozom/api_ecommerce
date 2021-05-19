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
                'value_ar' => '',
                'value' => 'images/settings/logo.png'
            ],
            [
                'key' => 'address',
                'value' => '3 Ibrahem Soliman from Shehab St, Mohndssen, Giza',
                'value_ar' => '3 ابراهيم سليمان , متفرع من شارع شهاب , المهندسين , الجيزة'
            ],
            [
                'key' => 'phone',
                'value_ar' => '',
                'value' => ' 0123456789 '
            ],
            [
                'key' => 'email',
                'value_ar' => '',
                'value' => ' info@elnozom.com '
            ],
            [
                'key' => 'about',
                'value' => ' Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi nobis praesentium ab cupiditate dolor.',
                'value_ar' => ' لوريم ايبسوم دولار سيت أميت ,كونسيكتيتور أدايبا يسكينج أليايت,سيت دو أيوسمود تيمبور أنكايديديونتيوت لابوري ات دولار'
            ],
        ];
        Setting::insert($settings);
    }
}
