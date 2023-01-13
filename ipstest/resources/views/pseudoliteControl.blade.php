<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>伪卫星网络控制</title>

    <link rel="stylesheet" href="https://js.arcgis.com/4.20/esri/themes/light/main.css" />
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script> 
    <script src="./js/notify/bootstrap.min.js"></script>
    <script src="./js/notify/hullabaloo.js"></script>
    <script type="text/javascript" src="./js/tools.js"></script>
    <script src="https://js.arcgis.com/4.24/"></script>

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
    <style>
        .black_overlay {
            display: none;
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            height: 100%;
            background-color: black;
            z-index: 1001;
            -moz-opacity: 0.8;
            opacity: 0.8;
            filter: alpha(opacity=80);
        }
 
        .white_content {
            display: none;
            position: absolute;
            top: 10%;
            left: 10%;
            width: 80%;
            height: 80%;
            border: 16px solid lightblue;
            background-color: white;
            z-index: 1002;
            overflow: auto;
        }
 
        .white_content_small {
            display: none;
            position: absolute;
            top: 30%;
            left: 40%;
            width: 20%;
            height: 30%;
            border: 16px solid lightblue;
            background-color: white;
            z-index: 1002;
            overflow: auto;
        }
    </style>


    <script>
        var POINTSIZE = "30px";    //默认图片大小为24*24
        var INTERVAL_TIME = 2; //数据刷新间隔时间
        var map;
        var nowStaName;
        var ws = new WebSocket("ws://39.107.84.169/ws/?topic=pseudoliteControl");

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

            //定位到中心112.3777716, 33.4011231
            var cityCenter = new Point(112.3777716, 33.4011231, new SpatialReference({ wkid: 4490 }));

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
                zoom: 5,
                maxZoom: 18,
                ui: {
                    components: ["zoom", "compass"]
                }
            });

            /**
             * 添加基站
             */
            function addStaPoint(id,Lng,Lat,Status,Name,Ip,Adress){
                var picpoint = new Point(Lng,Lat);
                var pseStatus = "";
                if (Status == 1){
                        var img_uri="./Ips_api_javascript/Ips/image/point_1.png";
                        pseStatus = "在线";
                    }else{
                        var img_uri="./Ips_api_javascript/Ips/image/point_6.png";
                        pseStatus = "离线";
                    }
                //弹出框参数
                var attributes = {
                    id: id, 
                    staName: Name, 
                    IP: Ip,
                    status: pseStatus,
                    adress:Adress,
                  };
                //自定按钮
                var fileInputBtn = {
                  title: "文件烧录",//页面显示的按钮名字
                  id: "fileInputID",//按钮id
                  className: "esri-icon-documentation"
                };
                var commandInputBtn = {
                  title: "命令烧录",//页面显示的按钮名字
                  id: "commandInputID",//按钮id
                  className: "esri-icon-right-triangle-arrow"
                };
                var details = {
                  title: "详细参数",//页面显示的按钮名字
                  id: "details",//按钮id
                  className: "esri-icon-review"
                };
                // 弹出框定义
                var popupTemplate = {
                  title: "基站号:{staName}",
                  content: "状态：{status} <br> IP:{IP} <br> 地址：{adress}",
                  actions:[fileInputBtn,commandInputBtn,details]
                };
                var pointGraphic = new Graphic({
                  geometry: picpoint,
                  symbol: {
                    // 类型有 图片标记 和 点
                    type: 'picture-marker',
                    // 图片地址，可以网络路径或本地路径（PS：base64亦可）
                    url: img_uri,
                    // 图片的大小
                    width: POINTSIZE,
                    height: POINTSIZE
                  },

                  attributes: attributes,
                  popupTemplate: popupTemplate
                });

                view.popup.on("trigger-action", function(event){

                  if(event.action.id === "fileInputID"){
                      var strTmp = $('.esri-popup__header-title').html();
                      console.log(strTmp.split("基站号:"));

                      if (Name == strTmp.split("基站号:")[1]) {
                          fileDivShow(Name,'fileDiv','fade');
                      }
                  }
                  if(event.action.id === "commandInputID"){
                      var strTmp = $('.esri-popup__header-title').html();
                      if (Name == strTmp.split("基站号:")[1]) {
                          commandDivShow(Name,'commandDiv','fade');
                      }
                  }
                  if(event.action.id === "details"){
                      var strTmp = $('.esri-popup__header-title').html();
                      if (Name == strTmp.split("基站号:")[1]) {
                          detailShow(Name);
                      }
                  }
                });
                // pointLayer.graphics.removeAll() ;

                pointLayer.graphics.add(pointGraphic);
                map.add(pointLayer);
             }
            /**
             * 烧录文件，弹出对话框，进行操作 
             */ 
            function fileDivShow(name,fileDiv,bg_div){
                document.getElementById(fileDiv).style.display = 'block';
                document.getElementById(bg_div).style.display = 'block';
                var bgdiv = document.getElementById(bg_div);
                bgdiv.style.width = document.body.scrollWidth;
                // bgdiv.style.height = $(document).height();
                $("#" + bg_div).height($(document).height());
                nowStaName = name;
            }
            /**
             * 烧录命令，弹出对话框，进行操作
             */ 
            function commandDivShow(name,commandDiv, bg_div) {
                document.getElementById(commandDiv).style.display = 'block';
                document.getElementById(bg_div).style.display = 'block';
                var bgdiv = document.getElementById(bg_div);
                bgdiv.style.width = document.body.scrollWidth;
                // bgdiv.style.height = $(document).height();
                $("#" + bg_div).height($(document).height());
                nowStaName = name;
            }
            /**
             * 详细参数
             */ 
            function detailShow(staName){
                console.log("参数弹出");
            }
            /**
             * 获取基站列表
             */
            function getPseudoliteList(){
                // 从云端读取数据
                $.get("/ipstest/api/getpseudoliteList",
                // $.get("/api/getpseudoliteList",

                    {},
                    function (dat, status) {
                        pseudoliteList = dat;
                        // console.log(dat);
                        if (dat.status == 0) {
                            // console.log(222222)
                            // 删除数据
                            pointLayer.removeAll();
     
                            for (var i in dat.data) {
                                addStaPoint(
                                    dat.data[i].id, 
                                    dat.data[i].lng, 
                                    dat.data[i].lat, 
                                    dat.data[i].status,
                                    dat.data[i].name,
                                    dat.data[i].ip,
                                    dat.data[i].address);
                            }
                            
                        } else {
                            console.log('ajax error!');
                        }
                    }
                );
            }
            
            //循环执行
            setInterval(getPseudoliteList, (INTERVAL_TIME * 1000));
           // getPseudoliteList();


        });

        


        //关闭弹出层
        function CloseDiv(show_div, bg_div) {
            document.getElementById(show_div).style.display = 'none';
            document.getElementById(bg_div).style.display = 'none';
        };
        /**发送命令
         */
         function sendCommand(){
            console.log(nowStaName);
            var command = document.getElementById("commandInput").value;
            var msg ={
                PN : nowStaName,
                command : command
            }
            ws.send(JSON.stringify(msg));
            notify("指令发送成功", "sys");
         }
         /**
          * 文件上传
          */
          function uploadFile(){
            console.log(nowStaName);

          }
    </script>
