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
        if($product == null){
            return response()->json('product not found' , 400);
        }
        $group  = Group::select([ 'id' ,'GroupNameEn' , 'GroupName' ])->find($product->GroupCode);
        $product->group = $group;
        // if(isset($user->id)){
            //     $product = $this->inCartProduct($user , $product);
            // }
        if($product->hasOptions){
            $product = $this->productOptions($request , $product);
        }
        $product->ItemImage = $product->ItemImage && file_exists('images/'.$product->ItemImage) ? asset('images/' . $product->ItemImage) : $product->ItemImage;
        $product->ItemImageWhole = $product->ItemImageWhole && file_exists('images/'.$product->ItemImageWhole) ? asset('images/' . $product->ItemImageWhole) : $product->ItemImageWhole;
        
        return response()->json($product);
    }


    //get product options
    private function productOptions($request , $product)
    {
        $images = DB::select('SELECT `image` , color FROM product_images WHERE product_id = ?' , [$product->id] );
        if(count($images) > 0){
            foreach($images as $image){
                $image->image = $image->image && file_exists('images/products/'.$image->image) ? asset('images/products/' . $image->image) : $image->image;
              
            }
        }
        if(isset($request->size)){
            //get avilable colors based on size
            $colors = DB::select('SELECT DISTINCT color FROM product_options WHERE product_id = ? AND InStock = 1 AND size = ?' , [$product->id , $request->size]);
        } else {
            //get all avilable colors of the prouct
            $colors = DB::select('SELECT DISTINCT color, InStock FROM product_options WHERE product_id = ? AND InStock = 1' , [$product->id] );
        }
        //get inital color
        $initialColor =isset($request->color) ? $request->color : $colors[0]->color;
        $sizes = DB::select('SELECT DISTINCT size FROM product_options WHERE product_id = ? AND InStock = 1 AND color = ?' , [$product->id , $initialColor]);
        // dd($sizes);
        $product->sizes = $sizes;
        $product->images = $images;
        $product->colors = $colors;
        $product->initialColor = $initialColor;

        return $product;
    }
    private function inCartProduct($user , $product){
       
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
                    WHERE w.user_id = ? AND isNull(w.deleted_at) AND p.id = ? " , [$user->id , $product->id]);
            if(isset($wihslist[0])){
                $product->InWihslit = true;
            }

            return $product;
        
    }
    public function list(ListProductRequest $request)
    {
        $PriceFrom = $request->PriceFrom ? $request->PriceFrom : null;
        $PriceTo = $request->PriceTo ? $request->PriceTo : null;
        $Search = $request->Search ? $request->Search : null;
        $page = $request->page ?  $request->page : 1;
        $GroupCode = $request->group ? $request->group : null;
        $products =DB::select("CALL GetProducts(? , ? , ? , ? , ? , ? , @CountRecords ) " , [$Search , asset('images/') , $PriceFrom , $PriceTo ,$GroupCode,$page  ]);
        $count = DB::select('select @CountRecords as count')[0]->count;
        $last = ceil($count / 8);
        $result = ['data' => $products , 'total' => $count , 'last_page' => $last];
        return $result;
    }
    public function listHome($key , Request $request)
    {
        if($key == 'featured'){
            $products = DB::select("SELECT * FROM products_view WHERE featured = 1");
        } else if($key == 'latest'){
            $products = DB::select("SELECT * FROM products_view WHERE latest = 1");
        } else if($key == 'bestseller'){
            $products = DB::select("SELECT * FROM products_view WHERE bestseller = 1");
            // dd($products);
        } else {
            return [];
        }
        foreach($products as $product)
        {
            $product->ItemImage = $product->ItemImage && file_exists('images/'.$product->ItemImage) ? asset('images/' . $product->ItemImage) : $product->ItemImage;

        }

        return $products; 
    }

    protected function inCart($user , $products , $request)
    {
        $cart = Cart::cart()->select(['id'])->where('user_id' , $user)->first();
            foreach($products as $product){
                if($product->hasOptions){
                    $product = $this->productOptions($request , $product);
                }

                if($cart !== null){
                    $inCart= CartProduct::where('cart_id' , $cart->id)->where('product_id' , $product->id)->first();
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
                        WHERE w.user_id = ? AND isNull(w.deleted_at) AND p.id = ? " , [$user , $product->id]);
                if(isset($wihslist[0])){
                    $product->InWihslit = true;
                }
                // dd($product);
        }
        
        return $products;
    }
}
