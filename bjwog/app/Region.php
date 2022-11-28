<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    
    protected $table = 'regions';

    //获取region内的成员
    public function users()
    {
         return $this->hasMany('App\User','region_id','id');
    }

    public function areas(){

	return $this->hasMany('App\Area','region_id','id');
    }

    public function pseudolites(){

	return $this->hasMany('App\Pseudolite','region_id','id');
    }

}

