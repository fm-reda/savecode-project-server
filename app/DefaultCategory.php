<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultCategory extends Model
{
    protected $guarded = [];
    public function elements()
    {
        return $this->hasMany('App\Element');
    }
}
