<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Phone;
use App\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Validator;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email' , $request->email)->first();
        if(!$user){
              return response()->json("this email is not found",400);

        }
        $rules = [
            'email' => 'required|email|max:255',
        'password' => 'required|max:255',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json("This password dosen't belong to this email",400);

        }

        $passwordGrantClient = Client::find(env('PASSPORT_CLIENT_ID', 2));
        
        // dd($passwordGrantClient);
        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ];

        $tokenRequest =  Request::create('oauth/token' , 'post', $data );
        
        
        return app()->handle($tokenRequest);


    }
    public function register(Request $request)
    {

        if(User::where('email' , $request->email)->count() > 0){
            return  response()->json(['success' => 'false' , 'message' => 'this email is already exists']);
        }
        $rules = ['email' => 'required|email|max:255',
        'password' => 'required|max:255',
        'name' => 'required|max:255',
        'phone' => 'required|max:255|unique:phones'];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
    
        $userRequest =  [
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>bcrypt($request->password),
        ];
        $user =  User::create($userRequest);
        $q = "INSERT INTO OlAccounts(AccSerial ,`Name` ,Email ,`Password`) VALUES($user->id , $user->name , $user->email , $user->password)";
        DB::insert('call SetQuery(?)',[$q]);
        $phoneRequest =  [
            'Phone' =>$request->phone,
            'AccSerial' =>$user->id,
        ];
        $this->attachPhone($phoneRequest);
        if(!$user) return  response()->json(['success' => 'false' , 'message' => 'registration_faild']);
        return response()->json(['success' => 'true' , 'message' => 'registration_success']);
    }
    protected function attachPhone($request){
        $phone = Phone::create($request);
        $q = "INSERT INTO OlPhones(PhSerial,AccSerial ,`Phone`) VALUES($phone->id , $phone->AccSerial , $phone->phone)";
        DB::insert('call SetQuery(?)',[$q]);
    }
}
