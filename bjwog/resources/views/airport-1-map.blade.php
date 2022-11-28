<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>机场一层</title>

    <!-- 菜单开始 -->
    <link rel="stylesheet" type="text/css" href="/css/menu/style.css"/>
    <!-- 菜单结束 -->

    <!-- 提示框开始 -->
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- 提示框结束 -->

    <!-- 地图开始 -->
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/dijit/themes/tundra/tundra.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/esri/css/esri.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/Ips/css/widget.css"/>
    <!-- 地图结束 -->

	<!-- MD5 -->
	<script src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.js"></script>
	<!-- MD5 -->

    <style>
        html, body, .map {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: white;
        }
    </style>

	<!-- 极光云推送 -->
	<script src='/js/jmessage-sdk-web.2.6.0.min.js'></script>
	<!-- 极光云推送 -->
	
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>

    <!-- 提示框开始 -->
    <script src="/js/notify/bootstrap.min.js"></script>
    <script src="/js/notify/hullabaloo.js"></script>
    <!-- 提示框结束 -->

    <!-- 331地图 -->
    <script type="text/javascript" src="Ips_api_javascript/init.js"></script>
    <!-- 331地图 -->

    <!-- tools -->
    <script type="text/javascript" src="/js/tools.js"></script>
    <!-- tools-->

</head>

<body class="tundra">

<div class="row" style="height: 100%">

    <div id="map_c7" class="col-md-12">

        <div style="position: absolute; z-index: 10; top: 10px; right: 30px";>
            <button class="btn btn-primary" onclick="toggleLocus()" id="btn-toggle-loucs">开启轨迹</button>
            <button class="btn btn-default" onclick="clearAll()">清除轨迹</button> 
        </div>

        <!-- 菜单 -->
        <div style="position: absolute; z-index: 10; left: 50%; bottom: 10%";>
            <nav class="nav" >
              <input type="checkbox" class="nav__cb" id="menu-cb">
              <div class="nav__content">
                <ul class="nav__items">
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-group-msg"> 群发消息</span> </li>
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-group-cmd"> 群发命令</span> </li>
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-user-search"> 人员查询 </span> </li>
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-device-search"> 设备搜索</span> </li>
                </ul>
              </div>
              <label class="nav__btn" for="menu-cb"></label>
            </nav>
        </div>
        <!-- 菜单 -->

        <!-- 模态框 -->

            <!-- 群发消息-->
            <div class="modal fade" id="modal-group-msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" >群发消息</h4>
                  </div>
                  <div class="modal-body">
                     <input type="text" class="form-control" id="input-group-msg" >
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" id="btn-group-msg" onclick="groupMsg()">发送</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 群发命令 -->
            <div class="modal fade" id="modal-group-cmd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" >群发命令</h4>
                  </div>
                  <div class="modal-body">
                    <button type="button" class="btn btn-primary" id="btn-group-cmd-on" onclick="groupCmd('on')">开启所有设备</button>
                    <button type="button" class="btn btn-danger"  id="btn-group-cmd-off" onclick="groupCmd('off')">关闭所有设备</button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- 人员查询 -->
            <div class="modal fade" id="modal-user-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title" >人员查询</h4>
                  </div>

                  <div class="modal-body">
                    <select class="form-control" id="select-user-search">
                        <option value="name">查姓名</option>
                        <option value="phone">查手机号</option>
                        <option value="uid">查UID</option>
                    </select>
                    <br>
                    <input type="text" class="form-control" id="input-user-search" required>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close-user-search-modal">关闭</button>
                      <button type="button" class="btn btn-primary" id="btn-user-search" onclick="userSearch()">查找</button>
                    </div>
                    <table class="table table-condensed " id="tab-user-list">
                    </table>
                  </div>

                </div>
              </div>
            </div>

            <!-- 设备查询 -->
            <div class="modal fade" id="modal-device-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title" >设备查询</h4>
                  </div>

                  <div class="modal-body">
                     <select class="form-control" id="select-device-search">
                        <option value="name">查设备名</option>
                        <option value="uid">查UID</option>
                    </select>
                    <br>
                    <input type="text" class="form-control" id="input-device-search" required>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close-device-search-modal">关闭</button>
                      <button type="button" class="btn btn-primary" id="btn-device-search" onclick="deviceSearch()">查找</button>
                    </div>
                  
                    <table class="table table-condensed " id="tab-device-list">
                   </table>
                  </div>
                </div>
              </div>
            </div>


        <!-- 模态框 -->

    </div>

