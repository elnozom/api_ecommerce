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
    [ "Home" => 0 , "GroupName"=>"المخبوزات ","FatherCode"=>null, "Featured" => 1, "image" => "https://spinneys-egypt.com/storage/slider_images/Spinneys%20Online%20Shop/jAnOLwsIMdXEgEGBcz90TBRfUsRn7uPZXvRc5yRZ.jpeg"],
    [ "Home" => 0 , "GroupName"=>"المعجنات و الحلويات","FatherCode"=>1, "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"خيز","FatherCode"=>1, "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الاطعمة الطازجة","FatherCode"=>null, "Featured" => 1, "image" => "https://spinneys-egypt.com/storage/slider_images/Spinneys%20Online%20Shop/lzvznj6xopJjxDH1umYggk2P9FOd8xzC9u8Gh9j9.jpeg"],
    [ "Home" => 0 , "GroupName"=>"الخضروات و الفاكة","FatherCode"=>4,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"اللحوم و الدواجن ","FatherCode"=>4,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الاسماك","FatherCode"=>4,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الاطعمة الجافه و البقالة ","FatherCode"=>null,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"البقاله","FatherCode"=>8,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الارز و البقوليات","FatherCode"=>9,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"حبوب المكرونة ","FatherCode"=>9,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"السكر","FatherCode"=>9,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"لوازم الخبز و الحلاويات ","FatherCode"=>9,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"طعام الافطار","FatherCode"=>9,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"المربى و الاحلاوة و الشكولاتة ","FatherCode"=>14,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الافطار","FatherCode"=>14,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"المعلبات ","FatherCode"=>8,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الاطعمة المعلبة ","FatherCode"=>17,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"المخللات","FatherCode"=>17,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"المرق  الحساء ","FatherCode"=>17,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"منتجات الالبان المعلبة ","FatherCode"=>17,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"نودلز","FatherCode"=>17,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"التوابل والصوصات ","FatherCode"=>8,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الاعشاب و التوابل ","FatherCode"=>23,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الصوصات","FatherCode"=>23,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الزيوت و السمنة","FatherCode"=>8,  "image" => null , "Featured" => 0],
    [ "Home" => 1 , "GroupName"=>"منتجات الالبان والزبدة والبيض ","FatherCode"=>null, "Featured" => 1, "image" => "https://spinneys-egypt.com/storage/slider_images/Spinneys%20Online%20Shop/egxEe2rl5j0T1WIinV65QmC9tslT7xjIo4xtM03z.jpeg"],
    [ "Home" => 0 , "GroupName"=>"الالبان ","FatherCode"=>27,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"البيض","FatherCode"=>27,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الاجبان","FatherCode"=>27,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الزبادي ","FatherCode"=>27,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الزبدة","FatherCode"=>27,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"منتجات مبردة ومجمدة ","FatherCode"=>null,  "image" => null , "Featured" => 0],
    [ "Home" => 1 , "GroupName"=>"مصنعات اللحوم المبردة","FatherCode"=>33,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"لحوم - دجاج - اسماك","FatherCode"=>33,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الخضروات المجمدة","FatherCode"=>33,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"معجنات معلبة","FatherCode"=>33,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"وجبات جاهزه","FatherCode"=>33,  "image" => null , "Featured" => 0],
    [ "Home" => 1 , "GroupName"=>"المشروبات","FatherCode"=>null,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"الشاى و القهوه","FatherCode"=>39,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"المشروبات الساخنة","FatherCode"=>39,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"المشروبات الباردة","FatherCode"=>39,  "image" => null , "Featured" => 0],
    [ "Home" => 0 , "GroupName"=>"المياة المعدنية","FatherCode"=>3  ,"image" => null , "Featured" => 0],
  ];
        $chunks = array_chunk($groups , 100);
        foreach($chunks as $chunk)
        {
            Group::insert($chunk);
        }
    }
}
