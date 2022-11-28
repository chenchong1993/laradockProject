<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Robot extends Model
{
    
    //用户对应的设备
    public function device()
    {
        return $this->belongsTo('App\Device','device_id','device_id');
    }

}

