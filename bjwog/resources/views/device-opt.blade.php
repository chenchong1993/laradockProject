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
        <div class="modal-dialog modal-lg" role="document">

            @if (session('err_msg'))
                <div class="alert alert-danger">
                    {{ session('err_msg') }}
                </div>
            @endif

            @if (session('suc_msg'))
                <div class="alert alert-success">
                    {{ session('suc_msg') }}
                </div>
            @endif


            <h4 class="modal-title">设备操作</h4>

            <div class="modal-content" style="margin-top: 40px">

                <div class="modal-header">
                    <h4 class="modal-title">设备修改</h4>
                </div>

                <form action="{{ url('api/deviceChange') }}" method="post" class="form form-horizontal">

                    <div class="modal-body">

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">设备ID：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input name="id" type="text" class="input-text" value="{{ $device->id }}"
                                       autocomplete="off" readonly >
                            </div>
                        </div>

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">设备名：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input name="name" type="text" class="input-text" value="{{ $device->name }}"
                                       autocomplete="off" required>
                            </div>
                        </div>

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">设备类型：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                        <span class="select-box">
                                          <select name="type" class="select" size="1">
                                            <option value="转发器" {{ $device->type == '转发器'?'selected':'' }}>转发器</option>
                                            <option value="中心站" {{ $device->type == '中心站'?'selected':'' }}>中心站</option>
                                          </select>
                                        </span>
                            </div>
                        </div>

                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">设备状态：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                        <span class="select-box">
                                          <select name="status" class="select" size="1">
                                            <option value="1" {{ $device->status == 1?'selected':'' }}>开启</option>
                                            <option value="0" {{ $device->status == 0?'selected':'' }}>关闭</option>
                                          </select>
                                        </span>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">修改</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->


            <div class="modal-content" style="margin-top: 20px">

                <div class="modal-header">
                    <h4 class="modal-title">发送消息</h4>
                </div>

                <form action="{{ url('api/deviceMsg') }}" method="post" class="form form-horizontal">

                    <div class="modal-body">
                        <div class="row cl">

                            <label class="form-label col-xs-4 col-sm-3">设备ID：</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input name="id" type="text" class="input-text" value="{{ $device->id }}"
                                       autocomplete="off" readonly >
                            </div>
                        </div>
                        <div class="row cl">
                            <label class="form-label col-xs-4 col-sm-3">消息内容</label>
                            <div class="formControls col-xs-8 col-sm-9">
                                <input name="msg" type="text" class="input-text"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">发送</button>
                    </div>
                </form>

            </div><!-- /.modal-content -->
        </div>
    </div>


</div>


</body>

<script>


</script>
</html>