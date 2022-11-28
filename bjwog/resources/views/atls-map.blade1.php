<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset=utf-8"/>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1,user-scalable=no"/>
    <title>������˹����ͼ </title>

    <!-- �˵���ʼ -->
    <link rel="stylesheet" type="text/css" href="/css/menu/style.css"/>
    <!-- �˵����� -->

    <!-- ��ʾ��ʼ -->
    <link href="https://cdn.bootcss.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- ��ʾ����� -->

    <!-- ��ͼ��ʼ -->
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/dijit/themes/tundra/tundra.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/esri/css/esri.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="Ips_api_javascript/Ips/css/widget.css"/>
    <!-- ��ͼ���� -->

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

    <!-- ��ʾ��ʼ -->
    <script src="/js/notify/bootstrap.min.js"></script>
    <script src="/js/notify/hullabaloo.js"></script>
    <!-- ��ʾ����� -->

    <!-- 331��ͼ -->
    <script type="text/javascript" src="Ips_api_javascript/init.js"></script>
    <!-- 331��ͼ -->

    <!-- tools -->
    <script type="text/javascript" src="/js/tools.js"></script>
    <!-- tools-->

</head>

<body class="tundra">

<div class="row" style="height: 100%">

    <div id="map_atls_1" class="col-md-12">
        <h5 style="position: absolute; z-index: 10">һ��</h5>
    </div>

    
  	<div style="position: absolute; z-index: 10; top: 10px; right: 30px";>
            <button class="btn btn-primary" onclick="toggleLocus()" id="btn-toggle-loucs">�����켣</button>
            <button class="btn btn-default" onclick="clearLocus()">����켣</button> 
    </div>

        <!-- �˵� -->
        <div style="position: absolute; z-index: 10; left: 50%; bottom: 10%";>
            <nav class="nav" >
              <input type="checkbox" class="nav__cb" id="menu-cb">
              <div class="nav__content">
                <ul class="nav__items">
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-group-msg"> Ⱥ����Ϣ</span> </li>
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-group-cmd"> Ⱥ������</span> </li>
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-user-search"> ��Ա��ѯ </span> </li>
                  <li class="nav__item"> <span class="nav__item-text" data-toggle="modal" data-target="#modal-device-search"> �豸����</span> </li>
                </ul>
              </div>
              <label class="nav__btn" for="menu-cb"></label>
            </nav>
        </div>
        <!-- �˵� -->

        <!-- ģ̬�� -->

            <!-- Ⱥ����Ϣ-->
            <div class="modal fade" id="modal-group-msg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" >Ⱥ����Ϣ</h4>
                  </div>
                  <div class="modal-body">
                     <input type="text" class="form-control" id="input-group-msg" >
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">�ر�</button>
                    <button type="button" class="btn btn-primary" id="btn-group-msg" onclick="groupMsg()">����</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Ⱥ������ -->
            <div class="modal fade" id="modal-group-cmd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" >Ⱥ������</h4>
                  </div>
                  <div class="modal-body">
                    <button type="button" class="btn btn-primary" id="btn-group-cmd-on" onclick="groupCmd('on')">���������豸</button>
                    <button type="button" class="btn btn-danger"  id="btn-group-cmd-off" onclick="groupCmd('off')">�ر������豸</button>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">�ر�</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- ��Ա��ѯ -->
            <div class="modal fade" id="modal-user-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title" >��Ա��ѯ</h4>
                  </div>

                  <div class="modal-body">
                    <select class="form-control" id="select-user-search">
                        <option value="name">������</option>
                        <option value="phone">���ֻ���</option>
                        <option value="uid">��UID</option>
                    </select>
                    <br>
                    <input type="text" class="form-control" id="input-user-search" required>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close-user-search-modal">�ر�</button>
                      <button type="button" class="btn btn-primary" id="btn-user-search" onclick="userSearch()">����</button>
                    </div>
                    <table class="table table-condensed " id="tab-user-list">
                    </table>
                  </div>

                </div>
              </div>
            </div>

            <!-- �豸��ѯ -->
            <div class="modal fade" id="modal-device-search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">

                  <div class="modal-header">
                    <h4 class="modal-title" >�豸��ѯ</h4>
                  </div>

                  <div class="modal-body">
                     <select class="form-control" id="select-device-search">
                        <option value="name">���豸��</option>
                        <option value="uid">��UID</option>
                    </select>
                    <br>
                    <input type="text" class="form-control" id="input-device-search" required>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal" id="btn-close-device-search-modal">�ر�</button>
                      <button type="button" class="btn btn-primary" id="btn-device-search" onclick="deviceSearch()">����</button>
                    </div>
                  
                    <table class="table table-condensed " id="tab-device-list">
                   </table>
                  </div>
                </div>
              </div>
            </div>


        <!-- ģ̬�� -->

    </div>

