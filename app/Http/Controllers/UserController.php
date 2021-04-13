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
    public function GetOrders(Request $request)
    {
        $id = $request->user()->id;
        $orders = Cart::where('user_id' , $id)->orders()->get();
        foreach($orders as $order){
            $products = DB::select(
                "SELECT 
                    p.* ,
                    cp.price ,
                    cp.cart_id ,
                    cp.qty 
                    FROM cart_product cp 
                    JOIN products p 
                        ON cp.product_id = p.id
                    WHERE cp.cart_id = ?
                    AND cp.deleted_at IS NULL" , [$order->id]);
    // dd($products);
    
            if(count($products) > 0){
                $order->products = $products;
                $subtotal = DB::select("SELECT SUM(price * qty) subtotal FROM cart_product WHERE cart_id = ? AND deleted_at IS NULL" ,[ $order->id])[0]->subtotal;
                $discountVal = 0;
                if($order->discount_code != null){
                    $coupon = Coupon::where('code' , $order->discount_code)->first();
                    // dd($coupon->type);
                    if($coupon->type == 'fixed'){
                        $discountVal = $coupon->value;
                    } else {
                        $order->percentOff = $coupon->value;
                        $discountVal =  $coupon->value * $subtotal / 100;
                    }
                    $order->discounVal = $discountVal;
                }

                $order->subtotal = $subtotal;
                $order->total = $subtotal - $discountVal +  $order->shipping;
            }
        }

        return response()->json($orders);
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
        return ['phones' => $request->user()->phones , 'id' => $phone->id];
    }
}
