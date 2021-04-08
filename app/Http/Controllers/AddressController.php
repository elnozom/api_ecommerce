<?php

namespace App\Http\Controllers;

use App\Address;
use App\Area;
use App\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function create(Request $request)
    {
        $address = $this->validateReq($request);
        if(gettype($address) != 'array'){
            return $address;
        }
        // dd(gettype($address));
        // if()
        $address['AccSerial'] = $request->user()->id;
        $address = Address::create($address);
        return response()->json($address->id);
    }
    public function update(Request $request , $id)
    {
        $currAddress = Address::find($id);
        if(!$currAddress){
            return response()->json('You are trying to edit none existing address' , 400);

        }   
        if($currAddress->AccSerial !== $request->user()->id){
            return response()->json("this address dosen't belong to this user" , 400);
        }
        $address = $this->validateReq($request);
        if(gettype($address) != 'array'){
            return $address;
        }
        $address = Address::where('id', $id)->update($address);
        return response()->json(['success' => true , 'message' => 'address updated successfully']);
    }
    public function delete($id)
    {
        $address = Address::find($id);
        if(!$address){
            return response()->json('this address is not stored' , 400);
        }
        DB::delete('DELETE FROM addresses WHERE id = ? ' , [$id]);
        return response()->json(['success' => true , 'message' => 'address deleted successfully']);
    }
    public function find(Request $request , $id){
        // dd('hu');
        $address = Address::find($id);
    
        if(!$address){
            return response()->json("this address dosn't exist",400);
        }
        if($address->AccSerial !== $request->user()->id){
            return response()->json("this address dosn't belong to this user",403);
        }
        $area = $address->area;
        $section = $area->parent;
        $address->section = $section->id;
        $address->areas = $section->children;
        
        
        // dd($address);
        return $address;

    }
    public function list(Request $request)
    {
        $addresses = DB::select("SELECT  a.* , p.Phone , ar.AreaName , s.AreaName SectionName , s.id SectionNo  FROM addresses a JOIN phones p ON  a.PhSerial = p.id JOIN areas ar ON a.AreaNo = ar.id JOIN areas s ON ar.SectionNo = s.id  WHERE a.AccSerial = ? ", [$request->user()->id]);
        foreach($addresses as $address){
            $title = $address->BuildingNo. ' ' . $address->Street. ' ' . $address->Remark. ' ' . $address->RowNo. ' ' . $address->FlatNo;
            $address->title = $title;
        }
        return $addresses;
    }

    private function validateReq($request)
    {
        $rules = [
            "BuildingNo" => "required|max:255",
            "RowNo" => "required|max:255",
            "FlatNo" => "required|max:255",
            "Street" => "required|max:255",
            "Remark" => "nullable|max:255",
            "Main" => "nullable|max:1|min:1",
            "AreaNo" => "required",
            "PhSerial" => "required",
            
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        if(!Phone::find($request->PhSerial))
        {
            return response()->json('this phone is not stored' , 400);
        }
        if(!Area::find($request->AreaNo))
        {
            return response()->json('this area is not stored' , 400);
        }
        return [
            'BuildingNo' => $request->BuildingNo,
            'RowNo' => $request->RowNo,
            'FlatNo' => $request->FlatNo,
            'Street' => $request->Street,
            'Remark' => $request->Remark,
            'Main' => $request->Main,
            'AreaNo' => $request->AreaNo,
            'PhSerial' => $request->PhSerial,
        ];
    }
}
