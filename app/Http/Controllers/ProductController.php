<?php

namespace App\Http\Controllers;

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
    public function find($id)
    {
        $product = Product::find($id);
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
        return $pipeline->paginate(9); 
    }
}
