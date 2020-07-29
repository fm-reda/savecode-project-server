<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function coments()
    {
        return $this->hasMany('App\Coment');
    }
    public function customs()
    {
        return $this->hasMany('App\Custom');
    }
    public function defaultCategory()
    {
        return $this->belongsTo('App\DefaultCategory');
    }
  
}
