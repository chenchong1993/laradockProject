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
        .data-title>.title-center{
                width: 100%;
                height: 100%;
                box-sizing: border-box;
                background: url("/lib/CheLianWang/img/title-player.png") no-repeat;
                background-position:center;
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
<button style="position: absolute;  left:  2%;top: 0%;z-index: 5" class="btn"><a href="/DA2Map">二维地图</a></button>
<!-- 切换按钮 -->

<!-- logo -->
 <img  style="position: absolute;  right: 3%;top: 0%; width: 6%;z-index: 5"  src="/lib/CheLianWang/img/logo.png" onclick="toggleBottomDiv()" >
 <!-- <img  style="position: absolute;  right: 3%;top: 0%; width: 6%;z-index: 5"  src="/lib/CheLianWang/img/cepnt.jpg" onclick="toggleBottomDiv()" > -->
<!-- logo -->

<!-- 拖动框1 -->
<div class="box" style="z-index: 1000;background-color: rgba(0,24,106,0.5); position: fixed; left: 1px;top:20%; padding: 5px;border: 1px solid #20558b;">
    <div class="title"><span>运动员列表</span></div>
    <div class="con">
        <table  class="table table-bordered" style="margin: 0 auto;margin-top: 19%;font-size:13px;color: #fff; " >
            <tbody id="tab-play-grade">
                <tr>
                    <td>排名</td>
                    <td>姓名</td>
                    <td>位置</td>                                    
                </tr>
                <tr>
                    <td>1</td>
                    <td>运动员1</td>
                    <td>1,1,1</td>
                </tr>     
                <tr>
                    <td>2</td>
                    <td>运动员2</td>
                    <td>1,1,1</td>
                </tr>  
                <tr>
                    <td>3</td>
                    <td>运动员3</td>
                    <td>1,1,1</td>
                </tr>                 
           </tbody>                                                                                                                                         
        </table>
        <br>
        <div class="right-center">
            <div class="title"><span>定位信息:</span> <span class="span-player-name">1号</span>运动员</div>
            <div class="con">
            <table  class="table table-bordered" style="margin: 0 auto;margin-top: 19%;font-size:13px;color: #fff; " >
                <tbody id="tab-location-info">

               </tbody>                                                                                                                                         
            </table>
            </div>
        </div>
    </div>
</div>
<!-- 拖动框1 -->


<!-- 弹出框1 -->
<div class="box" id="div_location_info_1" style="width: 1250px;height: 430px;background-color: rgba(0,24,106,0.5); position: fixed; left: 20%;top:20%; padding: 5px;border: 1px solid #20558b; opacity: 0.97;visibility:hidden;z-index: 999 ">
    <div class="con"  >
        <div id="location_info_echarts_1" style="width: 900px;height: 430px;display: inline-block;" class="charts"></div>
        <div style="width: 300px;height: 400px;display: inline-block;color: #fff;margin-top: 30px;">
             <table  class="table table-bordered"  >
                <tbody id="tab-location-info-1">
               </tbody>                                                                                                                                         
            </table>
        </div>
    </div>
</div>
<!-- 弹出框1 -->
<!-- 弹出框2 -->
<div class="box" id="div_location_info_2" style="width: 900px;height: 430px;background-color: rgba(0,24,106,0.5); position: fixed; left: 20%;top:20%; padding: 5px;border: 1px solid #20558b; opacity: 0.97;visibility:hidden;z-index: 999 ">
    <div class="con"  >
        <div id="location_info_echarts_2" style="width: 900px;height: 430px;display: inline-block;" class="charts"></div>
    </div>
</div>
<!-- 弹出框2 -->
<!-- 弹出框3 -->
<div class="box" id="div_location_info_3" style="width: 900px;height: 430px;background-color: rgba(0,24,106,0.5); position: fixed; left: 20%;top:20%; padding: 5px;border: 1px solid #20558b; opacity: 0.97;visibility:hidden;z-index: 999 ">
    <div class="con"  >
        <div id="location_info_echarts_3" style="width: 900px;height: 430px;display: inline-block;" class="charts"></div>
    </div>
</div>
<!-- 弹出框3 -->
<!-- 弹出框4 -->
<div class="box" id="div_location_info_4" style="width: 900px;height: 430px;background-color: rgba(0,24,106,0.5); position: fixed; left: 20%;top:20%; padding: 5px;border: 1px solid #20558b; opacity: 0.97;visibility:hidden;z-index: 999 ">
    <div class="con"  >
        <div id="location_info_echarts_4" style="width: 900px;height: 430px;display: inline-block;" class="charts"></div>
    </div>
</div>
<!-- 弹出框4 -->
<!-- 弹出框5 -->
<div class="box" id="div_location_info_5" style="width: 900px;height: 430px;background-color: rgba(0,24,106,0.5); position: fixed; left: 20%;top:20%; padding: 5px;border: 1px solid #20558b; opacity: 0.97;visibility:hidden;z-index: 999 ">
    <div class="con"  >
        <div id="location_info_echarts_5" style="width: 900px;height: 430px;display: inline-block;" class="charts"></div>
    </div>
</div>
<!-- 弹出框5 -->
<!-- 大标题 -->
<div class="data-title">
    <div class="title-center opacity"></div>
</div>
<!-- 大标题 -->
<body>

<div class="data">
    <div class="data-content">
        <div class="con-center">

            <!-- <iframe src="http://61.240.144.70:5604/mapSelect?uid=32771028388151306&address=%E5%86%AC%E5%A5%A5%E4%BC%9A" id="map" style="position: absolute;height: 100%;width: 100%;"></iframe> -->
            <!-- http://124.70.129.134:8216/apps/dongao/#/3d -->
            <iframe src="http://124.70.129.134:8216/apps/dongao/#/3d" id="map" style="position: absolute;height: 100%;width: 100%;"></iframe>
            <!-- 占位符 -->
            <div class="cen-top" ></div>
            <!-- 占位符 -->
            
            <!-- 运动速度图表 -->
            <div class="cen-bottom" id="div-sport-v">
                <div style="width: 25%;display: inline-block;">
                    <span class="title">运动速度:</span><br>
                    <span style="color: #FFF;">GNSS解算获得的<span class="span-player-name" >1号</span>运动员速度信息</span><br>
                </div>
                <div style="width: 25%;display: inline-block;">
                    <span class="title">GNSS定位解算模式:</span><br>
                    <span style="color: #FFF;">1:伪距单点定位2:伪距差分解算4:RTK固定解算5:RTK浮点解算</span>
                </div>
                <div style="width: 25%;display: inline-block;">
                    <span class="title">GNSS系统定位精度:</span><br>
                    <span style="color: #FFF;">位置几何精度因子(PDOP)与用户等效测距误差(UERE)乘积</span>
                </div>
               <div style="width: 24%;display: inline-block;">
                    <span class="title">北斗伪卫星系统定位精度:</span><br>
                    <span style="color: #FFF;">水平几何精度因子(HDOP)与室内精度比例乘积</span>
                </div>
                <div id="echarts_3" class="charts"  style="width: 25%;display: inline-block;" ></div>

                <div id="echarts_4" class="charts" style="width: 25%;display: inline-block;"></div>

                <div id="echarts_5" class="charts" style="width: 25%;display: inline-block;"></div>

                <div id="echarts_6" class="charts" style="width: 24%;display: inline-block;"></div>

            </div>
            <!-- 运动速度图表 -->

            <!-- 定位网络图表 -->
           <div  id="div-sport-type" style="width: 100%;height: 7%;background-color: rgba(0,24,106,0.5);border: 1px solid #20558b;box-sizing: border-box;position: relative; ">
                <span class="title" >定位网络:</span>
                <span class="title span-player-name" >1号</span>
                <img id="img_bd" style="width: 2%;margin-left: 4%;margin-right: 8%" src="/lib/CheLianWang/img/pos_type/bd.png">
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
var myChart6;
var dat_v = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
var dat_5G = [1,1,1,1,1,1,1,1,1,1,1];
var dat_BLE_near = [1,1,1,1,1,1,1,1,1,1,1];
var dat_GNSS = [2,2,2,2,2,2,2,2,2,2,2];
var dat_GD = [3,3,3,3,3,3,3,3,3,3];
var dat_pdop_level1 = [0,0,0,0,0];
var dat_pdop_level2 = [0,0,0,0,0];
var dat_pdop_level3 = [0,0,0,0,0];
var dat_hdop_level1 = [0,0,0,0,0];
var dat_hdop_level2 = [0,0,0,0,0];
var dat_hdop_level3 = [0,0,0,0,0];
var currentPlayerUid = '65239274009657347';

// 当前是否有下列的定位方式
var positionTypeBd = 0;
var positionTypeBluetooth = 0;
var positionTypeSatelite = 0;
var positionTypeVision = 0;
var positionTypePDR = 0;
var positionTypeIns = 0;
var positionTypeDc = 0;
var positionType5G = 0;

// 地图变量
var map; 
var mapLayer;
var poiLayer;
var pointLayer;
var LocusPointLayer;
var currentFloor;
var IS_LOCUS = 0;
var IS_SPORT_V_TYPE_VISIBLED = 0;
var IS_LOCATION_DIV1_VISIBLED = 1;
var IS_LOCATION_DIV2_VISIBLED = 1;
var IS_LOCATION_DIV3_VISIBLED = 1;
var IS_LOCATION_DIV4_VISIBLED = 1;
var IS_LOCATION_DIV5_VISIBLED = 1;
var SRC_DA_FLOOR1_MAP = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F1map/MapServer";
var SRC_DA_FLOOR2_MAP = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F2map/MapServer";
var SRC_DA_FLOOR3_MAP = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F3map/MapServer";
var SRC_DA_FLOOR4_MAP = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F4map/MapServer";
var SRC_DA_FLOOR5_MAP = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F5map/MapServer";
var SRC_DA_FLOOR1_POI = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F1poi/MapServer";
var SRC_DA_FLOOR2_POI = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F2poi/MapServer";
var SRC_DA_FLOOR3_POI = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F3poi/MapServer";
var SRC_DA_FLOOR4_POI = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F4poi/MapServer";
var SRC_DA_FLOOR5_POI = "http://61.240.144.70:5567/arcgis/rest/services/GJTTHXZX/F5poi/MapServer";

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
 * 显示或关闭定位信息表格
 */
function toggleLocationInfoTab(tab_id){

    $('#div_location_info_1').css('visibility','hidden');
    $('#div_location_info_2').css('visibility','hidden');
    $('#div_location_info_3').css('visibility','hidden');
    $('#div_location_info_4').css('visibility','hidden');
    $('#div_location_info_5').css('visibility','hidden');

    switch(tab_id){
        case 1:
            if (IS_LOCATION_DIV1_VISIBLED == 0) {
                $('#div_location_info_1').css('visibility','hidden');
                IS_LOCATION_DIV1_VISIBLED = 1;
            }else if(IS_LOCATION_DIV1_VISIBLED == 1){
                $('#div_location_info_1').css('visibility','visible');
                IS_LOCATION_DIV1_VISIBLED = 0;
            }
        break;        
        case 2:
            if (IS_LOCATION_DIV2_VISIBLED == 0) {
                $('#div_location_info_2').css('visibility','hidden');
                IS_LOCATION_DIV2_VISIBLED = 1;
            }else if(IS_LOCATION_DIV2_VISIBLED == 1){
                $('#div_location_info_2').css('visibility','visible');
                IS_LOCATION_DIV2_VISIBLED = 0;
            }       
        break;                
        case 3:
            if (IS_LOCATION_DIV3_VISIBLED == 0) {
                $('#div_location_info_3').css('visibility','hidden');
                IS_LOCATION_DIV3_VISIBLED = 1;
            }else if(IS_LOCATION_DIV3_VISIBLED == 1){
                $('#div_location_info_3').css('visibility','visible');
                IS_LOCATION_DIV3_VISIBLED = 0 
            }        
        break;        
        case 4:
            if (IS_LOCATION_DIV4_VISIBLED == 0) {
                $('#div_location_info_4').css('visibility','hidden');
                IS_LOCATION_DIV4_VISIBLED = 1;
            }else if(IS_LOCATION_DIV4_VISIBLED == 1){
                $('#div_location_info_4').css('visibility','visible');
                IS_LOCATION_DIV4_VISIBLED = 0
            }
        break;
        case 5:
            if (IS_LOCATION_DIV5_VISIBLED == 0) {
                $('#div_location_info_5').css('visibility','hidden');
                IS_LOCATION_DIV5_VISIBLED = 1;
            }else if(IS_LOCATION_DIV5_VISIBLED == 1){
                $('#div_location_info_5').css('visibility','visible');
                IS_LOCATION_DIV5_VISIBLED = 0
            }
        break;        
        default:
        break;        
    }
}

/**
 * 更新定位网络显示图表
 */
function updateLocationType(dat){
    positionTypeBd = dat.data['positionTypeBd'];
    positionTypeBluetooth = dat.data['positionTypeBluetooth'];
    positionTypeSatelite = dat.data['positionTypeSatelite'];
    positionTypeVision = dat.data['positionTypeVision'];
    positionTypePDR = dat.data['positionTypePDR'];
    positionTypeIns = dat.data['positionTypeIns'];
    positionTypeDc = dat.data['positionTypeDc'];
    positionType5G = dat.data['positionType5G'];

    if(!positionTypeBd){
        $('#img_bd').css('visibility','visible');
    }
    if(!positionTypeBluetooth){
        $('#img_bluetooth').css('visibility','visible');
    }
    if(!positionTypeSatelite){
        $('#img_satelite').css('visibility','visible');
    }
    if(!positionTypeVision){
        $('#img_vision').css('visibility','visible');
    }
    if(!positionTypePDR){
        $('#img_rtk').css('visibility','visible');
    }
    if(!positionTypeIns){
        $('#img_ins').css('visibility','visible');
    }
    if(!positionTypeDc){
        $('#img_dc').css('visibility','visible');
    }
    if(!positionType5G){
        $('#img_5g').css('visibility','visible');
    }
}

/**
 * 更新定位信息显示
 */
function updateLocationInfo(dat){
    // console.log(dat)

     $('#tab-location-info').empty()
    $('#tab-location-info').append(
        '<tr>'+
            '<td>信号源</td>'+
            '<td>信号源数量</td>'+
            '<td>信号源信息</td>'+                                   
        '</tr>'       
    );
    if (dat.data['BDpseudolite']!= ""){
        var obj = JSON.parse(dat.data['BDpseudolite'])
        $('#tab-location-info').append(
            '<tr>'+
                '<td onclick="toggleLocationInfoTab(1)" >北斗伪卫星</td>'+
                '<td>'+ obj.num +'</td>'+
                '<td>'+ obj.quality +'</td>'+                                   
            '</tr>'       
        );

    }else{
        $('#tab-location-info').append(
            '<tr>'+
                '<td >北斗伪卫星</td>'+
                '<td>无</td>'+
                '<td>无</td>'+                                   
            '</tr>'       
        );        
    }
   if (dat.data['GNSS']!= ""){
        var obj = JSON.parse(dat.data['GNSS'])
        $('#tab-location-info').append(
            '<tr>'+
                '<td onclick="toggleLocationInfoTab(2)">GNSS</td>'+
                '<td>'+ obj.num +'</td>'+
                '<td>'+ obj.quality +'</td>'+                                   
            '</tr>'       
        );
    }else{
        $('#tab-location-info').append(
            '<tr>'+
                '<td>GNSS</td>'+
                '<td>无</td>'+
                '<td>无</td>'+                                   
            '</tr>'       
        );        
    }
    if (dat.data['ins']!= ""){
        var obj = JSON.parse(dat.data['ins'])
        $('#tab-location-info').append(
            '<tr>'+
                '<td onclick="toggleLocationInfoTab(3)">惯导</td>'+
                '<td>'+ obj.num +'</td>'+
                '<td>'+ obj.quality +'</td>'+                                   
            '</tr>'       
        );
    }else{
        $('#tab-location-info').append(
            '<tr>'+
                '<td>惯导</td>'+
                '<td>无</td>'+
                '<td>无</td>'+                                   
            '</tr>'       
        );        
    }     
    if (dat.data['5G']!= ""){
        var obj = JSON.parse(dat.data['5G'])
        $('#tab-location-info').append(
            '<tr>'+
                '<td onclick="toggleLocationInfoTab(4)">5G</td>'+
                '<td>'+ obj.num +'</td>'+
                '<td>'+ obj.quality +'</td>'+                                   
            '</tr>'       
        );    
    }else{
        $('#tab-location-info').append(
            '<tr>'+
                '<td>5G</td>'+
                '<td>无</td>'+
                '<td>无</td>'+                                   
            '</tr>'       
        );        
    } 
    if (dat.data['BLE_near']!= ""){
        var obj = JSON.parse(dat.data['BLE_near'])
        $('#tab-location-info').append(
            '<tr>'+
                '<td onclick="toggleLocationInfoTab(5)">蓝牙</td>'+
                '<td>'+ obj.num +'</td>'+
                '<td>'+ obj.quality +'</td>'+                                   
            '</tr>'       
        );    
    }else{
        $('#tab-location-info').append(
            '<tr>'+
                '<td>BLE_near</td>'+
                '<td>无</td>'+
                '<td>无</td>'+                                   
            '</tr>'       
        );        
    }            
}

/**
 * 改变定位网络的显示人员
 */
function changeLocationTypeOfPlayer(uid,name){

    currentPlayerUid = uid;
    $('.span-player-name').html(name)
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
        if (positionTypePDR) {
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
 * 开关运动速度和定位网络div
 */
function toggleBottomDiv(){

    if (IS_SPORT_V_TYPE_VISIBLED == 0) {
        $('#div-sport-type').css('visibility','hidden');
        $('#div-sport-v').css('visibility','hidden');    
        IS_SPORT_V_TYPE_VISIBLED = 1;
    }else if(IS_SPORT_V_TYPE_VISIBLED == 1){
        $('#div-sport-type').css('visibility','visible');
        $('#div-sport-v').css('visibility','visible');
        IS_SPORT_V_TYPE_VISIBLED = 0
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
                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);
                break;        
                case 2:
                    currentFloor = floorNum;
                    $('#btn_floor_2').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR2_MAP);
                    map.addLayer(mapLayer);
                break;    
                case 3:
                    currentFloor = floorNum;
                    $('#btn_floor_3').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR3_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR3_POI);
                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);
                break;    
                case 4:
                    currentFloor = floorNum;
                    $('#btn_floor_4').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR4_MAP);
                    map.addLayer(mapLayer);                  
                break;    
                case 5:
                    currentFloor = floorNum;
                    $('#btn_floor_5').addClass('btn-primary');
                    mapLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR5_MAP);
                    poiLayer = new DynamicMapServiceLayer(SRC_DA_FLOOR5_POI);
                    map.addLayer(mapLayer);
                    map.addLayer(poiLayer);     
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
            left: '5%',
            right: '15%',
            top:'20%',
            bottom: '15%',
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
        xAxis : 
        [
            {
                name:'秒(S)',
                nameTextStyle:{
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '15',
                },
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
                        var paramsNameNumber = params.length;// 实际标签的数
                        var provideNumber = 4;// 每行能显示的字的数
                        var rowNumber = Math.ceil(paramsNameNumber / provideNumber);// 换行的话，需要显示几行，向上取整
                        /**
                         * 判断标签的数是否大于规定的数， 如果大于，则进行换行处理 如果不大于，即等于或小于，就返回原标签
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
            name:'米/秒(m/s)',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
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
            left: '5%',
            right: '15%',
            top:'20%',
            bottom: '25%',
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
            name:'模式',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
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
            name:'米(m)',
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
            left: '9%',
            right: '15%',
            top:'20%',
            bottom: '25%',
            textStyle: {
                color: "#fff"
            }
        },        
        series: [{
            data: [0.1,0.4,0.2,0.3,0.5],
            type: 'line',
            smooth: true
        },{
            data: [0.5,0.4,0.3,0.2,0.1],
            type: 'line',
            smooth: true
        },{
            data: [0.1,0.2,0.3,0.4,0.5],
            type: 'line',
            smooth: true
        }]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart5.setOption(option);
    window.addEventListener("resize",function(){
        myChart5.resize();
    });         
}


/**
 * 初始化图表5
 */
function initEchart6(){
   // 基于准备好的dom，初始化echarts实例
    myChart6 = echarts.init(document.getElementById('echarts_6'));

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
            name:'米(m)',
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
            left: '9%',
            right: '15%',
            top:'20%',
            bottom: '25%',
            textStyle: {
                color: "#fff"
            }
        },        
        series: [{
            data: [0.1,0.4,0.2,0.3,0.5],
            type: 'line',
            smooth: true
        },{
            data: [0.5,0.4,0.3,0.2,0.1],
            type: 'line',
            smooth: true
        },{
            data: [0.1,0.2,0.3,0.4,0.5],
            type: 'line',
            smooth: true
        }]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart6.setOption(option);
    window.addEventListener("resize",function(){
        myChart6.resize();
    });         
}

/**
 * 初始化弹出框1
 */
function initLocationInfoEchart1(){
    locationIntoEchart1 = echarts.init(document.getElementById('location_info_echarts_1'));

   var colors = ['#5470C6', '#91CC75', '#EE6666'];

    option = {
        color: colors,
        title :{
            text: "北斗伪卫星观测数据质量分析",
            textStyle:{
                color:"#FFF"
            },
            subtextStyle:{
              align : "center"
            } 
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        grid: {
 
            containLabel: true
        },

        legend: {
            data: ['C/N0','载波相位差']
        },
        xAxis: [
            {
                type: 'category',
                axisTick: {
                    alignWithLabel: true
                },
                data: ['1号星', '2号星', '3号星', '4号星', '5号星', '6号星', '7号星', '8号星']
            }
        ],
        yAxis: [
            {
                type: 'value',
                name: 'C/N0',
                min: 0,
                max: 100,
                position: 'right',
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: colors[1]
                    }
                },
                axisLabel: {
                    formatter: '{value}'
                }
            },
            {
                type: 'value',
                name: '载波相位差',
                min: 0,
                max: 1000,
                position: 'left',
                axisLine: {
                    show: true,
                    lineStyle: {
                        color: colors[0]
                    }
                },
                axisLabel: {
                    formatter: '{value} '
                }
            }
        ],
        series: [
            {
                name: '载波相位差',
                type: 'bar',
                yAxisIndex: 1,
                data: [260, 590, 900, 264, 287, 707, 1756, 1822]
            },
            {
                name: 'C/N0',
                type: 'bar',
                data: [20.0, 49, 27.0, 23.2, 25.6, 76.7, 35.6, 62.2]
            },


        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart1.setOption(option);
    window.addEventListener("resize",function(){
        locationIntoEchart1.resize();
    });   

}

/**
 * 初始化弹出框图表2
 */
function initLocationInfoEchart2(){
    locationIntoEchart2 = echarts.init(document.getElementById('location_info_echarts_2'));

   var colors = ['#5470C6', '#91CC75', '#EE6666'];

    option = {
        title :{
            text: "GNSS观测卫星数量分析",
            textStyle:{
              color:"#FFF"
            },
            subtextStyle:{
                align : "center"
            } 
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            orient: 'vertical',
            data:['简易程序案件数']
        },
        grid: {
            left: '3%',
            right: '10%',
            top:'20%',
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
        xAxis : 
        [
            {
                name:'秒(S)',
                nameTextStyle:{
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '15',
                },
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
                data: ['0','1','2','3','4','5','6','7','8','9','10']
            }
        ],
        yAxis : {
            name:'颗',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
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
                data:dat_GNSS
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart2.setOption(option);
    window.addEventListener("resize",function(){
        locationIntoEchart2.resize();
    });   

}
/**
 * 初始化弹出框图表3
 */
function initLocationInfoEchart3(){
    locationIntoEchart3 = echarts.init(document.getElementById('location_info_echarts_3'));

    option = {
        title :{
            text: "惯导数据分析",
            textStyle:{
              color:"#FFF"
            },
            subtextStyle:{
                align : "center"
            } 
        },        
        xAxis: {
            name:'相对位置X/米(M)',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
            axisLabel: {
                textStyle:{
                    color: '#ccc',
                    fontSize:'12'
                },
                lineStyle:{
                    color:'#2c3459',
                }, 
            }           
        },
        yAxis: {
            name:'相对位置Y/米(M)',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
            axisLabel: {
                textStyle:{
                    color: '#ccc',
                    fontSize:'12'
                },
                lineStyle:{
                    color:'#2c3459',
                }, 
            }

        },
        series: [{
            symbolSize: 20,
            data: [
                [10.0, 8.04],
            ],
            type: 'scatter'
        }]
    };
    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart3.setOption(option);
    window.addEventListener("resize",function(){
        locationIntoEchart3.resize();
    });   

}

/**
 * 初始化弹出框图表4
 */
function initLocationInfoEchart4(){
    locationIntoEchart4 = echarts.init(document.getElementById('location_info_echarts_4'));

   var colors = ['#5470C6', '#91CC75', '#EE6666'];

    option = {
        title :{
            text: "5G通讯网络延迟分析",
            textStyle:{
              color:"#FFF"
            },
            subtextStyle:{
                align : "center"
            } 
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            orient: 'vertical',
            data:['简易程序案件数']
        },
        grid: {
            left: '3%',
            right: '10%',
            top:'20%',
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
        xAxis : 
        [
            {
                name:'秒(S)',
                nameTextStyle:{
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '15',
                },
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
                data: ['0','1','2','3','4','5','6','7','8','9','10']
            }
        ],
        yAxis : {
            name:'MS',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
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
                data:dat_5G
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart4.setOption(option);
    window.addEventListener("resize",function(){
        locationIntoEchart4.resize();
    });   

}

/**
 * 初始化弹出框图表5
 */
function initLocationInfoEchart5(){
    locationIntoEchart5 = echarts.init(document.getElementById('location_info_echarts_5'));

   var colors = ['#5470C6', '#91CC75', '#EE6666'];

    option = {
        title :{
            text: "蓝牙基站接收状态",
            textStyle:{
              color:"#FFF"
            },
            subtextStyle:{
                align : "center"
            } 
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            orient: 'vertical',
            data:['简易程序案件数']
        },
        grid: {
            left: '3%',
            right: '10%',
            top:'20%',
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
        xAxis : 
        [
            {
                name:'秒(S)',
                nameTextStyle:{
                    color: '#bac0c0',
                    fontWeight: 'normal',
                    fontSize: '15',
                },
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
                data: ['0','1','2','3','4','5','6','7','8','9','10']
            }
        ],
        yAxis : {
            name:'颗',
            nameTextStyle:{
                color: '#bac0c0',
                fontWeight: 'normal',
                fontSize: '15',
            },
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
                data:dat_5G
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart5.setOption(option);
    window.addEventListener("resize",function(){
        locationIntoEchart5.resize();
    });   

}
/**
 * 更新图表3
 */
function updateEchart3(dat){
    dat_v.splice(0,1);
    dat_v.push(dat.data.plays[0].v);

    option = {
        series : [
            {
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

        series: [{
           
            data: data,
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

    dat_pdop_level1.splice(0,1)
    dat_pdop_level1.push(JSON.parse(dat.data.plays[0]['GNSS']).quality.split("：")[1] * 2);
    dat_pdop_level2.splice(0,1)
    dat_pdop_level2.push(JSON.parse(dat.data.plays[1]['GNSS']).quality.split("：")[1] * 2);
    dat_pdop_level3.splice(0,1)
    dat_pdop_level3.push(JSON.parse(dat.data.plays[2]['GNSS']).quality.split("：")[1] * 2);

    option = {
        series: [{
            data: dat_pdop_level1,
            type: 'line',
            smooth: true
        },{
            data: dat_pdop_level2,
            type: 'line',
            smooth: true
        },{
            data: dat_pdop_level3,
            type: 'line',
            smooth: true
        }]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart5.setOption(option);
}

/**
 * 更新图表5
 */
function updateEchart6(dat){
    
    var hdop1 = 0;
    var hdop2 = 0;
    var hdop3 = 0;
    if (JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo) != null )
        hdop1 = JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo).hdop
    if (JSON.parse(JSON.parse(dat.data.plays[1].BDpseudolite).extraInfo) != null )
        hdop2 = JSON.parse(JSON.parse(dat.data.plays[1].BDpseudolite).extraInfo).hdop
    if (JSON.parse(JSON.parse(dat.data.plays[2].BDpseudolite).extraInfo) != null )
        hdop3 = JSON.parse(JSON.parse(dat.data.plays[2].BDpseudolite).extraInfo).hdop

    dat_hdop_level1.splice(0,1)
    dat_hdop_level1.push(hdop1);
    dat_hdop_level2.splice(0,1)
    dat_hdop_level2.push(hdop2);
    dat_hdop_level3.splice(0,1)
    dat_hdop_level3.push(hdop3);

    option = {
        series: [{
            data: dat_hdop_level1,
            type: 'line',
            smooth: true
        },{
            data: dat_hdop_level2,
            type: 'line',
            smooth: true
        },{
            data: dat_hdop_level3,
            type: 'line',
            smooth: true
        }]
    };


    // 使用刚指定的配置项和数据显示图表。
    myChart6.setOption(option);
}


/**
 * 更新弹出图表1
 */
function updateLocationInfoEchart1(dat){

    data_cD = [];
    data_cn0 = [];
    is_null = 0;

    var obj;
    if (currentPlayerUid == dat.data.plays[0].uid) {
        if(JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo) != null){
            obj = JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[1].uid){
        if(JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo) != null){
            obj = JSON.parse(JSON.parse(dat.data.plays[1].BDpseudolite).extraInfo);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[2].uid){
        if(JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo) != null){
            obj = JSON.parse(JSON.parse(dat.data.plays[2].BDpseudolite).extraInfo);
        }else{
            is_null = 1;
        }
    }



    if (!is_null) {

        for(var i in obj.satelliteDatas){
        	var carrierDiffer = obj.satelliteDatas[i]['carrierDiffer'];
        	var cn0 = obj.satelliteDatas[i]['cn0'];
		    if(carrierDiffer < 0){
		    	carrierDiffer = carrierDiffer * -1;
		    }
		    if (carrierDiffer > 2500) {
		    	carrierDiffer = 0;
		    }
			data_cD.push(carrierDiffer)
            data_cn0.push(cn0)
        }
    }

    option = {
        series: [
            {
                data: data_cD
            },
            {
                data: data_cn0
            },
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart1.setOption(option);
    window.addEventListener("resize",function(){
        locationIntoEchart1.resize();
    });   
}    

/**
 * 更新弹出图表4
 */
function updateLocationInfoEchart2(dat){

    is_null = 0;
    
    var obj;
    if (currentPlayerUid == dat.data.plays[0].uid) {
        if(JSON.parse(dat.data.plays[0]['GNSS']) != null){
            obj = JSON.parse(dat.data.plays[0]['GNSS']);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[1].uid){
        if(JSON.parse(dat.data.plays[1]['GNSS']) != null){
            obj = JSON.parse(dat.data.plays[1]['GNSS']);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[2].uid){
        if(JSON.parse(dat.data.plays[2]['GNSS']) != null){
            obj = JSON.parse(dat.data.plays[2]['GNSS']);
        }else{
            is_null = 1;
        }
    }

    if (!is_null) {
        dat_GNSS.splice(0,1);
        dat_GNSS.push(obj.num);
    }

    option = {
        series : [
            {
                data:dat_GNSS
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart2.setOption(option);
}
/**
 * 更新弹出图表3
 */
function updateLocationInfoEchart3(dat){


    var obj;
    is_null = 0;
    x = 0;
    y = 0;

    if (currentPlayerUid == dat.data.plays[0].uid) {
        if(dat.data.plays[0].ins != ""){
            if(JSON.parse(dat.data.plays[0].ins).extraInfo != ""){
                obj = JSON.parse(JSON.parse(dat.data.plays[0].ins).extraInfo);
            }else{
                is_null = 1;
            }
        }
        else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[1].uid){
        if(dat.data.plays[1].ins != ""){
            if(JSON.parse(dat.data.plays[1].ins).extraInfo != ""){
                obj = JSON.parse(JSON.parse(dat.data.plays[1].ins).extraInfo);
            }else{
                is_null = 1;
            }
        }
        else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[2].uid){
        if(dat.data.plays[2].ins != ""){
            if(JSON.parse(dat.data.plays[2].ins).extraInfo != ""){
                obj = JSON.parse(JSON.parse(dat.data.plays[2].ins).extraInfo);
            }else{
                is_null = 1;
            }
        }
        else{
            is_null = 1;
        }
    }

    if (!is_null) {
        x = obj.x;
        y = obj.y;
    }


    option = {
        series: [{
            data: [
                [x, y]
            ]
        }]
    };


    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart3.setOption(option);
}

/**
 * 更新弹出图表4
 */
function updateLocationInfoEchart4(dat){

    is_null = 0;
    
    var obj;
    if (currentPlayerUid == dat.data.plays[0].uid) {
        if(JSON.parse(dat.data.plays[0]['5G']) != null){
            obj = JSON.parse(dat.data.plays[0]['5G']);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[1].uid){
        if(JSON.parse(dat.data.plays[1]['5G']) != null){
            obj = JSON.parse(dat.data.plays[1]['5G']);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[2].uid){
        if(JSON.parse(dat.data.plays[2]['5G']) != null){
            obj = JSON.parse(dat.data.plays[2]['5G']);
        }else{
            is_null = 1;
        }
    }

    if (!is_null) {
        dat_5G.splice(0,1);
        dat_5G.push(obj.quality[5]);
    }

    option = {
        series : [
            {
                data:dat_5G
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart4.setOption(option);
}

/**
 * 更新弹出图表5
 */
function updateLocationInfoEchart5(dat){

    is_null = 0;
    
    var obj;
    if (currentPlayerUid == dat.data.plays[0].uid) {
        if(dat.data.plays[0]['BLE_near'] != ""){
            obj = JSON.parse(dat.data.plays[0]['BLE_near']);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[1].uid){
        if(dat.data.plays[1]['BLE_near'] != ""){
            obj = JSON.parse(dat.data.plays[1]['BLE_near']);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[2].uid){
        if(dat.data.plays[2]['BLE_near'] != ""){
            obj = JSON.parse(dat.data.plays[2]['BLE_near']);
        }else{
            is_null = 1;
        }
    }

    if (!is_null) {
        dat_BLE_near.splice(0,1);
        dat_BLE_near.push(obj.num);
    }

    option = {
        series : [
            {
                data:dat_BLE_near
            }
        ]
    };

    // 使用刚指定的配置项和数据显示图表。
    locationIntoEchart5.setOption(option);
}
/**
 * 更新Echart
 */        
function updateEchart(dat){
    
    updateEchart3(dat);
    updateEchart4(dat);
    updateEchart5(dat);
    updateEchart6(dat);
    updateLocationInfoEchart1(dat);
    updateLocationInfoEchart2(dat);
    updateLocationInfoEchart3(dat);
    updateLocationInfoEchart4(dat);
    updateLocationInfoEchart5(dat);
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
        grade_list_before_sort.push({name:dat.data.plays[i].name,grade:dat.data.plays[i].grade,uid:dat.data.plays[i].uid,x:dat.data.plays[i].x,y:dat.data.plays[i].y,h:dat.data.plays[i].h});

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
    $('#tab-play-grade').append('<tr><td>排名</td><td>姓名</td></tr>');

    for (var i = 0; i < grade_list_sort.length; i++) {
        position = i + 1;
        $('#tab-play-grade').append(
             '<tr onclick=changeLocationTypeOfPlayer('+ "'" + grade_list_sort[i].uid + "'"+ ',' + "'" +grade_list_sort[i].name + "'" +')>'+
                '<td>'+ position +'</td>'+
                '<td>'+ grade_list_sort[i].name +'</td>'+
            '</tr>'
        );
    }    
}
 
/**
 * 更新伪卫星表格1
 */
function updateLocationInfoTab1(dat){

    is_null = 0;

    var obj;
    if (currentPlayerUid == dat.data.plays[0].uid) {
        if(JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo) != null){
            obj = JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[1].uid){
        if(JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo) != null){
            obj = JSON.parse(JSON.parse(dat.data.plays[1].BDpseudolite).extraInfo);
        }else{
            is_null = 1;
        }
    }else if(currentPlayerUid == dat.data.plays[2].uid){
        if(JSON.parse(JSON.parse(dat.data.plays[0].BDpseudolite).extraInfo) != null){
            obj = JSON.parse(JSON.parse(dat.data.plays[2].BDpseudolite).extraInfo);
        }else{
            is_null = 1;
        }
    }

    $('#tab-location-info-1').empty()
    $('#tab-location-info-1').append(
        '<tr>'+
            '<td>卫星号</td>'+
            '<td>质量</td>'+                                  
        '</tr>'       
    );

    if (!is_null) {
        for(var i in obj.satelliteDatas){

            level = "";
            var carrierDiffer = obj.satelliteDatas[i]['carrierDiffer'];
            var cn0 = obj.satelliteDatas[i]['cn0'];
            if(carrierDiffer < 0 ){
            	carrierDiffer = carrierDiffer * -1;
            }

            if (true) {}

            if ((carrierDiffer < 2500) && (carrierDiffer > 1) && (cn0 < 55) && (cn0 > 37)){
                level = "优"
            }
            else if((carrierDiffer < 2500) && (carrierDiffer > 1) && (cn0 < 38) && (cn0 > 35)){
                level = "良"
            }
            else if((carrierDiffer < 2500) && (carrierDiffer > 1) && (cn0 < 36) && (cn0 > 30)){
                level = "中"
            }
            else if((carrierDiffer < 2500) && (carrierDiffer > 1) && (cn0 < 31) && (cn0 > 29)){
                level = "可定位"
            }
            else if( (carrierDiffer > 10000) || (cn0 < 30) ){
                level = "失锁"
            }else {
                level = "优"
            }

            $('#tab-location-info-1').append(
                '<tr>'+
                    '<td>'+ obj.satelliteDatas[i]['svid']+'</td>'+
                    '<td>'+ level +'</td>'+                                
                '</tr>'       
            );
        }
    }
}

/**
 * 更新表格
 */
function updateTable(dat){
    updateTable1(dat);
    updateTable2(dat);
    updateLocationInfoTab1(dat);
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
                    } else {
                        console.log('ajax error!');
                    }
                }
            );

            //读取定位网络数据
            $.post("/api/apiGetLoctionType",
                {uid:currentPlayerUid},
                function (dat, status) {
                    if (dat.status == 0) {
                        updateLocationType(dat);
                    } else {
                        console.log('ajax error!');
                    }
                }
            );            

            //读取定位信息数据
            $.post("/api/apiGetLocationSource",
                {uid:currentPlayerUid},
                function (dat, status) {
                    if (dat.status == 0) {
                        updateLocationInfo(dat);
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
initEchart6();
initLocationInfoEchart1();
initLocationInfoEchart2();
initLocationInfoEchart3();
initLocationInfoEchart4();
initLocationInfoEchart5();
initMapAndRefreshData();

</script>
</html>