</head>
<body>
<div id="viewDiv"></div>
<div id="fade" class="black_overlay"></div>
<div id="fileDiv" class="white_content_small">
    <div style="text-align: right; cursor: default; height: 40px;">
        <span style="font-size: 16px;" onclick="CloseDiv('fileDiv','fade')">关闭</span>
        <div >
            <div  style="width:100px;height:100px;position: absolute;top:35%;left:30%;margin-top: -50px;margin-left: -50px;">
                <div >            
                    <label for="exampleInputFile">
                    </label>
                    <input type="file" class="form-control-file" id="upload">
                </div>
            </div>
            <div  style="width:100px;height:100px;position: absolute;top:70%;left:45%;margin-top: -50px;margin-left: -50px;">
                <div>
                    <button style="display:block;margin:0 auto" class="btn" type="button" id="uploadFile" onclick="uploadFile()">烧入</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="commandDiv" class="white_content_small">
    <div style="text-align: right; cursor: default; height: 40px;">
        <span style="font-size: 16px;" onclick="CloseDiv('commandDiv','fade')">关闭</span>
         <div >
            <div  style="width:100px;height:100px;position: absolute;top:35%;left:22%;margin-top: -50px;margin-left: -50px;">
                <div >            
                    <input style="width:300px" type="text" class="hui-input-text"  id="commandInput" placeholder="输入指令" />
                </div>
            </div>
            <div  style="width:100px;height:100px;position: absolute;top:70%;left:50%;margin-top: -50px;margin-left: -50px;">
                <div>
                    <button style="display:block;margin:0 auto" class="btn" type="button" id="sendCommand" onclick="sendCommand()">烧入</button>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>