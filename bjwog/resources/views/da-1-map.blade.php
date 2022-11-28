<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>2022北京-张家口冬奥会跳台滑雪中心室内外无缝导航定位应用示范</title>
    <link rel="stylesheet" href="/lib/CheLianWang/css/common.css">
    <link rel="stylesheet" href="/lib/CheLianWang/css/map.css">
    <link href="/lib/AirportDemonstration/js/bstable/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/AirportDemonstration/js/bstable/css/bootstrap-table.css" rel="stylesheet" type="text/css" />

    <!-- MD5 -->
    <script src="https://cdn.bootcss.com/blueimp-md5/2.10.0/js/md5.js"></script>
    <!-- MD5 -->

    <!-- 极光云推送 -->
    <script src='/js/jmessage-sdk-web.2.6.0.min.js'></script>
    <!-- 极光云推送 -->

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
        	background: #000;

        }
    </style>

    <!-- jq -->
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <!-- jq -->

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

    <!-- tools -->
    <script type="text/javascript" src="/js/tools.js"></script>
    <!-- tools-->
</head>

<!-- 切换按钮 -->
<button style="position: absolute;  left:  2%;top: 0%;z-index: 5" class="btn"><a href="/DA3DMap">三维地图</a></button>
<!-- 切换按钮 -->

<!-- logo -->
<img style="position: absolute;  right: 3%;top: 0%; width: 6%;z-index: 5"  src="/lib/CheLianWang/img/logo.png">
<!-- logo -->




<!-- 拖动框1 -->
<div class="box" style="z-index: 1000;background-color: rgba(0,24,106,0.5); position: fixed; left: 1px;top:20%; padding: 5px;border: 1px solid #20558b;">
    <div class="title"><span>排名</span></div>
    <div class="con">
        <table  class="table table-bordered" style="margin: 0 auto;margin-top: 19%;font-size:13px;color: #fff; " >
            <tbody id="tab-play-grade">
                <tr>
                    <td>排名</td>
                    <td>姓名</td>
                    <td>成绩</td>                                    
                </tr>
                <tr>
                    <td>1</td>
                    <td>运动员1</td>
                    <td>999.9</td>
                </tr>     
                <tr>
                    <td>2</td>
                    <td>运动员2</td>
                    <td>999.9</td>
                </tr>  
                <tr>
                    <td>3</td>
                    <td>运动员3</td>
                    <td>999.9</td>
                </tr>                 
           </tbody>                                                                                                                                         
        </table>
    </div>
</div>
<!-- 拖动框1 -->

<!-- 拖动框2 -->
<div class="box" style="z-index: 1000;background-color: rgba(0,24,106,0.5); position: fixed; right: 1px;top:0px;padding: 5px;border: 1px solid #20558b; width: 200px;top: 20%">
    <div class="right-top">
        <div class="title" >定位质量</div>
        <div id="echarts_4" class="charts" style="height: 150px"></div>

    </div>
    <div class="right-center">
        <div class="title">定位精度</div>
        <div id="echarts_5" class="charts" style="height: 150px"></div>

    </div>
    <!-- <div class="right-bottom">
        <div class="title">定位连续性</div>
    
            <table class="table table-bordered" style=" margin: 0 auto;margin-top: 1%;font-size:8px;color: white ">
                <tbody >
                    <tr>
                        <td>标题1</td>
                        <td>标题2</td>
                        <td>标题3</td>
                        
                    </tr>
                    <tr>
                        <td>111</td>
                        <td>111</td>
                        <td>111</td>
                    </tr>                                    
                </tbody>
            </table>
    </div>        -->
</div>
<!-- 拖动框2 -->

<!-- 楼层切换按钮 -->
<div class="opacity" style="position: absolute;  left: 1%;top: 20%; z-index: 5;font-size: 5;">
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

<!-- 大标题 -->
<div class="data-title">
    <div class="title-center opacity"></div>
</div>
<!-- 大标题 -->
<body>

