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


class ApiController extends Controller
{
    /**
     * 测试路由
     */
    public function apiTest()
    {
        return 0;

    }
}