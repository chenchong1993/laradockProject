<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>

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


    <h1 style="padding-left: 50% "> {{ $position }} </h1>
    <div id="map" class="col-md-12">

       

    </div>

</div>
</body>

<script>

    var lat = '{{ $lat }}';
    var lng = '{{ $lng }}';
    var uid = '{{ $uid }}';
    var position = '{{ $position }}';
    var floor = '{{ $floor }}';


    if (position == 'C7') {
        if (floor == 1) {

            mapAddr = "http://121.28.24.203:5567/arcgis/rest/services/C7/c7floor1/MapServer";

        }else if(floor == 2){

            mapAddr = "http://121.28.24.203:5567/arcgis/rest/services/C7/c7floor2/MapServer";

        }else if(floor == 3){

            mapAddr = "http://121.28.24.203:5567/arcgis/rest/services/C7/c7floor3/MapServer"

        }
    }else if(position == 'ATLS'){
        if (floor == 1) {

            mapAddr = "http://121.28.24.203:5567/arcgis/rest/services/outlets/outlets1f/MapServer";

        }else if(floor == 2){

            mapAddr = "http://121.28.24.203:5567/arcgis/rest/services/outlets/outlets2f/MapServer";

        }
    }else if(position == 'Airport'){

        mapAddr = "http://121.28.24.203:5567/arcgis/rest/services/airport/airport_level1/MapServer";

    }else if(position == 'DA'){
        if (floor == 1) {

            mapAddr = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F1map/MapServer";

        }else if(floor == 2){

            mapAddr = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F2map/MapServer";

        }else if(floor == 3){

            mapAddr = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F3map/MapServer";

        }else if(floor == 4){

            mapAddr = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F4map/MapServer";

        }else if(floor == 5){

            mapAddr = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F5map/MapServer";

        }
    }
    //把图层提出到外边来声明方便调用
    var pointLayer;

    var map;

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

        map = new Map("map", {
            logo: false
        });

        //初始化F2楼层平面图
        var f1 = new DynamicMapServiceLayer(mapAddr);
        map.addLayer(f1);

        //初始化坐标点pointLayer 用户数据点图层
        pointLayer = new GraphicsLayer();
        map.addLayer(pointLayer);

        //初始化轨迹点pointLayer 用户数据点图层
        LocusPointLayer = new GraphicsLayer();
        map.addLayer(LocusPointLayer);




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
        function addUserPoint(id, x, y, name, phone, uid, status) {

            //定义点的几何体
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //定义点的图片符号
            var picSymbol;
            picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/user_red.png", 32, 32);
            var picgr = new Graphic(picpoint, picSymbol);
            pointLayer.add(picgr);
            
        }


        addUserPoint(                                    
            1,
            lat,
            lng,
            '终端',
            '-------',
            uid,
            0)
        });

    console.log('lng:'+lng);
    console.log('lat:'+lat);


// lng 538271.1630904482
// lat 4212801.846389664
// http://127.0.0.1/showPointMap?uid=32770901179105290&lng=538271.1630904482&lat=4212801.846389664&floor=2

</script>
</html>
