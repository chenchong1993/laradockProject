<?php

/**
 * @param $code
 * @param null $data
 * @return array 失败返回错误码和信息
 */
function http_err($code)
{
    return response('Some Things Error!',$code)->header('Content-Type', 'text/plain');
}

Route::group(['middleware' => 'web'], function () {

    Route::post('test', 'ApiController@test')->middleware('checkjwttoken');//测试

    Route::group(['prefix' => 'api'], function () {

        //登录
        Route::post('login', 'ApiController@login');
        Route::post('getCode', 'ApiController@getCode');
        Route::post('bindUserAndDevice', 'ApiController@bindUserAndDevice')->middleware('checkjwttoken');
        Route::post('resetPassword', 'ApiController@resetPassword')->middleware('checkjwttoken');
        Route::post('forgetPassword', 'ApiController@forgetPassword')->middleware('checkjwttoken')->middleware('checkjwttoken');
        
        //用户
        Route::post('addUser', 'ApiController@addUser')->middleware('checkjwttoken');
        Route::post('addUserAndDevice', 'ApiController@addUserAndDevice');
        Route::post('delUserById', 'ApiController@delUserById')->middleware('checkjwttoken');
        Route::post('updateUserById', 'ApiController@updateUserById')->middleware('checkjwttoken');
        Route::post('getUserList', 'ApiController@getUserList')->middleware('checkjwttoken');
        Route::post('getUserById', 'ApiController@getUserById')->middleware('checkjwttoken');
        Route::post('getUserListLikeUserName', 'ApiController@getUserListLikeUserName')->middleware('checkjwttoken');
        Route::post('getOnlineUserCodeList', 'ApiController@getOnlineUserCodeList')->middleware('checkjwttoken');
        Route::post('addAdmin', 'ApiController@addAdmin');

        //位置
        Route::post('getUserPastLoactionByIDAndTimeStamp', 'ApiController@getUserPastLoactionByIDAndTimeStamp')->middleware('checkjwttoken');
        Route::post('getUserPastLoactionTimeStamp', 'ApiController@getUserPastLoactionTimeStamp')->middleware('checkjwttoken');

        //小组
        Route::post('addGroup', 'ApiController@addGroup')->middleware('checkjwttoken');
        Route::post('delGroupById', 'ApiController@delGroupById')->middleware('checkjwttoken');
        Route::post('getUserListWithoutGroup', 'ApiController@getUserListWithoutGroup')->middleware('checkjwttoken');
        Route::post('addUserListToGroup', 'ApiController@addUserListToGroup')->middleware('checkjwttoken');
        Route::post('getGroupList', 'ApiController@getGroupList');
        Route::post('getGroupById', 'ApiController@getGroupById')->middleware('checkjwttoken');
        Route::post('updateGroupById', 'ApiController@updateGroupById')->middleware('checkjwttoken');
        Route::post('getGroupWithUserById', 'ApiController@getGroupWithUserById')->middleware('checkjwttoken');
        Route::post('delUserListFromGroup', 'ApiController@delUserListFromGroup')->middleware('checkjwttoken');
        Route::post('getGroupListLikeGroupName', 'ApiController@getGroupListLikeGroupName')->middleware('checkjwttoken');
        Route::post('getGroupWithUserWithDeviceById', 'ApiController@getGroupWithUserWithDeviceById')->middleware('checkjwttoken');
        Route::post('getGroupWithUwbIdById', 'ApiController@getGroupWithUwbIdById')->middleware('checkjwttoken');
        
        //设备
        Route::post('addDevice', 'ApiController@addDevice')->middleware('checkjwttoken');
        Route::post('delDeviceByDeviceId', 'ApiController@delDeviceByDeviceId')->middleware('checkjwttoken');
        Route::post('getDeviceList', 'ApiController@getDeviceList')->middleware('checkjwttoken');
        Route::post('getDeviceByDeviceId', 'ApiController@getDeviceByDeviceId')->middleware('checkjwttoken');
        Route::post('updateDeviceConfigByDeviceId', 'ApiController@updateDeviceConfigByDeviceId')->middleware('checkjwttoken');
        Route::post('updateAllDeviceConfig', 'ApiController@updateAllDeviceConfig')->middleware('checkjwttoken');
        Route::post('bindDeviceByDeviceIdAndUserId', 'ApiController@bindDeviceByDeviceIdAndUserId')->middleware('checkjwttoken');
        Route::post('unbindByUserId', 'ApiController@unbindByUserId')->middleware('checkjwttoken');
        Route::post('updateAllDeviceSoft', 'ApiController@updateAllDeviceSoft')->middleware('checkjwttoken');
        Route::post('updateAllDeviceRate', 'ApiController@updateAllDeviceRate')->middleware('checkjwttoken');
        Route::post('updateAllDeviceDifferenceAddress', 'ApiController@updateAllDeviceDifferenceAddress')->middleware('checkjwttoken');
        Route::post('addPse', 'ApiController@addPse')->middleware('checkjwttoken');
        Route::post('getPseLocation', 'ApiController@getPseLocation')->middleware('checkjwttoken');
        Route::post('updateAllPowerControl', 'ApiController@updateAllPowerControl')->middleware('checkjwttoken');
        Route::post('getDeviceStatusAndPower', 'ApiController@getDeviceStatusAndPower')->middleware('checkjwttoken');
        

        //地图
        //->重点人员区域
        Route::post('getRegionUserNum', 'ApiController@getRegionUserNum')->middleware('checkjwttoken');
        Route::post('getUserInput', 'ApiController@getUserInput')->middleware('checkjwttoken');
        Route::post('getGroupValPercent', 'ApiController@getGroupValPercent')->middleware('checkjwttoken');
        Route::post('getEventNum', 'ApiController@getEventNum')->middleware('checkjwttoken');
        Route::post('getEventList', 'ApiController@getEventList')->middleware('checkjwttoken');
        Route::post('getEventById', 'ApiController@getEventById')->middleware('checkjwttoken');
        Route::post('getEventByIdWithUserList', 'ApiController@getEventByIdWithUserList')->middleware('checkjwttoken');
        Route::post('getRegionsWithAreas', 'ApiController@getRegionsWithAreas')->middleware('checkjwttoken');
        Route::post('getUserById', 'ApiController@getUserById')->middleware('checkjwttoken');
        Route::post('getGroupById', 'ApiController@getGroupById')->middleware('checkjwttoken');
        Route::post('getRegionWithUserLocation', 'ApiController@getRegionWithUserLocation')->middleware('checkjwttoken');
        Route::post('getAreasByRegionId', 'ApiController@getAreasByRegionId')->middleware('checkjwttoken');
        Route::post('getJobList', 'ApiController@getJobList')->middleware('checkjwttoken');
        Route::post('getUserListByJob', 'ApiController@getUserListByJob')->middleware('checkjwttoken');
        Route::post('getUserListByRegion', 'ApiController@getUserListByRegion')->middleware('checkjwttoken');

        //大屏
        Route::post('adminLogin', 'ApiController@adminLogin');
        Route::post('getPseudoliteList', 'ApiController@getPseudoliteList')->middleware('checkjwttoken');
        Route::post('getUserPositionListByUserList', 'ApiController@getUserPositionListByUserList')->middleware('checkjwttoken');
        Route::post('getUserPositionListInGroupByUserId', 'ApiController@getUserPositionListInGroupByUserId')->middleware('checkjwttoken');
        Route::post('getEventsByUserId', 'ApiController@getEventsByUserId')->middleware('checkjwttoken');
        Route::post('getMsgList', 'ApiController@getMsgList')->middleware('checkjwttoken');
        Route::post('addEvent', 'ApiController@addEvent')->middleware('checkjwttoken');
        Route::post('bindEventOfUser', 'ApiController@bindEventOfUser')->middleware('checkjwttoken');
        Route::post('getPseudoliteListByRegion', 'ApiController@getPseudoliteListByRegion')->middleware('checkjwttoken');
        Route::post('getPseudoliteListById', 'ApiController@getPseudoliteListById')->middleware('checkjwttoken');
        Route::post('controlPseById', 'ApiController@controlPseById')->middleware('checkjwttoken');
        Route::post('addSounds', 'ApiController@addSounds')->middleware('checkjwttoken');
        Route::post('endEvent', 'ApiController@endEvent')->middleware('checkjwttoken');
        Route::post('getMsgByWarningMsgIdAndCommandMsgId', 'ApiController@getMsgByWarningMsgIdAndCommandMsgId')->middleware('checkjwttoken');
        Route::post('getAreaIdFromRegionIdAndLngAndLat', 'ApiController@getAreaIdFromRegionIdAndLngAndLat')->middleware('checkjwttoken');
        Route::post('getAreaListLikeAreaName', 'ApiController@getAreaListLikeAreaName')->middleware('checkjwttoken');
        Route::post('getDPUser', 'ApiController@getDPUser')->middleware('checkjwttoken');

        //机器人
        Route::post('getRobotListLocationListByTimeStamp', 'ApiController@getRobotListLocationListByTimeStamp')->middleware('checkjwttoken');
        Route::post('getRobotListImgListByTimeStamp', 'ApiController@getRobotListImgListByTimeStamp')->middleware('checkjwttoken');
        Route::post('getRobotLocationById', 'ApiController@getRobotLocationById')->middleware('checkjwttoken');
        Route::post('getRobotListLocation', 'ApiController@getRobotListLocation')->middleware('checkjwttoken');
        //机器人，微信公众号专用
        Route::post('getOnlineUser', 'ApiController@getOnlineUser')->middleware('checkjwttoken');
        Route::post('getAllUser', 'ApiController@getAllUser')->middleware('checkjwttoken');
        Route::post('getUserPositionListByUserCodeList', 'ApiController@getUserPositionListByUserCodeList')->middleware('checkjwttoken');
        Route::post('getRobotLocation', 'ApiController@getRobotLocation')->middleware('checkjwttoken');
        
        //推送
        Route::post('push', 'ApiController@push')->middleware('checkjwttoken');
        Route::post('getYSYToken', 'ApiController@getYSYToken')->middleware('checkjwttoken');

        //电子围栏
        Route::post('addElectricFence','ApiController@addElectricFence')->middleware('checkjwttoken');
        Route::post('delElectricFenceById','ApiController@delElectricFenceById')->middleware('checkjwttoken');
        Route::post('updateElectricFenceById','ApiController@updateElectricFenceById')->middleware('checkjwttoken');
        Route::post('getElectricFenceById','ApiController@getElectricFenceById')->middleware('checkjwttoken');
        Route::post('getElectricFenceList','ApiController@getElectricFenceList')->middleware('checkjwttoken');
        Route::post('getElectricFenceListByRegionId','ApiController@getElectricFenceListByRegionId')->middleware('checkjwttoken');

        //密接
        Route::post('getUserContact','ApiController@getUserContact')->middleware('checkjwttoken');
        Route::post('getAreaContact','ApiController@getAreaContact')->middleware('checkjwttoken');
        Route::post('firmwareUpload','ApiController@firmwareUpload')->middleware('checkjwttoken');

        //手机
        Route::post('getApk','ApiController@getApk')->middleware('checkjwttoken');
        Route::post('apkUploade','ApiController@apkUploade')->middleware('checkjwttoken');

        //区域
        Route::post('getAreaList','ApiController@getAreaList')->middleware('checkjwttoken');
        Route::post('updateRegionById','ApiController@updateRegionById')->middleware('checkjwttoken');
        Route::post('addArea','ApiController@addArea')->middleware('checkjwttoken');
        Route::post('delAreaById','ApiController@delAreaById')->middleware('checkjwttoken');
        Route::post('updateAreaById','ApiController@updateAreaById')->middleware('checkjwttoken');

        //除雪车
        Route::post('getSnowSweeperLocation','ApiController@getSnowSweeperLocation')->middleware('checkjwttoken');
        Route::post('getSnowSweeperUwbID','ApiController@getSnowSweeperUwbID')->middleware('checkjwttoken');
        Route::post('addCarInfo','ApiController@addCarInfo')->middleware('checkjwttoken');
        Route::post('getCarByCarName','ApiController@getCarByCarName')->middleware('checkjwttoken');

        //uwb
        Route::post('getUserByUwbId','ApiController@getUserByUwbId')->middleware('checkjwttoken');
        Route::post('addAlarmArea','ApiController@addAlarmArea')->middleware('checkjwttoken');
        Route::post('getFenceByPosId','ApiController@getFenceByPosId')->middleware('checkjwttoken');
        Route::post('addAlarmFence','ApiController@addAlarmFence')->middleware('checkjwttoken');
        Route::post('getAlarms','ApiController@getAlarms')->middleware('checkjwttoken');
        Route::post('getIndexCarInfo','ApiController@getIndexCarInfo')->middleware('checkjwttoken');
        Route::post('apiGetDeviceConfig','ApiController@apiGetDeviceConfig');
        Route::post('apiDeviceRegist','ApiController@apiDeviceRegist');
    });
});

