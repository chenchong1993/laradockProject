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

    <!-- tools -->
    <script type="text/javascript" src="/js/tools.js"></script>
    <!-- tools-->

</head>

<body class="tundra">

<div class="row" style="height: 100%">


    <div class="container">
    <h1 style="margin-left:25%;margin-top:20px" >伪卫星综合监控平台</h1>
        <button class="btn btn-default " style="float:right" onclick="location.reload();"> 刷新</button>
        <table class="table table-border">

            <tr>
                <th>ID</th>
                <th>名字</th>
                <th>设备类型</th>
                <th>设备状态</th>
                <th>创建时间</th>
                <th>修改时间</th>
                <th>操作</th>
            </tr>

            @foreach ($devices as $device)
                <tr>
                    <td>{{ $device->id }}</td>
                    <td>{{ $device->name }}</td>
                    <td>{{ $device->type }}</td>
                    <td>{{ $device->status==0?'关闭':'开启' }}</td>
                    <td>{{ $device->created_at }}</td>
                    <td>{{ $device->updated_at }}</td>
                    <td>
                        <button onclick="deviceOn({{$device->id}})"
                                class="btn btn-default " {{ $device->status==0?:'disabled' }}>开启
                        </button>
                        <button onclick="deviceOff({{$device->id}})"
                                class="btn btn-default "{{ $device->status==1?:'disabled' }}>关闭
                        </button>
                        <button
                                class="btn btn-default "><a href="{{ url('deviceOpt').'/'.$device->id }}">操作设备</a>
                        </button>
                    </td>
                </tr>
            @endforeach

        </table>

        {{ $devices->links() }}
    </div>


</div>


</body>

<script>


    /**
     * 开启设备
     * @param id 设备ID
     */
    function deviceOn(id) {
        if (confirm("确定开启？")) {
            $.post("/api/deviceOn",
                {'id': id},
                function (dat, status) {
                    if (dat.status == 0) {
                        notify("开启成功", "opt_ok");

                        setTimeout(function () {
                            location.reload()

                        }, 1000);

                    } else {
                        notify("开启失败", "opt_err");
                    }
                }
            );
        }
    }

    /**
     * 关闭设备
     * @param id 设备ID
     */
    function deviceOff(id) {
        if (confirm("确定关闭？")) {
            $.post("/api/deviceOff",
                {'id': id},
                function (dat, status) {
                    if (dat.status == 0) {
                        notify("关闭成功", "opt_ok");

                        setTimeout(function () {
                                location.reload()
                            }, 1000
                        );

                    } else {
                        notify("关闭失败", "opt_err");
                    }
                }
            );
        }
    }

    /**
     * 删除设备
     * @param id 设备ID
     */    
    function deviceDel(id) {
        if (confirm("确定删除？")) {
            $.post("/api/deviceDel",
                {'id': id},
                function (dat, status) {
                    if (dat.status == 0) {
                        notify("删除成功", "opt_ok");

                        setTimeout(function () {
                                location.reload()
                            }, 1000
                        );

                    } else {
                        notify("删除失败", "opt_err");
                    }
                }
            );
        }
    }


</script>
</html>
