<?php

use App\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mainGroups = [
            [
                "GroupName" => "meet",
                "ByWeight" => true,
                
            ],
            [
                "GroupName" => "canned",
                "ByWeight" => false,
                
            ],
        ];

        $meets = [
            [
                "GroupName" => "Bacon",
                "ByWeight" => true,
            ],
            [
                "GroupName" => "Beaf / Steak",
                "ByWeight" => true,
            ],
            [
                "GroupName" => "Chicken",
                "ByWeight" => true,
            ],
            [
                "GroupName" => "Fish",
                "ByWeight" => true,
            ],
        ];

        $canned = [
            [
                "GroupName" => "Applesauce",
                "ByWeight" => true,
            ],
            [
                "GroupName" => "Beans",
                "ByWeight" => true,
            ],
            [
                "GroupName" => "Chili",
                "ByWeight" => true,
            ],
            [
                "GroupName" => "Fruits",
                "ByWeight" => true,
            ],
            [
                "GroupName" => "Mushrooms",
                "ByWeight" => false,
            ],
            [
                "GroupName" => "Olives",
                "ByWeight" => false,
            ],
            [
                "GroupName" => "Soup",
                "ByWeight" => false,
            ],
            [
                "GroupName" => "Tomato Sauce",
                "ByWeight" => false,
            ],
            [
                "GroupName" => "Tuna",
                "ByWeight" => false,
            ],
            [
                "GroupName" => "Vegetables",
                "ByWeight" => true,
            ],
        ];

        foreach($mainGroups as $gr)
        {
            $group = Group::create($gr);
            if($gr['GroupName'] == 'meet'){
                foreach($meets as $meet){
                    $meet['FatherCode'] = $group->id;
                    Group::create($meet);
                }
            }
            if($gr['GroupName'] == 'canned'){

                foreach($canned as $ca){
                    $ca['FatherCode'] = $group->id;
                    Group::create($ca);
                }
            }
        }
    }
}
