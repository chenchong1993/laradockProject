<!DOCTYPE html>
<html lang="en">
<head>
    <link href="/lib/AirportDemonstration/css/BigData.css" rel="stylesheet" type="text/css" />
    <link href="/lib/AirportDemonstration/css/index.css" rel="stylesheet" type="text/css" />
    <link href="/lib/AirportDemonstration/css/index01.css" rel="stylesheet" type="text/css" />
    <script src="/lib/AirportDemonstration/js/jquery.js"></script>
    <link href="/lib/AirportDemonstration/js/bstable/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/lib/AirportDemonstration/js/bstable/css/bootstrap-table.css" rel="stylesheet" type="text/css" />
    <link href="/lib/AirportDemonstration/css/Security_operation.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/lib/AirportDemonstration/js/artDialog/skins/default.css" type="text/css"/>
    <meta charset="UTF-8">
    <title>石家庄正定机场室内外混合智能定位示范系统</title>

    <!-- 时间选择器 -->
    <link type="text/css" href="/lib/jQuery_calendar/jQuery-Timepicker-Addon/jquery-ui.css" rel="stylesheet" />
    <link href="/lib/jQuery_calendar/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.css" type="text/css" />
    <link href="/lib/jQuery_calendar/jQuery-Timepicker-Addon/demos.css"   rel="stylesheet" type="text/css" />
    <script src="/lib/jQuery_calendar/jQuery-Timepicker-Addon/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/lib/jQuery_calendar/jQuery-Timepicker-Addon/jquery-ui.min.js"></script>
    <script src="/lib/jQuery_calendar/jQuery-Timepicker-Addon/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <!--中文-->
    <script src="/lib/jQuery_calendar/js/jquery.ui.datepicker-zh-CN.js.js" type="text/javascript" charset="gb2312"></script>
    <script src="/lib/jQuery_calendar/js/jquery-ui-timepicker-zh-CN.js" type="text/javascript"></script>
    <!-- 时间选择器 -->

</head>
<body >
<div class="data_bodey">
    <div class="index_nav" >
        <ul style="height: 30px; margin-bottom: 0px; font-size: 14px">
            <a href="AirportDemonstrationRealTimeMonitoring"><li class="l_left total_chose_pl nav_active">实时监测</li></a>
            <a href="AirportDemonstrationAreaPerception"><li class="l_left total_chose_pl">区域感知</li></a>
            <a href="AirportDemonstrationNameSelect"><li class="l_left total_chose_pl">精准位置评估</li></a>
        </ul>
    </div>

    <div class="index_tabs" >
        <!--安防运作-->
        <div class="inner" style="height: 109%;">

            <div class="left_cage">
                <div class="dataAllBorder01 cage_cl" style="margin-top: 12% !important; height: 20%">
                    <div class="dataAllBorder02" id="cage_cl" >
                        <div class="analysis">当前流量：</div>
                        <ul  class="data_show_box">
                            <li class="data_cage">0</li>
                            <li class="data_cage">0</li>
                            <li class="data_cage" style="background-image: none;">,</li>
                            <li class="data_cage">0</li>
                            <li class="data_cage">0</li>
                            <li class="data_cage">6</li>
                        </ul>
                        <div class="depart_number_box">
                            <ul class="depart_number_cage">
                                <li class="depart_name">本周流量：</li>
                                <li class="depart_number">1,630</li>
                            </ul>
                            <ul class="depart_number_cage" style="margin-bottom: 0px;">
                                <li class="depart_name">本月流量：</li>
                                <li class="depart_number">4,251</li>
                            </ul>
                    
                        </div>
                    </div>
                </div>

                <div class="dataAllBorder01 cage_cl" style="margin-top: 1.5% !important; height: 35%; position: relative;">
                    <div class="dataAllBorder02 over_hide dataAllBorder20" id="over_hide">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>用户名</th>
                                <th>打卡地</th>
                                <th>体温</th>
                                <th>打卡方式</th>
                                <th>查询轨迹</th>
                            </tr>
                            <tr>
                                <span style="color:white">开始时间</span><input style="position: inline;width:30%" id="start_time" type="text"/>
                                <span style="color:white">结束时间</span><input style="position: inline;width:30%" id="end_time" type="text"/>
                            </tr>
                            </thead>
                            <tbody id="tab-record-list">
         
                            </tbody>
                        </table> 
                    </div>
                </div>

                 <div class="dataAllBorder01 cage_cl check_increase" style=" margin-top: 1.5% !important;">
                    <div class="dataAllBorder02 over_hide dataAllBorder20" id="over_hide">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>用户名</th>
                                <th>标记颜色</th>
                                <th>定位方式</th>
                                <th>定位精度</th>
                            </tr>
                            </thead>
                            <tbody id="tab-user-list">
         
                            </tbody>
                        </table> 
                    </div>
                </div>

            </div>

            <div class="center_cage" style="width: 77%">
                <div class="dataAllBorder01 cage_cl" style="margin-top: 3.5% !important; height: 94%; position: relative;">
              
                    <div class="dataAllBorder02" style="position: relative; overflow: hidden;">
                        <!--标题栏-->
                        <div class="map_title_box" style="height: 3%">
                            <div class="map_title_innerbox">
                                <div class="map_title" >
                                <a id="span-bdmap" style="color:white" onclick="showBdMap()">百度地图</a>
                                /
                                <a id="span-kt4map" style="color:gray" onclick="showKt4Map()">室内GIS地图</a>
                                </div>
                            </div>
                        </div>

						<iframe id="map" scrolling="yes" frameborder="0" src="{{ url('BDmap') }}" style=" height: 100% ;width:100%;"></iframe>
                    </div>
                </div>
            </div>
    
        </div>
    </div>
