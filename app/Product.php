<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    public function scopeActive($query)
    {
        return $query->where('ActiveItem' , true);
    }
    public function scopeAvilable($query)
    {
        return $query->where('InStock' , true);
    }
    public function scopeByWeight($query)
    {
        return $query->where('ByWeight' , true);
    }
    public function scopeByItem($query)
    {
        return $query->where('ByWeight' , false);
    }
}
