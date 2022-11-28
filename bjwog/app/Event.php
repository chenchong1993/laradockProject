<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    

    //小组
    public function msg()
    {
        return $this->belongsTo('App\Msg','warning_msg_id','id');
    }

   //
   public function group()
   {
	return $this->belongsTo('App\Group','group_id','id');
   }

   public function area()
   {
	return $this->belongsTo('App\Area','area_id','id');
   }

   //事件
   public function users(){
	return $this->belongsToMany('App\User');
   }

}