</div>

<script>
    
    //------------------------时间选择器------------------------
    jQuery(function () {
    // 时间设置
        jQuery('#start_time').datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat: "yy-mm-dd"
        });
    });
    jQuery(function () {
    // 时间设置
        jQuery('#end_time').datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat: "yy-mm-dd"
        });
    });    
    //------------------------时间选择器------------------------



    //------------------------地图切换------------------------
    function showBdMap(){
        $('#span-bdmap').css("color","white");
        $('#span-kt4map').css("color","gray");
    	$("#map").attr("src","{{ url('BDmap') }}");
    }
    function showKt4Map(){
        $('#span-bdmap').css("color","gray");
        $('#span-kt4map').css("color","white");
    	$("#map").attr("src","{{ url('AirportFloor1Map') }}");
    }
    //------------------------地图切换------------------------


	/**
	 * 从服务器读取转发器列表数据数据并更新界面
    */
	function getDataAndRefresh() {

	    //用户状态列表	
	    $.post("/api/getAllLocation",
	        {},
	        function (dat, status) {
	            if (dat.status == 0) {
                    $('#tab-user-list').empty();
                    $('#tab-record-list').empty();
                    for (var i in dat.data.users) {
                    	if (dat.data.users[i].status != 0) {

                            //打卡列表
                            $('#tab-record-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td>6号门</td>'+
                                '<td>36.4</td>'+
                                '<td>健康码</td>'+
                                '<td><a href="http://61.240.144.70:5604/AirportTrail?uid='+ dat.data.users[i].uid +'&startTime='+ $('#start_time').val() +'&endTime='+ $('#end_time').val() +'">查看</a></td>'+
                                '</tr>'
                                );


                            //用户列表
	                        var location_method = "";
	                        if (dat.data.users[i].location_method == 1) { location_method = "伪卫星+惯导" }
	                        if (dat.data.users[i].location_method == 2) { location_method = "蓝牙+PDR+惯导" }
	                        if (dat.data.users[i].location_method == 3) { location_method = "蓝牙+PDR" }
	                        if (dat.data.users[i].location_method == 4) { location_method = "蓝牙+PDR+惯导" }
	                        if (dat.data.users[i].location_method == 5) { location_method = "伪卫星" }
	                        if (dat.data.users[i].location_method == 6) { location_method = "伪卫星+PDR" }
	                        if (dat.data.users[i].location_method == 7) { location_method = "RTT" }


	                        $('#tab-user-list').append(
	                            '<tr>'+
	                            '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td><img style="height:28px" src="Ips_api_javascript/Ips/image/point_'+ dat.data.users[i].status  +'.png"></td>'+
	                            '<td>'+ location_method +'</td>'+
	                            '<td>1M</td>'+
                                '</tr>'
	                            );
	                    }
                    }					
	            } else {
	                console.log('ajax error!');
	            }
	        }
	    );
	}

   setInterval(getDataAndRefresh, (5 * 100));	

</script>

</body>
</html>



