Auth::routes();

Route::get('/', 'PageController@index')->middleware('auth');
Route::get('/home', 'PageController@index')->middleware('auth');
Auth::routes();
Route::get('/home', 'HomeController@index');


function rq($key = null)
{
    return ($key == null) ? \Illuminate\Support\Facades\Request::all() : \Illuminate\Support\Facades\Request::get($key);
}

/**
 * @param null $data
 * @return array 成功返回0
 */
function suc_bat($data = null)
{
    if ($data)
        return ['status' => 0, 'data' => $data];
    return ['status' => 0];
}

/**
 * @param $code
 * @param null $data
 * @return array 失败返回错误码和信息
 */
function err_bat($code, $data = null)
{
    if ($data)
        return ['status' => $code, 'data' => $data];
    return ['status' => $code];
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
    }
    $timestamp = time();
    $nonce = str_random(32);
    $md5 = md5($nonce.":".json_encode($ram,JSON_UNESCAPED_UNICODE).":".$timestamp);
    return response()->json($ram)->withHeaders([
        'timestamp' => $timestamp,
        'nonce' => $nonce,
        'sign' => $md5,
    ]);    
}

/**
 * @param $code
 * @param null $data
 * @return array 失败返回错误码和信息
 */
function err($code, $data = null)
{

    $ram = ['status' => $code];
    if ($data) {
        $ram['data'] = $data;
    }
    $timestamp = time();
    $nonce = str_random(32);
    $md5 = md5($nonce.":".json_encode($ram,JSON_UNESCAPED_UNICODE).":".$timestamp);
    return response()->json($ram)->withHeaders([
        'timestamp' => $timestamp,
        'nonce' => $nonce,
        'sign' => $md5,
    ]); 
}

