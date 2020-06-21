<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];
    public function subCategories()
    {
        return $this->hasMany('App\SubCategory');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customs()
    {
        return $this->hasMany('App\Custom');
    }
}
