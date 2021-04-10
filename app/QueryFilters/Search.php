<?php

namespace App\QueryFilters;

use Closure;

class Search
{
    //
    public function handle($request , Closure $next)
    {

        $builder = $next($request);
        if(! request()->has('Search')){
            return $builder;
        }
        
        return $builder->where('ItemName' , 'LIKE' , '%'.request("Search").'%')->orWhere('ItemNameEn' , 'LIKE' , '%'.request("Search").'%');
    }

}