function icon_to_utf8($s) {
  if(is_array($s)) {
    foreach($s as $key => $val) {
      $s[$key] = icon_to_utf8($val);
    }
  } else {
      $s = ct2($s);
  }
  return $s;
}

// 随机字符串
function get_random_str($length = 16)
{
    $char_set = array_merge(range('a', 'z'), range('A', 'Z'), range('0', '9'));
    shuffle($char_set);
    return implode('', array_slice($char_set, 0, $length));
}

/**
 * 加密算法
 * @param  string $content 待加密数据
 * @param  string $key     加密key 注意 key 长度要求
 * @param  string $iv      加密向量 固定为16位可以保证与openssl的兼容性
 * @param  string $cipher  加密算法
 * @param  string $mode    加密模式
 * @param  bool $pkcs7     是否使用pkcs7填充 否则使用 mcrypt 自带的 NUL("\0") 填充
 * @param  bool $base64    是否对数据做 base64 处理 因加密后数据会有非打印字符 所以推荐做 base64 处理
 * @return string          加密后的内容
 */
function user_mcrypt_encrypt($content, $key, $iv, $cipher = MCRYPT_RIJNDAEL_128, $mode = MCRYPT_MODE_CBC, $pkcs7 = true, $base64 = true)
{
    //AES, 128 模式加密数据 CBC
    $content           = $pkcs7 ? addPKCS7Padding($content) : $content;
    $content_encrypted = mcrypt_encrypt($cipher, $key, $content, $mode, $iv);
    return $base64 ? base64_encode($content_encrypted) : $content_encrypted;
}

