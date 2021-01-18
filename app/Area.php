<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('Apply' , true);
    }

    public function scopeMain($query)
    {
        return $query->where('SectionNo' , null);
    }


}