</div>
</body>

<script>

    //331地图
    // 初始化全局参数
    var INTERVAL_TIME = 2; //数据刷新间隔时间
    var HELLO_STR = "系统初始化成功！"; //初始化欢迎语句
    var ERR_MSG = "您正处于危险区域！"//危险区域发送的信息
    var DANGER_AREA = [];//危险区域范围
    var IS_LOCUS = 0;
    var POINT_LINE = [];
    var lineArrF1 = [];

    // POINT_LINE.push({'color':1,'position':[ [111,222],[333,444] ]});
    

    //把图层提出到外边来声明方便调用
    var pointLayer;
    var LocusPointLayer;
    var LinePointLayer;

    

    //websocket 连接对象
    var conn;
    var map;


    /**
     * 开启或者关闭轨迹打印
     */
    function toggleLocus(){

        if(IS_LOCUS == 0){
            IS_LOCUS = 1;
            $('#btn-toggle-loucs').text('关闭轨迹');
            $('#btn-toggle-loucs').addClass("btn-danger");
            $('#btn-toggle-loucs').removeClass("btn-primary");
        }

        else if (IS_LOCUS == 1){
            IS_LOCUS = 0;
            $('#btn-toggle-loucs').text('开启轨迹'); 
            $('#btn-toggle-loucs').addClass("btn-primary");
            $('#btn-toggle-loucs').removeClass("btn-danger");
        }
    }

    function clearAll(){
        clearLocus();
        clearLine();
    }

    /**
    * 清除轨迹点数据
    */
    function clearLocus(){
        LocusPointLayer.clear();
    }

    /**
    * 清除连线数据
    */
    function clearLine(){
        LinePointLayer.clear();
    }

    /**
     * 地图定位到这个位置
     */
    function locationTo(lng,lat){
        //关闭对话框
        $('#btn-close-user-search-modal').click();
        $('#btn-close-device-search-modal').click();
        //地图
        require(["esri/geometry/Point",], function (Point) {
            var point = new Point(lng,lat);
            map.infoWindow.show(point)
            map.centerAndZoom(point,1);
        });
    }


    /**
     * [人员查找]
     * @return null
     */
    function userSearch(){

        var select_func = $('#select-user-search').val();
        var select_content = $('#input-user-search').val();
        if (select_func == 'name'){

            $.post("/api/getUsersByName",
                {'name':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-user-list').empty();
                        $('#tab-user-list').append('<tr><th>姓名</th><th>UID</th><th>手机号</th><th>状态</th><th>操作</th></tr>');
                        for (var i in dat.data.users) {
                            console.log(dat.data.users);
                            $('#tab-user-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td>'+ dat.data.users[i].uid +'</td>'+
                                '<td>'+ dat.data.users[i].phone +'</td>'+
                                '<td>'+ dat.data.users[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.users[i].lng +','+ dat.data.users[i].lat +')">查看</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("查找成功", "sys");
                    } else {
                        notify("查找失败", "sys");
                    }
                }
            );

        }
        else if(select_func == 'phone')
        {

            $.post("/api/getUsersByPhone",
                {'phone':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-user-list').empty();
                        $('#tab-user-list').append('<tr><th>姓名</th><th>UID</th><th>手机号</th><th>状态</th><th>操作</th></tr>');
                        for (var i in dat.data.users) {
                            console.log(dat.data.users);
                            $('#tab-user-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td>'+ dat.data.users[i].uid +'</td>'+
                                '<td>'+ dat.data.users[i].phone +'</td>'+
                                '<td>'+ dat.data.users[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.users[i].lng +','+ dat.data.users[i].lat +')">查看</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("查找成功", "sys");
                    } else {
                        notify("查找失败", "sys");
                    }
                }
            );

        }
        else if(select_func == 'uid')
        {
         
            $.post("/api/getUsersByUid",
                {'uid':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-user-list').empty();
                        $('#tab-user-list').append('<tr><th>姓名</th><th>UID</th><th>手机号</th><th>状态</th><th>操作</th></tr>');
                        for (var i in dat.data.users) {
                            console.log(dat.data.users);
                            $('#tab-user-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td>'+ dat.data.users[i].uid +'</td>'+
                                '<td>'+ dat.data.users[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.users[i].lng +','+ dat.data.users[i].lat +')">查看</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("查找成功", "sys");
                    } else {
                        notify("查找失败", "sys");
                    }
                }
            );

        }
    }


    /**
     * [设备查找]
     * @return null
     */
    function deviceSearch(){

        var select_func = $('#select-device-search').val();
        var select_content = $('#input-device-search').val();
        if (select_func == 'name'){

            $.post("/api/getDevicesByName",
                {'name':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-device-list').empty();
                        $('#tab-device-list').append('<tr><th>姓名</th><th>UID</th><th>状态</th><th>操作</th></tr>');
                        for (var i in dat.data.devices) {
                            console.log(dat.data.devices);
                            $('#tab-device-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.devices[i].name +'</td>'+
                                '<td>'+ dat.data.devices[i].uid +'</td>'+
                                '<td>'+ dat.data.devices[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.devices[i].lng +','+ dat.data.devices[i].lat +')">查看</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("查找成功", "sys");
                    } else {
                        notify("查找失败", "sys");
                    }
                }
            );

        }
        else if(select_func == 'uid')
        {
         
            $.post("/api/getDevicesByUid",
                {'uid':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-device-list').empty();
                        $('#tab-device-list').append('<tr><th>姓名</th><th>UID</th><th>状态</th><th>操作</th></tr>');
                        for (var i in dat.data.devices) {
                              $('#tab-device-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.devices[i].name +'</td>'+
                                '<td>'+ dat.data.devices[i].uid +'</td>'+
                                '<td>'+ dat.data.devices[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.devices[i].lng +','+ dat.data.devices[i].lat +')">查看</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("查找成功", "sys");
                    } else {
                        notify("查找失败", "sys");
                    }
                }
            );

        }
    }


 	//极光云-----------------------------------------------------------------------------------------------------------

	JG_APP_KEY = '{{ $appkey }}'; 
    JG_MASTER_SECRET = '{{ $master_secret }}';
	RANDOM_STR = "qwerty1234567jde3d32dad"; //固定乱码
	USER_NAME = 'AQJK_SERVER';
	PASSWORD = '123456';


    window.JIM = new JMessage({
        debug : true
    });

	 JIM.onDisconnect(function(){
	  console.log("【disconnect】");
	 }); //异常断线监听

	/**
	 * 极光云初始化
	 * @return {[type]} [description]
	 */

  function jgInit() {
  		// var signature = md5(appkey={appkey}&timestamp={timestamp}&random_str={random_str}&key={secret});
		var timestamp = Date.parse(new Date());
  		var signature = "appkey="+JG_APP_KEY+"&timestamp="+timestamp+"&random_str="+RANDOM_STR+"&key="+JG_MASTER_SECRET;
  		console.log("signature is:"+signature);
  		signature = md5(signature);

        JIM.init({
            "appkey":JG_APP_KEY,
            "random_str": RANDOM_STR,
            "signature":  signature,
            "timestamp":  timestamp,
            "flag": 0
                
            }).onSuccess(function(data) {
            	notify("极光云初始化成功！",'user');
            	// register();
            // console.log('success:' + JSON.stringify(data));
            	login();
            }).onFail(function(data) {
            	notify("极光云初始化失败!","danger");
               console.log('--------------------------------------------------------------------')
               console.log('JG_APP_KEY is :' + JG_APP_KEY)
               console.log('JG_MASTER_SECRET is :' + JG_MASTER_SECRET)
               console.log('signature is :' + signature)
               console.log('error:' + JSON.stringify(data))
               console.log('--------------------------------------------------------------------')
              

           });
    }
    
    jgInit();

    /**
     * 极光云注册
     * @return {[type]} [description]
     */
    function register(){
          JIM.register({
            'username' : USER_NAME,
            'password': PASSWORD,
            'nickname' : 'nickname'
        }).onSuccess(function(data) {
            // console.log('success:' + JSON.stringify(data));
          }).onFail(function(data) {
            // console.log('error:' + JSON.stringify(data))
        });
    }

	/**·
	 * 极光云登录
	 * @return {[type]} [description]
	 */
    function login() {
	
        JIM.login({
            'username' : USER_NAME,
			'password': PASSWORD
        }).onSuccess(function(data) {
        	notify("极光云登录成功！","user");
            console.log('success:' + JSON.stringify(data));
		   JIM.onMsgReceive(function(data) {               
                notify(data['messages'][0]['from_username'] + ":<br/>" + data['messages'][0]['content']['msg_body']['text'], 'user');
            });
        }).onFail(function(data) {
            notify("极光云登录失败!","danger");
             // console.log('error:' + JSON.stringify(data));
        }).onTimeout(function(data) {
            // console.log('timeout:' + JSON.stringify(data));
        });
    }
    
    /**
     * 发送消息
     * @return {[type]} [description]
     */
    function sendSingleMsg(uid) {
    	var content;
    	content = $('#input-send-msg').val();

    	console.log("uid is ---------------------------",uid);

   //      JIM.sendSingleMsg({
   //          'target_username' : uid,
   //          'content' : content,
			// 'no_offline' : false,
			// 'no_notification' : false,
			// need_receipt:true
   //      }).onSuccess(function(data,msg) {
   //      	notify('发送成功！', 'user');
   //      }).onFail(function(data) {
   //      	notify('发送失败！', 'warning');

   //          console.log('error:' + JSON.stringify(data));
   //      });
    }

    //极光云-----------------------------------------------------------------------------------------------------------

	/**
     * 开启或者关闭轨迹打印
     */
    function toggleLocus(){

        if(IS_LOCUS == 0){
            IS_LOCUS = 1;
            $('#btn-toggle-loucs').text('关闭轨迹');
            $('#btn-toggle-loucs').addClass("btn-danger");
            $('#btn-toggle-loucs').removeClass("btn-primary");
        }

        else if (IS_LOCUS == 1){
            IS_LOCUS = 0;
            $('#btn-toggle-loucs').text('开启轨迹'); 
            $('#btn-toggle-loucs').addClass("btn-primary");
            $('#btn-toggle-loucs').removeClass("btn-danger");
        }
    }

    /**
     * 向设备发送消息
     */
    function sendDeviceMessage(uid,cmd){
    	console.log(uid);
    	console.log(cmd);
    	if (cmd == 'cmd_on') {
    		 $.post("/api/deviceOn",
                {
					'uid':uid
                },
                function (dat, status) {
    				notify('操作成功！',"sys");
    				// notify('收到专业终端01消息：你好',"sys");
                }
            );

    	}else if(cmd == 'cmd_off'){
    		 $.post("/api/deviceOff",
                {
					'uid':uid
                },
                function (dat, status) {
    				notify('操作成功！',"sys");
                }
            );

    	}
    }


    //地图
    require([
        "Ips/map",
        "Ips/layers/DynamicMapServiceLayer",
        "Ips/layers/FeatureLayer",
        "Ips/layers/GraphicsLayer",
        "esri/graphic",
        "esri/geometry/Point",
        "esri/geometry/Polyline",
        "esri/geometry/Polygon",
        "esri/InfoTemplate",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/SimpleFillSymbol",
        "esri/symbols/PictureMarkerSymbol",
        "esri/symbols/TextSymbol",
        "dojo/colors",
        "dojo/on",
        "dojo/dom",
        "dojo/domReady!"
    ], function (Map, DynamicMapServiceLayer, FeatureLayer, GraphicsLayer, Graphic, Point, Polyline, Polygon, InfoTemplate, SimpleMarkerSymbol, SimpleLineSymbol,
                 SimpleFillSymbol, PictureMarkerSymbol, TextSymbol, Color, on, dom) {

        map = new Map("map_c7", {
            logo: false
        });

        // //初始化F2楼层平面图
        var f1 = new DynamicMapServiceLayer("http://61.240.144.70:5567/arcgis/rest/services/airport/airport_level1/MapServer");
        // var f1 = new DynamicMapServiceLayer("http://61.240.144.70:5567/arcgis/rest/services/C7/c7floor1/MapServer");
        map.addLayer(f1);

        // //初始化路网
        var f2 = new DynamicMapServiceLayer("http://61.240.144.70:5567/arcgis/rest/services/ariport/airport_route/NAServer");
        map.addLayer(f2);

        var lineLayerF1 = new GraphicsLayer();
        

        //初始化坐标点
        pointLayer = new GraphicsLayer();
        map.addLayer(pointLayer);

        //初始化轨迹点
        LocusPointLayer = new GraphicsLayer();
        map.addLayer(LocusPointLayer);

        //初始化连线
        LinePointLayer = new GraphicsLayer();
        map.addLayer(LinePointLayer);

        //设置电子围栏    
        $.post("/api/getFenceList",
            {},
            function (dat, status) {

                if (dat.status == 0) {

                    //初始化 电子围栏图层
                    var surfaceLayer = new GraphicsLayer();

                    for (var i in dat.data.fences) {
                        DANGER_AREA.push($.parseJSON(dat.data.fences[i].content));

                        //定义面的几何体
                        var polygon = new Polygon($.parseJSON(dat.data.fences[i].content));
                        //定义面的符号
                        var fill = new SimpleFillSymbol(SimpleFillSymbol.STYLE_HORIZONTAL,
                            new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASHDOT, new Color([255, 50, 0]), 2),
                            new Color([0, 50, 200, 0.25]));
                        var fillgr = new Graphic(polygon, fill);

                        surfaceLayer.add(fillgr);

                    }                               
                    console.log(DANGER_AREA);

                    map.addLayer(surfaceLayer);
                    notify("读取电子围栏成功", "sys");

                } else {
                    notify("读取电子围栏失败", "sys");
                }
            }
        );   
        

        /**
         * 根据返回点判断是否为危险区域内
         * @param {[type]} x       [x坐标]
         * @param {[type]} y       [y坐标]
         */
        function isInDangerArea(lng, lat) {
            for (var i in DANGER_AREA) {
                var point1 = DANGER_AREA[i][0];
                var point3 = DANGER_AREA[i][2];

                var point1Lng = point1[0];
                var point1Lat = point1[1];
                var point3Lng = point3[0];
                var point3Lat = point3[1];

                if ((point1Lng < lng) && (lng < point3Lng) && (point1Lat < lat) && (lat < point3Lat))
                    return true;

                return false;
            }
        }


        /**
         * 添加用戶點
         * @param {[type]} id      [用户ID]
         * @param {[type]} x       [x坐标]
         * @param {[type]} y       [y坐标]
         * @param {[type]} name    [用户姓名]
         * @param {[type]} phone   [用户手机号]
         * @param {[type]} uid     [用户推送ID]
         * @param {[type]} status  [用户状态]
         */
        function addUserPoint(id, x, y, name, phone, uid, status,color) {

            //定义点的几何体
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //定义点的图片符号
            var picSymbol;

            picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_"+ color +".png", 28, 28);
           
            //定义点的图片符号
            var attr = {"name": name, "phone": phone};
            //信息模板
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle('人员');

            infoTemplate.setContent(
                "<b>名称:</b><span>${name}</span><br>"
                + "<b>手机号:</b><span>${phone}</span><br><br>"
                + "<input id='input-send-msg',class='form-control'>"
                + "<button class='' onclick=sendSingleMsg("+ "'" + uid + "'" +") >发送</button>"

            );
            var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
            pointLayer.add(picgr);
        }

        /**
         * 添加转发器点
         * @param {[type]} id     [用户ID]
         * @param {[type]} x      [x坐标]
         * @param {[type]} y      [y坐标]
         * @param {[type]} name   [用户名]
         * @param {[type]} status [用户状态]
         */
        function addDevicePoint(id, x, y, name, uid, status) {
            //定义点的几何体
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //定义点的图片符号
            var picSymbol;
            if (status == 0)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/en.png", 32, 32);
            else if (status == 1)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/en-red.png", 32, 32);
            // //定义点的图片符号
            var attr = {"name": name};
            // //信息模板
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle('设备');
            var Onisdisabled = '';
            var Offisdisabled = '';
            if (status) {
                Onisdisabled = 'disabled';
            }else{
                Offisdisabled = 'disabled';
            }

            infoTemplate.setContent(
                "<b>名称:</b><span>${name}</span><br>"
                + "<b>手机号:</b><span>${phone}</span><br><br>"
                + "<button class='' " + Onisdisabled + " onclick=sendDeviceMessage("
                + "'" + uid + "'" + ",'cmd_on') >开机</button>"
                + "<button class='' " + Offisdisabled + " onclick=sendDeviceMessage("
                + "'" + uid + "'" + ",'cmd_off') >关机</button>"
            );
            var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
            pointLayer.add(picgr);
        }


        /**
         * 添加轨迹点数据
         */
        function addLocusUserPoint(id, x, y, name, phone, uid, status,color){

            linePoint = [x,y];

            //定义点的几何体
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //定义点的图片符号
            var picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_"+ color +".png", 28, 28);
            var picgr = new Graphic(picpoint, picSymbol);
            LocusPointLayer.add(picgr);
            console.log(uid);

            if (uid == 32770925313130506) {
            	console.log("sefafafsafasfdfd");
                var lineSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID, new Color("#FF0000"), 2);
                lineArrF1.push(linePoint);
                var line= new Polyline(lineArrF1);
                var linegr=new Graphic(line,lineSymbol);
                lineLayerF1.add(linegr);
                map.addLayer(lineLayerF1);
                

            }
        }

        /**
         * 添加用户轨迹点数据
         */
        function addUserPointLine(id, x, y, name, phone, uid, status,color){
            for(var i in POINT_LINE){
                if (POINT_LINE[i]['color'] == color) {
                    POINT_LINE[i]['position'].push[[x,y]]
                }
                else{

                }
            }
        }

        /**
         * 更新轨迹点连线
         */
        function refreshPointLine(){

            //清除线
            clearLine();

            //遍历线json
           for(var i in POINT_LINE){
                console.log(POINT_LINE[i]['color']);
                console.log(POINT_LINE[i]['position'][0]);
                console.log(POINT_LINE[i]['position'][1]);

                if(color == color){

                }
            }

            //定义线的几何体
            var line= new Polyline([[2,3],[25,30],[40,10]]);
            //定义线的符号
            var lineSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
            var linegr=new Graphic(line,lineSymbol);
            LinePointLayer.add(linegr);
        }

   

        /**
         * 从服务器读取转发器列表数据数据并更新界面
         */
        function getDataAndRefresh() {

            // 从云端读取数据
            $.post("/api/getAllLocation",
                {},
                function (dat, status) {

                    if (dat.status == 0) {

                        // 删除数据
                        pointLayer.clear();

                        // 添加数据

                        // 添加人
                        for (var i in dat.data.users) {
                            // console.log(dat.data.users)
                            
                            if(dat.data.users[i].floor == 1){
                                //打点
                                addUserPoint(
                                    dat.data.users[i].id,
                                    dat.data.users[i].y,
                                    dat.data.users[i].x,
                                    dat.data.users[i].name,
                                    dat.data.users[i].phone,
                                    dat.data.users[i].uid,
                                    dat.data.users[i].status,
                                    dat.data.users[i].color
                                );

                        //         if (isInDangerArea(dat.data.users[i].y, dat.data.users[i].x)) {
                    				// notify("用户 “" + dat.data.users[i].name + "” 处于危险区域 已发送预警消息", "sys");
                        //             sendSingleMsg(dat.data.users[i].uid);
                        //         }

                                //轨迹
                                if(IS_LOCUS){
                                    //用户轨迹点
                                    addLocusUserPoint(
                                        dat.data.users[i].id,
                                        dat.data.users[i].y,
                                        dat.data.users[i].x,
                                        dat.data.users[i].name,
                                        dat.data.users[i].phone,
                                        dat.data.users[i].uid,
                                        dat.data.users[i].status,
                                        dat.data.users[i].color
                                    );
                                    //用户连线
                                    addUserPointLine(
                                        dat.data.users[i].id,
                                        dat.data.users[i].y,
                                        dat.data.users[i].x,
                                        dat.data.users[i].name,
                                        dat.data.users[i].phone,
                                        dat.data.users[i].uid,
                                        dat.data.users[i].status,
                                        dat.data.users[i].color
                                    );
                                    
                                }
                            }
                        }
                        // 添加设备
                        for (var i in dat.data.devices) {   
                            if(dat.data.devices[i].floor == 1){

                                addDevicePoint(
                                    dat.data.devices[i].id,
                                    dat.data.devices[i].y,
                                    dat.data.devices[i].x,
                                    dat.data.devices[i].name,
                                    dat.data.devices[i].uid,
                                    dat.data.devices[i].status,
                                );
                            }
                        }
                        refreshPointLine();
                    } else {
                        console.log('ajax error!');
                    }
                }
            );
        }

        //循环执行
        setInterval(getDataAndRefresh, (INTERVAL_TIME * 500));

        //显示初始化成功
        notify(HELLO_STR, "sys");

    });

</script>
</html>
