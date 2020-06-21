<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function customs()
    {
        return $this->hasMany('App\Custom');
    }
}
