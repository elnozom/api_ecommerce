<?php

namespace App\QueryFilters;

use Closure;

class GroupCode
{
    //
    public function handle($request , Closure $next)
    {

        $builder = $next($request);
        if(! request()->has('group')){
            return $builder;
        }
        
        return $builder->where('GroupCode' , (int)request('group'));
    }

}