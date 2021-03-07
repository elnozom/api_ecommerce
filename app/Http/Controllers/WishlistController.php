<?php

namespace App\Http\Controllers;

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
            return response()->json($wishlist);
        } else{
            return response()->json('no items');
        }   
    }

    public function create(Request $request)
    {
        $id = $request->user()->id;
        $rec = ['user_id' => $id , 'product_id' => $request->product];
        Wishlist::create($rec);
        return response()->json('added to wishlist successfully');
    }

    public function delete(Request $request , $id)
    {
        $id = $request->user()->id;
        $rec = Wishlist::where('user_id' , $id)->where('product_id' , $id)->first();
        if($rec == null){ 
                return response()->json('Sorry! this item dosn\'t exist on your wishlist' , 400);
        } 
        $rec->delete();
        return response()->json('added to wishlist successfully');
    }
}
