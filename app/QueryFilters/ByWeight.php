<?php

namespace App\QueryFilters;

use Closure;

class ByWeight
{
    //
    public function handle($request , Closure $next)
    {

        $builder = $next($request);
        if(! request()->has('ByWeight')){
            return $builder;
        }
        
        return (int)request('ByWeight') == 1 ? $builder->ByWeight() : $builder->ByItem();
    }

}