<div class="data">
    <div class="data-content">
        <div class="con-center">
            <div id="map" style="position: absolute;height: 100%;width: 100%;"></div>
            
            <!-- 占位符 -->
            <div class="cen-top" ></div>
            <!-- 占位符 -->
            
            <!-- 运动速度图表 -->
            <div class="cen-bottom ">
                <div class="title" style="text-align: left;">运动速度</div>
                <div id="echarts_3" class="charts"></div>
            </div>
            <!-- 运动速度图表 -->

            <!-- 定位网络图表 -->
           <div style="width: 100%;height: 7%;background-color: rgba(0,24,106,0.5);border: 1px solid #20558b;box-sizing: border-box;position: relative; ">
                <span class="title" style="margin-right: 1%">定位网络</span>
                <img id="img_bd" style="width: 2%;margin-left: 8%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/bd.png">
            	<img id="img_bluetooth" style="width: 2%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/bluetooth.png">
            	<img id="img_satelite" style="width: 2%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/satelite.png">
            	<img id="img_vision" style="width: 2%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/vision.png">
                <img id="img_rtk" style="width: 2%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/rtk.png">
                <img id="img_ins" style="width: 2%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/ins.png">
                <img id="img_dc" style="width: 2%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/dc.png">
            	<img id="img_5g" style="width: 2%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/5g.png">
            </div>
            <!-- 定位网络图表 -->
            
        </div>
    </div>
</div>
</body>

<script type="text/javascript">


// 更新频率 单位：秒
INTERVAL_TIME = 2;

// 定义图表对象 没有myChart1、myChart2
var myChart3;
var myChart4;
var myChart5;
var dat_v = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

// 当前是否有下列的定位方式
var positionTypeBd = 0;
var positionTypeBluetooth = 0;
var positionTypeSatelite = 1;
var positionTypeVision = 0;
var positionTypeRtk = 1;
var positionTypeIns = 0;
var positionTypeDc = 0;
var positionType5G = 1;

// 地图变量
var map; 
var mapLayer;
var poiLayer;
var gridLayer;
var pointLayer;
var LocusPointLayer;
var currentFloor;
var IS_LOCUS = 0;
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
//当前定位方式的显示状态(visibility) 0:hidden 1:visible
var currentVisibilityPositionTypeBd = 1;
var currentVisibilityPositionTypeBluetooth = 1;
var currentVisibilityPositionTypeSatelite = 1;
var currentVisibilityPositionTypeVision = 1;
var currentVisibilityPositionTypeRtk = 1;
var currentVisibilityPositionTypeIns = 1;
var currentVisibilityPositionTypeDc = 1;
var currentVisibilityPositionType5G = 1;

//极光云参数初始化
JG_APP_KEY = '{{ $appkey }}'; 
JG_MASTER_SECRET = '{{ $master_secret }}';
RANDOM_STR = "qwerty1234567jde3d32dad"; //固定乱码
USER_NAME = 'AQJK_SERVER';
PASSWORD = '123456';
window.JIM = new JMessage({debug : true}); //极光云对象
JIM.onDisconnect(function(){console.log("【disconnect】");}); //异常断线监听

/**
 * 极光云初始化
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

/**
 * 极光云注册
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
 * 极光云发送消息
 */
function sendSingleMsg(uid) {
    var content;
    content = $('#input-send-msg').val();

    console.log("uid is ---------------------------",uid);

    JIM.sendSingleMsg({
        'target_username' : uid,
        'content' : content,
        'no_offline' : false,
        'no_notification' : false,
        need_receipt:true
    }).onSuccess(function(data,msg) {
        notify('发送成功！', 'user');
    }).onFail(function(data) {
        notify('发送失败！', 'warning');

        console.log('error:' + JSON.stringify(data));
    });
}

/**
 * 使定位方式图表闪烁
 */
