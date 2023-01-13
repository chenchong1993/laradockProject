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
</head>
<body >
<div class="data_bodey">
    <div class="index_nav" >
        <ul style="height: 30px; margin-bottom: 0px;">
            <a href="AirportDemonstrationRealTimeMonitoring"><li class="l_left total_chose_pl">实时监测</li></a>
            <a href="AirportDemonstrationAreaPerception"><li class="l_left total_chose_pl nav_active">区域感知</li></a>
            <a href="AirportDemonstrationNameSelect"><li class="l_left total_chose_pl">精准位置评估</li></a>
        </ul>
    </div>

    <div class="index_tabs" >
        <!--安防运作-->
        <div class="inner" style="height: 109%;">
            <div class="center_cage" style="width: 99.5%">
                <div class="dataAllBorder01 cage_cl" style="margin-top: 3.5% !important; height: 94%; position: relative;">
                    <div class="dataAllBorder02" style="position: relative; overflow: hidden;">
                        <iframe id="map" scrolling="yes" frameborder="0" src="{{ url('http://121.28.24.203:5604/areaPerception') }}" style=" height: 100% ;width:100%;"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
</body>
</html>



























