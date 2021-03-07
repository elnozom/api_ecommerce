<?php

use App\Area;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            [
                "AreaName" => "Mohandseen",
                "DeliveryServiceTotal" => 100,
                "PostalCode" => "!2234",
                "AvilableFrom" => "12:00:00",
                "AvilableTo" => "00:00:00",
            ],
            [
                "AreaName" => "New Cairo",
                "DeliveryServiceTotal" => 100,
                "PostalCode" => "!2234",
                "AvilableFrom" => "12:00:00",
                "AvilableTo" => "00:00:00",
            ],
            [
                "AreaName" => "Nasr City",
                "DeliveryServiceTotal" => 100,
                "PostalCode" => "!2234",
                "AvilableFrom" => "12:00:00",
                "AvilableTo" => "00:00:00",
            ],
            [
                "AreaName" => "Shehab",
                "DeliveryServiceTotal" => 100,
                "PostalCode" => "!2234",
                "AvilableFrom" => "12:00:00",
                "AvilableTo" => "00:00:00",
                "SectionNo" => 1
            ],
            [
                "AreaName" => "Marghany",
                "DeliveryServiceTotal" => 100,
                "PostalCode" => "!2234",
                "AvilableFrom" => "12:00:00",
                "AvilableTo" => "00:00:00",
                "SectionNo" => 2
            ],
            [
                "AreaName" => "Abas El aqad",
                "DeliveryServiceTotal" => 100,
                "PostalCode" => "!2234",
                "AvilableFrom" => "12:00:00",
                "AvilableTo" => "00:00:00",
                "SectionNo" => 3
            ]
        ];

        foreach($areas as $area)
        {
            $area = Area::create($area);
            $q = "INSERT INTO areas(AreaNo , AreaName , DeliveryServiceTotal , PostalCode , AvilableFrom , AvilableTo , `Apply` , SectionNo) VALUES($area->id , $area->AreaName , $area->DeliveryServiceTotal , $area->PostalCode , $area->AvilableFrom , $area->AvilableTo , $area->Apply , $area->SectionNo);";
            DB::insert('call SetQuery(?)',[$q]);

            
        }

    }
}