function twinklePositionType(){
    setInterval(function(){
        if (positionTypeBd) {
            if (currentVisibilityPositionTypeBd) {
                currentVisibilityPositionTypeBd = 0;
                $('#img_bd').css('visibility','visible');
            }else{
                currentVisibilityPositionTypeBd = 1;
                $('#img_bd').css('visibility','hidden');            
            }
        }        
        if (positionTypeBluetooth) {
            if (currentVisibilityPositionTypeBluetooth) {
                currentVisibilityPositionTypeBluetooth = 0;
                $('#img_bluetooth').css('visibility','visible');
            }else{
                currentVisibilityPositionTypeBluetooth = 1;
                $('#img_bluetooth').css('visibility','hidden');            
            }
        }
        if (positionTypeSatelite) {
            if (currentVisibilityPositionTypeSatelite) {
                currentVisibilityPositionTypeSatelite = 0;
                $('#img_satelite').css('visibility','visible');
            }else{
                currentVisibilityPositionTypeSatelite = 1;
                $('#img_satelite').css('visibility','hidden');            
            }
        }
        if (positionTypeVision) {
            if (currentVisibilityPositionTypeVision) {
                currentVisibilityPositionTypeVision = 0;
                $('#img_vision').css('visibility','visible');
            }else{
                currentVisibilityPositionTypeVision = 1;
                $('#img_vision').css('visibility','hidden');            
            }
        }
        if (positionTypeRtk) {
            if (currentVisibilityPositionTypeRtk) {
                currentVisibilityPositionTypeRtk = 0;
                $('#img_rtk').css('visibility','visible');
            }else{
                currentVisibilityPositionTypeRtk = 1;
                $('#img_rtk').css('visibility','hidden');            
            }
        }
        if (positionTypeIns) {
            if (currentVisibilityPositionTypeIns) {
                currentVisibilityPositionTypeIns = 0;
                $('#img_ins').css('visibility','visible');
            }else{
                currentVisibilityPositionTypeIns = 1;
                $('#img_ins').css('visibility','hidden');            
            }
        }
        if (positionTypeDc) {
            if (currentVisibilityPositionTypeDc) {
                currentVisibilityPositionTypeDc = 0;
                $('#img_dc').css('visibility','visible');
            }else{
                currentVisibilityPositionTypeDc = 1;
                $('#img_dc').css('visibility','hidden');            
            }
        }
        if (positionType5G) {
            if (currentVisibilityPositionType5G) {
                currentVisibilityPositionType5G = 0;
                $('#img_5g').css('visibility','visible');
            }else{
                currentVisibilityPositionType5G = 1;
                $('#img_5g').css('visibility','hidden');            
            }
        }
    }, (0.5 * 1000));
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

    LocusPointLayer.clear();
}

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
                    currentFloor = floorNum;
                    $('#btn_floor_1').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_POI);
                    gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);
                    map.addLayer(gridLayer);

                break;        
                case 2:
                    currentFloor = floorNum;
                    $('#btn_floor_2').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR2_MAP);
                    gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
                    map.addLayer(mapLayer);
                    map.addLayer(gridLayer);
                break;    
                case 3:
                    currentFloor = floorNum;
                    $('#btn_floor_3').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR3_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR3_POI);
                    gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);
                    map.addLayer(gridLayer);
                break;    
                case 4:
                    currentFloor = floorNum;
                    $('#btn_floor_4').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR4_MAP);
                    gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
                    map.addLayer(mapLayer);   
                    map.addLayer(gridLayer);               
                break;    
                case 5:
                    currentFloor = floorNum;
                    $('#btn_floor_5').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR5_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR5_POI);
                    gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);  
                    map.addLayer(gridLayer);   
                break;
                default:
                break;                                   
        }
    });
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

    /**
     * 图标闪烁
     */
    twinklePositionType();

    /**
     * 极光初始化
     */
    jgInit();
}

/**
 * 初始化图表3
 */
