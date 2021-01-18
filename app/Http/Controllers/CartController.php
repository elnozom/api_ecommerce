<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function getCartItems(Request $request)
    {
        $id = $request->user()->id;
        $cart = DB::select('call getCart(?) ', 
        [
            $id
        ]
    );
        
        $total = DB::select('call getTotal(?)' , [$id]);
        $cart['total'] = $total[0]->total;

        return response()->json($cart);
    }
     public function getCartItemsCount(Request $request , $instance = null)
    {
        
        $cart = DB::select('call getCartCount(?) ', 
        [
            $request->user()->id
        ]
    );

    return response()->json($cart[0]->count);
    }
    public function SetCartItem(Request $request , $instance = null)
    {
        $rules = [
            "product" => "required|max:255",
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $cart = DB::insert('call addToCart(?, ? , ? ) ', 
        [
            $request->product,
            $request->user()->id,
            isset($request->qty) ? $request->qty :  1,

        ]
    );

        return response()->json(['success' => 'true' , 'message' => 'added to cart successfully']);
    }
    public function DeleteCartItem($id , Request $request)
    {
        $cart = DB::delete('call deleteFromCart(? , ?) ', 
            [
            $id,
            $request->user()->id
            ]
        );

        return response()->json(['success' => 'true' , 'message' => 'deleted from cart successfully']);
    }
    public function DecreaseCartItem(Request $request ,$id)
    {
        $cart = DB::delete('call decreaseCart(?) ', 
            [
                $id,
            ]
        );

        return response()->json(['success' => 'true' , 'message' => 'quantity updated successfully']);
    }

    public function update(Request $request ,$id)
    {
        $rules = [
            "qty" => "required",
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        $uid = $request->user()->id;
        DB::delete('call deleteFromCart(? , ?) ', 
            [
            $id,
            $uid
            ]
        );
         DB::insert('call addToCart(?, ? , ? ) ', 
        [
            $id,
            $uid,
            $request->qty,

        ]
    );
         
       
        return response()->json(['success' => 'true' , 'message' => 'quantity updated successfully']);
    }
}
