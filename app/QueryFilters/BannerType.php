<?php

namespace App\QueryFilters;

use Closure;

class BannerType
{
    //
    public function handle($request , Closure $next)
    {

        $builder = $next($request);
        if(! request()->has('BannerType')){
            return $builder;
        }
        
        return $builder->where('type' , request('BannerType'));
    }

}