function initEchart3(){
    // 基于准备好的dom，初始化echarts实例
    myChart3 = echarts.init(document.getElementById('echarts_3'));

    option = {
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            orient: 'vertical',
            data:['简易程序案件数']
        },
        grid: {
            left: '3%',
            right: '3%',
            top:'8%',
            bottom: '5%',
            containLabel: true
        },
        color:['#a4d8cc','#25f3e6'],
        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },

        calculable : true,
        xAxis : [
            {
                type : 'category',

                axisTick:{show:false},

                boundaryGap : false,
                axisLabel: {
                    textStyle:{
                        color: '#ccc',
                        fontSize:'12'
                    },
                    lineStyle:{
                        color:'#2c3459',
                    },
                    interval: {default: 0},
                    rotate:50,
                    formatter : function(params){
                        var newParamsName = "";// 最终拼接成的字符串
                        var paramsNameNumber = params.length;// 实际标签的个数
                        var provideNumber = 4;// 每行能显示的字的个数
                        var rowNumber = Math.ceil(paramsNameNumber / provideNumber);// 换行的话，需要显示几行，向上取整
                        /**
                         * 判断标签的个数是否大于规定的个数， 如果大于，则进行换行处理 如果不大于，即等于或小于，就返回原标签
                         */
                        // 条件等同于rowNumber>1
                        if (paramsNameNumber > provideNumber) {
                            /** 循环每一行,p表示行 */
                            var tempStr = "";
                            tempStr=params.substring(0,4);
                            newParamsName = tempStr+"...";// 最终拼成的字符串
                        } else {
                            // 将旧标签的值赋给新标签
                            newParamsName = params;
                        }
                        //将最终的字符串返回
                        return newParamsName
                    }

                },
                data: ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17'
                    ,'18','19','20','21','22','23']
            }
        ],
        yAxis : {

            type : 'value',
            axisLabel: {
                textStyle: {
                    color: '#ccc',
                    fontSize:'12',
                }
            },
            axisLine: {
                lineStyle:{
                    color:'rgba(160,160,160,0.3)',
                }
            },
            splitLine: {
                lineStyle:{
                    color:'rgba(160,160,160,0.3)',
                }
            },

        }
        ,
        series : [
            {
                // name:'简易程序案件数',
                type:'line',
                areaStyle: {

                    normal: {type: 'default',
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 0.8, [{
                            offset: 0,
                            color: '#25f3e6'
                        }, {
                            offset: 1,
                            color: '#0089ff'
                        }], false)
                    }
                },
                smooth:true,
                itemStyle: {
                    normal: {areaStyle: {type: 'default'}}
                },
                data:dat_v
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart3.setOption(option);
    window.addEventListener("resize",function(){
        myChart3.resize();
    });
}

/**
 * 初始化图表4
 */
function initEchart4(){
   // 基于准备好的dom，初始化echarts实例
    myChart4 = echarts.init(document.getElementById('echarts_4'));

    var xData = function() {
        var data = ['1号','2号','3号'];

        return data;
    }();

    var data = [0,0,0]

    option = {
        // backgroundColor: "#141f56",

        tooltip: {
            show: "true",
            trigger: 'item',
            backgroundColor: 'rgba(0,0,0,0.4)', // 背景
            padding: [8, 10], //内边距
            // extraCssText: 'box-shadow: 0 0 3px rgba(255, 255, 255, 0.4);', //添加阴影
            formatter: function(params) {
                if (params.seriesName != "") {
                    return params.name + ' ：  ' + params.value ;
                }
            },

        },
        grid: {
            borderWidth: 0,
            top: 20,
            bottom: 35,
            left:55,
            right:30,
            textStyle: {
                color: "#fff"
            }
        },
        xAxis: [{
            type: 'category',

            axisTick: {
                show: false
            },
            axisLine: {
                show: true,
                lineStyle: {
                    color: '#363e83',
                }
            },
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
            data: xData,
        }, {
            type: 'category',
            axisLine: {
                show: false
            },
            axisTick: {
                show: false
            },
            axisLabel: {
                show: false
            },
            splitArea: {
                show: false
            },
            splitLine: {
                show: false
            },
            data: xData,
        }],
        yAxis: {
            type: 'value',
            axisTick: {
                show: false
            },
            axisLine: {
                show: true,
                lineStyle: {
                    color: '#32346c',
                }
            },
            splitLine: {
                show: true,
                lineStyle: {
                    color: '#32346c ',
                }
            },
            axisLabel: {
                textStyle: {
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '12',
                },
                formatter: '{value}',
            },
        },
        series: [{
            // name: '生师比(%)',
            type: 'bar',
            itemStyle: {
                normal: {
                    show: true,
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: '#00c0e9'
                    }, {
                        offset: 1,
                        color: '#3b73cf'
                    }]),
                    barBorderRadius: 50,
                    borderWidth: 0,
                },
                emphasis: {
                    shadowBlur: 15,
                    shadowColor: 'rgba(105,123, 214, 0.7)'
                }
            },
            zlevel: 2,
            barWidth: '20%',
            data: data,
        },
            {
                name: '',
                type: 'bar',
                xAxisIndex: 1,
                zlevel: 1,
                itemStyle: {
                    normal: {
                        color: '#121847',
                        borderWidth: 0,
                        shadowBlur: {
                            shadowColor: 'rgba(255,255,255,0.31)',
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowOffsetY: 2,
                        },
                    }
                },
                barWidth: '20%',
                data: [5, 5, 5]
            }
        ]
    }


    // 使用刚指定的配置项和数据显示图表。
    myChart4.setOption(option);
    window.addEventListener("resize",function(){
        myChart4.resize();
    });	
}

