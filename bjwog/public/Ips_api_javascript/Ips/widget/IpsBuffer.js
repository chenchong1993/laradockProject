define(["dojo/_base/declare",
        "dijit/_Widget",
        "dojo/_base/lang",
        "dojo/dom-geometry",
        "dojo/dom-style",
        "dojo/_base/fx",
        "dojo/fx",
        "dojo/query",
        "dijit/_TemplatedMixin",
        "dojo/_base/window",
        "dojo/dnd/Moveable",
        "esri/tasks/Geoprocessor",
        "esri/tasks/LinearUnit",
        "esri/tasks/FeatureSet",
        "esri/toolbars/draw",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/SimpleFillSymbol",
        "esri/Color",
        "esri/graphic",
        "esri/SpatialReference",
        "dojo/on",
        "dojo/parser",
        "dojo/text!./templates/IpsBuffer.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,
              Geoprocessor,LinearUnit,FeatureSet,Draw,SimpleMarkerSymbol,SimpleLineSymbol,SimpleFillSymbol,Color,Graphic,SpatialReference,
              on,parser,template) {
        var defaultIndex=100;
        return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            map:null,
            toolBar:null,
            dis:null,
            pointSet:null,
            lineSet:null,
            psymbol:null,
            lsymbol:null,
            addPointevent:null,
            addLineevent:null,
            selectDraw:null,
            pstatus:0,
            lstatus:0,
            constructor:function (map) {
                this.map=map;
            },
            close: function () {
                basefx.fadeOut({
                    node: this.id,
                    onEnd: lang.hitch(this, function() {
                        this.destroy()
                        if(this.closeCallBack!=null)
                        {
                            this.closeCallBack(this);
                        }
                    }),
                    duration: 600
                }).play();
                this.clear();
                this.status=0;
            },
            changeZindex:function () {
                domStyle.set(this.domNode,"z-index",++defaultIndex);
            },
            getDistance:function () {
                this.dis=$(".distance").val();
            },
            initParas:function(){
                //????????????????????????
                this.pointSet=new FeatureSet();
                this.lineSet=new FeatureSet();
                //????????????????????????
                this.psymbol=new SimpleMarkerSymbol(SimpleMarkerSymbol.STYLE_CROSS, 12,
                    new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([255, 0, 0]), 2),
                    new Color([0, 255, 0, 0.25]));
                this.lsymbol=new SimpleLineSymbol(SimpleLineSymbol.STYLE_SOLID,new Color([255, 0, 0]), 2);
            },
            drawPoint:function () {
                this.selectDraw = 1;
                this.clearSet();
                //??????????????????
                this.toolBar= new Draw(this.map, { showTooltips: true });
                if(this.pstatus==0) {
                    //??????????????????
                    this.toolBar.activate(Draw.POINT);
                    this.addPointevent=on(this.toolBar, "draw-complete", lang.hitch(this, function (result) {
                        //??????????????????????????????
                        var geometry = result.geometry;
                        //????????????????????????????????????
                        var graphic = new Graphic(geometry, this.psymbol);
                        //?????????????????????????????????
                        this.pointSet.features.push(graphic);
                        //????????????????????????????????????????????????
                        this.map.graphics.add(graphic);
                    }));
                    this.pstatus=1;
                }
            },
            drawLine:function () {
                this.selectDraw = 1;
                this.clearSet();
                //??????????????????
                this.toolBar= new Draw(this.map, { showTooltips: true });
                if(this.lstatus==0){
                    //??????????????????
                    this.toolBar.activate(Draw.POLYLINE);
                    this.addLineevent=on(this.toolBar, "draw-complete", lang.hitch(this,function(result){
                        //??????????????????????????????
                        var geometry = result.geometry;
                        //????????????????????????????????????
                        var graphic = new Graphic(geometry, this.lsymbol);
                        //?????????????????????????????????
                        this.lineSet.features.push(graphic);
                        //????????????????????????????????????????????????
                        this.map.graphics.add(graphic);
                    }));
                    this.lstatus=1;
                }
            },
            buffer:function () {
                this.getDistance();
                //??????GP????????????
                var buffer = new Geoprocessor("http://localhost:6080/arcgis/rest/services/331/Buffer/GPServer/buffer");
                //??????GP????????????
                var gpParams={};
                //GP?????????Input??????
                if(this.pstatus==1){
                    //??????fields??????????????????????????????????????????
                    this.pointSet.fields=[];
                    gpParams.Input=this.pointSet;
                }else{
                    if(this.lstatus==1){
                        //??????fields??????????????????????????????????????????
                        this.lineSet.fields=[];
                        gpParams.Input=this.lineSet;
                    }
                }
                //GP?????????dis??????
                var distance=new LinearUnit({
                    "distance": this.dis,
                    "units": "esriMeters"
                });
                gpParams.dis=distance;
                //??????GP??????
                buffer.execute(gpParams, this.showResult);
            },
            showResult:function (results, messages) {
                var features = results[0].value.features;
                for (var i = 0; i < features.length; i++) {
                    var graphic = features[i];
                    //???????????????
                    var lineSymbol=new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASHDOT, new Color([255, 0, 0]), 1);
                    //???????????????
                    var PolygonSymbol = new SimpleFillSymbol(SimpleFillSymbol.STYLE_SOLID, lineSymbol, new Color([255, 255, 0, 0.25]));
                    //???????????????
                    graphic.setSymbol(PolygonSymbol);
                    this.map.graphics.add(graphic);
                }
            },
            clearSet:function () {
                this.pointSet=new FeatureSet();
                this.lineSet=new FeatureSet();
            },
            clear:function () {
                this.map.graphics.clear();
                $(".distance").val("");

                this.clearSet();
                this.dis=null;
                //??????????????????
                if(this.pstatus==1||this.lstatus==1) {
                    if(this.selectDraw ==1){
                        this.toolBar.deactivate();
                    }
                }
                this.toolBar=null;
                //?????????????????????????????????
                if(this.pstatus==1){
                    this.addPointevent.remove();
                    this.pstatus=0;
                }
                if(this.lstatus==1){
                    this.addLineevent.remove();
                    this.lstatus=0;
                }
                this.selectDraw = 0;
            },
            startup: function () {
                domStyle.set(this.domNode,"position","absolute");
                domStyle.set(this.domNode,"top","70px");
                domStyle.set(this.domNode,"left","600px");
                domStyle.set(this.domNode,"z-index",defaultIndex);
                basefx.fadeIn({
                    node: this.domNode,
                    duration: 800
                }).play();
                this.placeAt(win.body());
                //?????????????????????
                this.initParas();
                //?????????
                this.a=new Moveable(this.domNode,{
                    handle:query(".mytitle",this.domNode)
                });
            }
        });
    });