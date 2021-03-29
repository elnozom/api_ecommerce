<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
             
        $items = [
            ['ItemNameEn' => 'BANANA', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/1.png', 'ByWeight' => '1', 'POSPP' => 50 , 'minorPerMajor' => 1000,'POSTP' => 50 * 1000, 'GroupCode' => '1', 'ItemName' => 'موز'],
            ['ItemNameEn' => 'orange', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/2.png', 'ByWeight' => '1', 'POSPP' => 10 , 'minorPerMajor' => 1000,'POSTP' => 10 * 1000, 'GroupCode' => '1', 'ItemName' => 'برتقال'],
            ['ItemNameEn' => 'potato', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/3.png', 'ByWeight' => '1', 'POSPP' => 10 , 'minorPerMajor' => 1000,'POSTP' => 10 * 1000, 'GroupCode' => '2', 'ItemName' => 'بطاطس'],
            ['ItemNameEn' => 'tomatoes', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/5.png', 'ByWeight' => '1', 'POSPP' => 5 , 'minorPerMajor' => 1000,'POSTP' => 5 * 1000, 'GroupCode' => '2', 'ItemName' => 'طماطم'],
            ['ItemNameEn' => 'grapes', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/6.png', 'ByWeight' => '1', 'POSPP' => 5 , 'minorPerMajor' => 1000,'POSTP' => 5 * 1000, 'GroupCode' => '1', 'ItemName' => 'عنب'],
            ['ItemNameEn' => 'kiwi', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/7.png', 'ByWeight' => '1', 'POSPP' => 5 , 'minorPerMajor' => 1000,'POSTP' => 5 * 1000, 'GroupCode' => '1', 'ItemName' => 'كيوي'],
            ['ItemNameEn' => 'pepper', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/8.png', 'ByWeight' => '1', 'POSPP' => 5 , 'minorPerMajor' => 1000,'POSTP' => 5 * 1000, 'GroupCode' => '2', 'ItemName' => 'فلفل'],
            ['ItemNameEn' => 'broccoli', 'InStock' => 1 ,'latest' => 1 , 'featured' => 1 , 'ItemImage' => 'https://www.ocsolutions.co.in/html/organic_food/images/header3/4.png', 'ByWeight' => '1', 'POSPP' => 5 , 'minorPerMajor' => 1000,'POSTP' => 5 * 1000, 'GroupCode' => '2', 'ItemName' => 'بروكلي'],
        ];
        Product::insert($items);
          
      }
}