/**
 * 初始化图表5
 */
function initEchart5(){
   // 基于准备好的dom，初始化echarts实例
    myChart5 = echarts.init(document.getElementById('echarts_5'));

    option = {

        tooltip : {
            trigger: 'item',
            formatter: "{b}: <br/>  {c} ({d}%)"
        },

        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {
                    show: true,
                    type: ['pie', 'funnel']
                },
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        series : [

            {
                name:'排名',
                type:'pie',
                color: ['#af89d6', '#f5c847', '#ff999a', '#0089ff','#25f3e6'],
                radius : [20, 40],
                center : ['50%', '50%'],
                roseType : 'area',
                data:[
                    {value:1, name:'1号'},
                    {value:1, name:'2号'},
                    {value:1, name:'3号'},
                ]
            }
        ]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart5.setOption(option);
    window.addEventListener("resize",function(){
        myChart5.resize();
    });        	
}

/**
 * 更新图表3
 */
function updateEchart3(dat){

    console.log(dat.data.plays[0].v);

    dat_v.splice(0,1);
    dat_v.push(dat.data.plays[0].v);

    option = {
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            orient: 'vertical',
            data:['简易程序案件数']
        },
        grid: {
            left: '3%',
            right: '3%',
            top:'8%',
            bottom: '5%',
            containLabel: true
        },
        color:['#a4d8cc','#25f3e6'],
        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },

        calculable : true,
        xAxis : [
            {
                type : 'category',

                axisTick:{show:false},

                boundaryGap : false,
                axisLabel: {
                    textStyle:{
                        color: '#ccc',
                        fontSize:'12'
                    },
                    lineStyle:{
                        color:'#2c3459',
                    },
                    interval: {default: 0},
                    rotate:50,
                    formatter : function(params){
                        var newParamsName = "";// 最终拼接成的字符串
                        var paramsNameNumber = params.length;// 实际标签的个数
                        var provideNumber = 4;// 每行能显示的字的个数
                        var rowNumber = Math.ceil(paramsNameNumber / provideNumber);// 换行的话，需要显示几行，向上取整
                        /**
                         * 判断标签的个数是否大于规定的个数， 如果大于，则进行换行处理 如果不大于，即等于或小于，就返回原标签
                         */
                        // 条件等同于rowNumber>1
                        if (paramsNameNumber > provideNumber) {
                            /** 循环每一行,p表示行 */
                            var tempStr = "";
                            tempStr=params.substring(0,4);
                            newParamsName = tempStr+"...";// 最终拼成的字符串
                        } else {
                            // 将旧标签的值赋给新标签
                            newParamsName = params;
                        }
                        //将最终的字符串返回
                        return newParamsName
                    }

                },
                data: ['0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17'
                    ,'18','19','20','21','22','23']
            }
        ],
        yAxis : {

            type : 'value',
            axisLabel: {
                textStyle: {
                    color: '#ccc',
                    fontSize:'12',
                }
            },
            axisLine: {
                lineStyle:{
                    color:'rgba(160,160,160,0.3)',
                }
            },
            splitLine: {
                lineStyle:{
                    color:'rgba(160,160,160,0.3)',
                }
            },

        }
        ,
        series : [
            {
                // name:'简易程序案件数',
                type:'line',
                areaStyle: {

                    normal: {type: 'default',
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 0.8, [{
                            offset: 0,
                            color: '#25f3e6'
                        }, {
                            offset: 1,
                            color: '#0089ff'
                        }], false)
                    }
                },
                smooth:true,
                itemStyle: {
                    normal: {areaStyle: {type: 'default'}}
                },
                data:dat_v
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    myChart3.setOption(option);
}

/**
 * 更新图表4
 */
function updateEchart4(dat){
    var xData = function() {
        var data = [];
        data.push(dat.data.plays[0].name);
        data.push(dat.data.plays[1].name);
        data.push(dat.data.plays[2].name);
        return data;
    }();

    var data = [];
    data.push(dat.data.plays[0].quality);
    data.push(dat.data.plays[1].quality);
    data.push(dat.data.plays[2].quality);


    option = {
        // backgroundColor: "#141f56",

        tooltip: {
            show: "true",
            trigger: 'item',
            backgroundColor: 'rgba(0,0,0,0.4)', // 背景
            padding: [8, 10], //内边距
            // extraCssText: 'box-shadow: 0 0 3px rgba(255, 255, 255, 0.4);', //添加阴影
            formatter: function(params) {
                if (params.seriesName != "") {
                    return params.name + ' ：  ' + params.value;
                }
            },

        },
        grid: {
            borderWidth: 0,
            top: 20,
            bottom: 35,
            left:55,
            right:30,
            textStyle: {
                color: "#fff"
            }
        },
        xAxis: [{
            type: 'category',

            axisTick: {
                show: false
            },
            axisLine: {
                show: true,
                lineStyle: {
                    color: '#363e83',
                }
            },
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
            data: xData,
        }, {
            type: 'category',
            axisLine: {
                show: false
            },
            axisTick: {
                show: false
            },
            axisLabel: {
                show: false
            },
            splitArea: {
                show: false
            },
            splitLine: {
                show: false
            },
            data: xData,
        }],
        yAxis: {
            type: 'value',
            axisTick: {
                show: false
            },
            axisLine: {
                show: true,
                lineStyle: {
                    color: '#32346c',
                }
            },
            splitLine: {
                show: true,
                lineStyle: {
                    color: '#32346c ',
                }
            },
            axisLabel: {
                textStyle: {
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '12',
                },
                formatter: '{value}',
            },
        },
        series: [{
            // name: '生师比(%)',
            type: 'bar',
            itemStyle: {
                normal: {
                    show: true,
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                        offset: 0,
                        color: '#00c0e9'
                    }, {
                        offset: 1,
                        color: '#3b73cf'
                    }]),
                    barBorderRadius: 50,
                    borderWidth: 0,
                },
                emphasis: {
                    shadowBlur: 15,
                    shadowColor: 'rgba(105,123, 214, 0.7)'
                }
            },
            zlevel: 2,
            barWidth: '20%',
            data: data,
        },
            {
                name: '',
                type: 'bar',
                xAxisIndex: 1,
                zlevel: 1,
                itemStyle: {
                    normal: {
                        color: '#121847',
                        borderWidth: 0,
                        shadowBlur: {
                            shadowColor: 'rgba(255,255,255,0.31)',
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowOffsetY: 2,
                        },
                    }
                },
                barWidth: '20%',
                data: [5, 5, 5]
            }
        ]
    }


    // 使用刚指定的配置项和数据显示图表。
    myChart4.setOption(option);
}

