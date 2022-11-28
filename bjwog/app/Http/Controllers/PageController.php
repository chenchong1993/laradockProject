<?php

namespace App\Http\Controllers;

use App\Tools\Tools;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{

    /**
     * 首页
     */
    public function index()
    {
        return view('index');
    }




}
