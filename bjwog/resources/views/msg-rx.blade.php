<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>接收消息历史</title>

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
               <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">接收消息历史</h4>
                    </div>
                
                    <div class="modal-body">
                        <table class="table table-border">
                            <th>ID</th>
                            <th>内容</th>
                            <th>接收用户 / 用户ID</th>
                            <th>创建时间</th>
                            @foreach ($msgs as $msg)
                                <tr>
                                    <td>{{ $msg->id }}</td>
                                    <td>{{ $msg->content }}</td>
                                    <td>
                                        @if($msg->terminalUser)
                                            {{ $msg->terminalUser->name.' / '.$msg->terminalUser->id }}        
                                        @else
                                            所有用户
                                        @endif
                                    </td>
                                    <td>{{ $msg->created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div style="padding-left: 45%">{{ $msgs->links() }}</div>
                    </div>
                </div><!-- /.modal-content -->
           </div>
        </div><!-- /.container -->

    </div><!-- /.row -->

</body>

<script>

 
</script>
</html>