/**
 * 更新图表5
 */
function updateEchart5(dat){
    data = [];
    data.push({value:dat.data.plays[0].accuracy,name:dat.data.plays[0].name});
    data.push({value:dat.data.plays[1].accuracy,name:dat.data.plays[1].name});
    data.push({value:dat.data.plays[2].accuracy,name:dat.data.plays[2].name});

    option = {
        tooltip : {
            trigger: 'item',
            formatter: "{b}: <br/>  {c} ({d}%)"
        },

        toolbox: {
            show : false,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {
                    show: true,
                    type: ['pie', 'funnel']
                },
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        series : [

            {
                name:'排名',
                type:'pie',
                color: ['#af89d6', '#f5c847', '#ff999a', '#0089ff','#25f3e6'],
                radius : [20, 40],
                center : ['50%', '50%'],
                roseType : 'area',
                data:data
            }
        ]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart5.setOption(option);
}

/**
 * 更新Echart
 */        
function updateEchart(dat){
    // 运动速度
    updateEchart3(dat);
    updateEchart4(dat);
    updateEchart5(dat);
}

/**
 * 更新图表1
 */
function updateTable1(dat){

}

/**
 * 更新图表2
 */
function updateTable2(dat){

    var grade_list_before_sort = [];
    var grade_list_sort = [];
    for(var i in dat.data.plays)
        grade_list_before_sort.push({name:dat.data.plays[i].name,grade:dat.data.plays[i].grade});

    //排序
    while(grade_list_before_sort.length != 0){


        if (grade_list_before_sort.length == 1) {
            grade_list_sort.push(grade_list_before_sort[0]);
            grade_list_before_sort.splice(0,1);
        }else{
            is_biggest = 1;
            for (var i = 1; i < grade_list_before_sort.length; i++) {
                if(grade_list_before_sort[0].grade < grade_list_before_sort[i].grade){
                    is_biggest = 0;
                }
            }
            if (is_biggest) {
                grade_list_sort.push(grade_list_before_sort[0]);
                grade_list_before_sort.splice(0,1);
            }else{
                grade_list_before_sort.push(grade_list_before_sort[0]);
                grade_list_before_sort.splice(0,1);
            }
           
        }
    }
    

    $('#tab-play-grade').empty();
    $('#tab-play-grade').append('<tr><td>排名</td><td>姓名</td><td>成绩</td></tr>');

    for (var i = 0; i < grade_list_sort.length; i++) {
        position = i + 1;
        $('#tab-play-grade').append(
             '<tr>'+
                '<td>'+ position +'</td>'+
                '<td>'+ grade_list_sort[i].name +'</td>'+
                '<td>'+ grade_list_sort[i].grade +'</td>'+
            '</tr>'
        );
    }    
}

/**
 * 更新表格
 */
function updateTable(dat){
    updateTable1(dat);
    updateTable2(dat);
}
/**
 * 更新定位网络图标
 */
function updateTwinklePositionType(dat){

}

/**
 * 初始化地图；更新地图、图表、表格数据
 */
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

        //初始化路网
        poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR1_POI);
        map.addLayer(poiLayer);
        currentFloor = 1;

        //初始化网格
        gridLayer = new DynamicMapServiceLayer(SRC_DA_GRID);
        map.addLayer(gridLayer);

        //初始化坐标点pointLayer 用户数据点图层
        pointLayer = new GraphicsLayer();
        map.addLayer(pointLayer);

        //初始化轨迹点pointLayer 用户数据点图层
        LocusPointLayer = new GraphicsLayer();
        map.addLayer(LocusPointLayer);

         /**
         * 添加用戶點
         */
        function addUserPoint(id, x, y, name, phone, uid, status) {

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
         * 添加轨迹点数据
         */
        function addLocusUserPoint(id, x, y, name, phone, uid, status,color){
            if(color == undefined) 
                color = "red";
            //定义点的几何体
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //定义点的图片符号
            var picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_"+ color +".png", 28, 28);
            var picgr = new Graphic(picpoint, picSymbol);
            LocusPointLayer.add(picgr);
        }

        /**
         * [更新地图]
         */
        function updateMap(dat){
            // 清空图层
            pointLayer.clear();

            // 添加人
            for (var i in dat.data.users) {
                if(dat.data.users[i].floor == currentFloor){
                    //打点
                    addUserPoint(
                        dat.data.users[i].id,
                        dat.data.users[i].y,
                        dat.data.users[i].x,
                        dat.data.users[i].name,
                        dat.data.users[i].phone,
                        dat.data.users[i].uid,
                        dat.data.users[i].status
                    );
                    // 轨迹
                    if(IS_LOCUS)
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
                }
            }
        }

        /**
         * 从服务器读取转发器列表数据数据并更新界面
         */
        function getData() {

            // 从云端读取数据
            $.post("/api/getAllPlayerLocation",
                {},
                function (dat, status) {

                    if (dat.status == 0) {
                        updateMap(dat);
                        updateEchart(dat);
                        updateTable(dat);
                        updateTwinklePositionType(dat);
                    } else {
                        console.log('ajax error!');
                    }
                }
            );
        }

        //循环执行
        setInterval(getData, (INTERVAL_TIME * 1000));

    });    
}


init();
initEchart3();
initEchart4();
initEchart5();
initMapAndRefreshData();

</script>
</html>