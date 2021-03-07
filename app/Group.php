<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];
    public function scopeActive($query)
    {
        return $query->where('Active' , true);
    }


    public function scopeMain($query)
    {
        return $query->where('FatherCode' , null);
    }

    public function groups()
    {
        return $this->hasMany(Group::class , 'FatherCode' , 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class , 'GroupCode' , 'id');
    }
}