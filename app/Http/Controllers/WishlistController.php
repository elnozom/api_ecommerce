<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
use App\Product;
use App\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function get(Request $request)
    {
        $id = $request->user()->id;
        $wishlist = DB::select(
                    "SELECT 
                        p.*
                        FROM wishlist w 
                        JOIN products p 
                            ON w.product_id = p.id
                        WHERE w.user_id = ? AND isNull(w.deleted_at) " , [$id]);
        
        if(count($wishlist) > 0){
            foreach($wishlist as $pr){
                $pr->ItemImage = $pr->ItemImage && file_exists('images/'.$pr->ItemImage) ? asset('images/' . $pr->ItemImage) : $pr->ItemImage;
            }
            return response()->json($wishlist);
        } else{
            return response()->json('no items');
        }   
    }

    public function create(Request $request)
    {
        $id = $request->user()->id;
        $item = Wishlist::where('product_id' , $request->product)->where('user_id' , $id)->first();
        if($item !== null){
            $item->delete();
            return response()->json('deleted');
        
        }
        $rec = ['user_id' => $id , 'product_id' => $request->product];
        Wishlist::create($rec);
        return response()->json('added to wishlist successfully');
    }

    public function delete(Request $request , $id)
    {
        $userId = $request->user()->id;
        $rec = Wishlist::where('user_id' , $userId)->where('product_id' , $id)->first();
        if($rec == null){ 
                return response()->json('Sorry! this item dosn\'t exist on your wishlist' , 400);
        } 
        $rec->delete();
        return response()->json('added to wishlist successfully');
    }


    public function switch(Request $request , $id)
    {
        $userId = $request->user()->id;
        $rec = Wishlist::where('user_id' , $userId)->where('product_id' , $id)->first();
        if($rec == null){ 
                return response()->json('Sorry! this item dosn\'t exist on your wishlist' , 400);
        } 
        $cart = Cart::where('user_id' , $userId)->cart()->first();
        if($cart == null){
            $cart = $this->init($userId);
        }
        // dd($cart);
        $this->setProducts($cart->id , $id , $request->qty);
        $rec->delete();
        return response()->json('switched to cart successfully');
    }

    private function init($id){
        $cart = Cart::create(['user_id' => $id]);
        return $cart;
    }
    private function setProducts($cart  , $product , $qty ){
        // dd($product);
        $qty = $qty == null ? 1 : $qty;
        $product = Product::where('id' , $product)->first();
        $rec = [
            "cart_id" => $cart,
            "product_id" => $product->id,
            "price" => $product->POSPP,
            "qty" => $qty,
        ];
        // dd($rec);
        CartProduct::create($rec);
        return $product;
    }
}
