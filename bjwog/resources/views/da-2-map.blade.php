<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2022北京-张家口冬奥会跳台滑雪中心室内外无缝导航定位应用示范</title>
    <link rel="stylesheet" href="/lib/CheLianWang/css/common.css">
    <link rel="stylesheet" href="/lib/CheLianWang/css/map.css">
    <link href="/lib/AirportDemonstration/js/bstable/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/AirportDemonstration/js/bstable/css/bootstrap-table.css" rel="stylesheet" type="text/css" />



    <script src="/lib/CheLianWang/js/jquery-2.1.1.min.js"></script>
    <script src="/lib/CheLianWang/js/echarts.min.js"></script>
    <script src="/lib/CheLianWang/js/china.js"></script>    

    <!-- 地图开始 -->
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/dijit/themes/tundra/tundra.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/esri/css/esri.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/Ips/css/widget.css"/>
    <!-- 地图结束 -->

    <style type="text/css">
        .opacity{
            filter:alpha(Opacity=80);-moz-opacity:0.8;opacity: 0.8;
        }
        .title{
            text-align: center;
            color:#fff;
            font-size: 18px;
            font-weight: 600;
            line-height: 23px;
        }
        body{
            background: gray;

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

    <!-- 拖动框 -->
    <script type="text/javascript" src="/lib/box/box.js"></script>
    <!-- 拖动框 -->

</head>


<div class="data-title">
    <div class="title-center opacity"></div>
</div>

<img style="position: absolute;  right: 3%;top: 0%; width: 6%;z-index: 5"  src="/lib/CheLianWang/img/logo.png">

<body>

<!-- 拖动框1 -->
<div class="box" style="z-index: 1000;background-color: rgba(0,24,106,0.5); position: fixed; left: 1px;top:20%; padding: 5px;border: 1px solid #20558b;">
    <div class="title"><span>终端列表</span></div>
    <div class="con">
        <table  class="table table-bordered" style="margin: 0 auto;margin-top: 1%;font-size:13px;color: #fff; " >
            <tbody id="tab-play-grade">              
           </tbody>                                                                                                                                         
        </table>
    </div>
</div>
<!-- 拖动框1 -->


<!-- 楼层切换按钮 -->
<div class="opacity" style="position: absolute;  right: 1%;top: 20%; z-index: 5;font-size: 5;">
    <button id="btn_floor_5" class="btn btn-default" onclick="changeFloor(5)">
    &nbsp;  &nbsp;  5层 &nbsp;  &nbsp;  
    </button><br>
    <button id="btn_floor_4" class="btn btn-default" onclick="changeFloor(4)">
    &nbsp;  &nbsp;  4层 &nbsp;  &nbsp;  
    </button><br>
    <button id="btn_floor_3" class="btn btn-default" onclick="changeFloor(3)">
    &nbsp;  &nbsp;  3层 &nbsp;  &nbsp;  
    </button><br>
    <button id="btn_floor_2" class="btn btn-default" onclick="changeFloor(2)">
    &nbsp;  &nbsp;  2层 &nbsp;  &nbsp;  
    </button><br>
    <button id="btn_floor_1" class="btn btn-primary" onclick="changeFloor(1)">
    &nbsp;  &nbsp;  1层 &nbsp;  &nbsp;  
    </button><br>
    <button class="btn btn-default" onclick="toggleLocus()" id="btn-toggle-loucs">开启轨迹</button><br>
    <button class="btn btn-default" onclick="clearLocus()">清除轨迹</button> 
</div>
<!-- 楼层切换按钮 -->

<div class="data">
    <div class="data-content">

        <div class="con-center">
            <div id="map" style="position: absolute;height: 100%;width: 100%;"></div>

             <!-- 占位符 -->
            <div class="cen-top" style="height: 75%" ></div>
            <!-- 占位符 -->

             <!-- 运动速度图表 -->
            <div class="cen-bottom" id="div-sport-v" style=" height: 24%;border: 0px">
                <div style="width: 50%;display: inline-block;">
                    <span class="title">定位可信度分析:</span><span style="color: #FFF;">动态评估智能混合定位系统可信度</span>
                </div>
                <div style="width: 45%;display: inline-block;">
                    <span class="title">用户相对位置描述:</span>
                </div>
                <div id="echarts_1" class="charts" style="width: 50%;display: inline-block;"></div>
                <div style="width: 49%;display: inline-block;" >
                    <table  class="table table-bordered" style="margin: 0 auto;;font-size:12px;color: #fff;line-height: 5px " >
                        <tbody id="tab-user-desc">              
                       </tbody>                                                                                                                                         
                    </table>
                </div>

            </div>
            <!-- 运动速度图表 -->


        </div>
      
    </div>
</div>

</body>

<script type="text/javascript">
// 定义图表对象 没有myChart1、myChart2
var myChart1;
var dat_trust_level1 = [0,0,0,0,0,0];
var dat_trust_level2 = [0,0,0,0,0,0];
var dat_trust_level3 = [0,0,0,0,0,0];
var currentPlayerUid = '65239274009657347';


// 地图变量
var map; 
var mapLayer;
var poiLayer;
var patrolLayer;
var gridLayer;
var pointLayer;
var locusPointLayer1;
var locusPointLayer2;
var locusPointLayer3;
var locusPointLayer4;
var locusPointLayer5;
var currentFloor;
var IS_LOCUS = 0;
var SRC_C7_FLOOR1_MAP = "http://61.240.144.70:5567/arcgis/rest/services/C7/c7floor1/MapServer";
var SRC_DA_FLOOR1_MAP = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F1map/MapServer";
var SRC_DA_FLOOR2_MAP = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F2map/MapServer";
var SRC_DA_FLOOR3_MAP = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F3map/MapServer";
var SRC_DA_FLOOR4_MAP = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F4map/MapServer";
var SRC_DA_FLOOR5_MAP = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F5map/MapServer";
var SRC_DA_FLOOR1_POI = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F1poi/MapServer";
var SRC_DA_FLOOR2_POI = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F2poi/MapServer";
var SRC_DA_FLOOR3_POI = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F3poi/MapServer";
var SRC_DA_FLOOR4_POI = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F4poi/MapServer";
var SRC_DA_FLOOR5_POI = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F5poi/MapServer";
var SRC_DA_GRID = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/grid/MapServer";
var SRC_DA_FLOOR1_PATROL = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F1patrol/MapServer";
var SRC_DA_FLOOR3_PATROL = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F3patrol/MapServer";
var SRC_DA_FLOOR5_PATROL = "http://61.240.144.70:5567/arcgis/rest/services/Gymnasium/F5patrol/MapServer";

/**
 * 切换楼层
 * floorNum：层数 1、2、3、4、5
 */
function changeFloor(floorNum){
    require(["Ips/layers/DynamicMapServiceLayer",],
        function (DynamicMapServiceLayer) {
            map.removeLayer(mapLayer);
            map.removeLayer(poiLayer);
            map.removeLayer(gridLayer);
            
            switch(currentFloor){
                case 1:
                    map.removeLayer(locusPointLayer1);                    
                break;
                case 2:
                    map.removeLayer(locusPointLayer2);
                break;                
                case 3:
                    map.removeLayer(locusPointLayer3);
                break;
                case 4:
                    map.removeLayer(locusPointLayer4);
                break;
                case 5:
                    console.log(locusPointLayer5)
                    map.removeLayer(locusPointLayer5);      
                break;
                default:
                break;                                                                
            }

            currentFloor = floorNum;

            $('#btn_floor_1').removeClass('btn-primary');
            $('#btn_floor_2').removeClass('btn-primary');
            $('#btn_floor_3').removeClass('btn-primary');
            $('#btn_floor_4').removeClass('btn-primary');
            $('#btn_floor_5').removeClass('btn-primary');
            $('#btn_floor_1').removeClass('btn-default');
            $('#btn_floor_2').removeClass('btn-default');
            $('#btn_floor_3').removeClass('btn-default');
            $('#btn_floor_4').removeClass('btn-default');
            $('#btn_floor_5').removeClass('btn-default');            
            switch(floorNum){
               case 1:
                    $('#btn_floor_1').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_POI);
                    patrolLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_PATROL);

                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);
                    map.addLayer(patrolLayer);     
                    map.addLayer(locusPointLayer1);
                break;        
                case 2:
                    $('#btn_floor_2').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR2_MAP);
                    map.addLayer(mapLayer);
                    map.addLayer(locusPointLayer2);

                break;    
                case 3:
                    $('#btn_floor_3').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR3_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR3_POI);
                    patrolLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR3_PATROL);

                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);
                    map.addLayer(patrolLayer);     
                    map.addLayer(locusPointLayer3);

                break;    
                case 4:
                    $('#btn_floor_4').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR4_MAP);
                    map.addLayer(mapLayer);                  
                    map.addLayer(locusPointLayer4);

                break;    
                case 5:
                    $('#btn_floor_5').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR5_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR5_POI);
                    patrolLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR5_PATROL);

                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);     
                    map.addLayer(patrolLayer);     
                    map.addLayer(locusPointLayer5);

                break;
                default:
                break;                                   
            }
            gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
            map.addLayer(gridLayer);
    });
}

