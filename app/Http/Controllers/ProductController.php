<?php

namespace App\Http\Controllers;

use App\Cart;
use App\CartProduct;
use App\Group;
use App\Http\Requests\ListProductRequest;
use App\Product;
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
        }
        $product->group = $group;
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
        $products = $pipeline->paginate(1);
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
            }
        }
        
        return $products;
    }
}