</div>
</body>

<script>

    //331��ͼ
    // ��ʼ��ȫ�ֲ���
    var HTHT_SERVER_IP = "121.28.103.199:9078"; //�����ͼ��������ַ
    var HTHT_TYPE_LOGIN_SCUUESS = 102 //�����ͼ��Ϣ����:��¼�ɹ�
    var HTHT_TYPE_RECEIVE_MSG = 1; //�����ͼ��Ϣ����:�յ���Ϣ
    var INTERVAL_TIME = 4; //����ˢ�¼��ʱ��
    var HELLO_STR = "ϵͳ��ʼ���ɹ���"; //��ʼ����ӭ���
    var ERR_MSG = "��������Σ������"//Σ�������͵���Ϣ
    var DANGER_AREA = [];//Σ������Χ
    var IS_LOCUS = 0;
    var pointLayer;
    var LocusPointLayer;

    //websocket ���Ӷ���
    var conn;
    var map1;

	/**
     * �������߹رչ켣��ӡ
     */
    function toggleLocus(){

        if(IS_LOCUS == 0){
            IS_LOCUS = 1;
            $('#btn-toggle-loucs').text('�رչ켣');
            $('#btn-toggle-loucs').addClass("btn-danger");
            $('#btn-toggle-loucs').removeClass("btn-primary");
        }

        else if (IS_LOCUS == 1){
            IS_LOCUS = 0;
            $('#btn-toggle-loucs').text('�����켣'); 
            $('#btn-toggle-loucs').addClass("btn-primary");
            $('#btn-toggle-loucs').removeClass("btn-danger");
        }
    }


    /**
    * ����켣������
    */
    function clearLocus(){
        LocusPointLayer.clear();
    }

    /**
     * ��ͼ��λ�����λ��
     */
    function locationTo(x,y,floor){
        //�رնԻ���
        // $('#btn-close-user-search-modal').click();
        // $('#btn-close-device-search-modal').click();
        //��ͼ
        require(["esri/geometry/Point","esri/SpatialReference"], function (Point,SpatialReference) {
            var point = new Point(y,x,new SpatialReference({ wkid: 4547}));
            map1.infoWindow.show(point);
            map1.centerAndZoom(point,1);
            
        });
    }


    /**
     * [��Ա����]
     * @return null
     */
    function userSearch(){

        var select_func = $('#select-user-search').val();
        var select_content = $('#input-user-search').val();
        if (select_func == 'name'){

            $.post("/api/getUsersByName",
                {'name':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-user-list').empty();
                        $('#tab-user-list').append('<tr><th>����</th><th>UID</th><th>�ֻ���</th><th>״̬</th><th>����</th></tr>');
                        for (var i in dat.data.users) {
                            console.log(dat.data.users);
                            $('#tab-user-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td>'+ dat.data.users[i].uid +'</td>'+
                                '<td>'+ dat.data.users[i].phone +'</td>'+
                                '<td>'+ dat.data.users[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.users[i].x +','+ dat.data.users[i].y + ',' + dat.data.users[i].floor + ')">�鿴</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("���ҳɹ�", "sys");
                    } else {
                        notify("����ʧ��", "sys");
                    }
                }
            );

        }
        else if(select_func == 'phone')
        {

            $.post("/api/getUsersByPhone",
                {'phone':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-user-list').empty();
                        $('#tab-user-list').append('<tr><th>����</th><th>UID</th><th>�ֻ���</th><th>״̬</th><th>����</th></tr>');
                        for (var i in dat.data.users) {
                            console.log(dat.data.users);
                            $('#tab-user-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td>'+ dat.data.users[i].uid +'</td>'+
                                '<td>'+ dat.data.users[i].phone +'</td>'+
                                '<td>'+ dat.data.users[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.users[i].x +','+ dat.data.users[i].y + ',' + dat.data.users[i].floor + ')">�鿴</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("���ҳɹ�", "sys");
                    } else {
                        notify("����ʧ��", "sys");
                    }
                }
            );

        }
        else if(select_func == 'uid')
        {
         
            $.post("/api/getUsersByUid",
                {'uid':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-user-list').empty();
                        $('#tab-user-list').append('<tr><th>����</th><th>UID</th><th>�ֻ���</th><th>״̬</th><th>����</th></tr>');
                        for (var i in dat.data.users) {
                            console.log(dat.data.users);
                            $('#tab-user-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.users[i].name +'</td>'+
                                '<td>'+ dat.data.users[i].uid +'</td>'+
                                '<td>'+ dat.data.users[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.users[i].x +','+ dat.data.users[i].y + ',' + dat.data.users[i].floor + ')">�鿴</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("���ҳɹ�", "sys");
                    } else {
                        notify("����ʧ��", "sys");
                    }
                }
            );

        }
    }


    /**
     * [�豸����]
     * @return null
     */
    function deviceSearch(){

        var select_func = $('#select-device-search').val();
        var select_content = $('#input-device-search').val();
        if (select_func == 'name'){

            $.post("/api/getDevicesByName",
                {'name':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-device-list').empty();
                        $('#tab-device-list').append('<tr><th>����</th><th>UID</th><th>״̬</th><th>����</th></tr>');
                        for (var i in dat.data.devices) {
                            console.log(dat.data.devices);
                            $('#tab-device-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.devices[i].name +'</td>'+
                                '<td>'+ dat.data.devices[i].uid +'</td>'+
                                '<td>'+ dat.data.devices[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.devices[i].x +','+ dat.data.devices[i].y + ',' + dat.data.devices[i].floor + ')">�鿴</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("���ҳɹ�", "sys");
                    } else {
                        notify("����ʧ��", "sys");
                    }
                }
            );

        }
        else if(select_func == 'uid')
        {
         
            $.post("/api/getDevicesByUid",
                {'uid':select_content},
                function (dat, status) {

                    if (dat.status == 0) {
                        $('#tab-device-list').empty();
                        $('#tab-device-list').append('<tr><th>����</th><th>UID</th><th>״̬</th><th>����</th></tr>');
                        for (var i in dat.data.devices) {
                              $('#tab-device-list').append(
                                '<tr>'+
                                '<td>'+ dat.data.devices[i].name +'</td>'+
                                '<td>'+ dat.data.devices[i].uid +'</td>'+
                                '<td>'+ dat.data.devices[i].status +'</td>'+
                                '<td><button class="btn btn-default btn-xs" onclick="locationTo('+ dat.data.devices[i].x +','+ dat.data.devices[i].y + ',' + dat.data.devices[i].floor + ')">�鿴</button></td>'+
                                '</tr>'
                                );
                        }
                        notify("���ҳɹ�", "sys");
                    } else {
                        notify("����ʧ��", "sys");
                    }
                }
            );

        }
    }

    /**
     * [Ⱥ����Ϣ]
     * @return {[type]} [description]
     */
    function groupMsg(){
        
        var msg = $('#input-group-msg').val();
        $.post("/api/getAllLocation",
            {},
            function (dat, status) {

                if (dat.status == 0) {
                    // ����Ա������Ϣ
                    for (var i in dat.data.users) {
                        sendMessage(dat.data.users[i].uid, msg, 1);
                    }
                    // ���豸������Ϣ
                    // for (var i in dat.data.devices) {
                    //     sendMessage(dat.data.devices[i].uid, msg);
                    // }
                    $.post("/api/msgTxAdd",
                        {content:msg},
                        function (dat, status) {
                            //TODO
                            if (dat.status == 0) {                                
                                notify("Ⱥ����Ϣ�ɹ�", "sys");
                            } else {
                                notify("Ⱥ����Ϣʧ��", "sys");
                            }
                        }
                    );                    
                } else {
                    notify("Ⱥ����Ϣʧ��", "sys");
                }
            }
        );
    }

    /**
     * [Ⱥ������]
     * @param  {[type]} cmd [���͵�����]
     * @return {[type]}     [description]
     */
    function groupCmd(cmd){
        console.log(cmd);
         $.post("/api/getAllLocation",
            {},
            function (dat, status) {

                if (dat.status == 0) {
                    // ����Ա������Ϣ
                    // for (var i in dat.data.users) {
                    //     sendMessage(dat.data.users[i].uid, msg);
                    // }
                    // ���豸������Ϣ
                    for (var i in dat.data.devices) {
                        sendMessage(dat.data.devices[i].uid, cmd);
                    }
                    notify("Ⱥ����Ϣ�ɹ�", "sys");


                } else {
                    notify("Ⱥ����Ϣʧ��", "sys");
                }
            }
        );
    }


    /**
     * Ϊ�������ͼ�ϵ��Ȼ���������ַ�����Ϣ ��Ϊ��htmlѡ�񲻳���
     * @param  {[type]} uid [description]
     * @return {[type]}     [description]
     */
    function sendMessageByUid(uid){
    	sendMessage(uid,$('#input-send-msg').val());
    	return true;
    }

     /**
     * [ͨ�������ͷ�������]
     * @param  {[type]} uid [����Ŀ��ID]
     * @param  {[type]} message    [������Ϣ]
     * @return {[null]}            [description]
     */
    function sendMessage(push_user_id, message,isGroup = 0) {
        console.log(push_user_id);
      //  console.log("sendMessage id ��", uid);
        if (!conn) {
            return false;
        }
        console.log(message);
        //���շ���Ϣ
        var msgJson = '"{\\"Type\\":2,\\"Data\\":{\\"from\\":29914377884794889,\\"to\\":29914377884794889,\\"content\\":\\"{\\\\\\"_id\\\\\\":3,\\\\\\"content\\\\\\":{\\\\\\"_id\\\\\\":3,\\\\\\"contentType\\\\\\":3,\\\\\\"fileName\\\\\\":null,\\\\\\"json\\\\\\":\\\\\\"' + message + '\\\\\\"},\\\\\\"contentType\\\\\\":3,\\\\\\"conversationId\\\\\\":\\\\\\"1536888885424\\\\\\",\\\\\\"conversationType\\\\\\":1,\\\\\\"createTime\\\\\\":1536888940315,\\\\\\"direct\\\\\\":2,\\\\\\"fileurl\\\\\\":null,\\\\\\"fromUserId\\\\\\":31783766124920837,\\\\\\"isImportance\\\\\\":false,\\\\\\"lat\\\\\\":0.0,\\\\\\"lon\\\\\\":0.0,\\\\\\"msgId\\\\\\":0,\\\\\\"serverMessageId\\\\\\":null,\\\\\\"status\\\\\\":0,\\\\\\"targetIDs\\\\\\":\\\\\\"29914377884794889\\\\\\"}\\",\\"tag\\":\\"1\\",\\"timestamp\\":1536888940}}"';

        var sengMsg = '{"type":1,"to":' + push_user_id+ ',"text":' + msgJson + ',"appid":10,"time":1508898308,"platform":1}';
        conn.send(sengMsg);
        // console.log('ggggggggggggggggggggggggggg');
        notify("������Ϣ�ɹ�", "sys");
        return true;
    }
  

    /**
     * �����͵��
     * @return {[type]} [description]
     */
    function login() {
        if (!conn) {
            return false;
        }
        var loginfo = '{ "Type": 101,"Appid": 10,"From": 29914363070513161,"To": 0, "Connid": 0,"ConnServerid": 0, "Gid": 0,"Text": "{\\"uid\\":29914363070513161,\\"user\\":\\"u\\",\\"passwd\\":\\"bd_agent_10\\",\\"key\\":\\"\\",\\"platform\\":2,\\"lastmsgid\\":0}","Time": 1498203115,"Platform": 1,"Payload": null}';
        conn.send(loginfo);
    }


    //����������WS
    if (window["WebSocket"]) {
        conn = new WebSocket("ws://" + HTHT_SERVER_IP + "/ws");
        console.log("conn:", conn)
        conn.onopen = function (evt) {
            login()
        };
        conn.onclose = function (evt) {
            console.log(evt.data);
        }
        conn.onmessage = function (evt) {
            rootObj = JSON.parse(evt.data);

            switch (rootObj.Type) {
                case HTHT_TYPE_LOGIN_SCUUESS:
                    notify('�����͵�¼�ɹ�', 'opt_ok');
                    break;
                //���յ���Ϣ
                case HTHT_TYPE_RECEIVE_MSG:
                    console.log("rootObj:" + JSON.stringify(rootObj));

                    uid = rootObj.From;
                    // console.log("uid  is:" + uid);

                    // console.log("item console:" + rootObj.Text);
                    textObj = $.parseJSON(rootObj.Text);

                    // console.log("item console:" + textObj.Data.content);
                    contentObj = $.parseJSON(textObj.Data.content);

                    // console.log("item console:" + contentObj.content.json);
                    msg = contentObj.content.json;

                    $.post("/api/getUsersByUid",
                        {
                            uid:uid
                        },
                        function (dat, status) {
                            if (dat.status == 0) {
                                console.log(uid);
                                if (!dat.data.users[0]) 
                                     notify("δ֪�û�" + ":<br/>" + msg, 'user');
                                else
                                    notify(dat.data.users[0].name + ":<br/>" + msg, 'user');

                            } else {
                                notify('��ȡ�û���ʧ�ܣ�', 'user');
                            }
                        }
                    );                    

                    $.post("/api/msgRxAdd",
                        {
                            content:msg,
                            uid:uid
                        },
                        function (dat, status) {
                            if (dat.status == 0) {                                

                            } else {
                                
                            }
                        }
                    );       

                    break;
            }
        }
    } else {
        console.log("Your browser does not support WebSockets.");
    }


    //��ͼ
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


        //-----------------------------һ��-------------------------------------
        map1 = new Map("map_atls_1", {
            logo: false
        });

        //��ʼ��F1¥��ƽ��ͼ
        var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/outlets/outlets1f/MapServer");
        // var f1 = new DynamicMapServiceLayer("http://121.28.103.199:5567/arcgis/rest/services/outlets/outlets2f/MapServer");
        map1.addLayer(f1);

        //��ʼ��pointLayer �û����ݵ�ͼ��
        pointLayer = new GraphicsLayer();
        map1.addLayer(pointLayer);

        //��ʼ���켣��pointLayer �û����ݵ�ͼ��
        LocusPointLayer = new GraphicsLayer();
        map1.addLayer(LocusPointLayer);
 

        //���õ���Χ��    
        $.post("/api/getFenceList",
            {},
            function (dat, status) {

                if (dat.status == 0) {

                    //��ʼ�� ����Χ��ͼ��
                    var surfaceLayer = new GraphicsLayer();

                    for (var i in dat.data.fences) {
                        DANGER_AREA.push($.parseJSON(dat.data.fences[i].content));

                        //������ļ�����
                        var polygon = new Polygon($.parseJSON(dat.data.fences[i].content));
                        //������ķ���
                        var fill = new SimpleFillSymbol(SimpleFillSymbol.STYLE_HORIZONTAL,
                            new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASHDOT, new Color([255, 50, 0]), 2),
                            new Color([0, 50, 200, 0.25]));
                        var fillgr = new Graphic(polygon, fill);

                        surfaceLayer.add(fillgr);

                    }                               
                    console.log(DANGER_AREA);

                    map1.addLayer(surfaceLayer);
                    notify("��ȡ����Χ���ɹ�", "sys");

                } else {
                    notify("��ȡ����Χ��ʧ��", "sys");
                }
            }
        );   
        
		/**
	     * ��ӹ켣������
	     */
	    function addLocusUserPoint(id, x, y, name, phone, uid, status){

	        //�����ļ�����
	        //38.2477770 114.3489115
	        var picpoint = new Point(x, y);
	        // //������ͼƬ����
	        var picSymbol;

	    if(status == 0)
	        	picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_blue.png", 32, 32);
	    else if(status == 1)
	        	picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_red.png", 32, 32);
	    else if(status == 2)
	        	picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/point_black.png", 32, 32);
		

	        var picgr = new Graphic(picpoint, picSymbol);
	        LocusPointLayer.add(picgr);
	    }

        /**
         * ���ݷ��ص��ж��Ƿ�ΪΣ��������
         * @param {[type]} x       [x����]
         * @param {[type]} y       [y����]
         */
        function isInDangerArea(lng, lat) {

            for (var i in DANGER_AREA) {
                var point1 = DANGER_AREA[i][0];
                var point3 = DANGER_AREA[i][2];

                var point1Lng = point1[0];
                var point1Lat = point1[1];
                var point3Lng = point3[0];
                var point3Lat = point3[1];

                if ((point1Lng < lng) && (lng < point3Lng) && (point1Lat < lat) && (lat < point3Lat))
                    return true;

                return false;
            }
        }


        /**
         * ����Ñ��c
         * @param {[type]} id      [�û�ID]
         * @param {[type]} x       [x����]
         * @param {[type]} y       [y����]
         * @param {[type]} name    [�û�����]
         * @param {[type]} phone   [�û��ֻ���]
         * @param {[type]} uid     [�û�����ID]
         * @param {[type]} status  [�û�״̬]
         */
        function addUserPoint(id, x, y, floor,name, phone, uid, status) {
            //�����ļ�����
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //������ͼƬ����
            var picSymbol;
            if (status == 0){
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/user_black.png", 32, 32);
            }
            else if (status == 1){
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/user_red.png", 32, 32);
            }
            else if (status == 2){
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/user_blue.png", 32, 32);
            }
            //������ͼƬ����
            var attr = {"name": name, "phone": phone};
            //��Ϣģ��
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle('��Ա');

            infoTemplate.setContent(
                "<b>����:</b><span>${name}</span><br>"
                + "<b>�ֻ���:</b><span>${phone}</span><br><br>"
                + "<input id='input-send-msg',class='form-control'>"
                + "<button class='' onclick=sendMessageByUid("
                + "'" + uid +  "') >����</button>"

            );
            var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);

            if (floor == 1) {
                pointLayer.add(picgr);
            }
            // console.log(x+'--'+y+'--'+'--'+name)
        }

        /**
         * ���ת������
         * @param {[type]} id     [�û�ID]
         * @param {[type]} x      [x����]
         * @param {[type]} y      [y����]
         * @param {[type]} name   [�û���]
         * @param {[type]} status [�û�״̬]
         */
        function addDevicePoint(id, x, y,floor, name, uid, status) {

            //�����ļ�����
            //38.2477770 114.3489115
            var picpoint = new Point(x, y);
            // //������ͼƬ����
            var picSymbol;
            if (status == 0)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/en.png", 32, 32);
            else if (status == 1)
                picSymbol = new PictureMarkerSymbol("Ips_api_javascript/Ips/image/en-red.png", 32, 32);
            // //������ͼƬ����
            var attr = {"name": name};
            // //��Ϣģ��
            var infoTemplate = new InfoTemplate();
            infoTemplate.setTitle('�豸');
            var Onisdisabled = '';
            var Offisdisabled = '';
            if (status) {
                Onisdisabled = 'disabled';
            }else{
                Offisdisabled = 'disabled';
            }

            infoTemplate.setContent(
                "<b>����:</b><span>${name}</span><br>"
                + "<b>�ֻ���:</b><span>${phone}</span><br><br>"
                + "<button class='' " + Onisdisabled + " onclick=sendMessage("
                + "'" + uid + "'" + ",'cmd_on') >����</button>"
                + "<button class='' " + Offisdisabled + " onclick=sendMessage("
                + "'" + uid + "'" + ",'cmd_off') >�ػ�</button>"
            );
            var picgr = new Graphic(picpoint, picSymbol, attr, infoTemplate);
            if (floor == 1) {
                pointLayer.add(picgr);
            }
        }


        /**
         * �ӷ�������ȡת�����б��������ݲ����½���
         */
        function getDataAndRefresh() {

            // ���ƶ˶�ȡ����
            $.post("/api/getAllLocation",
                {},
                function (dat, status) {

                    if (dat.status == 0) {

                        // ɾ������
                        pointLayer.clear();

                        // �������

                        // �����
                        for (var i in dat.data.users) {

                            addUserPoint(
                                dat.data.users[i].id,
                                dat.data.users[i].y,
                                dat.data.users[i].x,
                                dat.data.users[i].floor,
                                dat.data.users[i].name,
                                dat.data.users[i].phone,
                                dat.data.users[i].uid,
                                dat.data.users[i].status
                            );
                            if (isInDangerArea(dat.data.users[i].y, dat.data.users[i].x)) {
                                sendMessage(dat.data.users[i].uid, ERR_MSG);
                            }

                            //�켣
                            if(IS_LOCUS)
                                addLocusUserPoint(
                                    dat.data.users[i].id,
                                    dat.data.users[i].y,
                                    dat.data.users[i].x,
                                    dat.data.users[i].name,
                                    dat.data.users[i].phone,
                                    dat.data.users[i].uid,
                                    dat.data.users[i].status
                                );

                        }
                        // ����豸
                        for (var i in dat.data.devices) {
                            addDevicePoint(
                                dat.data.devices[i].id,
                                dat.data.devices[i].lng,
                                dat.data.devices[i].lat,
                                dat.data.devices[i].floor,
                                dat.data.devices[i].name,
                                dat.data.devices[i].uid,
                                dat.data.devices[i].status,

                            );
                        }

                    } else {
                        console.log('ajax error!');
                    }
                }
            );
        }

        //ѭ��ִ��
        setInterval(getDataAndRefresh, (INTERVAL_TIME * 1000));

        //��ʾ��ʼ���ɹ�
        notify(HELLO_STR, "sys");

    });




</script>
</html>
