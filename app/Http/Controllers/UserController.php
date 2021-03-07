<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Coupon;
use App\Phone;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function get(Request $request)
    {
        $user = User::find($request->user()->id);
        $phones = Phone::where('AccSerial' , $request->user()->id)->select(['phone' , 'id'])->get();
        $user->phones = $phones;
        // dd($request->user()->phones->pluck('Phone')->flatten());

        return ['user' => $user];
    }
    public function update(Request $request)
    {
        $id = $request->user()->id;
        $currUser = User::find($id);
       
        $rules = [
            'email' => 'required|email|max:255',
            'password' => 'nullable|max:255',
            'name' => 'required|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $userRequest =  [
            'name' =>$request->name,
            'email' =>$request->email,
        ];
        if(isset($request->password)){
            $userRequest['password'] = bcrypt($request->password);
        }
        
        User::where('id', $id)->update($userRequest);
        $q = "UPDATE  OlAccounts SET AccSerial = $currUser->AccSerial , `Name` = $currUser->Name , Email = $currUser->Email , `Password` = $currUser->password WHERE id = $id";
        DB::insert('call SetQuery(?)',[$q]);
        
        return response()->json(['success' => 'true' , 'message' => 'User data updated successfully']);
    }
    public function UpdatePhone(Request $request , $id)
    {
        
        $currPhone = Phone::find($id);
        if(!$currPhone){
            return response()->json('this phone is not stored' , 400); 
        }
        
        $rules = [
            'phone' => 'required|max:255|unique:phones,phone,'.$id,      
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $currPhone->update($request->all());
        
  
  
        $q = "UPDATE PlPhones SET PhSerial = $currPhone->id , Phone = $currPhone->Phone , AccSerial = $currPhone->AccSerial";
        DB::insert('call SetQuery(?)',[$q]);
        return response()->json(['success' => 'true' , 'message' => 'Phone updated successfully']);

    }
    public function DeletePhone(Request $request , $id)
    {
        $phone = Phone::find($id);
        if(!$phone){
            return response()->json('this phone is not stored' , 400);
        }
        if($phone->AccSerial != $request->user()->id){
            return response()->json('this phone dosen\'t belong to this user' , 400);
        }
        DB::delete('DELETE FROM phones WHERE id = ? ' , [$id]);
        DB::insert('call SetQuery(?)',["DELETE FROM PlPhones WHERE PhSerial = $id"]);
        return response()->json(['success' => 'true' , 'message' => 'phone deleted successfully']);
    }
    public function AddPhone(Request $request)
    {
        $rules = [
            'phone' => 'required|digits_between:11,14|unique:phones|max:255',      
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $phone = Phone::create([
            "Phone" => $request->phone ,
            "AccSerial" => $request->user()->id,
        ]);
        
  
  
        $q = "INSERT INTO PlPhones(PhSerial , Phone , AccSerial) VALUES($phone->id , $phone->Phone , $phone->AccSerial";
        DB::insert('call SetQuery(?)',[$q]);
        return response()->json(['success' => 'true' , 'message' => 'Phone updated successfully']);
        return $request->user()->phones;
    }
}
