<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    protected $table = "cart";
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    protected $guarded = [];

    public function scopeCart($query)
    {
        return $query->where('closed_at', null);
    }
    // public function getCreatedAtAttribute($value)
    // {
    //     return ucfirst($value);
    // }
    public function scopeOrders($query)
    {
        return $query->where('closed_at', '!=', null);
    }


    public function getClosedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M-d-Y');
    }
}
