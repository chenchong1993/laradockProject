<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    //用户对应的设备
    public function device()
    {
        return $this->belongsTo('App\Device','device_id','device_id');
    }

    //小组
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    //区域
    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    //区域
    public function region()
    {
        return $this->belongsTo('App\Region');
    }

   //事件
   public function events(){
	return $this->belongsToMany('App\Event');
   }

    //
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
       
}
