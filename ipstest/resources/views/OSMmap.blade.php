<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>OSM地图</title>

    <!-- 菜单开始 -->
    <link rel="stylesheet" type="text/css" href="./css/menu/style.css"/>
    <!-- 菜单结束 -->
    <!-- 提示框开始 -->
{{--    <link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">--}}
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- 提示框结束 -->

    <!-- 地图开始 -->
    <link rel="stylesheet" type="text/css" href="./Ips_api_javascript/dijit/themes/tundra/tundra.css"/>
    <link rel="stylesheet" type="text/css" href="./Ips_api_javascript/esri/css/esri.css"/>
    <link rel="stylesheet" type="text/css" href="./Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="./Ips_api_javascript/Ips/css/widget.css"/>
    <!-- 地图结束 -->
    {{--拖动框--}}
    <link rel="stylesheet" type="text/css" href="./css/box.css">
    <style>
        html, body, .map {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background: white;
        }
    </style>

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>

    <!-- 提示框开始 -->
    <script src="./js/notify/bootstrap.min.js"></script>
    <script src="./js/notify/hullabaloo.js"></script>
    <!-- 提示框结束 -->

    <!-- 331地图 -->
    <script type="text/javascript" src="./Ips_api_javascript/init.js"></script>
    <!-- 331地图 -->

    <!-- tools -->
    <script type="text/javascript" src="./js/tools.js"></script>
    <!-- tools-->
    {{--拖动框--}}
    <script type="text/javascript" src="./js/box.js"></script>
</head>

<body class="tundra">

<div class="row" style="height: 100%">

    <div id="map" class="col-md-12"></div>
    <div  style="z-index: 5; position: fixed ;left:0%;top: 0%"><a href="#" id="showClean">清除轨迹</a>
    </div>

</div>
</body>

<script>

    // 初始化全局参数
    var INTERVAL_TIME = 1; //数据刷新间隔时间
    var HELLO_STR = "系统初始化成功！"; //初始化欢迎语句
    var ERR_MSG = "电子围栏示范用户正处于危险区域！";//危险区域发送的信息
    var POINTSIZE = 22;    //默认图片大小为24*24
    var map;


    //地图
    require([
        "esri/map",
        "esri/geometry/Extent",
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
    ], function (Map,Extent,DynamicMapServiceLayer, FeatureLayer, GraphicsLayer, Graphic, Point, Polyline, Polygon, InfoTemplate, SimpleMarkerSymbol, SimpleLineSymbol,
                 SimpleFillSymbol, PictureMarkerSymbol, TextSymbol, Color, on, dom) {
        var initialExtent = new Extent({
            "spatialReference": { "wkid": 4326 }
        });

        var map = new Map("map", {
            basemap:"satellite",
            center:[115.92571367237852, 39.05182842393302],
            zoom:15,
            extent:initialExtent,
            logo:false
        });
        //初始化pointLayer 用户数据点图层
        var pointLayer = new GraphicsLayer();
        map.addLayer(pointLayer);

        var ws = new WebSocket("ws://60.205.57.192:8282/?type=calculate");

        ws.onopen = function(evt) {
            console.log("Connection open ...");
        };

        ws.onmessage = function(evt) {
            console.log(JSON.parse(evt.data));
            data = JSON.parse(evt.data);
            console.log(data.data[0].lat)
            if(data.type == "fastlocation"){
                addUserPoint(
                    1,
                    "32770901179105290",
                    data.data[0].lng,
                    data.data[0].lat,
                    data.data[0].name,
                    "150000000",
                    "0",
                    0
                );
            }


        };

        ws.onclose = function(evt) {
            console.log("Connection closed.");
        };
        on(dom.byId("showClean"),"click",function(){
            pointLayer.clear();
        })
        /**
         * 添加点图标
         * */
        function addUserPoint(id,uid, lng, lat, name, phone,floor,status) {
            //定义点的几何体
            //38.2477770 114.3489115
            console.log(lat);
            console.log(lng);
            console.log(status);
            var picpoint = new Point(lng,lat);
            // //定义点的图片符号
            if (name == "route"){
                var img_uri="/Ips_api_javascript/Ips/image/b.png";
            }else{
                var img_uri="/Ips_api_javascript/Ips/image/r.png";
            }

            var picSymbol = new PictureMarkerSymbol(img_uri,POINTSIZE,POINTSIZE);
            //定义点的图片符号
            var attr = {"name": name, "phone": phone};
            //信息模板
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle('用户');
            infoTemplate.setContent(
                "<b>名称:</b><span>${name}</span><br>"
                + "<b>时间:</b><span>${time}</span><br>"
            );
            var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
            pointLayer.add(picgr);
            map.addLayer(pointLayer);
            if (status==1){
                notify(ERR_MSG, "sys");
            }
        }
        //显示初始化成功
        notify(HELLO_STR, "sys");
    });




</script>
</html>