/**
 * 开启、关闭轨迹打印 
 */
function toggleLocus(){

    if(IS_LOCUS == 0){
        IS_LOCUS = 1;
        $('#btn-toggle-loucs').text('关闭轨迹');
        $('#btn-toggle-loucs').addClass("btn-primary");
        $('#btn-toggle-loucs').removeClass("btn-default");
    }

    else if (IS_LOCUS == 1){
        IS_LOCUS = 0;
        $('#btn-toggle-loucs').text('开启轨迹'); 
        $('#btn-toggle-loucs').addClass("btn-default");
        $('#btn-toggle-loucs').removeClass("btn-primary");
    }
}

/**
* 清除轨迹点数据
*/
function clearLocus(){

    locusPointLayer1.clear();
    locusPointLayer2.clear();
    locusPointLayer3.clear();
    locusPointLayer4.clear();
    locusPointLayer5.clear();
}
    
/**
 * 全局初始化
 */
function init(){

    /**
     * 拖动框
     */
    $(document).ready(function () {
        $(".box").bg_move({
            move: '.title',
            closed: '.open',
            size: 6
        });
    });

}

/**
 * 初始化图表1
 */
function initEchart1(){
   // 基于准备好的dom，初始化echarts实例
    myChart1 = echarts.init(document.getElementById('echarts_1'));

   
    option = {
        xAxis: {
            name:'秒(S)',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
            type: 'category',
            data: ['1', '2', '3', '4', '5'],
            axisLabel: {
                inside: false,
                textStyle: {
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '12',
                },
                // formatter:function(val){
                //     return val.split("").join("\n")
                // },
            },
        },
        yAxis: {
            name:'可信度',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },

            type: 'value',
            axisLabel: {
                textStyle: {
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '12',
                },
                formatter: '{value}',
            },
        },
        grid:{
            height:90,
            y2:30,
            textStyle: {
                color: "#fff"
            }
        },        
        series: [{
            data: [0.1,0.4,0.2,0.3,0.5],
            type: 'line',
            smooth: true,
            color:'#0000ff'
        },{
            data: [0.5,0.4,0.3,0.2,0.1],
            type: 'line',
            smooth: true,
            color:'#FF0000'
        },{
            data: [0.1,0.2,0.3,0.4,0.5],
            type: 'line',
            smooth: true,
            color:'#000000'

        }]
    };



    // 使用刚指定的配置项和数据显示图表。
    myChart1.setOption(option);
    window.addEventListener("resize",function(){
        myChart1.resize();
    });         
}


