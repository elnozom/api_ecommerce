<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    protected $table = "cart";
    
    protected $guarded = [];

    public function scopeCart($query)
    {
        return $query->where('closed_at', null);
    }

    public function scopeOrders($query)
    {
        return $query->where('closed_at', '!=', null);
    }
}
