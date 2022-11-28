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

            <!-- 列表 -->
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
            </div>

           <!-- 列表 -->
           <div class="modal-dialog modal-lg" role="document">
               <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">电子围栏列表</h4>
                    </div>
                
                    <div class="modal-body">
                        <table class="table table-border">
                            <th>ID</th>
                            <th>内容(左下，右下，右上，左上)</th>
                            <th>创建时间</th
>                            <th>操作</th>
                            @foreach ($fences as $fence)
                                <tr>
                                    <td>{{ $fence->id }}</td>
                                    <td>{{ $fence->content }}</td>
                                    <td>{{ $fence->created_at }}</td>
                                    <td>
                                         <a title="删除" href="#" onclick=submit_as_form('{{url('/api/fenceDel')}}','fence_id','{{ $fence->id }}')> 删除 </a>
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div><!-- /.modal-content -->
           </div>

            <!-- 添加 -->
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title">添加电子围栏（矩形）</h4>
                    </div>

                    <form action="{{ url('api/fenceAdd') }}" method="post" class="form form-horizontal" >
                        <ul class="modal-body" id="ul-point-list">

                            <li class="row cl">
                                <label class="form-label col-xs-3 col-sm-3">坐标点(左上)：</label>
                                经度：
                                <div class="formControls  col-xs-3 col-sm-3">
                                    <input name="point_lng_1" type="text" class="input-text" autocomplete="off" required>
                                </div>
                                纬度:
                                <div class="formControls col-xs-3 col-sm-3">
                                    <input name="point_lat_1" type="text" class="input-text" autocomplete="off" required>
                                </div>
                          
                            </li>    

                            <li class="row cl">
                                <label class="form-label col-xs-3 col-sm-3">坐标点(右下)：</label>
                                经度：
                                <div class="formControls  col-xs-3 col-sm-3">
                                    <input name="point_lng_2" type="text" class="input-text" autocomplete="off" required>
                                </div>
                                纬度:
                                <div class="formControls col-xs-3 col-sm-3">
                                    <input name="point_lat_2" type="text" class="input-text" autocomplete="off" required>
                                </div>
                            </li>     


                        </ul>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->

        </div><!-- /.container -->

    </div><!-- /.row -->

</body>

<script>

 
</script>
</html>