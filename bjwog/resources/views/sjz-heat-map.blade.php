<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>添加图形</title>

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

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>

    <!-- 提示框开始 -->
    <script src="/js/notify/bootstrap.min.js"></script>
    <script src="/js/notify/hullabaloo.js"></script>
    <!-- 提示框结束 -->


    <!-- 石家庄地图 -->
    <script type="text/javascript" src="Ips_api_javascript/echartsExtent.js"></script>
    <script type="text/javascript" src="Ips_api_javascript/init.js"></script>
    <!-- 石家庄地图 -->

    <!-- tools -->
    <script type="text/javascript" src="/js/tools.js"></script>
    <!-- tools-->


</head>


<body class="tundra">


<div class="btn-group" role="group" aria-label="...">
    <button type="button" id="btn-people-num" class="btn btn-primary">当前在线人数：1</button>
    <button type="button" id="btn-max-den-num" class="btn btn-primary">当前报警密度阈值：{{ $max_den }}</button>
    <button type="button" id="btn-set-max-den" class="btn btn-primary" data-toggle="modal"
            data-target="#mod-set-max-den">设置最大阈值
    </button>
</div>


<div class="row" style="height: 100%">

    <div id="map_sjz" class="col-md-12"></div>
</div>


</body>


<!-- Modal -->
<div class="modal fade" id="mod-set-max-den" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">设置最大密度通知阈值</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleInputName2">阈值：</label>
                    <input type="number" class="form-control" value="{{ $max_den }}" id="input-max-den" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" onclick="setMaxDen()" class="btn btn-primary">保存</button>
            </div>
        </div>

    </div>
</div>


<script>



    THRESHOLD_DISTANCE = 0.001; // 密度阈值 未使用
    CURRENT_PEOPLE_NUM = 0; // 当前人数
    MAX_PEOPLE_NUM = $('#input-max-den').val(); // 报警人口阈值


    /**
     * 测量(x1,y1)和(x2,y2)的距离
     */
    function getDistance(x1, y1, x2, y2) {
        return Math.sqrt((Math.pow((x2 - x1), 2) + Math.pow((y2 - y1), 2)));
    }

    /**
     * 修改密度最大值
     */
    function setMaxDen() {
        $.post("/api/setMaxDen",
            {'maxDen': $('#input-max-den').val()},
            function (dat, status) {
                if (dat.status == 0) {
                    notify("修改成功", "opt_ok");

                    setTimeout(function () {
                        location.reload()
                    }, 2000);

                } else {
                    notify("修改失败", "opt_err");
                }
            }
        );
    }

    //地图
    var map;
    require(["esri/map",
        "src/Echarts3Layer",
        "dojo/on",
        "dojo/dom",
        "dojo/domReady!"], function (Map, Echarts3Layer, on, dom) {
        map = new Map("map_sjz", {
            basemap: "osm",
            center: [114.441, 38.049],
            zoom: 15,
            logo: false
        });

        var overlay = new Echarts3Layer(map, echarts);
        var chartsContainer = overlay.getEchartsContainer();
        overlay.initECharts(chartsContainer);



        /**
         * [从云端获取热力图数据]
         * @return {[type]} [description]
         */
        function getHeatMap() {
            $.get("data/sjz-heat-data.json",
                {},
                function (dat) {

                    //设置显示人数
                    $("#btn-people-num").text("当前在线人数：" + CURRENT_PEOPLE_NUM);

                    //设置常量
                    CURRENT_PEOPLE_NUM = dat.length * 2;

                    //初始化echarts图层
                    var point = dat;

                    //热力图配置
                    var data = point.slice(0, point.length * 0.01);
                    var option = {
                        title: {
                            text: '',
                            left: 'center',
                            textStyle: {
                                color: '#fff'
                            }
                        },
                        visualMap: {
                            min: 0,
                            max: 2,
                            show: false,
                            seriesIndex: 0,
                            calculable: true,
                            inRange: {
                                color: ['blue', 'blue', 'green', 'yellow', 'red'] //色带
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
                            type: 'heatmap', //effectScatter
                            coordinateSystem: 'geo',
                            data: data, //渲染数据【点数组】
                            pointSize: 8,  //点大小
                            blurSize: 30  //模糊大小
                        }]
                    };
                    // 使用刚指定的配置项和数据显示图表。
                    overlay.setOption(option);


                }
            );
        }


        //设置定时器 循环执行
        setInterval(function () {
            console.log('刷新图层');
            getHeatMap();
            
            if (CURRENT_PEOPLE_NUM  > MAX_PEOPLE_NUM) {
                notify("人口密度过大", "opt_err");
            }

        }, 3000);


    });


</script>
</html>
