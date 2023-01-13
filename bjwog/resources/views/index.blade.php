<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="Bookmark" href="hui/favicon.jpg" >
    <link rel="Shortcut Icon" href="hui/favicon.jpg" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="hui/lib/html5shiv.js"></script>
    <script type="text/javascript" src="hui/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/lib/Hui/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/lib/Hui/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="hui/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>安全监控平台</title>
    
    <meta name="description" content="综合管理系统">
</head>
<body>
{{--头部--}}
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl">
            <nav class="nav navbar-nav">
                <ul class="cl">
                    <li class="dropDown dropDown_hover "><a href="javascript:;" class="dropDown_A" style="font-size: 18px">安全监控平台<i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="http://121.28.103.199:5604/index"> 大众位置服务平台</a></li>
                            <li><a href="javascript:;">应急救援平台</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li class="dropDown dropDown_hover">
                        <a href="#" class="dropDown_A">{{ Auth::user()->name }} <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    退出
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
{{--左侧菜单栏--}}
<aside class="Hui-aside">
    <div class="menu_dropdown bk_2">
        <dl>
            <dt>设备管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{ url('deviceList')}}" data-title="设备列表" href="javascript:void(0)">设备列表</a></li>
                    <li><a data-href="{{ url('deviceAdd')}}" data-title="添加设备" href="javascript:void(0)">添加设备</a></li>
                </ul>
            </dd>
        </dl>

        <dl>
            <dt>基础地图<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{ url('map')}}" data-title="331地图" href="javascript:void(0)">331地图</a></li>
                    <li><a data-href="{{ url('BDmap')}}" data-title="百度地图" href="javascript:void(0)">百度地图</a></li>
                    <li><a data-href="{{ url('ATLSMap')}}" data-title="奥特莱斯地图" href="javascript:void(0)">奥特莱斯地图</a></li>
                    <li><a data-href="{{ url('C7Floor1Map')}}" data-title="C7一层地图" href="javascript:void(0)">C7一层地图</a></li>
                    <li><a data-href="{{ url('C7Floor2Map')}}" data-title="C7二层地图" href="javascript:void(0)">C7二层地图</a></li>
                    <li><a data-href="{{ url('C7Floor3Map')}}" data-title="C7三层地图" href="javascript:void(0)">C7三层地图</a></li>
                    <li><a data-href="{{ url('AirportFloor1Map')}}" data-title="机场一层地图" href="javascript:void(0)">机场一层地图</a></li>
                    <li><a data-href="{{ url('AirportFloor2Map')}}" data-title="机场二层地图" href="javascript:void(0)">机场二层地图</a></li>
                </ul>
            </dd>
        </dl>

        <dl>
            <dt>高级地图<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{ url('sjzMap')}}" data-title="石家庄地图" href="javascript:void(0)">石家庄地图</a></li>
                </ul>
            </dd>
        </dl>

        <dl>
            <dt>热力图<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{ url('sjzHeatMap')}}" data-title="石家庄热力图" href="javascript:void(0)">石家庄热力图</a></li>
                    <li><a data-href="{{ url('ATLSHeatMap')}}" data-title="奥特莱斯热力图" href="javascript:void(0)">奥特莱斯热力图</a></li>
                    <li><a data-href="{{ url('AirportFloor1HeatMap')}}" data-title="机场一层热力图" href="javascript:void(0)">机场一层热力图</a></li>
                </ul>
            </dd>
        </dl>

        <dl>
            <dt>信息管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{ url('msgTx')}}" data-title="发布预警信息" href="javascript:void(0)">发布预警信息</a></li>
                    <li><a data-href="{{ url('msgRx')}}" data-title="接收到的信息" href="javascript:void(0)">接收到的信息</a></li>
                </ul>
            </dd>
        </dl>
        <dl>
            <dt>设置<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a data-href="{{ url('mapFenceSetting')}}" data-title="电子围栏设置" href="javascript:void(0)">电子围栏设置</a></li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active">
                    <em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="{{ url('welcome') }}"></iframe>
        </div>
    </div>
</section>

<div class="contextMenu" id="Huiadminmenu">
    <ul>
        <li id="closethis">关闭当前</li>
        <li id="closeall">关闭全部 </li>
    </ul>
</div>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/lib/Hui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/Hui/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/lib/Hui/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/lib/Hui/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/lib/Hui/lib/jquery.contextmenu/jquery.contextmenu.r2.js"></script>

</body>
</html>
