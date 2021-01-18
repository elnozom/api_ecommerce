<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function list(Request $request)
    {
        $areas = Area::select(['AreaName' , 'id'])->active();
        if($request->SectionNo){ 
            $areas = $areas->where('SectionNo' , $request->SectionNo);
        } else {
            $areas = $areas->main();
        }
        return $areas->get();
    }
    public function create(Request $request)
    {
        
        $area = $this->validateReq($request);
        if(gettype($area) != 'array'){
            return $area;
        }
        $area = Area::create($area);
        $q = "INSERT INTO OlAreas(AreaNo , AreaName , DeliveryServiceTotal , PostalCode , AvilableFrom , AvilableTo , `Apply` ) VALUES ($area->id , $area->AreaName , $area->DeliveryServiceTotal , $area->PostalCode , $area->AvilableFrom , $area->AvilableTo , $area->Apply , $area->SectionNo)";
        DB::insert('call SetQuery(?)',[$q]);
        return response()->json(['success' => 'true' , 'message' => 'atrea created successfully']);
    }
    public function update(Request $request , $id)
    {
        $currArea = Area::find($id);
        if(!$currArea){
            return response()->json('You are trying to edit none existing area' , 400);

        }   
        $area = $this->validateReq($request);
        if(gettype($area) != 'array'){
            return $area;
        }
        $area = Area::where('id' , $id)->update($area);
        $q = "UPDATE OlAreas SET AreaNo = $currArea->AreaNo, AreaName = $currArea->AreaName, DeliveryServiceTotal = $currArea->DeliveryServiceTotal, PostalCode = $currArea->PostalCode, AvilableFrom = $currArea->AvilableFrom, AvilableTo = $currArea->AvilableTo, `Apply` = $currArea->Apply WHERE id = $id ";
        DB::insert('call SetQuery(?)',[$q]);
        return response()->json(['success' => 'true' , 'message' => 'area updated successfully']);
    }

    public function delete($id)
    {
        $area = Area::find($id);
        if(!$area){
            return response()->json('this area is not stored' , 400);
        }
        DB::delete('DELETE FROM araes WHERE id = ? ' , [$id]);
        DB::insert('call SetQuery(?)',["DELETE FROM OlAreas WHERE AreaNo = $id"]);
        return response()->json(['success' => 'true' , 'message' => 'area deleted successfully']);
    }

    private function validateReq($request)
    {
        $rules = [
            "AreaName" => "required|max:255",
            "DeliveryServiceTotal" => "required|regex:/^\d+(\.\d{1,2})?$/|max:8",
            "PostalCode" => "nullable|max:255",
            "AvilableFrom" => "required|regex:/(\d+\:\d+)/|before:AvilableTo|max:255",
            "AvilableTo" => "required|regex:/(\d+\:\d+)/|after:AvilableFrom|max:255",
            "Apply" => "nullable|max:1",
            "SectionNo" => "nullable|max:20",
            
        ];

        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        if(isset($request->SectionNo) && !Area::find($request->SectionNo))
        {
            return response()->json('this parent area is not stored' , 400);
        }
        return $request->all();
    }

}
