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
        
        $groups = [
            [ "icon" => "paper-roll" , "Home" => 1 , "GroupNameEn"=> "7.9 cashier thermal paper" , "GroupName"=>"ورق طابعات كاشير حراري 7.9 سم ", "image" => null , "FatherCode"=>null, "Featured" => 1],
            [ "icon" => "paper-roll-outline" , "Home" => 1 , "GroupNameEn"=> "5.7cm thermal paper" , "GroupName"=>"ورق حراري 5.7","FatherCode"=>null, "image" => null , "Featured" => 1],
            [ "icon" => "sticker-circle-outline" , "Home" => 1 , "GroupNameEn"=> "Sticker rolls" , "GroupName"=>"ورق لصق للموازيين و الباركود","FatherCode"=>null, "image" => null , "Featured" => 1],
        ];
        
            Group::insert($groups);
        
    }
}
