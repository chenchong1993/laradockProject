<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Custom Basemap - 4.12</title>

    <style>
        html,
        body,
        #viewDiv {
            padding: 0;
            margin: 0;
            height: 100%;
            width: 100%;
        }
    </style>

    <link href="https://js.arcgis.com/4.12/esri/themes/light/main.css" rel="stylesheet" type="text/css" />
    <script src="https://js.arcgis.com/4.12/"></script>

    <script>
        require([
            "esri/layers/WebTileLayer",
            "esri/Map",
            "esri/Basemap",
            "esri/widgets/BasemapToggle",
            "esri/views/SceneView"
        ], function(WebTileLayer, Map, Basemap, BasemapToggle, SceneView) {

            var mapBaseLayer = new WebTileLayer({
                urlTemplate: "http://{subDomain}.tianditu.gov.cn/img_w/wmts?SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&LAYER=img&STYLE=default&TILEMATRIXSET=w&FORMAT=tiles&TILEMATRIX={level}&TILEROW={row}&TILECOL={col}&tk=cf165756006c20d7fbff15c67ff4b433",
                subDomains: ["t0", "t1", "t2", "t3", "t4", "t5", "t6", "t7"],
                copyright: '天地图影像图'
            });

            var anoBaseLayer = new WebTileLayer({
                urlTemplate: "http://{subDomain}.tianditu.gov.cn/cia_w/wmts?SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&LAYER=cia&STYLE=default&TILEMATRIXSET=w&FORMAT=tiles&TILEMATRIX={level}&TILEROW={row}&TILECOL={col}&tk=cf165756006c20d7fbff15c67ff4b433",
                subDomains: ["t0", "t1", "t2", "t3", "t4", "t5", "t6", "t7"],
                copyright: '天地图影像注记'
            });

            var imgBasemap = new Basemap({
                baseLayers: [mapBaseLayer,anoBaseLayer],
                title: "影像图",
                id: "img_w",
                thumbnailUrl: "https://services.arcgisonline.com/arcgis/rest/services/World_Imagery/MapServer/tile/0/0/0"
            });

            var mapBaseLayer_vec = new WebTileLayer({
                urlTemplate: "http://{subDomain}.tianditu.gov.cn/vec_w/wmts?SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&LAYER=vec&STYLE=default&TILEMATRIXSET=w&FORMAT=tiles&TILEMATRIX={level}&TILEROW={row}&TILECOL={col}&tk=cf165756006c20d7fbff15c67ff4b433",
                subDomains: ["t0", "t1", "t2", "t3", "t4", "t5", "t6", "t7"],
                copyright: '天地图矢量图'
            });

            var anoBaseLayer_vec = new WebTileLayer({
                urlTemplate: "http://{subDomain}.tianditu.gov.cn/cva_w/wmts?SERVICE=WMTS&REQUEST=GetTile&VERSION=1.0.0&LAYER=cva&STYLE=default&TILEMATRIXSET=w&FORMAT=tiles&TILEMATRIX={level}&TILEROW={row}&TILECOL={col}&tk=cf165756006c20d7fbff15c67ff4b433",
                subDomains: ["t0", "t1", "t2", "t3", "t4", "t5", "t6", "t7"],
                copyright: '天地图矢量注记'
            });

            var vecBasemap = new Basemap({
                baseLayers: [mapBaseLayer_vec,anoBaseLayer_vec],
                title: "矢量图",
                id: "cva_w",
                thumbnailUrl: "https://stamen-tiles.a.ssl.fastly.net/terrain/10/177/410.png"
            });

            var map = new Map({
                basemap: imgBasemap,
                ground: "world-elevation"
            });


            var view = new SceneView({
                container: "viewDiv",
                map: map
            });

            view.when(function() {
                var toggle = new BasemapToggle({
                    titleVisible: true,
                    view: view,
                    nextBasemap: vecBasemap
                });

                view.ui.add(toggle, "bottom-right");
            });
        });
    </script>
</head>

<body>
<div id="viewDiv"></div>
</body>
</html>