<?php
/**
 * Created by PhpStorm.
 * User: chenchong
 * Date: 2019/3/21
 * Time: 22:23
 */

namespace App\Http\Controllers;



class PageController extends Controller
{
    /**
     * 测试
     */
    public function test(){
        return view('test');
    }

    /**
     * 地图
     */
    public function OSMmap(){
        return view('OSMmap');
    }
    /**
     * 天地图地图
     */
    public function TDmap(){
        return view('TDmap');
    }

    /**
     * 天地图demo
     */
    public function tiandituDemo(){
        return view('tiandituDemo');
    }
    /**
     * 天地图demo
     */
    public function pseudoliteControl(){
        return view('pseudoliteControl');
    }



}
