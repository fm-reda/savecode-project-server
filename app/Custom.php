<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function element()
    {
        return $this->hasOne('App\Coment');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
    public function Category()
    {
        return $this->belongsTo('App\Category');
    }
}
