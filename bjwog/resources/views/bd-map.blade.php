
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>机场一层百度地图</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <style>
        body,
        html,
        #container {
            overflow: hidden;
            width: 100%;
            height: 100%;
            margin: 0;
            font-family: "微软雅黑";
        }

        </style>

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
        <script src="//api.map.baidu.com/api?type=webgl&v=1.0&ak=whLtGsLgpUmjcL87x6w5Ydu9VCaCTb1y"></script>
    </head>

<body>
    <div id="container"></div>
</body>
</html>
<script type="text/javascript">
	var map = new BMapGL.Map('container');
	map.centerAndZoom(new BMapGL.Point(114.69860, 38.28941), 19);
	// 创建小车图标
	var myIcon = new BMapGL.Icon("Ips_api_javascript/Ips/image/point_black.png", new BMapGL.Size(64,64));
	// 创建Marker标注，使用小车图标
	var point = new BMapGL.Point(114.69760, 38.28961);
	var marker = new BMapGL.Marker(point, {
	    icon: myIcon
	});
	// 将标注添加到地图
	map.addOverlay(marker);
	// 创建信息窗口
	var opts = {
	    width: 230,
	    height: 120,
	    title: '{$name}'
	};
	var infoWindow = new BMapGL.InfoWindow(
	 				"<b>name:</b><span>${name}</span><br>"
	                + "<b>phone:</b><span>${phone}</span><br><br>"
	                + "<input id='input-send-msg',class='form-control'>"
	                + "<button class='' onclick=sendSingleMsg() >send</button>"

	                , opts);
	// 点标记添加点击事件
	marker.addEventListener('click', function () {
	    map.openInfoWindow(infoWindow, point); // 开启信息窗口
	});
</script>

<!-- 114.69860, 38.28941), 19 -->

