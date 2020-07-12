<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{



    protected $fillable = [
        'title', 'slug', 'category_id', 'sub_category_id', 'element_id', 'user_id'
    ];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function element()
    {
        return $this->belongsTo('App\Element');
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
