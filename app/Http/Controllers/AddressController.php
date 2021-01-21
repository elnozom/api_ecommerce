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
        $q = "INSERT INTO OlAddresses(id , BuildingNo , RowNo , FlatNo , Street , Remark , Main , AreaNo , AccSerial , PhSerial) VALUES ($address->id , $address->BuildingNo , $address->RowNo , $address->FlatNo , $address->Street , $address->Remark , $address->Main , $address->AreaNo , $address->AccSerial , $address->PhSerial)";
        DB::insert('call SetQuery(?)',[$q]);
        return response()->json(['success' => true , 'message' => 'address created successfully']);


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
        $q = "UPDATE OlAddresses SET id = $currAddress->id, BuildingNo = $currAddress->BuildingNo, RowNo = $currAddress->RowNo, FlatNo = $currAddress->FlatNo, Street = $currAddress->Street, Remark = $currAddress->Remark, Main = $currAddress->Main, AreaNo = $currAddress->AreaNo, AccSerial = $currAddress->AccSerial, PhSerial = $currAddress->PhSerial WHERE id = $id ";
        ;
        DB::insert('call SetQuery(?)',[$q]);

        return response()->json(['success' => true , 'message' => 'address updated successfully']);

    }
    public function delete($id)
    {
        $address = Address::find($id);
        if(!$address){
            return response()->json('this address is not stored' , 400);
        }
        DB::delete('DELETE FROM addresses WHERE id = ? ' , [$id]);
        DB::insert('call SetQuery(?)',["DELETE FROM OlAddresses WHERE id = $id"]);
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
        return $address;

    }
    public function list(Request $request)
    {
        $addresses = DB::select("SELECT * FROM addresses WHERE AccSerial = ? ", [$request->user()->id]);
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
        return $request->all();
    }
}
