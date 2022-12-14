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
        "esri/tasks/RouteTask",
        "esri/tasks/RouteParameters",
        "esri/tasks/FeatureSet",
        "esri/toolbars/draw",
        "esri/symbols/SimpleMarkerSymbol",
        "esri/symbols/SimpleLineSymbol",
        "esri/symbols/TextSymbol",
        "esri/Color",
        "esri/graphic",
        "esri/SpatialReference",
        "dojo/on",
        "dojo/parser",
        "dojo/text!./templates/IpsNetworkAnalysis.html"],
    function (declare,_Widget,lang,domGeometry,domStyle,basefx,fx,query,_TemplatedMixin,win,Moveable,
              RouteTask,RouteParameters,FeatureSet,Draw,SimpleMarkerSymbol,SimpleLineSymbol,TextSymbol,Color,Graphic,SpatialReference,
              on,parser,template) {
        var defaultIndex=100;
        return declare([_Widget,_TemplatedMixin],{
            templateString: template,
            closeCallBack:null,
            map:null,
            routeanalysis1:null,
            routeanalysis2:null,
            routeanalysis3:null,
            routeParas:null,
            selectPointID:null,
            status:0,
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
            initParas:function(){
                this.routeanalysis1 = new RouteTask(config.FFSserver.route1);
                this.routeanalysis2 = new RouteTask(config.FFSserver.route2);
                this.routeanalysis3 = new RouteTask(config.FFSserver.route3);
                this.routeParas=new RouteParameters();
                //???????????????????????????????????????
                this.routeParas.barriers = new FeatureSet();
                //???????????????????????????????????????
                this.routeParas.stops = new FeatureSet();
                //?????????????????????
                this.routeParas.returnDirections = false;
                //???????????????????????????????????????
                this.routeParas.returnRoutes = true;
                //????????????
                this.routeParas.outSpatialReference = new SpatialReference(4326);
            },
            addStopPoint:function () {
                this.selectPointID = 1;
                this.status=1;
                //????????????????????????
                var stopSymbol = new SimpleMarkerSymbol();
                stopSymbol.style = SimpleMarkerSymbol.STYLE_DIAMOND;
                stopSymbol.setSize(10);
                stopSymbol.setColor(new Color("#ffb000"));
                on(this.map, "click", lang.hitch(this,function(evt){
                    if(this.status==1){
                        //????????????????????????
                        var pointStop=evt.mapPoint;
                        var gr=new Graphic(pointStop,stopSymbol);
                        //????????????????????????
                        this.routeParas.stops.features.push(gr);

                        //??????selectPointID?????????0??????????????????????????????????????????
                        if (this.selectPointID != 0) {
                            this.addTextPoint("?????????", pointStop, stopSymbol);
                            this.selectPointID = 0;
                        }
                    }
                }));
            },
            addTextPoint:function(text,point,symbol) {
                //????????????????????????????????????????????????
                var textSymbol = new TextSymbol(text);
                textSymbol.setColor(new Color([128, 0, 0]));
                textSymbol.setOffset(0, 8)
                var graphicText = Graphic(point, textSymbol);
                var graphicpoint = new Graphic(point, symbol);
                //????????????????????????
                this.map.graphics.add(graphicpoint);
                //????????????????????????
                this.map.graphics.add(graphicText);
            },
            anlysis:function () {
                if  (this.routeParas.stops.features.length == 0 )
                {
                    alert("?????????????????????????????????");
                    return;
                }
                //????????????????????????
                if(floor_num==1){
                    this.routeanalysis1.solve(this.routeParas, this.showRoute);
                }
                if(floor_num==2){
                    this.routeanalysis2.solve(this.routeParas, this.showRoute);
                }
                if(floor_num==3){
                    this.routeanalysis3.solve(this.routeParas, this.showRoute);
                }
            },
            showRoute:function (solveResult) {
                //?????????????????????
                var routeResults = solveResult.routeResults;
                //?????????????????????
                var res = routeResults.length;
                //???????????????
                routeSymbol  = new SimpleLineSymbol(SimpleLineSymbol.STYLE_DASH, new Color([0, 50, 250]), 3);
                if (res > 0) {
                    for (var i = 0; i < res; i++) {
                        var graphicroute = routeResults[i];
                        var graphic = graphicroute.route;
                        graphic.setSymbol(routeSymbol);
                        map.graphics.add(graphic);
                    }
                }
                else {
                    alert("??????????????????");
                }
            },
            clear:function () {
                this.map.graphics.clear();
                this.routeParas=null;
                this.selectPointID=null;
                this.initParas();
            },
            startup: function () {
                domStyle.set(this.domNode,"position","absolute");
                domStyle.set(this.domNode,"top","70px");
                domStyle.set(this.domNode,"left","800px");
                domStyle.set(this.domNode,"z-index",defaultIndex);
                basefx.fadeIn({
                    node: this.domNode,
                    duration: 800
                }).play();
                this.placeAt(win.body());
                //???????????????
                this.initParas();
                //?????????
                this.a=new Moveable(this.domNode,{
                    handle:query(".mytitle",this.domNode)
                });
            }
        });
    });