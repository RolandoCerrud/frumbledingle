<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;
 
    protected $guarded = ['id'];

    public function parents()
    {
        return $this->belongsTo(Categories::class , 'parent_id')->select('id', 'name');
    }
}