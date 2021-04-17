<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
use App\Group;
use App\Http\Requests\ListProductRequest;
use App\Product;
use App\ProductOption;
use App\QueryFilters\ByWeight;
use App\QueryFilters\PriceTo;
use App\QueryFilters\PriceFrom;
use App\QueryFilters\Search;
use App\QueryFilters\GroupCode;
use App\QueryFilters\Sort;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function create(Request $request)
    {

    }
    public function update(Request $request)
    {

    }
    public function delete(Request $request)
    {

    }
    public function find($id , Request $request)
    {
        $product = Product::find($id);
        $group  = Group::select([ 'id' ,'GroupNameEn' , 'GroupName' ])->find($product->GroupCode);
        // $group = DB::select('SELECT GroupNameEn , GroupName FROM groups WHERE id = ?' , [$product->GroupCode]);
        $user = $request->user('api');
        if(isset($user->id)){
            $cart = Cart::cart()->select(['id'])->where('user_id' , $user->id)->first();
            if($cart !== null){
                $inCart = CartProduct::where('cart_id' , $cart->id)->where('product_id' , $product->id)->first();
                if($inCart !== null){
                    $product->InCart = true;
                    $product->cartQty = $inCart->qty;
                }
            }
            $wihslist =  DB::select(
                "SELECT 
                    w.id
                    FROM wishlist w 
                    JOIN products p 
                        ON w.product_id = p.id
                    WHERE w.user_id = ? AND isNull(w.deleted_at) AND p.id = ? " , [$user->id , $id]);
            if(isset($wihslist[0])){
                $product->InWihslit = true;
            }
        }
        $product->group = $group;

        //get product options


        //get all avilable sizes of the product
        $sizes = DB::select('SELECT DISTINCT size FROM product_options WHERE product_id = ? AND InStock = 1' , [$product->id] );
        //get avilable sizes based on color
        $avilableSizes = DB::select('SELECT DISTINCT size FROM product_options WHERE product_id = ? AND InStock = 1 AND color = ?' , [$product->id , $request->color]);

        //get avilable colors based on size
        $avilableColors = DB::select('SELECT DISTINCT color FROM product_options WHERE product_id = ? AND InStock = 1 AND size = ?' , [$product->id , $request->size]);
        //get all avilable images of the product
        $images = DB::select('SELECT `image` , color FROM product_images WHERE product_id = ?' , [$product->id] );
        //get add avilable colors of the prouct
        $colors = DB::select('SELECT DISTINCT color FROM product_options WHERE product_id = ?' , [$product->id] );

        //inject stock avilability on sizes array based on color
        foreach($sizes as $size){
            if(in_array($size , $avilableSizes)){
                $size->InStock = 1;
            }
        }

        //inject stock avilability on colors array based on size
        foreach($colors as $color){
            if(in_array($color , $avilableColors)){
                $color->InStock = 1;
            }
        }
        $product->sizes = $sizes;
        $product->images = $images;
        $product->colors = $colors;
        return response()->json($product);
    }
    public function list(ListProductRequest $request)
    {
        // dd((int)$request->byWeight);
        $pipeline = app(Pipeline::class)->send(Product::query())->through([
            ByWeight::class,
            PriceFrom::class,
            PriceTo::class,
            Search::class,
            Sort::class,
            GroupCode::class,

        ])->thenReturn();
        $products = $pipeline->paginate(8);
        $user = $request->user('api');
        if(isset($user->id)){
            return $this->inCart($user->id , $products); 
        }
        return $products;
    }

    

    public function listHome($key , Request $request)
    {
        if($key == 'featured'){
            $products = Product::where('featured' , 1)->get();
        } else if($key == 'latest'){
            $products = Product::where('latest' , 1)->get();
        } else {
            return [];
        }
        $user = $request->user('api');
        if(isset($user->id)){
            return $this->inCart($user->id , $products); 
        }
        return $products; 
    }

    protected function inCart($user , $products)
    {
        $cart = Cart::cart()->select(['id'])->where('user_id' , $user)->first();
        if($cart !== null){
            foreach($products as $product){
                // dd($product);
                $inCart= CartProduct::where('cart_id' , $cart->id)->where('product_id' , $product->id)->first();
                if($inCart !== null){
                    $product->InCart = true;
                    $product->cartQty = $inCart->qty;
                }

                $wihslist =  DB::select(
                    "SELECT 
                        w.id
                        FROM wishlist w 
                        JOIN products p 
                            ON w.product_id = p.id
                        WHERE w.user_id = ? AND isNull(w.deleted_at) AND p.id = ? " , [$user , $product->id]);
                if(isset($wihslist[0])){
                    $product->InWihslit = true;
                }

                
            }
        }
        
        return $products;
    }
}
