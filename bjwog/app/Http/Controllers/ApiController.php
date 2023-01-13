<?php
/**
 * design CETC54-DH-XiaoSong 2020.10.20
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Apk;
use App\Robot;
use App\Group;
use App\Region;
use App\Config;
use App\TaskErr;
use App\Event;
use App\EventUser;
use App\pseLocation;
use App\Area;
use App\Msg;
use App\Device;
use App\AlarmArea;
use App\AlarmFence;
use App\AlarmPark;
use App\Jobs\FirmwareUpgrade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;//我用的缓存保存验证code
use Qcloud\Sms\SmsSingleSender;//依赖包引入
use Illuminate\Support\Facades\Redis;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiController extends Controller
{

    public function test(){

        dd(Cache::get("code_13081114886"));

        // $data = "5KLASfy63TwQN9Ea7ExD/Q==";

        // echo stripZeroPadding(openssl_decrypt($data, "AES-128-CBC", AES_KEY, OPENSSL_ZERO_PADDING, AES_IV));


        // //签发
        // $nowtime = time();
        // $token = [
        //     'iss' => 'http://www.helloweba.net', //签发者
        //     'aud' => 'http://www.helloweba.net', //jwt所面向的用户
        //     'iat' => $nowtime, //签发时间
        //     'nbf' => $nowtime + 1, //在什么时间之后该jwt才可用
        //     'exp' => $nowtime + 600, //过期时间-10min
        //     'data' => [
        //         'userid' => 1,
        //         'username' => "xiaosong"
        //     ]
        // ];
        // $jwt = JWT::encode($token, JWT_TOKEN_KEY); 

        // //解密
        // JWT::$leeway = 60;
        // $decoded = JWT::decode($jwt, JWT_TOKEN_KEY, ['HS256']);
        // $arr = (array)$decoded;
        // if ($arr['exp'] < time()) {
        //     return '请重新登录';
        // } else {
        //     return ((array)$arr['data'])['username'];
        // }
    }

	/**
	 * 大屏管理员登录
	 */
	public function adminLogin(){
        $validator = Validator::make(rq(), [
            // 'phone' => 'required|string|exists:admins,phone',
            'phone' => 'required|string',
            'password' => 'required|string',
            // 'code' => 'required',
        ]
        );

        if ($validator->fails())
            return err(1, $validator->messages());


        $admin = DB::table('admins')->where('phone',rq('phone'))->first();

        if(!$admin)
            return err(2);
        	// return err(2,"用户不存在");
             
        if($admin->password != md5(stripZeroPadding(openssl_decrypt(rq('password'), "AES-128-CBC", AES_KEY, OPENSSL_ZERO_PADDING, AES_IV))))
        	return err(3,'用户名或密码不正确');

        // $code = Cache::get("code_".rq('phone'));
        // if( $code != rq('code') ){
        //      return err(4,"验证码错误");
        // }

        // 签发token
        $nowtime = time();
        $token = [
            'iss' => 'http://www.helloweba.net', //签发者
            'aud' => 'http://www.helloweba.net', //jwt所面向的用户
            'iat' => $nowtime, //签发时间
            'nbf' => $nowtime, //在什么时间之后该jwt才可用
            'exp' => $nowtime + 3600, //过期时间-10min
            'data' => [
                'usercode' => $admin->usercode
            ]
        ];
        $jwt_token = JWT::encode($token, JWT_TOKEN_KEY); 
        Redis::set("jwt_token_".$admin->usercode,$jwt_token);
        return suc(['admin'=>$admin,'jwt_token'=>$jwt_token]);
	}
    /**
     * 大屏管理员添加
     */
    public function addAdmin(){
        $validator = Validator::make(rq(), [
            'phone' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
            // 'code' => 'required',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());
        DB::table('admins')->insert([
            'username' => rq('username'),
            'usercode' => rq('phone'),
            'phone' => rq('phone'),
            'password' => md5(rq('password')),
        ]);

        return suc();
    }

    /**
     * 登录
     */
	public function login(){
	    $validator = Validator::make(rq(), [
	        'username' => 'required',
	        'password' => 'required|string',
	        // 'device_id' => 'required|exists:devices,device_id',
	        'tpns_token' => 'required'//TODO
	    ]);

	    if ($validator->fails())
	        return err(1, $validator->messages());

	    $user = User::with('group')
	        ->where(['username'=>rq('username')])
	        ->orwhere(['usercode'=>rq('username')])
	        ->orWhere(['phone'=>rq('username')])
	        ->first();
        if (!$user) {
            // code...
             return err(2,['用户名或密码不正确']);
        }

	    if (((rq('username') == $user->username)
	    	        ||(rq('username') == $user->usercode)
	    	        ||(rq('username') == $user->phone))
	        &&
	        (md5(rq('password')) == $user->password))
	    {
            DB::table('users')->where('id',$user->id)->update(['tpns_token'=>rq('tpns_token')]);

	        $user = User::with('group')->where(['id'=>$user->id])->with('device')->first();

	        //判定是不是组长
	        if ($user->group) {
	            if ($user->group->manager_user_id == $user->id) {
	                $user->is_manager = 1;
	            }else{
	                $user->is_manager = 0;
	            }
	        }else{
	            $user->is_manager = 0;
	        }

            // 签发token
            $nowtime = time();
            $token = [
                'iss' => 'http://www.helloweba.net', //签发者
                'aud' => 'http://www.helloweba.net', //jwt所面向的用户
                'iat' => $nowtime, //签发时间
                'nbf' => $nowtime, //在什么时间之后该jwt才可用
                'exp' => $nowtime + 3600, //过期时间-10min
                'data' => [
                    'usercode' => $user->usercode
                ]
            ];
            $jwt_token = JWT::encode($token, JWT_TOKEN_KEY); 
            Redis::set("jwt_token_".$user->usercode,$jwt_token);            
	        return suc(['user'=>$user,'token'=>$jwt_token]);
	    }else{
	        return err(2,['用户名或密码不正确']);
	    }
	}
    /**
     * 设备绑定接口
     */
    public function bindUserAndDevice(){
        $validator = Validator::make(rq(), [
            'user_id' => 'required',
            'device_id' => 'required|exists:devices,device_id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        // 如果其他用户有同样的设备ID的话 更新为0
        DB::table('users')->where('device_id',rq('device_id'))->update(['device_id'=>0,'uwb_id'=>0]);
        // 更新这个用户的设备ID
        DB::table('users')->where('id',rq('user_id'))->update(['device_id'=>rq('device_id'),'uwb_id'=>rq('uwb_id')]);

        $device = DB::table('devices')->where('device_id',rq('device_id'))->first();

        return suc($device);

    }


    /**
     * 修改密码
     */
    public function resetPassword(){
        $validator = Validator::make(rq(), [
            'id' => 'required|string|exists:users,id',
            'password' => 'required|string',
            'new_password' => 'required|string',
            're_new_password' => 'required|string',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

  		$user = User::find(rq('id'));

  		if(rq('new_password') != rq('re_new_password'))
  			return err(2,['两次密码输入不相同']);

        if (md5(rq('password')) == $user->password)
        {
        	$user->password = md5(rq('new_password'));
        	$user->save();
        	return suc(['user'=>$user]);
        }else{
        	return err(3,['密码不正确']);
        }

    }

    /**
     * 获取手机验证码 Design By CC
     */

    public function getCode()
    {
        $validator = Validator::make(rq(), [
            'phone' => 'required|string',
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        $phone = rq("phone");

        if (!DB::table('admins')->where(['phone'=>$phone])->first() && !DB::table('users')->where(['phone'=>$phone])->first())
            return err(1,"the phone is not register!");
        
        //test
        
        $appid = "1400564584";//SDK appid
        $appkey = "149275150843477e3f90b654a27992ec";//SDK appkey
        $rand = rand(100000, 999999);//code
        $minute = 300;//有效时间
        $tempid = 1098092;//模板id
        $params = [$rand];
        $sign = "技术服务办公室公众号";
        try {
            $sender = new SmsSingleSender($appid, $appkey);
            $result = $sender->sendWithParam("86", $phone, $tempid, $params, $sign);//86为地区数字编号
            $rsp = json_decode($result, true);
            if ($rsp['result'] == 0) {
                $key = time() . rand(100, 999);
                $rsp['key'] = $key;
                $rsp['code'] = '1';
                $rsp['msg'] = $phone . $key;
                Cache::put("code_".$phone, $rand, $minute);//放入缓存
                session(['token' => $rand]);
                return suc([$rsp]);
            } else {
                $rsp['code'] = '0';
                return err(1,[$rsp]);
            }
        } catch (\Exception $e) {
            $rsp['code'] = '0';
            return err(1,[$rsp]);
        }
    }
    /**
     * 修改密码 Design By CC
     */
    public function forgetPassword(){
        $validator = Validator::make(rq(), [
            'phone' => 'required|string|exists:users,phone',
            'password' => 'required|string',
            'code' => 'required',
            'key' => 'required',
        ]);
        if ($validator->fails())
            return err(1, [$validator->messages()]);
        $key = rq("key");
        $code = rq("code");
        $phone = rq("phone");
        if (!Cache::has($key)){
            return err(1,["验证失败"]);
        }
        $cacheCode = Cache::get($key);
        if ($cacheCode != $code){
            return err(2,["验证码不正确"]);
        }
        Cache::forget($key);
        if (!DB::table('users')->where('phone',$phone)->first()){
            return err(3,["该手机号未注册"]);
        }else{
            DB::table('users')->where('phone',$phone)->update(['password'=>md5(rq('password'))]);
            return suc(['密码重置成功']);
        }
    }


    /**
     * 添加用户
     */
    public function addUser(){
        $validator = Validator::make(rq(), [
            'username' => 'required|string',
            'usercode' => 'required|string|unique:users,usercode',
            'password' => 'required|string',
            'phone' => 'required|string',
            'sex' => 'required|in:1,2',
            'job' => 'required|string',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $user = new User();
        $user->username = rq('username');
        $user->usercode = rq('usercode');
        $user->password = md5(rq('password'));
        $user->device_id = 0;
        $user->group_id = 0;
        $user->phone = rq('phone');
        $user->sex = rq('sex');
        $user->job = rq('job');
        $user->status = 0;
        $user->save();
        return suc();
    }

    /**
     * 添加用户和对应的uwb标签
     */
     public function addUserAndDevice(){
         $validator = Validator::make(rq(), [
             'username' => 'required|string',
             'password' => 'required|string',
             'phone' => 'required|string|unique:users,phone',
             'sex' => 'required|in:1,2',
             'uwb_id' => 'required|string|unique:users,uwb_id',
             'group_id' => 'required|string'
         ]);

         if ($validator->fails())
             return err(1, $validator->messages());

         $user = new User();
         $user->username = rq('username');
         $user->usercode = rq('phone');
         $user->password = md5(rq('password'));
         $user->uwb_id = rq('uwb_id');
         $user->group_id = rq('group_id');
         $user->phone = rq('phone');
         $user->sex = rq('sex');
         $user->status = 11;
         $user->save();
         return suc();
     }
    /**
     * 用户删除
     */
    public function delUserById(){
        $validator = Validator::make(rq(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        DB::table('users')->where('id',rq('user_id'))->delete();

        return suc();
    }

    /**
     * 更新用户
     * 这个接口不更新用户位置信息
     */
    public function updateUserById(){
        $validator = Validator::make(rq(), [
            'user_id' => 'required|exists:users,id',
            'username' => 'required|string',
            'usercode' => 'required|string',
            'password' => 'required|string',
            'sex' => 'required|in:1,2',
            'phone' => 'required|string',
           	'job' => 'required|string'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        User::where('id',rq('user_id'))->update(['username'=>rq('username'),'password'=>md5(rq('password')),'sex'=>rq('sex'),'phone'=>rq('phone'),'job'=>rq('job'),'usercode'=>rq('usercode')]);
        return suc();
    }

    /**
     * 获取所有用户列表
     */
    public function getUserList()
    {

        $validator = Validator::make(rq(), [
            'page_num|required' => 'int',
            'page_size|required' => 'int',
            'username' => 'string',
            'group_id' => 'int',
            'sex' => 'int|in:1,2',
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());

        
        $total = DB::table('users')->count();

        $users = DB::table('users');

        if (rq('username')) {
  			$users = $users->where('username', 'like', '%'.rq('username').'%');
        }
        if (rq('group_id')) {
  			$users = $users->where('group_id',rq('group_id'));
        }
        if (rq('sex')) {
  			$users = $users->where('sex',rq('sex'));
        }

        $users = $users->offset( (rq('page_num') - 1) * rq('page_size') )->limit(rq('page_size'))->get();

        foreach ($users as $user) {
            if ($user->group_id == 0) {
                $user->group_name = '未分组';  
            }else{
                $group = Group::find($user->group_id);
                $user->group_name = $group->name;
            }
        }
        return suc(['users'=>$users,'total'=>$total]);
    }


    /**
     * 根据ID获取用户
     */
    public function getUserById(){
        $validator = Validator::make(rq(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

    	$user = User::with('device')->find(rq('user_id'));

        return suc(['user'=>$user]);
    }

    /**
     * 添加小组
     */
    public function addGroup(){
        $validator = Validator::make(rq(), [
            'name' => 'required|string',
            'manager_user_id' => 'required|exists:users,id',
            'desc' => 'required|string|max:255',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

		$group_id = DB::table('groups')->insertGetId(
		    [
		    'name' => rq('name'),
		    'manager_user_id' => rq('manager_user_id'),
		    'desc' => rq('desc'),
		    'type' => 0,
		    'status' => 0
		    ]
		);

        $user = User::find(rq('manager_user_id'));
        if ($user->group_id != 0) {
        	return err(2,['manager_user_id'=>['该用户已经添加小组']]);
        }else{
        	$user->group_id = $group_id;
        	$user->save();
        }

        return suc();
    }

    /**
     * 删除小组
     */
    public function delGroupById(){
        $validator = Validator::make(rq(), [
            'group_id' => 'required|exists:groups,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        //删除小组
        DB::table('groups')->where('id',rq('group_id'))->delete();

        //修改用户小组状态
        User::where('group_id',rq('group_id'))->update(['group_id'=>0]);

        return suc();
    }

    /**
     * 添加用户到小组
     */
    public function addUserListToGroup(){
        $validator = Validator::make(rq(), [
            'group_id' => 'required|exists:groups,id',
            'user_id_list' => 'required|json',
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        $user_id_list = json_decode(rq('user_id_list'),TRUE);
        foreach ($user_id_list as $user_id) {
			$user = User::find($user_id);
			if (!$user) {
        		return err(2,[$user_id=>['该用户不存在']]);				
			}else{
				if ($user->group_id != 0) {
					return err(3,[$user_id=>['该用户已经添加小组']]);
				}else{
					$user->group_id = rq('group_id');
					if(!$user->save()){
						return err(4);
					}
				}
			}
        }
        return suc();
    }

	/**
	* 用户移除小组
	*/
    public function delUserListFromGroup()
    {
        $validator = Validator::make(rq(), [
            'user_id_list' => 'required|json'
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        $user_id_list = json_decode(rq('user_id_list'),TRUE);
        foreach ($user_id_list as $user_id) {
			$user = User::find($user_id);
			$user->group_id = 0;
			if(!$user->save())
				return err(1);
        }
        return suc();
    }

    /**
     * 查询未绑定小组用户
     */
    public function getUserListWithoutGroup(){

        $validator = Validator::make(rq(), [
            'page_num' => 'required|int',
            'page_size' => 'required|int',
            'username' => 'string'
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());

        $users = DB::table('users');
        $total = DB::table('users')->count();

        if (rq('username')) {
  			$users = $users->where('username', 'like', '%'.rq('username').'%');
        }

        $users = $users->where('group_id',0)->offset( (rq('page_num') - 1) * rq('page_size') )->limit(rq('page_size'))->get();

        return suc(['users'=>$users,'totle'=>$total]);
    }

    /**
     * 获取所有小组列表 不包含用户 只有小组信息
     */
    public function getGroupList()
    {
        $validator = Validator::make(rq(), [
            'page_num' => 'required|int',
            'page_size' => 'required|int',
            'name' => 'string'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $groups = Group::with('manager_user');
        if (rq('name')) {
  			$groups = $groups->where('name', 'like', '%'.rq('name').'%');
        }
        
        $total = $groups->count();

        $groups = $groups->offset( (rq('page_num') - 1) * rq('page_size') )->limit(rq('page_size'))->get();

        foreach ($groups as $group) {
        	$group->user_num = DB::table('users')->where('group_id',$group->id)->count();
        	// $group->manager_user_name = $group->manager_user->username; 
        }

        return suc(['groups'=>$groups,'total'=>$total]);
    }

    /**
     * 获取指定小组列表 不包含指定小组的用户
     * (已测)
     */
    public function getGroupById()
    {
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:groups,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $group = Group::find(rq('id'));

        return suc(['group'=>$group]);
    }

    /**
     * 获取指定小组列表 有指定小组的用户
     */
    public function getGroupWithUserById()
    {
        $validator = Validator::make(rq(), [
            'group_id' => 'required|exists:groups,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $users = Group::find(rq('group_id'))->users;
        $group = Group::find(rq('group_id'));

        return suc(['group'=>$group,'users'=>$users]);
    }

    /**
     * 获取小组内所有成员的uwb_id
     */
    public function getGroupWithUwbIdById()
    {
        $validator = Validator::make(rq(), [
            'group_id' => 'required|exists:groups,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $users = Group::find(rq('group_id'))->users;
        $uwb_id_list = array ();
        $name = array();
        foreach ($users as $user){
            array_push($name,$user->username);
            if ($user->uwb_id == null)
                array_push($uwb_id_list,"tag:0");
            else
                array_push($uwb_id_list,"tag:".$user->uwb_id);

        }

        return suc(["uwb_id"=>$uwb_id_list,"name"=>$name]);
    }
    /**
     * 获取电量和状态
     */
    public function getDeviceStatusAndPower(){
        $validator = Validator::make(rq(), [
            'uwb_id' => 'required',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());
        // $device = new stdClass();
        $device = Device::where("uwb_id",rq('uwb_id'))->first(["status","power"]);
        if ($device == null) {
            $device = new Device;
            $device->status = 11;
            $device->power = 100;
        }


        return suc($device);
    }

    /**
     * 获取指定小组列表 有指定小组的用户
     */
    public function getGroupWithUserWithDeviceById()
    {
        $validator = Validator::make(rq(), [
            'group_id' => 'required|exists:groups,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $group = Group::with('users')->find(rq('group_id'));
        
        $new_user_list = [];
        foreach ($group->users as $user) {
        	$device = DB::table('devices')->where('device_id',$user->device_id)->first(['x','y','z','lng','lat','h','floor','status']);
        	if ($device) {
        		if (($user->status > 10) && ($device->status > 10)) {
	        		$user->device = $device;
	        		$new_user_list []= $user;
	        	}
        	}
        }
        
        unset($group->users);
        $group->users = $new_user_list;

        return suc($group);
    }

    /**
     * 编辑小组
     */
    public function updateGroupById(){
        $validator = Validator::make(rq(), [
            'group_id' => 'required|exists:groups,id',
            'name' => 'required|string',
            'manager_user_id' => 'required|exists:users,id',
            'desc' => 'required|string|max:255',
        ]);
        if ($validator->fails())
    		return err(1, $validator->messages());

    	$user = User::find(rq('manager_user_id'));
    	$group = DB::table('groups')->where('id',rq('group_id'))->first();

    	if (($user->group_id != 0) && ($user->group_id != rq('group_id'))) {
    		if ($group->manager_user_id != rq('manager_user_id')) {
        		return err(2,['manager_user_id'=>['该用户已经添加小组']]);
    		}
    	}

    	$user->group_id = rq('group_id');
    	$user->save();

        Group::where('id',rq('group_id'))->update([
            'name' => rq('name'),
            'manager_user_id' => rq('manager_user_id'),
            'desc' => rq('desc')
            ]);  

         return suc();
    }

    /**
     * 获取所有设备列表
     */
    public function getDeviceList()
    {
    	$validator = Validator::make(rq(), [
            'page_num|required' => 'int',
            'page_size|required' => 'int',
            'device_id' => '',
            'is_car' => ''
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());
        
        $devices = DB::table('devices')->where('devices.device_id','!=','');

        if (rq('device_id')) {
  			$devices = $devices->where('device_id', 'like', '%'.rq('device_id').'%');
        }
        if(rq('is_car')){
            $devices = $devices->join('cars','cars.device_id','=','devices.device_id');
        }

        $total = $devices->count();

        $devices = $devices->offset( (rq('page_num') - 1) * rq('page_size') )->limit(rq('page_size'))->get();

        foreach ($devices as $device) {
            if(count(explode("-",$device->fu_url)) > 2){
        	   $device->fu_version = explode("-",$device->fu_url)[2];
            }
        }
 
        return suc(['devices'=>$devices,'total'=>$total]);
    }

    /**
     * 删除设备
 	*/
	public function delDeviceByDeviceId(){
        $validator = Validator::make(rq(), [
            'device_id' => 'required|exists:devices,device_id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        //删除设备
        DB::table('devices')->where('device_id',rq('device_id'))->delete();

        //修改用户小组状态
        User::where('device_id',rq('device_id'))->update(['device_id'=>0]);

        return suc();
	}

    /**
     * 根据设备ID获取设备
     */
    public function getDeviceByDeviceId()
    {

        $validator = Validator::make(rq(), [
            'device_id' => 'required|exists:devices,device_id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $device = DB::table('devices')->where('device_id',rq('device_id'))->first();

        return suc(['device'=>$device]);
    }

    /**
     * 更新设备 设备只能配置 云端不能修改device的参数 只可以修改device里面的参数
     */
    public function updateDeviceConfigByDeviceId(){
        $validator = Validator::make(rq(), [
            'device_id' => 'required|exists:devices,device_id',
			'rate'=>'required',
			'f9p_gnss_system'=>'required',
			'f9p_rate'=>'required',
			'f9p_difference_address'=>'required',
			'fu_url'=>'required',
			'fu_md5'=>'required',
			'imu_rate'=>'required',
			'barometer_rate'=>'required',
			'control_uwb'=>'required',
            'control_wifi'=>'required',
			'control_typec'=>'required',
			'control_f9p'=>'required',
			'control_ble'=>'required',
			'control_barometer'=>'required',
			'L0'=>'required'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        Device::where('device_id',rq('device_id'))->update([
	            'rate'=>rq('rate'),
				'f9p_gnss_system'=>rq('f9p_gnss_system'),
				'f9p_rate'=>rq('f9p_rate'),
				'f9p_difference_address'=>rq('f9p_difference_address'),
				'fu_url'=>rq('fu_url'),
				'fu_md5'=>rq('fu_md5'),
				'imu_rate'=>rq('imu_rate'),
				'barometer_rate'=>rq('barometer_rate'),
				'control_uwb'=>rq('control_uwb'),
                'control_wifi'=>rq('control_wifi'),
				'control_typec'=>rq('control_typec'),
				'control_f9p'=>rq('control_f9p'),
				'control_ble'=>rq('control_ble'),
				'control_barometer'=>rq('control_barometer'),
				'L0'=>rq('L0'),
				'updated_flag'=>1 //更新读取
            ]);

        return suc();
    }
	        
    /**
     * 批量控制
     */
    public function updateAllDeviceConfig(){
        $validator = Validator::make(rq(), [
            'control_wifi'=>'required|in:0,1',
			'control_typec'=>'required|in:0,1',
			'control_ble'=>'required|in:0,1'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        DB::table('devices')->update([
                'control_wifi'=>rq('control_wifi'),
				'control_typec'=>rq('control_typec'),
				'control_ble'=>rq('control_ble'),
				'updated_flag'=>1 //更新读取
            ]);

        return suc();
    }
    /**
     * 批量控制车载终端电源模式
     * 0表示普通模式，1表示车载模式
     * power_time以分钟为单位
     */
    public function updateAllPowerControl(){
        $validator = Validator::make(rq(), [
            'power_mode'=>'required|in:0,1',
            'power_time'=>'required|',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $cars = DB::table('cars')->get();
        foreach($cars as $car){
            DB::table('devices')->where('device_id',$car->device_id)->update(['power_mode'=>rq('power_mode'),'power_time'=>rq('power_time')]);
        }
        return suc();

    }


    /**
     * 获取区域列表
     */
    public function getRegionsWithAreas(){
        return suc(Region::with('areas')->get());
    }

    /**
     * 
     */
    public function updateRegionById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:regions,id',
            'name' => 'required|string',
            'point_list' => 'required|json|string',
            'h' => 'required',
            'floor' => 'required',
            'max_user_num' => 'required',
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());        
        DB::table('regions')
            ->where('id',rq('id'))
            ->update([
                'name' => rq('name'),
                'point_list' => rq('point_list'),
                'h' => rq('h'),
                'floor' => rq('floor'),
                'max_user_num' => rq('max_user_num'),
            ]);
        return suc();
    }    



    /**
     * 分页获取Area
     */
    public function getAreaList()
    {
        $validator = Validator::make(rq(), [
            'page_num' => 'required|int',
            'page_size' => 'required|int',
            'name' => 'string'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $areas = DB::table('areas');

        if (rq('name')) {
            $areas = $areas->where('name', 'like', '%'.rq('name').'%');
        }
        
        $total = $areas->count();

        $areas = $areas->offset( (rq('page_num') - 1) * rq('page_size') )->limit(rq('page_size'))->get();
        
        return suc(['areas'=>$areas,'total'=>$total]);
    }

    /**
     * 
     */
    public function addArea(){
        $validator = Validator::make(rq(), [
            'name' => 'required|string',
            'point_list' => 'required|json|string',
            'region_id' => 'required|exists:regions,id',
            'type' => 'required',
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());
        $area = new Area();
        $area->name = rq('name');
        $area->point_list = rq('point_list');
        $area->region_id = rq('region_id');
        $area->type = rq('type');
        $area->save();
        return suc();
    }     


     public function delAreaById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:areas,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());
        DB::table('areas')->where('id',rq('id'))->delete();
        return suc();
    }

    /**
     * 
     */
    public function updateAreaById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:areas,id',
            'name' => 'required|string',
            'point_list' => 'required|json|string',
            'type' => 'required',
            'region_id' => 'required|exists:regions,id'
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());        
        DB::table('areas')
            ->where('id',rq('id'))
            ->update([
                'name' => rq('name'),
                'point_list' => rq('point_list'),
                'type' => rq('type'),
                'region_id' => rq('region_id'),
            ]);
        return suc();
    }    

  
    /**
     * 人员投入
     */
    public function getUserInput(){

    	$userInput = User::count();
        $allUser = User::all();
        $userVal = 0;
        foreach ($allUser as $user) {
            if (Redis::connection('device_location')->get("tag:".$user->uwb_id)) {
                $userVal = $userVal + 1;
            }
        }
    	$deviceInput = Device::count()+1000;
    	$deviceVal = DB::table('devices')
        ->where('status','>',10)  //筛选设备在线
        ->count();
        $tags = Redis::connection('device_location')->dbsize();

    	return suc([
    			'userInput'=>$userInput,
    			'userVal'=>$userVal,
    			'deviceInput'=>$deviceInput,
    			'deviceVal'=>$deviceVal+$tags,
    		]);
    }

    /**
     * 获取重点区域人员 这个表里面只有一条数据
     */
    public function getRegionUserNum(){
        $regions =  Region::get();
        $result = [];

        $south =  ["name"=> "南区","usernum"=> 0,"max_user_num"=> 0,"percent"=> 0];
        $north =  ["name"=> "北区","usernum"=> 0,"max_user_num"=> 0,"percent"=> 0];
        $top =    ["name"=> "顶区","usernum"=> 0,"max_user_num"=> 0,"percent"=> 0];
        $part =   ["name"=> "停车区","usernum"=> 0,"max_user_num"=> 0,"percent"=> 0];
        $people = ["name"=> "观众区","usernum"=> 0,"max_user_num"=> 0,"percent"=> 0];
        $player = ["name"=> "赛道区","usernum"=> 0,"max_user_num"=> 0,"percent"=> 0];

        foreach ($regions as $region) {
            $index_str = mb_substr($region->name,0,2);
        	// $current_user_num = User::where('region_id',$region->id)
            // join('users.device_id','devices.device_id')->where('status','>',10)->count();
            $current_user_num = DB::table('users')
            ->join('devices','users.device_id','=','devices.device_id')
            ->where('users.region_id',$region->id)
            ->where('devices.status','>',10)->count();

            if ($index_str == '南区') {
                $south['usernum'] = $south['usernum'] + $current_user_num;
                $south['max_user_num'] = $south['max_user_num'] + $region->max_user_num;
            }else if ($index_str == '北区') {
                $north['usernum'] = $north['usernum'] + $current_user_num;
                $north['max_user_num'] = $north['max_user_num'] + $region->max_user_num;
            }else if ($index_str == '顶区') {
                $top['usernum'] = $top['usernum'] + $current_user_num;
                $top['max_user_num'] = $top['max_user_num'] + $region->max_user_num;
            }else if ($index_str == '停车') {
                $part['usernum'] = $part['usernum'] + $current_user_num;
                $part['max_user_num'] = $part['max_user_num'] + $region->max_user_num;
            }else if ($index_str == '观众') {
                $people['usernum'] = $people['usernum'] + $current_user_num;
                $people['max_user_num'] = $people['max_user_num'] + $region->max_user_num;
            }else if ($index_str == '赛道') {
                $player['usernum'] = $player['usernum'] + $current_user_num;
                $player['max_user_num'] = $player['max_user_num'] + $region->max_user_num;
            }
        }

        $south['percent'] = $south['usernum'] / $south['max_user_num'];
        $north['percent'] = $north['usernum'] / $north['max_user_num'];
        $top['percent'] = $top['usernum'] / $top['max_user_num'];
        $part['percent'] = $part['usernum'] / $part['max_user_num'];
        $people['percent'] = $people['usernum'] / $people['max_user_num'];
        $player['percent'] = $player['usernum'] / $player['max_user_num'];

        $result []= $south;
        $result []= $north;
        $result []= $top;
        $result []= $part;
        $result []= $people;
        $result []= $player;

        return suc($result);
    }

    /**
     * 查询群组激活度列表
     */
    public function getGroupValPercent(){
    	$groups = Group::with('users')->get();
    	$userVals = DB::table('devices')
        ->join('users', 'users.device_id', '=', 'devices.device_id')  //筛选出来具备成功的绑定关系的
        ->where('devices.status','>',10)  //筛选设备在线
        ->where('users.status','>',10) //筛选用户在线
        ->get();

        $result = [];

        foreach ($groups as $group) {
        	$userValNum = 0;
        	foreach ($userVals as $userVal) {
        		if ($userVal->group_id == $group->id)
					$userValNum ++ ;        			
        	}
        	$result[] = ['group_name'=>$group->name,'group_num_all'=>count($group->users),'group_num_val'=>$userValNum];
        }
        return suc($result);
    }

    /**
     * 查询事件统计信息
     */
    public function getEventNum(){
    	$events_all = Event::count();
    	$events_waitting = Event::where('status',1)->count();
    	$events_dealing = Event::where('status',2)->count();
    	$events_complete = Event::where('status',3)->count();

    	return suc(['累计事件'=>$events_all,'未处理'=>$events_waitting,'处理中'=>$events_dealing,'已处理'=>$events_complete]);
    }

    /**
     * 查询报警事件列表
     */
    public function getEventList(){
    	$events_waitting = Event::with('msg','group','area')->where('status',1)->get();
    	$events_dealing = Event::with('msg','group','area')->where('status',2)->get();
    	return suc(['未处理'=>$events_waitting,'处理中'=>$events_dealing]);
    }

    /**
     * 查询事件的详细信息
     */
    public function getEventById(){
        $validator = Validator::make(rq(), [
            'event_id' => 'required|exists:events,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $event = Event::find(rq('event_id'));

        return suc($event);
    }

    /**
     * 查询事件的详细信息（带人）
     */
    public function getEventByIdWithUserList(){
        $validator = Validator::make(rq(), [
            'event_id' => 'required|exists:events,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $event = Event::with('users')->find(rq('event_id'));

        return suc($event);        
    }

    /**
     * 查询指定区域内人员的实时位置
     */
    public function getRegionWithUserLocation(){
        $validator = Validator::make(rq(), [
            'region_id_list' => 'required|json'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $region_id_list = json_decode(rq('region_id_list'),TRUE);
        if(!$region_id_list[0])
            return err(1,"region_id_list 为空！");
   
   		$res_arr = [];
        foreach ($region_id_list as $region_id) {
			$region = Region::find($region_id);
			if (!$region) {
        		return err(2,[$region_id=>['该region_id不存在']]);				
			}			
	    	$userVals = DB::table('devices')
				        ->join('users', 'users.device_id', '=', 'devices.device_id')  //筛选出来具备成功的绑定关系的
				        ->where('devices.status','>',10)  //筛选设备在线
				        // ->where('users.status','>',10) //筛选用户在线
				        ->where('users.region_id','=',$region_id) //筛选用户在线
				        ->get(['users.id','users.username','users.usercode','users.area_id','users.region_id','users.group_id','users.status','users.phone','users.job','users.sex','devices.name','devices.lng','devices.lat','devices.h','devices.x','devices.y','devices.z','devices.floor','devices.status']);
			$tmp_arr = [];
			foreach ($userVals as $userVal) {
				$tmp_arr []= $userVal;			        	
	        }			
	        $res_arr []= [$region->name=>$tmp_arr];
        }

        return suc($res_arr);
    }

    /**
     * 大屏人员态势用户位置接口
     */
    public function getDPUser(){
    	$regions = Region::get();

    	$res_arr = [];
    	$first_flag = 1;
    	foreach ($regions as $region) {
    		if ($first_flag) {
    			$first_flag = 0;
    			continue;
    		}
	    	$userVals = DB::table('devices')
		        ->join('users', 'users.device_id', '=', 'devices.device_id')  //筛选出来具备成功的绑定关系的
		        ->where('devices.status','>',10)  //筛选设备在线
		        // ->where('users.status','>',10) //筛选用户在线
		        ->where('users.region_id','=',$region->id) //筛选用户在线
		        ->get(['users.id','users.username','users.usercode','users.area_id','users.region_id','users.group_id','users.status','users.phone','users.job','users.sex','devices.name','devices.lng','devices.lat','devices.h','devices.x','devices.y','devices.z','devices.floor','devices.status']);
			$tmp_arr = [];
			foreach ($userVals as $userVal) {
				$tmp_arr []= $userVal;			        	
	        }			
	        $res_arr[$region->id] = $tmp_arr;
	       
    	}

    	$arr_floor_1 = array_merge($res_arr['1'],$res_arr['6'],$res_arr['16'],$res_arr['18'],$res_arr['21'],$res_arr['22']);
    	$arr_floor_2 = array_merge($res_arr['2'],$res_arr['7'],$res_arr['19']);
    	$arr_floor_3 = array_merge($res_arr['3'],$res_arr['8'],$res_arr['17'],$res_arr['20']);
    	$arr_floor_4 = array_merge($res_arr['4'],$res_arr['9'],$res_arr['23']);
        $arr_floor_5 = array_merge($res_arr['5'],$res_arr['24']);

		$res_arr ['101']= $arr_floor_1;
		$res_arr ['102']= $arr_floor_2;
		$res_arr ['103']= $arr_floor_3;
		$res_arr ['104']= $arr_floor_4;
        $res_arr ['105']= $arr_floor_5;

		unset($res_arr['1'],$res_arr['6'],$res_arr['16'],$res_arr['18'],$res_arr['21'],$res_arr['22'],
    		$res_arr['2'],$res_arr['7'],$res_arr['19'],
    		$res_arr['3'],$res_arr['8'],$res_arr['17'],$res_arr['20'],
    		$res_arr['4'],$res_arr['9'],$res_arr['23'],
    		$res_arr['5'],$res_arr['24']
    		);

    	return suc($res_arr);
    }

    /**
     * 根据区域 查询所有任务或者事件地理围栏列表
     */
    public function getAreasByRegionId(){
        $validator = Validator::make(rq(), [
            'region_id' => 'required|exists:regions,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $areas = Area::where('region_id',rq('region_id'))->get();

        return suc(['areas'=>$areas]);
    }

    /**
     * 根据用户ID和两个时间戳获取历史位置数据
     */
    public function getUserPastLoactionByIDAndTimeStamp(){
        $validator = Validator::make(rq(), [
            // 'user_id' => 'required|exists:users,id',
            'user_id' => 'required|int',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        // 获取数据

        $sql = "SELECT * FROM user_location where id='".rq('user_id')."' and time<'".rq('end_at')."' and time>'".rq('start_at')."' "."tz('Asia/Shanghai')";

        // return $sql;
		$fields = "db=BJWOGDB&q=".$sql;        

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => INFLUXDB_URL.'/query',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $fields,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);

		$response = json_decode($response,true);

		$res = [];
		if(array_key_exists('series',$response['results'][0])){
			foreach ($response['results'][0]['series'][0]['values'] as $point) {

				if($point[8] == 0)
					continue;

				$item['time'] = str_replace('T',' ',substr($point[0],0,19));
				$item['area_id'] = $point[1];
				$item['floor'] = $point[2];
				$item['height'] = $point[3];
				$item['id'] = $point[4];
				$item['lat'] = $point[5];
				$item['lng'] = $point[6];
				$item['name'] = $point[7];
				if (($point[8] == 1) || ($point[8] == 6) || ($point[8] == 16) || ($point[8] == 18) || ($point[8] == 21) || ($point[8] == 22)){
					$item['region_id'] = REGION_ID_1_6_16_18_21_22;
				}else if(($point[8] == 2) || ($point[8] == 7) || ($point[8] == 19)){
					$item['region_id'] = REGION_ID_2_7_19;
				}else if(($point[8] == 3) || ($point[8] == 8) || ($point[8] == 17) || ($point[8] == 20)){
					$item['region_id'] = REGION_ID_3_8_17_20;
				}else if(($point[8] == 4) || ($point[8] == 9) || ($point[8] == 23)){
					$item['region_id'] = REGION_ID_4_9_23;
				}else if(($point[8] == 5) || ($point[8] == 24)){
                    $item['region_id'] = REGION_ID_5_24;

                }
                else{
					$item['region_id'] = $point[8];
				}
				$item['x'] = $point[9];
				$item['x'] = $point[10];
				$item['y'] = $point[11];
				$item['z'] = $point[12];
				$res []= $item;
			}
		}
        return suc(['locations'=>$res]);
    }

    /**
     * 根据两个时间戳获取所有用户历史位置数据
     */
    public function getUserPastLoactionTimeStamp(){
        $validator = Validator::make(rq(), [
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        // 获取数据
        $users = DB::table('past_user_locations')
        				->where('created_at','>=',rq('start_at'))
        				->where('created_at','<=',rq('end_at'))
        				->get();

        return suc(['users'=>$users]);
    }

    /**
     * 模糊查询人员
     */
   	public function getUserListLikeUserName(){
        $validator = Validator::make(rq(), [
            'username' => 'required|string'
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());

        $users = DB::table('users')->where('username', 'like', '%'.rq('username').'%')->get();

        return suc($users);
   	}

    /**
     * 模糊查询组
     */
   	public function getGroupListLikeGroupName(){
        $validator = Validator::make(rq(), [
            'groupName' => 'required|string'
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());

        $groups = DB::table('groups')->where('name', 'like', '%'.rq('groupName').'%')->get();

        return suc($groups);
   	}    

    /**
     * 获取人员类型列表
     */
    public function getJobList(){
    	$resutl = [];

    	$users = User::get();

    	foreach ($users as $user) {
    		$result[]= $user->job;
    	}
    	$result = array_unique($result);
    	return suc($result);
    }

    /**
     * 根据类型获取人员
     */
    public function getUserListByJob(){
        $validator = Validator::make(rq(), [
            'job' => 'required|string'
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        $users = User::with('device')->where('job',rq('job'))->get();
        return suc($users);
    }

    /**
     * 根据区域获取人员
     */
   	public function getUserListByRegion(){
        $validator = Validator::make(rq(), [
            'region_id' => 'required|exists:regions,id'
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());

        $users = User::with('device')->where('region_id',rq('region_id'))->where('status','>',10)->get();

        return suc($users);
   	}


    /**
     * 根据用户列表获取用户的位置
     */
    public function getUserPositionListByUserList()
    {
    	// return rq('user_code_list');
        $validator = Validator::make(rq(), [
            'user_code_list' => 'required|json',
            'all_device' =>'in:1'
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        $user_code_list = json_decode(rq('user_code_list'),TRUE);

        $result = [];
        $item = [];
        $first_flag = 1;
        foreach ($user_code_list as $user_code) {
            $user = User::with('area','region')->where('usercode',$user_code)->first();
            if (!$user) {
                return err(2,"usercode list 存在无效值");
            }
            if($first_flag){
                $user->status = 11;
                $user->save();
                $first_flag = 0;
            }
            $device = Device::where('device_id',$user->device_id)->first(['lng','lat','h','floor','x','y','z','status','power']);
            if ($device->h == 0) {
                $device->h = 1700.26;
                $device->z = 1700.26;
                // code...
            }

            if (!$user) {
                return err(3,"usercode list 存在未绑定设备用户");
            }
            if (!$device) {
                return err(4,"device 不存在");
            }

            if(rq('all_device')){
                if (($user->status <= 10))
                    continue;
            }else{
                if (($user->status <= 10) || ($device->status <= 10))
                    continue;
            }

            $item['id'] = $user->id;
            $item['sex'] = $user->sex;
            $item['job'] = $user->job;
            $item['username'] = $user->username;
            $item['usercode'] = $user->usercode;
            $item['area_id'] = $user->area_id;
            $item['area_name'] = $user->area->name;
            $item['region_id'] = $user->region_id;
            $item['region_name'] = $user->region->name;
            $item['lng']=$device->lng;
            $item['lat']=$device->lat;
            $item['h']=$device->h;
            $item['floor']=$device->floor;
            $item['x']=$device->x;
            $item['y']=$device->y;
            $item['z']=$device->z;
            $item['power']=$device->power;
            // $item['area']=$device->area;
            $result []= $item;
        }
        return suc($result);
    }

    /**
     * 模糊查询车辆
     */
    public function getCarByCarName(){

        $validator = Validator::make(rq(), [
            'page_num' => 'required|int',
            'page_size' => 'required|int',
            'car_name' => 'string'
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());

        $cars = DB::table('cars');
        $total = DB::table('cars')->count();

        if (rq('car_name')) {
            $cars = $cars->where('car_name', 'like', '%'.rq('car_name').'%');
        }

        $cars = $cars->offset( (rq('page_num') - 1) * rq('page_size') )->limit(rq('page_size'))->get();

        return suc(['cars'=>$cars,'totle'=>$total]);
    }

    /**
     * 获取用户所属小组的成员的位置信息
     */
    public function getUserPositionListInGroupByUserId(){
        $validator = Validator::make(rq(), [
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $user = User::find(rq('user_id'));
        if ($user->group_id == 47) {
            // 除雪车位置监控小组
            $snow_sweepers = DB::table('snow_sweepers')->get();
            $result = [];
            foreach($snow_sweepers as $snow_sweeper){
                $device = Device::where('device_id',$snow_sweeper->device_id)->first(['lng','lat','h','floor','x','y','z','status']);
                if($device && $device->status>10){
                    $device->id = $snow_sweeper->id;//为了方便手机端才把device的id写成user_id
                    $device->region_id = 22;
                    $device->username = $snow_sweeper->car_name;
                    $device->sex = 2;
                    $device->job = "雪狼除雪";
                    $result[]= $device;
                }

            }
            
        }else{

            $group = Group::with('users')->where('id',$user->group_id)->first();

            $result = [];
            foreach ($group->users as $user) {
                if($user->id == rq('user_id'))
                    continue;
                if ($user->status > 10){
                    $device = Device::where('device_id',$user->device_id)->first(['lng','lat','h','floor','x','y','z','status']);
                    if($device && $device->status>10){
                        $device->id = $user->id;//为了方便手机端才把device的id写成user_id
                        $device->region_id = $user->region_id;
                        $device->username = $user->username;
                        $device->sex = $user->sex;
                        $device->job = $user->job;
                        $result[]= $device;
                    }
                }
            }

        }

        return suc($result);
    }
    
    /**
     * 根据用户ID获取事件列表
     */
    public function getEventsByUserId(){ //TODO events => event list
        $validator = Validator::make(rq(), [
            'user_id' => 'required|exists:users,id',
            'event_status' => 'required|in:0,1',
			'page_num|required' => 'int',
            'page_size|required' => 'int'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $user = User::with('events')->where('id',rq('user_id'))->first();

        $result = [];
        foreach ($user->events as $event) {
            if(rq('event_status') == 1){//处理中
                if (($event->status == 1) || ($event->status == 2)) {
                    $result[]= $event;
                }
            }else if(rq('event_status') == 0){//历史
                if ($event->status == 3) {
                    $event_user = EventUser::where('event_id',$event->id)->where('user_id',$user->id)->first();
                    $event->img_handle_uri = $event_user->img_handle_uri;
                    $event->complete_msg_id = $event_user->complete_msg_id;
                    $event->complete_time = $event_user->complete_time;
                    $result[]= $event;
                }
            }
        }

        $result = array_unique($result);
        
        /**
         * 按照 report_time 排序
         */
        $result = array_values(array_sort($result, function ($value) {
    		return !$value['report_time'];
		}));

		if (rq('page_num') && rq('page_size')) {
			$result = array_slice($result,(rq('page_num') - 1) * rq('page_size'),rq('page_size'));
		}

        return suc($result);
    }

    /**
     * 获取常用语
     */
    public function getMsgList(){
        $validator = Validator::make(rq(), [
            'system' => 'required|in:1,2,3'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());
        return suc(DB::table('msgs')->where('system',rq('system'))->get());
    }

    /**
     * 获取常用语
     */
    public function getMsgByWarningMsgIdAndCommandMsgId(){
        $validator = Validator::make(rq(), [
            'warning_msg_id' => 'exists:msgs,id',
            'command_msg_id' => 'exists:msgs,id',
            'complete_msg_id' => 'exists:msgs,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        if ((rq('warning_msg_id') == null) && (rq('command_msg_id') == null) && (rq('complete_msg_id') == null)) {
            return err(2);
        }

        $warning_msg = null;
        $command_msg = null;
        $complete_msg = null;

        if(rq('warning_msg_id')){
        	$warning_msg = Msg::find(rq('warning_msg_id'));
        }
        if(rq('command_msg_id')){
            $command_msg = Msg::find(rq('command_msg_id'));
        }
         if(rq('complete_msg_id')){
            $complete_msg = Msg::find(rq('complete_msg_id'));
        }

        return suc(["warning_msg"=>$warning_msg,"command_msg"=>$command_msg,"complete_msg"=>$complete_msg]);
    }



    /**
     * 报警
     */
    public function addEvent(Request $request){

        $validator = Validator::make(rq(), [
            'name' => 'required',
            'warning_msg_id' => 'required',
            'region_id' => 'required',
            'area_id' => 'required',
            'lng' => 'required',
            'lat' => 'required',
            'h' => 'required',
            'floor' => 'required',
            'level' => 'required',
            'img_warning_1'=>'image',
            'img_warning_2'=>'image',
            'img_warning_3'=>'image',
            'img_warning_4'=>'image'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $img_uri_list = [];
        if($request->file('img_warning_1')){
            $img_warning_1_uri =  explode("/",$request->file('img_warning_1')->store('public/img'))[2];
            $img_uri_list[] = $img_warning_1_uri;
		}
		if($request->file('img_warning_2')){
			$img_warning_2_uri =  explode("/",$request->file('img_warning_2')->store('public/img'))[2];
			$img_uri_list[] = $img_warning_2_uri;
		}
		if($request->file('img_warning_3')){
			$img_warning_3_uri =  explode("/",$request->file('img_warning_3')->store('public/img'))[2];
			$img_uri_list[] = $img_warning_3_uri;
		}
		if($request->file('img_warning_4')){
			$img_warning_4_uri =  explode("/",$request->file('img_warning_4')->store('public/img'))[2];
			$img_uri_list[] = $img_warning_4_uri;
		}

		$event_id = DB::table("events")->insertGetId([
		    "name" => rq('name'),
			"warning_msg_id" => rq('warning_msg_id'),
			"region_id" => rq('region_id'),
			"status" => 1,
			"area_id" => rq('area_id'),
			"lng" => rq('lng'),
			"lat" => rq('lat'),
            "x" => rq('x'),
            "y" => rq('y'),
            "z" => rq('z'),
			"h" => rq('h'),
			"floor" => rq('floor'),
			"report_time" => date('Y-m-d H:i:s', time()),
			"level" => rq('level'),
			"img_warning_uri" => json_encode($img_uri_list)
		]);

        return suc(['event_id'=>$event_id]);
    }

    /**
     * 绑定Event和User
     */
    public function bindEventOfUser(){

        $validator = Validator::make(rq(), [
            'event_id' => 'required|exists:events,id',
            'user_id_list' => 'required|json',
            'command_msg_id' => 'int'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $user_id_list = json_decode(rq('user_id_list'),TRUE);
        if(!$user_id_list[0])
            return err(1,"user id list 为空！");
        
        $event = Event::find(rq('event_id'));
        if(rq('command_msg_id')){ //任务转移
            $event->dispatch_time = date('Y-m-d H:i:s', time());
            $event->command_msg_id = rq('command_msg_id');
            $event->status = 2;
        }
   
        foreach ($user_id_list as $user_id) {
			$user = User::find($user_id);
			if (!$user) {
        		return err(2,[$user_id=>['该用户不存在']]);				
			}
			if(!$user->tpns_token)
        		return err(2,[$user_id=>['该用户token不存在']]);				

            $event_user = EventUser::where('user_id',$user->id)->where('event_id',rq('event_id'))->first();
            if($event_user)
                continue;
		    $event_user = new EventUser();
		    $event_user->user_id = $user->id;
		    $event_user->event_id = rq('event_id');
		    $event_user->save();
        }

         $event->save();
        // Log::info("bind".$user_id_list);
        //执行云推送 TODO
        if($this->tpns_push($user_id_list,TPNS_NEW_EVENT,"有新事件"))   
            return err(1,"推送失败");

        return suc();

    }

    /**
     * 报警
     */
    public function endEvent(Request $request){

        $validator = Validator::make(rq(), [
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'complete_msg_id' => 'required',
            'img_handle_uri_1'=>'image',
            'img_handle_uri_2'=>'image',
            'img_handle_uri_3'=>'image',
            'img_handle_uri_4'=>'image'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $img_uri_list = [];
        if($request->file('img_handle_uri_1')){
            $img_handle_1_uri =  explode("/",$request->file('img_handle_uri_1')->store('public/img'))[2];
            $img_uri_list[] = $img_handle_1_uri;
		}
		if($request->file('img_handle_uri_2')){
			$img_handle_2_uri =  explode("/",$request->file('img_handle_uri_2')->store('public/img'))[2];
			$img_uri_list[] = $img_handle_2_uri;
		}
		if($request->file('img_handle_uri_3')){
			$img_handle_3_uri =  explode("/",$request->file('img_handle_uri_3')->store('public/img'))[2];
			$img_uri_list[] = $img_handle_3_uri;
		}
		if($request->file('img_handle_uri_4')){
			$img_handle_4_uri =  explode("/",$request->file('img_handle_uri_4')->store('public/img'))[2];
			$img_uri_list[] = $img_handle_4_uri;
		}

		$event = Event::find(rq('event_id'));
		$event->status = 3;

        $event_user = EventUser::where('event_id',rq('event_id'))->where('user_id',rq('user_id'))->first();
        $event_user->complete_time = date('Y-m-d H:i:s', time());
        $event_user->complete_msg_id = rq('complete_msg_id');
        $event_user->img_handle_uri = json_encode($img_uri_list);

        $event->save();
        $event_user->save();
        return suc();
    }

    /**
     * 内部方法
     * 腾讯云推送
     */
    public function tpns_push($user_id_list,$title,$content){
        $token_list = [];
        foreach ($user_id_list as $user_id) {
            $user = User::find($user_id);
            // Log::info("user".json_encode($user));
            if (!$user) {
                return err(2,[$user_id=>['该用户不存在']]);               
            }else{
                $token = $user->tpns_token;
                // Log::info("11111".$token);
                if($token){
                   $token_list[]= $token;
                }
            }
        }

        $base64_auth_string = base64_encode(TPNS_ACCESS_ID.':'.TPNS_SECRET_KEY);
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json","Authorization: Basic " . $base64_auth_string);

        $data = [
                    'audience_type' => 'token_list',
                    "token_list"=> $token_list,
                    "message_type"=> "message",
                    "message"=> [
                        "title"=> $title,
                        "content"=> $content
                    ]
                ];

        $data = json_encode($data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, TPNS_URL);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        if(json_decode($output,true)['ret_code'] != 0){
            // Log::info($output);
        }
        // Log::info($token_list);
        // Log::info($output);
        return json_decode($output,true)['ret_code'];
    }

    /**
     * 所有区域的伪卫星列表
     */
    public function getPseudoliteList(){

        $regions = Region::with('pseudolites')->get(['id','name','floor']);

        return suc($regions);
    }

     /**
     * 每层伪卫星
     */
    public function getPseudoliteListByRegion(){
        $validator = Validator::make(rq(), [
            'region_id' => 'required|exists:regions,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $pseudolites = DB::table('pseudolites')->where('region_id',rq('region_id'))->get();

        return suc($pseudolites);
    }

    /**
     * 根据ID获取伪卫星
     */
    public function getPseudoliteListById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:pseudolites,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $pseudolite = DB::table('pseudolites')->find(rq('id'));

        return suc($pseudolite);
    }

    /**
     *  控制伪卫星开关
     */
    public function controlPseById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:pseudolites,id',
            'status' => 'required|in:0,1',
            'attenuation' => 'int'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $pseudolite = DB::table('pseudolites')->find(rq('id'));

		DB::table('pseudolites')->where('id',rq('id'))->update(['status'=>rq('status'),'attenuation'=>rq('attenuation'),'updated_flag'=>1]);
        return suc();
    }


    /**
     * 录音文件上传
     * type     1：所有人
     *          2：指定区域和人员类型列表
     *          3：组列表
     *          4：指定人
     */
    
    public function addSounds(Request $request){
        $validator = Validator::make(rq(), [
            'type' => 'required|in:1,2,3,4',
            'user_id_list' => 'json|string',
            'group_id_list' => 'json|string',
            'region_id' => 'exists:regions,id',
            'job_list' => 'json|string'
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        $user_id_list = [];

        if (rq('type') == 1) {
            foreach (User::where('status','>','10')->get(['id']) as $user) {
                $user_id_list []= $user['id'];
            }
        }else if(rq('type') == 2){
            if((!rq('job_list')) && (!rq('region_id'))){
                return err(2,"job_list 和region_id不能同时为空");
            }
            else if(rq('region_id') && !rq('job_list')){
                foreach (User::where('status','>','10')->where('region_id',rq('region_id'))->get(['id']) as $user_id){
                    $user_id_list []= $user_id['id'];                
                }
            }
            else if(rq('job_list') && !rq('region_id')){
                $job_list = json_decode(rq('job_list'),TRUE);

                foreach ($job_list as $job) {
                    if(!User::where('job',$job)->first())
                        return err(3,'job 无效');
                    foreach (User::where('status','>','10')->where('job',$job)->get(['id']) as $user_id)
                        $user_id_list []= $user_id['id'];
                } 
            }
            else{
                $job_list = json_decode(rq('job_list'),TRUE);
                foreach ($job_list as $job) {
                    if(!User::where('job',$job)->first())
                        return err(3,'job 无效');
                    foreach (User::where('status','>','10')->where('region_id',rq('region_id'))->where('job',$job)->get(['id']) as $user_id)
                        $user_id_list []= $user_id['id'];
                }

            }
        }
        else if(rq('type') == 3){
            if(!rq('group_id_list'))
                return err(2,"group_id_list 不能为空");
            $group_id_list = json_decode(rq('group_id_list'),TRUE);

            foreach ($group_id_list as $group_id) {
                if(!Group::find($group_id))
                    return err(3,'group_id 无效');
                foreach (User::where('status','>','10')->where('group_id',$group_id)->get(['id']) as $user_id)
                    $user_id_list []= $user_id['id'];
            } 
        }
        else if(rq('type') == 4){
            if(!rq('user_id_list'))
                return err(2,"user_id_list 不能为空");
            $user_id_list = json_decode(rq('user_id_list'),TRUE);
        }


        if($request->file('sounds')){
            $sounds_uri =  explode("/",$request->file('sounds')->store('public/sounds'))[2];
        }else{
            return err(3,'声音文件不能为空');
        }   

        Log::info("----------------".json_encode($user_id_list));
        Log::info("----------------".$sounds_uri);
        if($this->tpns_push($user_id_list,TPNS_NEW_SOUNDS,SOUNDS_PREFIX.$sounds_uri));
            // Log::info('推送失败 user_id_list is'.json_encode($user_id_list));
        return suc(SOUNDS_PREFIX.$sounds_uri);

    }



    public function getRobotListLocationListByTimeStamp(){
        $validator = Validator::make(rq(), [
            'robot_id' => 'required',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        // 获取数据

        $sql = "SELECT * FROM robot_location where id='".rq('robot_id')."' and time<'".rq('end_at')."' and time>'".rq('start_at')."'";

		$fields = "db=BJWOGDB&q=".$sql;        

		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => INFLUXDB_URL.'/query',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $fields,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/x-www-form-urlencoded'
		  ),
		));

		$response = curl_exec($curl);
		curl_close($curl);

		$response = json_decode($response,true);

		$res = [];
		if(array_key_exists('series',$response['results'][0])){
			foreach ($response['results'][0]['series'][0]['values'] as $point) {
				$item['time'] = str_replace('T',' ',substr($point[0],0,19));
				$item['area_id'] = $point[1];
				$item['floor'] = $point[2];
				$item['height'] = $point[3];
				$item['id'] = $point[4];
				$item['lat'] = $point[5];
				$item['lng'] = $point[6];
				$item['name'] = $point[7];
				$item['uwb_id'] = $point[9];
				$item['x'] = $point[10];
				$item['y'] = $point[11];
				$item['z'] = $point[12];
				$res []= $item;
			}
		}
        return suc(['locations'=>$res]);
    }



    public function getRobotListImgListByTimeStamp(){
        $validator = Validator::make(rq(), [
            'robot_id' => 'required|exists:robots,id',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        // 获取数据
        $robots = DB::table('past_robot_imgs')
                        ->where('robot_id','=',rq('robot_id'))
                        ->where('created_at','>=',rq('start_at'))
                        ->where('created_at','<=',rq('end_at'))
                        ->get();

        return suc(['robots'=>$robots]);
    }


    public function getRobotLocationById(){
        $validator = Validator::make(rq(), [
            'robot_id' => 'required|exists:robots,id'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        // 获取数据
        $robot = Robot::find(rq('robot_id'));

        $region = DB::table('regions')->where('id',$robot->region_id)->first();

        $device = Device::where('device_id',$robot->device_id)->first(['lng','lat','h','x','y','z','floor','power','status']);

        $robot_tag = json_decode(Redis::connection('device_location')->get("tag:".$robot->uwb_id));

        if ($robot_tag) {
            $device->lng = $robot_tag->posY;
            $device->lat = $robot_tag->posX;
            $device->floor = $robot_tag->floorId;
        }else{
            $device->lng = 0;
            $device->lat = 0;
        }

        $robot->region_name = $region->name;
        $robot->device = $device;

        if($device)
            return suc(['robot'=>$robot]);
        else
            return suc();
    }

    public function getRobotListLocation(){
        // 获取数据
        $robots = Robot::get();

        $result = [];
        foreach ($robots as $robot) {
            $device = Device::where('device_id',$robot->device_id)->first(['lng','lat','h','x','y','z','power','status','floor']);
            $robot->device = $device;
            $robot_tag = json_decode(Redis::connection('device_location')->get("tag:".$robot->uwb_id));

            if ($robot_tag) {
                $device->lng = $robot_tag->posY;
                $device->lat = $robot_tag->posX;
            }else{
                $device->lng = 0;
                $device->lat = 0;
            }


            if($device->status > 10)
                $result []= $robot;
        }
        return suc(['robots'=>$result]);
    }


  //------------电子围栏--------edit by cc-----------------------------------------
    /**
     * 增加电子围栏
     * edit by cc
     */
    public function addElectricFence(){
        $validator = Validator::make(rq(), [
            'name' => 'required|string',
            'user_id_list' => 'required|json|string',
            'point_list' => 'required|json|string',
            'time_list' => 'required|json|string',
            'region_id' => 'required|exists:regions,id',
            'desc' => 'required|string|max:255',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        DB::table('electric_fences')->insert([
            'name' => rq('name'),
            'user_id_list' => rq('user_id_list'),
            'point_list' => rq('point_list'),
            'time_list' => rq('time_list'),
            'region_id' => rq('region_id'),
            'desc' => rq('desc'),
        ]);
        return suc();
    }

    /**
     * 删除电子围栏
     * edit by cc
     * @return array|int[]
     */
    public function delElectricFenceById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:electric_fences,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());
        //删除电子围栏
        DB::table('electric_fences')->where('id',rq('id'))->delete();
        return suc();
    }

    /**
     * 更新电子围栏
     * edit by cc
     * @return array|int[]
     */
    public function updateElectricFenceById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:electric_fences,id',
            'name' => 'required|string',
            'user_id_list' => 'required|json|string',
            'point_list' => 'required|json|string',
            'time_list' => 'required|json|string',
            'region_id' => 'required|exists:regions,id',
            'desc' => 'required|string|max:255',
        ]);
        DB::table('electric_fences')
            ->where('id',rq('id'))
            ->update([
                'name' => rq('name'),
                'user_id_list' => rq('user_id_list'),
                'point_list' => rq('point_list'),
                'time_list' => rq('time_list'),
                'region_id' => rq('region_id'),
                'desc' => rq('desc'),
            ]);
        return suc();
    }

    /**
     * 获取电子围栏详细信息
     * edit by cc
     * @return array|int[]
     */
    public function getElectricFenceById(){
        $validator = Validator::make(rq(), [
            'id' => 'required|exists:electric_fences,id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());
        return suc(DB::table('electric_fences')->where('id',rq('id'))->first());
    }

    /**
     * 获取电子围栏列表
     * edit by cc
     * @return array|int[]
     */
    public function getElectricFenceList(){
        $validator = Validator::make(rq(), [
            'page_num' => 'required|int',
            'page_size' => 'required|int'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());

        $electric_fences = DB::table('electric_fences');

        if (rq('name')) {
            $electric_fences = $electric_fences->where('name', 'like', '%'.rq('name').'%');
        }

        $electric_fences = $electric_fences->offset( (rq('page_num') - 1) * rq('page_size') )->limit(rq('page_size'))->get();

        $count = DB::table('electric_fences')->count();
        return suc(['electric_fences'=>$electric_fences,'total'=>$count]);
    }

    /**
     * 获取YSY Token
     */
    public function getYSYToken(){
        return Config::where('name','YSY_ACCESS_TOKEN')->first()->value;
    }

   	/**
   	 * 根据经纬度 region_id 获取area
   	 */
   	public function getAreaIdFromRegionIdAndLngAndLat(){
        $validator = Validator::make(rq(), [
            'region_id' => 'required|exists:regions,id',
            'lng' => 'required|string',
            'lat' => 'required|string',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());   	

        $area_id = 0;
        $areas = DB::table('areas')->where('region_id',rq('region_id'))->get();
        if (!$areas) {
            // code...
            $area_id = 1;
            return suc($area_id);
        }
        foreach ($areas as $area) {

            //再判area
            if ($this->in_fences($area->point_list, rq('lng').','.rq('lat'))) {
                $area_id = $area->id;
                break;
            } else {
                $area_id = 1;
            }
        }	

        return suc($area_id);
   	}

   	/**
   	 * 根据AreaName获取AreaList
   	 */
   	public function getAreaListLikeAreaName(){
        $validator = Validator::make(rq(), [
            'areaname' => 'required|string'
        ]);

       if ($validator->fails())
        return err(1, $validator->messages());

        $areas = DB::table('areas')->where('name', 'like', '%'.rq('areaname').'%')->get();

        return suc($areas);   		
   	}

   	/**
   	 * 获取区域密接表数据
   	 */
   	public function getUserContact(){
        $res_ing = DB::table('user_contact')->where('status',0)->first();
        if ($res_ing) {
        	$res_ing->result = json_decode($res_ing->result,true);
        }
        $res = DB::table('user_contact')->where('status',1)->latest()->first();
        if ($res) {
        	$res->result = json_decode($res->result,true);
        }
        return suc(['res_ing'=>$res_ing,'res'=>$res]);
   	}

   	/**
   	 * 获取人员密接表数据
   	 */
   	public function getAreaContact(){
        $res_ing = DB::table('area_contact')->where('status',0)->first();
        if ($res_ing) {
        	$res_ing->result = json_decode($res_ing->result,true);
        }     
        $res = DB::table('area_contact')->where('status',1)->latest()->first();
        if ($res) {
        	$res->result = json_decode($res->result,true);
        }
        return suc(['res_ing'=>$res_ing,'res'=>$res]);
   	}

   	/**
	 * 固件上传
	 */
	public function firmwareUpload(Request $request){
	    $validator = Validator::make(rq(), [
	        'type' => 'required', //0为全部升级，1为单个升级，需要传入设备号
	        'version' => 'required',
	        'device_id' => 'exists:devices,id',

	    ]);
	    //判断请求中是否包含name=file的上传文件
	    if(!$request->hasFile('firmware')){
	        exit('上传文件为空！');
	    }
	    $file = $request->file('firmware');
	    $md5 = md5_file($file);
	    //判断文件上传过程中是否出错
	    if(!$file->isValid()){
	        exit('文件上传出错！');
	    }
	    $newFileName = 'CEPNT-Box-'.rq('version');//md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
	    $savePath = 'public/firmware/'.$newFileName;
	    $bytes = Storage::put(
	        $savePath,
	        file_get_contents($file->getRealPath())
	    );
	    header("Content-Type: ".Storage::mimeType($savePath));
	    $data = [
	        'fu_url'=>'http://61.240.144.70:5619/storage/firmware/'.$newFileName,
	        'fu_md5'=>$md5
	    ];
	    if (rq('type') == 0){
	        DB::table('devices')->update(['fu_url'=>$data['fu_url'],'fu_md5'=>$data['fu_md5'],'updated_flag'=>2]);
	        // FirmwareUpgrade::dispatch(json_encode($data));
	    }else{
	        DB::table('devices')->where('device_id',rq('device_id'))->update(['fu_url'=>$data['fu_url'],'fu_md5'=>$data['fu_md5'],'updated_flag'=>2]);
	    }
	    return suc();
	}

    /**
     * 获取APK
     */
    public function getApk(){
        return suc(Apk::first());
    }

    /**
	* 电子围栏算法
	*/
	public function in_fences($fences, $point)
	{
		// var_dump($fences);
        // var_dump($point);
        $list = json_decode($fences,TRUE);
        $nvert = sizeof($list);
        $vertx = [];
        $verty = [];
        foreach ($list as $i) {
            //如果坐标反了改这里
            $vertx[] = $i[0];
            $verty[] = $i[1];
        }
        list($testx,$testy) = explode(',', $point);
        $i = $j = $c = 0;
        for ($i = 0, $j = $nvert - 1; $i < $nvert; $j = $i++) {
            if ((($verty[$i] > $testy) != ($verty[$j] > $testy)) &&
                ($testx < ($vertx[$j] - $vertx[$i]) * ($testy - $verty[$i]) / ($verty[$j] - $verty[$i]) + $vertx[$i]))
                $c = !$c;
        }
        return $c;
	}

	/**
	 * 软件控制
	 */
	public function updateAllDeviceSoft(){
        $validator = Validator::make(rq(), [
			'L0'=>'required'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages()); 

        DB::table('devices')->update([
            'L0'=>rq('L0'),
            'updated_flag'=>1 //更新读取
        ]);

	   return suc();
	}

	/**
	 * 频率控制
	 */
	public function updateAllDeviceRate(){
        $validator = Validator::make(rq(), [
			'rate'=>'',
			'f9p_rate'=>'',
			'imu_rate'=>'',
			'barometer_rate'=>'',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());  		

        if((!rq('rate')) && (!rq('f9p_rate')) && (!rq('imu_rate')) && (!rq('barometer_rate')))
            return err(1,'请至少传递一个参数');

        $update_arr = [];

        if(rq('rate'))
            $update_arr['rate'] = rq('rate');
        if(rq('f9p_rate'))
            $update_arr['f9p_rate'] = rq('f9p_rate');
        if(rq('imu_rate'))
            $update_arr['imu_rate'] = rq('imu_rate');
        if(rq('barometer_rate'))
            $update_arr['barometer_rate'] = rq('barometer_rate');
                                                       
        DB::table('devices')->update([
            'rate'=>rq('rate'),
            'f9p_rate'=>rq('f9p_rate'),
            'imu_rate'=>rq('imu_rate'),
            'barometer_rate'=>rq('barometer_rate'),
            'updated_flag'=>1 //更新读取
        ]);        

       return suc();
	}

	/**
	 * 差分地址控制
	 */	
	public function updateAllDeviceDifferenceAddress(){
        $validator = Validator::make(rq(), [
            'f9p_difference_address'=>'required',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());  	

        DB::table('devices')->update([
            'f9p_difference_address'=>rq('f9p_difference_address'),
            'updated_flag'=>1 //更新读取
        ]);        

        return suc();            	
	}

    /**
     * 根据region_id 获取电子围栏列表
     */
    public function getElectricFenceListByRegionId(){
         $validator = Validator::make(rq(), [
            'region_id'=>'required',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());             


        $sql_index = DB::table('electric_fences');

        $where_in_arr = [];

        if(rq('region_id') == REGION_ID_1_6_16_18_21_22){
            $where_in_arr = [1,6,16,18,21,22];
        }
        else if(rq('region_id') == REGION_ID_2_7_19){
            $where_in_arr = [2,7,19] ;
        }
        else if(rq('region_id') == REGION_ID_3_8_17_20){
            $where_in_arr = [3,8,17,20];
        }
        else if(rq('region_id') == REGION_ID_4_9_23){
            $where_in_arr = [4,9,23] ;
        }else if(rq('region_id') == REGION_ID_5_24){
            $where_in_arr = [5,24] ;
        }else{
            $where_in_arr = [rq('region_id')];
        }                

        $electric_fences = $sql_index->whereIn('region_id',$where_in_arr)->get();
      
        return suc($electric_fences);
    }


    public function getOnlineUserCodeList(){
        $userVals = DB::table('devices')
        ->join('users', 'users.device_id', '=', 'devices.device_id')  //筛选出来具备成功的绑定关系的
        ->where('devices.status','>',10)  //筛选设备在线
        ->where('users.status','>',10) //筛选用户在线
        ->get(['users.usercode']);

        return suc($userVals);
    }

    public function addPse()
    {
        $validator = Validator::make(rq(), [
            'prn_id' => 'required',
            'name' => 'required',
            'gnss_id' => 'required',
            'sta_id' => 'required',
            'lng' => 'required',
            'lat' => 'required',
            'alt' => 'required',
            'floor' => 'required',
            'attenuation' => 'required',
            'region_id' => 'required',
            'area_id' => 'required',

        ]);
        if ($validator->fails())
            return err(1, $validator->messages());  
        DB::table('pseudolites')->insert([
            'prn_id' => rq('prn_id'),
            'name' => rq('name'),
            'gnss_id' => rq('gnss_id'),
            'lng' => rq('lng'),
            'lat' => rq('lat'),
            'alt' => rq('alt'),
            'floor' => rq('floot'),
            'attenuation' => rq('attenuation'),
            'region_id' => rq('region_id'),
            'area_id' => rq('area_id'),
        ]);
        return suc();
    }
    /**
     * 获取除雪车位置
     * 
     */
    public function getSnowSweeperLocation(){
        $locations = DB::table('cars')
        ->where('cars.type',1)
        ->join('devices','cars.device_id','=','devices.device_id')
        ->where('devices.status','>',10)
        ->get(['cars.id','cars.car_name','devices.lng','devices.lat','devices.h']);
        return suc($locations);


    }
    /**
     * 获取雪狼除雪车uwb_id
     */
    public function getSnowSweeperUwbID(){
        $cars = DB::table('cars')
        ->where('type',1)
        ->get(['car_name','uwb_id']);

        $uwb_id_list = array();
        $name = array();
        foreach ($cars as $car){
            array_push($name,$car->car_name);
            if ($car->uwb_id == null)
                array_push($uwb_id_list,"tag:0");
            else
                array_push($uwb_id_list,"tag:".$car->uwb_id);

        }

        return suc(["uwb_id"=>$uwb_id_list,"name"=>$name]);
    }
    /**
     * 上传更新apk
     */ 
    public function apkUploade(Request $request){
        $validator = Validator::make(rq(), [
            'version_name' => 'required',
            'version_code' => 'required',
            'desc' =>'required',

        ]);
        if ($validator->fails())
            return err(1, $validator->messages());  


        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('apk')){
            exit('上传文件为空！');
        }
        $file = $request->file('apk');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        $newFileName = 'DASF-2.0-release.apk';//md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = 'public/apk/'.$newFileName;
        $bytes = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        header("Content-Type: ".Storage::mimeType($savePath));

        $apk_uri = 'http://www.bdips.cn:5619/storage/apk/'.$newFileName;
        DB::table('apks')->update([
            'url'=>$apk_uri,
            'version_code'=>rq('version_code'),
            'version_name'=>rq('version_name'),
            'desc'=>rq('desc')
        ]); 
        return suc();
    }
    /**
     * 获取伪卫星位置接口
     */
    public function getPseLocation(){
        $validator = Validator::make(rq(), [
            'region_id'=>'required',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());  
        $pseLocation = DB::table('pseudolites')->where('region_id',rq('region_id'))->get();
        return suc($pseLocation);
    }

    /**
     * 获取报警信息
     */
    public function getAlarms(){
    	$alarm_areas = DB::table('alarm_areas')->orderBy('created_at', 'desc')->limit(20)->get();
    	$alarm_fences = DB::table('alarm_fences')->orderBy('created_at', 'desc')->limit(20)->get();
    	$alarm_parks = DB::table('alarm_parks')->orderBy('created_at', 'desc')->limit(20)->get();
    	return suc([
				'alarm_areas' => $alarm_areas,
				'alarm_fences' => $alarm_fences,
				'alarm_parks' => $alarm_parks
    		]);
    }

    /**
     * 根据uwb_id获取用户
     */
    public function getUserByUwbId(){
        $validator = Validator::make(rq(), [
            'uwb_id'=>'required|exists:users,uwb_id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());     

        $user = DB::table('users')->where('uwb_id',rq('uwb_id'))->first();

        return suc($user);
    }

    /**
     * 根据pos_id获取第一个围栏 
     * 注：围栏不是电子围栏
     */
    public function getFenceByPosId(){
        $validator = Validator::make(rq(), [
            'pos_id'=>'required|exists:fences,pos_id',
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());     

        $fence = DB::table('fences')->where('pos_id',rq('pos_id'))->first();

        return suc($fence);
    }

    /**
     * 添加报警信息（区域）
     */
    public function addAlarmArea(){
         $validator = Validator::make(rq(), [
			'user_id' => 'required',
			'username' => 'required',
			'phone' => 'required',
			'uwb_id' => 'required',
			'area_name' => 'required',
			'map_name' => 'required',
			'timestamp' => 'required'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());      	

        $item = new AlarmArea();
        $item->user_id = rq('user_id');
        $item->username = rq('username');
        $item->phone = rq('phone');
        $item->uwb_id = rq('uwb_id');
        $item->area_name = rq('area_name');
        $item->map_name = rq('map_name');
        $item->timestamp = rq('timestamp');
        $item->save();

        return suc();
    }

    /**
     * 添加报警信息（围栏）
     */
    public function addAlarmFence(){
         $validator = Validator::make(rq(), [
			'uwb_id' => 'required',
			'timestamp' => 'required',
			'desc' => 'required'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());      	

        $item = new AlarmFence();
        $item->uwb_id = rq('uwb_id');
        $item->timestamp = rq('timestamp');
        $item->desc = rq('desc');
        $item->save();
        return suc();
    }
    /**
     * 获取当前在线的人员列表。 for weixin
     */
    public function getOnlineUser(){
        $users = User::all();
        return suc($users);

    }
    /**
     *获取当前所有人员的列表 for weixin
     */
    public function getAllUser(){
        $users = User::all();
        return suc($users);

    }
    /**
     *根据人员code返回人员基本信息以及位置信息 for weixin
     */
     public function getUserPositionListByUserCodeList(){
        // return rq('user_code_list');
        $validator = Validator::make(rq(), [
            'user_code_list' => 'required|json',
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        $user_code_list = json_decode(rq('user_code_list'),TRUE);

        $result = [];
        $item = [];
        $first_flag = 1;
        foreach ($user_code_list as $user_code) {
            $user = User::where('usercode',$user_code)->first();
            if($user){
                $user_tag = json_decode(Redis::connection('device_location')->get("tag:".$user->uwb_id));

                if ($user_tag) {
                    $user->lng = $user_tag->posY;
                    $user->lat = $user_tag->posX;
                    $user->floor = $user_tag->floorId;
                }else{
                    $user->lng = 0;
                    $user->lat = 0;
                    $user->floor  = 0;
                }
                $item['id'] = $user->id;
                $item['sex'] = $user->sex;
                $item['job'] = $user->job;
                $item['username'] = $user->username;
                $item['usercode'] = $user->usercode;
                $item['lng']=$user->lng;
                $item['lat']=$user->lat;
                $item['floor']=$user->floor;
            }else{
                $item = null;
            }


            $result []= $item;
        }
        return suc($result);
     } 
     /**
      * 获取机器人位置 for weixin
      */
     public function getRobotLocation(){
        if (rq("robot_id")) {
            $robot = Robot::where("id",rq("robot_id"))->first();
            $result = [];
            $robot_tag = json_decode(Redis::connection('device_location')->get("tag:".$robot->uwb_id));

            if ($robot_tag) {
                $robot->lng = $robot_tag->posY;
                $robot->lat = $robot_tag->posX;
                $robot->floor = $robot_tag->floorId;
            }else{
                $robot->lng = 0;
                $robot->lat = 0;
                $robot->floor  = 0;
            }
            $result []= $robot;
            return suc(['robots'=>$result]);
        }else{

            $robots = Robot::get();
            $result = [];
            foreach ($robots as $robot) {
                $robot_tag = json_decode(Redis::connection('device_location')->get("tag:".$robot->uwb_id));

                if ($robot_tag) {
                    $robot->lng = $robot_tag->posY;
                    $robot->lat = $robot_tag->posX;
                    $robot->floor = $robot_tag->floorId;
                }else{
                    $robot->lng = 0;
                    $robot->lat = 0;
                    $robot->floor  = 0;
                }
                $result []= $robot;
            }
            return suc(['robots'=>$result]);
        }

     }

     //大屏车辆信息
     public function getIndexCarInfo(){
        $car_num = DB::table('cars')->count();
        $snow_car_num = DB::table('cars')->where('type',1)->count();
        $other_car_num = DB::table('cars')->where('type',2)->count();
        $alarm_park_num = DB::table('alarm_parks')->count();
        return suc([
            'car_num'=>$car_num,
            'snow_car_num'=>$snow_car_num,
            'other_car_num'=>$other_car_num,
            'alarm_park_num'=>$alarm_park_num,
            ]);
     }
     /*
    * 添加除雪车车辆信息
    */
    public function addCarInfo(){
        $validator = Validator::make(rq(), [
            'device_id'=>'required',
            'uwb_id' => 'required',
            'car_name'=>'required',
            'driver_name'=>'required',
            'type' => 'required',
            'driver_phone' => 'required'
        ]);

        if ($validator->fails())
            return err(1, $validator->messages());
        if (DB::table('cars')->where('car_name',rq('car_name'))->first()){
            //修改
            DB::table('cars')->where('car_name',rq('car_name'))->update([
                'device_id'=>rq('device_id'),
                'uwb_id' => rq('uwb_id'),
                'car_name'=>rq('car_name'),
                'driver_name'=>rq('driver_name'),
                'driver_phone' => rq('driver_phone'),
                'type' => rq('type')
            ]);
        }else{
            //添加
            DB::table('cars')->insert([
                'device_id'=>rq('device_id'),
                'uwb_id' => rq('uwb_id'),
                'car_name'=>rq('car_name'),
                'driver_name'=>rq('driver_name'),
                'driver_phone' => rq('driver_phone'),
                'type' => rq('type')
            ]);
        }
        return suc();
    }

  

    /**
     * 根据Device_id获取deviceconfig
     * @return [type] [description]
     */
    public function apiGetDeviceConfig(){
        $validator = Validator::make(rq(), [
            'deviceID' => 'required'
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());

        device::where('device_id',rq('deviceID'))->update([
            'updated_flag' => 0
        ]);
        $configs = DB::table('devices')->where('device_id',rq('deviceID'))->first(["id","device_id","rate","f9p_gnss_system","f9p_rate","f9p_difference_address","imu_rate","barometer_rate","fu_url","websocket","fu_md5","uwb","control_uwb","control_wifi","control_f9p","control_ble","control_barometer","control_typec","L0","created_at","updated_at"]);
        $configs->uwb = json_decode($configs->uwb);
        if (substr_count($configs->fu_url, "-") == 2) {
            $configs->fu_version = explode("-",$configs->fu_url)[2];
        }
        return suc(["config"=>$configs]);
    }
   /**
     * 时空盒终端首次开机注册
     */
    public function apiDeviceRegist()
    {
        $validator = Validator::make(rq(), [
            'deviceID' => 'required',
//            'version' => '',
        ]);
        if ($validator->fails())
            return err(1, $validator->messages());
        $deviceID = rq('deviceID');
        $device_old = device::where("device_id", '=', $deviceID)
            ->first(["id","device_id","rate","f9p_gnss_system","f9p_rate","f9p_difference_address","imu_rate","barometer_rate","fu_url","fu_md5","websocket","uwb","control_uwb","control_wifi","control_f9p","control_ble","control_barometer","control_typec","L0","created_at","updated_at"]);
        $pseStaInfo = pseLocation::all(["id","prn_id","gnss_id","name","x","y","z","lng","lat","alt","floor","status","created_at","updated_at"]);
        if ($device_old) {
            if (substr_count($device_old->fu_url, "-") == 2) {
                if (rq('version') && explode("-",$device_old->fu_url)[2] != rq('version')){
                DB::table('devices')->where('device_id',$deviceID)->update(['updated_flag'=>2]);
                }
            }
            $device_old->uwb = json_decode($device_old->uwb,true);
            return suc(["config"=>$device_old,"loc"=>$pseStaInfo]);
        } else {
            $device = new device();
            $device->device_id = $deviceID;
            $device->name = rq('deviceID');
            if ($device->save()) {
                $rdevice = device::where("device_id", '=', $deviceID)
                    ->first(["id","device_id","rate","f9p_gnss_system","f9p_rate","f9p_difference_address","imu_rate","barometer_rate","fu_url","fu_md5","control_uwb","uwb","websocket","control_wifi","control_f9p","control_ble","control_barometer","control_typec","L0","created_at","updated_at"]);
                $rdevice->uwb = json_decode($rdevice->uwb,true);
                return suc(["config"=>$rdevice,"loc"=>$pseStaInfo]);
            } else {
                return err(1,"Registration failed");
            }
        }
    }    

}





