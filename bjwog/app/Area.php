<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    
    //获取小组内的成员
	public function users()
    {
         return $this->hasMany('App\User','area_id','id');
    }
}

