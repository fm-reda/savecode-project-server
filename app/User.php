<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function elements()
    {
        return $this->hasMany('App\Element');
    }
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
    public function coments()
    {
        return $this->hasMany('App\Coment');
    }
    public function categories()
    {
        return $this->hasMany('App\Category');
    }
    public function customs()
    {
        return $this->hasMany('App\Custom');
    }
}