/**
 * 更新图表1
 */
function updateEchart1(dat){

	console.log(dat.data[1].level)
	console.log(dat.data[2].level)
	console.log(dat.data[3].level)

    dat_trust_level1.splice(0,1)
    dat_trust_level1.push(dat.data[1].level);
    dat_trust_level2.splice(0,1)
    dat_trust_level2.push(dat.data[2].level);
    dat_trust_level3.splice(0,1)
    dat_trust_level3.push(dat.data[3].level);

    option = {
        series: [{
            data: dat_trust_level1,
            type: 'line',
            smooth: true
        },{
            data: dat_trust_level2,
            type: 'line',
            smooth: true
        },{
            data: dat_trust_level3,
            type: 'line',
            smooth: true
        }]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart1.setOption(option);
}

/**
 * 更新表格1
 */
function updateTable1(dat){


    $('#tab-play-grade').empty();
    $('#tab-play-grade').append('<tr><td>ID</td><td>姓名</td><td>楼层</td><td>场景</td><td>定位方式</td><td>颜色</td><td>轨迹颜色</td></tr>');
    for (var i in dat.data) {
        var img_src;
        if (dat.data[i].status == 0)
            img_src = "Ips_api_javascript/Ips/image/user_blue.png";
        else if (dat.data[i].status == 1)
            img_src = "Ips_api_javascript/Ips/image/user_red.png";
        else if (dat.data[i].status == 2)
            img_src = "Ips_api_javascript/Ips/image/user_black.png";
        var img_locus_src;
        if (dat.data[i].status == 0)
            img_locus_src = "Ips_api_javascript/Ips/image/point_4.png";
        else if (dat.data[i].status == 1)
            img_locus_src = "Ips_api_javascript/Ips/image/point_3.png";
        else if (dat.data[i].status == 2)
            img_locus_src = "Ips_api_javascript/Ips/image/point_7.png";


        $('#tab-play-grade').append(
             '<tr>'+
                '<td>'+ dat.data[i].id +'</td>'+
                '<td>'+ dat.data[i].name +'</td>'+
                '<td>'+ dat.data[i].floor +'</td>'+
                '<td>'+ dat.data[i].scene +'</td>'+
                '<td>'+ dat.data[i].loc_type +'</td>'+
                '<td><img style="height:20px;width:20px" src="' + img_src +'"/></td>'+
                '<td><img style="height:20px;width:20px" src="' + img_locus_src +'"/></td>'+
            '</tr>'
        );
    }   
 
}



/**
 * 更新表格2
 */
function updateTable2(dat){


    $('#tab-user-desc').empty();
    $('#tab-user-desc').append('<tr><td>ID</td><td>姓名</td><td>相对位置</td>');
 

    for (var i in dat.data) {


        var desc = ""
        if (dat.data[i].rel_loc != null) {
            desc = dat.data[i].rel_loc[0] + ',<br><br>' + dat.data[i].rel_loc[1];
        }

        $('#tab-user-desc').append(
             '<tr>'+
                '<td>'+ dat.data[i].id +'</td>'+
                '<td>'+ dat.data[i].name +'</td>'+
                '<td>'+ desc +'</td>'+
            '</tr>'
        );
    }  
}

init();
initEchart1();
function initMapAndRefreshData(){
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

        //初始化楼层平面图
        mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_MAP);
        map.addLayer(mapLayer);

        //初始化坐标点pointLayer 用户数据点图层
        pointLayer = new GraphicsLayer();
        map.addLayer(pointLayer);

        //初始化路网
        poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_POI);
        map.addLayer(poiLayer);


        //初始化路网
        patrolLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_PATROL);
        map.addLayer(patrolLayer);

        //初始化网格
        gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
        map.addLayer(gridLayer);


        currentFloor = 1;
        //初始化轨迹点pointLayer 用户数据点图层
        locusPointLayer1 = new GraphicsLayer();
        locusPointLayer2 = new GraphicsLayer();
        locusPointLayer3 = new GraphicsLayer();
        locusPointLayer4 = new GraphicsLayer();
        locusPointLayer5 = new GraphicsLayer();
        map.addLayer(locusPointLayer1);



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
        function addUserPoint(id, x, y, name, status) {

            //定义点的几何体
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //定义点的图片符号
            var picSymbol;
            if (status == 0)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/user_blue.png", 32, 32);
            else if (status == 1)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/user_red.png", 32, 32);
            else if (status == 2)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/user_black.png", 32, 32);

            //定义点的图片符号
            var attr = {"name": name};
            //信息模板
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle('人员');

            infoTemplate.setContent(
                "<b>名称:</b><span>${name}</span><br>"
                + "<b>手机号:</b><span>${phone}</span><br><br>"
                + "<input id='input-send-msg',class='form-control'>"
                + "<button class='' onclick=sendSingleMsg() >发送</button>"

            );
            var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
            pointLayer.add(picgr);
        }

        /**
         * 添加轨迹点数据
         */
        function addLocusUserPoint(id, x, y, name, status,floor){
            //定义点的几何体
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            var picSymbol;
            if (status == 0)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_4.png", 16, 16);
            else if (status == 1)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_3.png", 16, 16);
            else if (status == 2)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_7.png", 16, 16);

            var picgr = new Graphic(picpoint, picSymbol);

            switch(floor){
                case 1:
                    locusPointLayer1.add(picgr);
                break;
                case 2:
                    locusPointLayer2.add(picgr);
                break;
                case 3:
                    locusPointLayer3.add(picgr);
                break;
                case 4:
                    locusPointLayer4.add(picgr);
                break;
                case 5:
                    locusPointLayer5.add(picgr);
                break;
                default:
                break;                                                                                
            }
            
        }
        
        /**
         * [更新地图]
         */
        function updateMap(dat){
            // 清空图层
            pointLayer.clear();

            if (currentFloor != dat.data[1].floor)
                changeFloor(dat.data[1].floor)
            // 添加人
            for (var i in dat.data) {
                if(dat.data[i].floor == currentFloor){

                    //打点
                    addUserPoint(
                        dat.data[i].id,
                        dat.data[i].coord[1],
                        dat.data[i].coord[0],
                        dat.data[i].name,
                        dat.data[i].status
                    );
                    // 轨迹
                    if(IS_LOCUS)
                        //用户轨迹点
                        addLocusUserPoint(
                            dat.data[i].id,
                            dat.data[i].coord[1],
                            dat.data[i].coord[0],
                            dat.data[i].name,
                            dat.data[i].status,
                            dat.data[i].floor
                        );
                }
            }
        }



        /**
         * 从云定位端读取转发器列表数据数据并更新界面
         */
        function getData() {

            // 从云端读取数据
            $.get("http://61.240.144.70:6008/users",
                {},
                function (dat, status) {
                    if (dat.code == 0) {
                        updateMap(dat);
                        updateTable1(dat);
                        updateTable2(dat);
                        updateEchart1(dat);

                    } else {
                        console.log('ajax error!');
                    }
                }
            );
        }

        //循环执行
        setInterval(getData, (1 * 1000));

    });    
}

initMapAndRefreshData();

</script>
</html>