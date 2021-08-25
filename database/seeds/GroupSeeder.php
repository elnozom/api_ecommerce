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
            [ "icon" => "paper-roll" , "Home" => 1 , "GroupNameEn"=> "Thermal Paper products" , "GroupName"=>"الورق الحراري ", "image" => null , "FatherCode"=>null, "Featured" => 1],
            [ "icon" => "desktop-classic" , "Home" => 1 , "GroupNameEn"=> "Hardware for retail" , "GroupName"=>"هارد وير","FatherCode"=>null, "image" => null , "Featured" => 1],
        ];
        Group::insert($groups);
    }
}
