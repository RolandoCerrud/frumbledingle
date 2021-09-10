<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function locations()
    {
        return $this->belongsTo(Location::class , 'location_id')->select('id', 'name');
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}