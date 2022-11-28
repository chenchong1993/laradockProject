<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>热力图demo</title>
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="Ips_api_javascript/dijit/themes/nihilo/nihilo.css">
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/esri/css/esri.css"/>
       <!-- 提示框开始 -->
    <script src="/js/notify/bootstrap.min.js"></script>
    <script src="/js/notify/hullabaloo.js"></script>
    <!-- 提示框结束 -->
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript" src="Ips_api_javascript/echartsExtent.js"></script>
    <script type="text/javascript" src="Ips_api_javascript/init.js"></script>

    <!-- tools -->
    <script type="text/javascript" src="/js/tools.js"></script>
    <!-- tools-->
    <style>
        html, body, #map {
            height: 100%; width: 100%;
            margin: 0; padding: 0;
        }


        .btn-group {
            position: absolute;
            z-index: 5;
            right: 2%;
            top: 2%;
            padding: 1%;
        }

        .btn-group button {
            margin-right: 2px;
            background-color: black;
            border-color: black;
        }

    </style>
</head>
<body class="nihilo">
<div id="map"></div>

<div class="btn-group" role="group" aria-label="...">
    <button type="button" id="btn-people-num" class="btn btn-primary">当前在线人数：1</button>
    <button type="button" id="btn-max-den-num" class="btn btn-primary">当前报警密度阈值：{{ $max_den }}</button>

</div>


<div class="btn-group" role="group" aria-label="...">
</div>

<script>
    var dojoConfig={
        async: true,
        packages: [{
            name: "src",
            location: location.pathname.replace(/\/[^/]+$/, "")+"/src"
        }]
    }
</script>
<script>
var map;
var overlay;
CURRENT_PEOPLE_NUM = 0; // 当前人数
MAX_PEOPLE_NUM = '{{ $max_den }}'; // 报警人口阈值
console.log('MAX_PEOPLE_NUM is :'+MAX_PEOPLE_NUM);

require([
        "esri/map",
        "esri/layers/ArcGISDynamicMapServiceLayer",
        "esri/geometry/Extent",
        "esri/SpatialReference",
        "src/Echarts3Layer",
        "dojo/parser",
        "dojo/domReady!"],
    function(Map, ArcGISDynamicMapServiceLayer,Extent, SpatialReference, Echarts3Layer, parser) {
        parser.parse();
        map = new Map("map", {
            center: [114.392, 37.95],
            zoom: 8,
            extent: new Extent(534362.5363358026, 4202647.57075908, 534555.0210957723, 4202895.893663552, new SpatialReference(4547)),
            logo:false
        });
        var floorMap = new ArcGISDynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/outlets/outlets1f/MapServer");
        map.addLayer(floorMap);


        //初始化echarts图层
        overlay = new Echarts3Layer(map, echarts);
        var chartsContainer = overlay.getEchartsContainer();
        var myChart = overlay.initECharts(chartsContainer);
            

        function getHeatMapData(){
            $.get("data/atls-heat-data.json",function(json){
            //设置常亮
            CURRENT_PEOPLE_NUM = json.length;
            //设置显示人数
            $("#btn-people-num").text("当前在线人数：" + json.length);
              var option = {
                visualMap: {
                    min: 0,
                    max: 2,
                    show: false,
                    seriesIndex: 0,
                    calculable: true,
                    inRange: {
                        color: ['blue', 'blue', 'green', 'yellow', 'red'] //热力图色带
                    },
                    textStyle: {
                        color: '#fff'
                    }
                },
                geo: {
                    map: '',
                    show: false,
                    label: {
                        emphasis: {
                            show: false
                        }
                    },
                    left: 0,
                    top: 0,
                    right: 0,
                    bottom: 0,
                    roam: false,
                    itemStyle: {
                        normal: {
                            areaColor: '#323c48',
                            borderColor: '#111'
                        },
                        emphasis: {
                            areaColor: '#2a333d'
                        }
                    }
                },
                series: [{
                    type: 'heatmap',
                    coordinateSystem: 'geo',
                    data: convertData(json), //转换后的港口数据
                    pointSize: 6,  //点大小
                    blurSize: 10  //模糊大小
                }]
            };
            overlay.setOption(option);
        })            
    }

      

    //设置定时器 循环执行
    setInterval(function () {
        console.log('刷新图层');
        getHeatMapData();
        
        if (CURRENT_PEOPLE_NUM  > MAX_PEOPLE_NUM) {
            notify("当前区域人群密度过大 已自动向该区域游客发送预警信息", "opt_err");
        }

    }, 3000);

}); 

  

function convertData(data){
    var res = [];
    for(var i = 0; i < data.length; i++) {
        res.push([parseFloat(data[i].x), parseFloat(data[i].y)]);
    }
    return res;
}


</script>
</body>
</html>