/**
 * 解密算法
 * @param  [type] $content_encrypted 待解密的内容
 * @param  [type] $key     加密key 注意 key 长度要求
 * @param  [type] $iv      加密向量 固定为16位可以保证与openssl的兼容性
 * @param  [type] $cipher  加密算法
 * @param  [type] $mode    加密模式
 * @param  bool $pkcs7     带解密内容是否使用了pkcs7填充 如果没使用则 mcrypt 会自动移除填充的 NUL("\0")
 * @param  bool $base64    是否对数据做 base64 处理
 * @return [type]          [description]
 */
function user_mcrypt_decrypt($content_encrypted, $key, $iv, $cipher = MCRYPT_RIJNDAEL_128, $mode = MCRYPT_MODE_CBC, $pkcs7 = true, $base64 = true)
{
    //AES, 128 模式加密数据 CBC
    $content_encrypted = $base64 ? base64_decode($content_encrypted) : $content_encrypted;
    $content           = mcrypt_decrypt($cipher, $key, $content_encrypted, $mode, $iv);
    // 解密后的内容 要根据填充算法来相应的移除填充数
    $content = $pkcs7 ? stripPKSC7Padding($content) : rtrim($content, "\0");
    return $content;
}

/**
 * PKCS7填充算法
 * @param string $source
 * @return string
 */
