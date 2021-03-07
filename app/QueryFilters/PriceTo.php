<?php

namespace App\QueryFilters;

use Closure;

class PriceTo
{
    //
    public function handle($request , Closure $next)
    {
        $builder = $next($request);
        if(! request()->has('PriceTo')){
            return $builder;
        }
        
        return $builder->where('POSPP' , '<=' , request('PriceTo'));
    }

}