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
        $products = [
            [
                "ProductCode" => 123,
                "ItemName" => "product 1",  
                "ItemImage" => "https://assets.bonappetit.com/photos/57ad3f9cf1c801a1038bcadf/1:1/w_2560%2Cc_limit/grilled-sliced-brisket.jpg",     
                "ByWeight" => true,
                "InStock" => true,
                "vat" => 14,
                "POSTP" => 20,
                "POSPP" => 20,
                "MinorPerMajor" => 1,
                "GroupCode" => 4,
            ],
            [
                "ProductCode" => 1235,
                "ItemName" => "product 2", 
                "ItemImage" => "https://assets.bonappetit.com/photos/57ad3f9cf1c801a1038bcadf/1:1/w_2560%2Cc_limit/grilled-sliced-brisket.jpg",            
                "InStock" => true,
                "ByWeight" => false,
                "vat" => 14,
                "POSTP" => 20,
                "POSPP" => 5,
                "MinorPerMajor" => 5,
                "GroupCode" => 5,
            ],
            [
                "ProductCode" => 1236,
                "ItemName" => "product 3",
                "ItemImage" => "https://assets.bonappetit.com/photos/57ad3f9cf1c801a1038bcadf/1:1/w_2560%2Cc_limit/grilled-sliced-brisket.jpg",
                "InStock" => true,
                "ByWeight" => true,
                "vat" => 14,
                "POSTP" => 20,
                "POSPP" => 20,
                "MinorPerMajor" => 1,
                "GroupCode" => 4,
            ],
            [
                "ProductCode" => 12357,
                "ItemName" => "product 4",
                "ItemImage" => "https://assets.bonappetit.com/photos/57ad3f9cf1c801a1038bcadf/1:1/w_2560%2Cc_limit/grilled-sliced-brisket.jpg",
                "ByWeight" => false,
                "InStock" => false,
                "vat" => 14,
                "POSTP" => 20,
                "POSPP" => 5,
                "MinorPerMajor" => 5,
                "GroupCode" => 5,
            ]
        ];


        foreach($products as $product)
        {
            Product::create($product);
        }
    }
}
