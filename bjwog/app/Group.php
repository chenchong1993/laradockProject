<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    
    //获取小组内的成员
	public function users()
    {
         return $this->hasMany('App\User','group_id','id');
    }

    //获取组长
	public function manager_user()
	{
		return $this->hasOne('App\User','id','manager_user_id');
	}
}

