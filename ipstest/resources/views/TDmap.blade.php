<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>测试</title>

    <link rel="stylesheet" href="https://js.arcgis.com/4.20/esri/themes/light/main.css" />
    <script src="https://js.arcgis.com/4.24/"></script>
{{--    <!-- 地图开始 -->--}}
{{--    <link rel="stylesheet" type="text/css" href="/Ips_api_javascript/dijit/themes/tundra/tundra.css"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="/Ips_api_javascript/esri/css/esri.css"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="/Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css"/>--}}
{{--    <link rel="stylesheet" type="text/css" href="/Ips_api_javascript/Ips/css/widget.css"/>--}}
{{--    <script type="text/javascript" src="Ips_api_javascript/init.js"></script>--}}
    <style>
        html,
        body,
        #viewDiv {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
        }
    </style>

    <script>
        var POINTSIZE = 10;    //默认图片大小为24*24
        var map;
        require([
            "esri/Map",
            "esri/layers/WebTileLayer",
            'esri/layers/support/TileInfo',
            'esri/views/MapView',
            "esri/layers/FeatureLayer",
            "esri/geometry/SpatialReference",
            "esri/geometry/Point",
            "esri/layers/GraphicsLayer",
            "esri/symbols/PictureMarkerSymbol",
            "esri/Graphic",
            "dojo/colors",
            "dojo/on",
            "dojo/dom",
            "dojo/domReady!"

        ], function (Map, WebTileLayer,TileInfo, MapView, FeatureLayer, SpatialReference, Point,GraphicsLayer,PictureMarkerSymbol,Graphic, Color, on, dom) {
            var tiandituBaseUrl = "http://{subDomain}.tianditu.com"; //天地图服务地址
            var token = "cf165756006c20d7fbff15c67ff4b433"; //天地图token，在官网申请

            var tileInfo = new TileInfo({
                "rows": 256,
                "cols": 256,
                "compressionQuality": 0,
                "origin": {
                    "x": -180,
                    "y": 90
                },
                "spatialReference": {
                    "wkid": 4490
                },
                "lods": [
                    {"level": 0,"resolution": 1.4062500000002376,"scale": 590995186.11759996},
                    {"level": 1,"resolution": 0.703125000000119,"scale": 295497593.0588},
                    {"level": 2,"resolution": 0.351562500000059,"scale": 147748796.5294},
                    {"level": 3,"resolution": 0.17578125000003,"scale": 73874398.2647},
                    {"level": 4,"resolution": 0.0878906250000148,"scale": 36937199.1323},
                    {"level": 5,"resolution": 0.0439453125000074,"scale": 18468599.566175},
                    {"level": 6,"resolution": 0.0219726562500037,"scale": 9234299.7830875},
                    {"level": 7,"resolution": 0.0109863281250019,"scale": 4617149.89154375},
                    {"level": 8,"resolution": 0.00549316406250093,"scale": 2308574.94577187},
                    {"level": 9,"resolution": 0.00274658203125046,"scale": 1154287.47288594},
                    {"level": 10,"resolution": 0.00137329101562523,"scale": 577143.736442969},
                    {"level": 11,"resolution": 0.000686645507812616,"scale": 288571.868221484},
                    {"level": 12,"resolution": 0.000343322753906308,"scale": 144285.934110742},
                    {"level": 13,"resolution": 0.000171661376953154,"scale":72142.9670553711},
                    {"level": 14,"resolution": 8.5830688476577E-05,"scale": 36071.4835276855},
                    {"level": 15,"resolution": 4.29153442382885E-05,"scale": 18035.7417638428},
                    {"level": 16,"resolution": 2.14576721191443E-05,"scale": 9017.87088192139},
                    {"level": 17,"resolution": 1.07288360595721E-05,"scale": 4508.93544096069},
                    {"level": 18,"resolution": 5.36441802978606E-06,"scale": 2254.46772048035},
                    {"level": 19,"resolution": 2.68220901489303E-06,"scale": 1127.23386024017},
                    {"level": 20,"resolution": 1.34110450744652E-06,"scale": 563.616930120087}

                ]
            })

            //影像地图
            var tiledLayer = new WebTileLayer({
                urlTemplate: tiandituBaseUrl + "/DataServer?T=img_c&x={col}&y={row}&l={level}&tk=" + token,
                subDomains: ["t0", "t1", "t2", "t3", "t4", "t5", "t6", "t7"],
                tileInfo: tileInfo,
                maxZoom: 18,
                spatialReference: { wkid: 4490 },
            });

            //影像注记
            var tiledLayerAnno = new WebTileLayer({
                urlTemplate: tiandituBaseUrl + "/DataServer?T=cia_c&x={col}&y={row}&l={level}&tk=" + token,
                subDomains: ["t0", "t1", "t2", "t3", "t4", "t5", "t6", "t7"],
                tileInfo: tileInfo,
                maxZoom: 18,
                spatialReference: { wkid: 4490 },
            });

            //定位到济南市中心
            var cityCenter = new Point(115.9174855, 39.0534475, new SpatialReference({ wkid: 4490 }));

            // 创建地图
            var map = new Map({
                basemap: {
                    baseLayers: [tiledLayer, tiledLayerAnno]
                },
                maxZoom: 18,
            });
            //初始化pointLayer 用户数据点图层
            var pointLayer = new GraphicsLayer();
            map.add(pointLayer);

            var view = new MapView({
                container: "viewDiv",
                map: map,
                center: cityCenter,
                zoom: 18,
                maxZoom: 18,
                ui: {
                    components: ["zoom", "compass"]
                }
            });
            //显示经纬度坐标
            view.on("click", (event) => {
                let lat = Math.round(event.mapPoint.latitude * 10000000) / 10000000;
                let lon = Math.round(event.mapPoint.longitude * 10000000) / 10000000;
                alert(lon + ", " + lat);
            });



            var ws = new WebSocket("ws://60.205.57.192:8282/?type=calculate");

            ws.onopen = function(evt) {
                console.log("Connection open ...");
            };

            ws.onmessage = function(evt) {
                console.log(JSON.parse(evt.data));
                data = JSON.parse(evt.data);
                console.log(data.data[0].lat)
                pointLayer.removeAll();
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
                pointLayer.destroy();
                pointLayer = new GraphicsLayer();
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
                if (name == "lidar"){
                    var img_uri="/Ips_api_javascript/Ips/image/point_6.png";
                }else{
                    var img_uri="/Ips_api_javascript/Ips/image/point_1.png";
                }

                var picSymbol = new PictureMarkerSymbol(img_uri,POINTSIZE,POINTSIZE);
                //定义点的图片符号
                // var attr = {"name": name, "phone": phone};
                // //信息模板
                // var infoTemplate = new InfoTemplate();
                // infoTemplate.setTitle('用户');
                // infoTemplate.setContent(
                //     "<b>名称:</b><span>${name}</span><br>"
                //     + "<b>时间:</b><span>${time}</span><br>"
                // );
                var picgr = new Graphic(picpoint, picSymbol);
                pointLayer.add(picgr);
                map.add(pointLayer);
                if (status==1){
                    notify(ERR_MSG, "sys");
                }
            }


        });
    </script>
</head>

<body>
<div id="viewDiv"></div>
<div  style="z-index: 5; position: fixed ;left:0%;top: 0%"><a href="#" id="showClean">清除轨迹</a></div>
</body>

</html>