<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/23
 * Time: 10:42
 */

namespace App\Http\Controllers;
use App\CORSinfo;
use Couchbase\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function PHPSTORM_META\type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;




class ApiController extends Controller
{
    /**
     * 测试路由
     */
    public function apiTest(){
        return 0;

    }
    /**
     * 获取伪卫星基站列表
     */
    public function getpseudoliteList(){
        $getpseudoliteList = DB::table('pseudoliteInfo')->get();
        return suc($getpseudoliteList);
    }
    /**
     * 固件上传
     */
    public function fileUpload(Request $request){
        $validator = Validator::make(rq(), [

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
        $newFileName = $file->getClientOriginalName();//md5(time().rand(0,10000)).'.'.$file->getClientOriginalExtension();
        $savePath = '/app'.$newFileName;
        $bytes = Storage::put(
            $savePath,
            file_get_contents($file->getRealPath())
        );
        header("Content-Type: ".Storage::mimeType($savePath));
        $data = [
            'fu_url'=>'http://39.107.84.169/ipstest/storage/app/'.$newFileName,
            'fu_md5'=>$md5
        ];

        return suc($data);
    }
}