function addPKCS7Padding($source, $cipher = MCRYPT_RIJNDAEL_128, $mode = MCRYPT_MODE_CBC)
{
    $source = trim($source);
    $block  = mcrypt_get_block_size($cipher, $mode);
    $pad    = $block - (strlen($source) % $block);
    if ($pad <= $block) {
        $char = chr($pad);
        $source .= str_repeat($char, $pad);
    }
    return $source;
}
/**
 * 移去PKCS7填充算法
 * @param string $source
 * @return string
 */
function stripPKSC7Padding($source)
{
    $source = trim($source);
    $char   = substr($source, -1);
    $num    = ord($char);
    if ($num == 62) {
        return $source;
    }

    $source = substr($source, 0, -$num);
    return $source;
}

/**
 * NUL("\0")填充算法
 * @param string $source
 * @return string
 */
function addZeroPadding($source, $cipher = MCRYPT_RIJNDAEL_128, $mode = MCRYPT_MODE_CBC)
{
    $source = trim($source);
    // openssl 并没有提供加密cipher对应的数据块大小的api这点比较坑
    $block = mcrypt_get_block_size($cipher, $mode);
    $pad   = $block - (strlen($source) % $block);
    if ($pad <= $block) {
        // $source .= str_repeat("\0", $pad);//KISS写法
        // pack 方法 a 模式使用 NUL("\0") 对内容进行填充  A 模式则使用空白字符填充
        $source .= pack("a{$pad}", ""); //高端写法
    }
    return $source;
}

/**
 * NUL("\0")填充算法移除
 * @param string $source
 * @return string
 */
function stripZeroPadding($source)
{
    return rtrim($source, "\0");
}
