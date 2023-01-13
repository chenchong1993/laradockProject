<?php

function rq($key = null)
{
    return ($key == null) ? \Illuminate\Support\Facades\Request::all() : \Illuminate\Support\Facades\Request::get($key);
}

/**
 * @param null $data
 * @return array 成功返回0
 */
function suc($data = null)
{
    $ram = ['status' => 0];
    if ($data) {
        $ram['data'] = $data;
        return $ram;
    }
    return $ram;
}

/**
 * @param $code
 * @param null $data
 * @return array 失败返回错误码和信息
 */
function err($code, $data = null)
{
    if ($data)
        return ['status' => $code, 'data' => $data];
    return ['status' => $code];
}


Route::group(['middleware' => 'web'], function () {


    Route::get('test', 'PageController@test');//laravel欢迎页
    Route::get('TDmap', 'PageController@TDmap');//天地图
    Route::get('OSMmap', 'PageController@OSMmap');//OSM地图
    Route::get('tiandituDemo', 'PageController@tiandituDemo');//天地图Demo 
    Route::get('pseudoliteControl', 'PageController@pseudoliteControl');//pseudoliteControl 

	Route::group(['prefix' => 'api'], function () {    //接口分组
        Route::get('apiTest', 'ApiController@apiTest');//测试路由
        Route::get('getpseudoliteList', 'ApiController@getpseudoliteList');//获取伪卫星基站信息列表
	    Route::post('fileUpload', 'ApiController@fileUpload');//上传文件

	});


});


