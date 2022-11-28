// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.17/esri/copyright.txt for details.
//>>built
define("esri/dijit/ObliqueViewer","dojo/_base/declare dojo/_base/lang dojo/has ../kernel ../tasks/QueryTask ../tasks/query ./_EventedWidget dijit/_Widget ./_ObliqueRotationWidget dojo/_base/array ../ImageSpatialReference ../tasks/ImageServiceProjectTask ../tasks/ProjectParameters ../layers/MosaicRule ../geometry/Extent ../geometry/Polygon ../lang ../config ./RasterList dojo/store/Observable dojo/store/Memory dojo/Deferred".split(" "),function(q,r,y,z,A,t,B,C,D,f,E,F,G,g,n,p,s,e,H,u,v,w){q=q([B,C],
{declaredClass:"esri.dijit.ObliqueViewer",azimuthField:"SensorAzimuth",elevationThreshold:70,elevationField:"SensorElevation",snap:!0,_refreshOK:!0,isNadir:!1,showThumbnail:!0,noQueryOnExtentChange:!1,azimuthTolerance:10,rasterListRefresh:!0,extents:[],maxExtentIdx:5,currentExtentIdx:null,setNextExtent:function(){if(!(this.currentExtentIdx>=this.maxExtentIdx||this.currentExtentIdx>=this.extents.length-1)){var a=this;this.currentExtentIdx++;var c=new g,b;c.method=g.METHOD_LOCKRASTER;c.lockRasterIds=
[this.extents[this.currentExtentIdx].spatialReference.icsid];a.imageServiceLayer.setMosaicRule(c,!0);a._refreshOK=!1;a.map.spatialReference=this.extents[this.currentExtentIdx].spatialReference;b=e.defaults.map.zoomDuration;e.defaults.map.zoomDuration=0;a.map.setExtent(this.extents[this.currentExtentIdx]).then(function(){a._refreshOK=!0;e.defaults.map.zoomDuration=b})}},setPreviousExtent:function(){if(!(0>=this.currentExtentIdx)){var a=this;this.currentExtentIdx--;var c=new g,b;c.method=g.METHOD_LOCKRASTER;
c.lockRasterIds=[this.extents[this.currentExtentIdx].spatialReference.icsid];a.imageServiceLayer.setMosaicRule(c,!0);a._refreshOK=!1;a.map.spatialReference=this.extents[this.currentExtentIdx].spatialReference;b=e.defaults.map.zoomDuration;e.defaults.map.zoomDuration=0;a.map.setExtent(this.extents[this.currentExtentIdx]).then(function(){a._refreshOK=!0;e.defaults.map.zoomDuration=b})}},isPreviousAvailable:function(){},isNextAvailable:function(){},_isICS:function(a){return!(!a.ics&&!a.icsid)},resizeRotationGauge:function(a){this._rotationWidget.resize(a)},
_initializeTasks:function(){this.obliqueRecordsQueryTask=new A(this.imageServiceUrl);this.projectTask=new F},_verifyRasterInfoFields:function(){return this.rasterInfoFields&&this.rasterInfoFields.length},_setupRasterList:function(){var a=this,c=[{name:this.imageServiceLayer.objectIdField,alias:"Object ID",display:!0},{name:this.azimuthField,alias:"Azimuth",display:!0},{name:this.elevationField,alias:this.elevationField,display:!0}];this.rasterInfoFields=this._verifyRasterInfoFields()?this.rasterInfoFields:
c;this.rasterList=new H({data:new u(new v),showThumbnail:this.showThumbnail,imageServiceUrl:this.imageServiceLayer.url,fields:this.rasterInfoFields},this.rasterListDiv);this.rasterList.on("raster-select",function(b){a.selectedRasterId=b[a.imageServiceLayer.objectIdField];a.emit("raster-select",{selectedRasterId:a.selectedRasterId});a.setImage(a.selectedRasterId,a.map.extent);f.forEach(a.filteredRecords,function(b){delete b.attributes.selected;b.attributes[a.imageServiceLayer.objectIdField]===a.selectedRasterId&&
(b.attributes.selected=!0)});a._rotationWidget&&a._rotationWidget.setAzimuth(b[a.azimuthField])});this.rasterList.startup()},_setupRotationWidget:function(){var a=this;this._rotationWidget=new D({snap:this.snap,azimuthAngle:this.azimuthAngle},this.rotationDiv);this._rotationWidget.startup();this.own(this._rotationWidget.on("azimuth-change",function(c){c=c.azimuth;a.currentExtentIdx=0;a.extents=[];a.emit("azimuth-change",{azimuth:c});c?(a.azimuthAngle=c,a._checkExtentOrientation(),a._filterByAzimuth(),
a._rotationWidget.refresh({features:a.records}),a._refreshListDijit(a.filteredRecords),a._refreshImage(a.map.extent),a._oldAzimuth=c,a.isNadir=!1):a._switchToNadir()}))},_checkExtentOrientation:function(){var a=Math.abs((this._oldAzimuth-this.azimuthAngle)/90%2);this._azimuthExtentChanged=0.25>a||1.75<a?!1:!0},_refreshListDijit:function(a){a=this._prepareListData(a);this.rasterList&&this.rasterListRefresh&&this.rasterList.setData(a);this.emit("records-refresh",{records:this.records,filteredRecords:this.filteredRecords})},
_prepareListData:function(a){var c=[],b,d=this.imageServiceLayer.objectIdField;f.forEach(a,function(a){b=a.attributes;b.thumbnailUrl=this.imageServiceUrl+"/"+b[d]+"/thumbnail";c.push(b)},this);return new u(new v({data:c,idProperty:this.imageServiceLayer.objectIdField}))},_switchToNadir:function(){var a=!!this.map.extent.spatialReference.icsid,c=this.defaultNadirMosaicRule||this.imageServiceLayer.mosaicRule||new g;this._oldAzimuth=this.azimuthAngle=null;this._azimuthExtentChanged=!1;c.method=c.method||
g.METHOD_NONE;c.where=this.elevationField+"\x3e"+this.elevationThreshold;this.defaultNadirMosaicRule=c;this.imageServiceLayer.setMosaicRule(c,a);if(a){var b=this,d;this.projectGeometry(this.map.extent,this.nadirSpatialReference).then(function(a){b._verifyExtent(a[0])&&(b._refreshOK=!1,b.map.spatialReference=a[0].spatialReference,d=e.defaults.map.zoomDuration,e.defaults.map.zoomDuration=0,b.map.setExtent((new n(a[0])).setSpatialReference(a[0].spatialReference)).then(function(){b._refreshOK=!0;b.isNadir=
!0;e.defaults.map.zoomDuration=d;b.selectedRasterId=null;b.selectedRaster=null;b.filteredRecords=null}))})}},projectGeometry:function(a,c){var b=new G;c=c||this.map.spatialReference;b.geometries=[a];b.outSR=c;return this.projectTask.execute(b)},_verifyExtent:function(a){return!isNaN(a.xmin)&&!isNaN(a.xmax)&&!isNaN(a.ymin)&&!isNaN(a.ymax)},_verifyPoint:function(a){return!isNaN(a.x)&&!isNaN(a.y)},_refreshRecords:function(a){function c(c){b._verifyExtent(c[0].getExtent())?(b.nadirExtent=c[0].getExtent(),
b.emit("extent-change",{extent:c[0]}),b.search(b._trimExtent(b.nadirExtent,d)).then(function(c){if(!c||!c.features||!c.features.length)return console.log("Oblique viewer: no records returned");b.records=c.features;b._rotationWidget&&b._rotationWidget.refresh({features:b.records});b.isNadir?b._refreshListDijit(b.records):(b._filterByAzimuth(),b._refreshListDijit(b.filteredRecords),a&&(b.filteredRecords&&b.filteredRecords.length)&&b._refreshImage(b.map.extent))})):(console.error("Oblique viewer: Project Operation returned invalid extent"),
b.search(b._trimExtent(b.map.extent,d)).then(function(c){if(!c||!c.features||!c.features.length)return console.log("Oblique viewer: no records returned");b.records=c.features;b._rotationWidget&&b._rotationWidget.refresh({features:b.records});b.isNadir?b._refreshListDijit(b.records):(b._filterByAzimuth(),b._refreshListDijit(b.filteredRecords),a&&(b.filteredRecords&&b.filteredRecords.length)&&b._refreshImage((new p(b.filteredRecords[0].geometry)).getExtent()))}))}var b=this,d=0.15;this.nadirSpatialReference.equals(this.map.extent.spatialReference)?
c([this.map.extent]):this.projectGeometry(this._convertExtentToPolygon(this.map.extent),this.nadirSpatialReference).then(c)},_convertExtentToPolygon:function(a){var c=new p(a.spatialReference);c.addRing([[a.xmax,a.ymin],[a.xmax,a.ymax],[a.xmin,a.ymax],[a.xmin,a.ymin],[a.xmax,a.ymin]]);return c},postCreate:function(){this.inherited(arguments);(!this.map||!this.imageServiceLayer)&&console.error("ObliqueViewer: Map or Image service layer not provided.");this.imageServiceUrl=this.imageServiceLayer.url;
this.nadirSpatialReference=this.map.extent.spatialReference;this._initializeTasks();(this.isNadir=!s.isDefined(this.azimuthAngle))&&this._switchToNadir();this.rotationDiv&&this._setupRotationWidget();if(this.rasterListDiv)if(this.imageServiceLayer.loaded)this._setupRasterList();else this.imageServiceLayer.on("load",r.hitch(this,this._setupRasterList));this.sorter||(this.sorter=this._sortSpatially);this.own(this.map.on("extent-change",r.hitch(this,function(a){this._refreshOK&&!this.noQueryOnExtentChange&&
(this._isICS(this.map.extent.spatialReference)||(this.nadirExtent=this.map.extent,this._switchToNadir(),this.emit("extent-change",{extent:this._convertExtentToPolygon(this.nadirExtent)})),this._refreshRecords(!0),this._azimuthExtentChanged=!1)})));s.isDefined(this.azimuthAngle)&&!this.noQueryOnExtentChange&&this._refreshRecords()},_refreshImage:function(a){!this.filteredRecords||!this.filteredRecords.length||this.selectedRasterId===this.filteredRecords[0].attributes[this.imageServiceLayer.objectIdField]?
this._refreshSavedExtents():this._setSelectedRaster(a)},_refreshSavedExtents:function(){this._isICS(this.map.extent.spatialReference)&&(!this.extents||!this.extents.length?(this.currentExtentIdx=0,this.extents=[]):(this.extents.length>this.maxExtentIdx&&(this.extents.shift(),this.currentExtentIdx--),this.currentExtentIdx<this.extents.length-1?this.currentExtentIdx=this.extents.length-1:this.currentExtentIdx++),this.extents.push(this.map.extent))},_createExtent:function(a,c,b){var d=1.00001*(b.getWidth()/
2);b=b.getHeight()/2;return new n(a.x-d,a.y-b,a.x+d,a.y+b,c)},setImage:function(a,c){function b(b){if(m)if(d._verifyPoint(b[0]))k=d._createExtent(b[0],d.imageSpatialReference,m),d.projectGeometry(d._convertExtentToPolygon(k),d.nadirSpatialReference).then(function(a){d.emit("extent-change",{extent:a[0]})});else return console.log("Project operation returned invalid result.");else{if(!m&&!d._verifyExtent(b[0]))return console.log("Project operation returned invalid extent.");k=b[0]}l=new g;l.method=
g.METHOD_LOCKRASTER;l.lockRasterIds=[a];d.imageServiceLayer.setMosaicRule(l,!0);d._refreshOK=!1;d.map.spatialReference=k.spatialReference;f=e.defaults.map.zoomDuration;x=e.defaults.map.panDuration=0;e.defaults.map.zoomDuration=0;e.defaults.map.panDuration=0;d.map.setExtent((new n(k)).setSpatialReference(k.spatialReference)).then(function(){d._refreshOK=!0;e.defaults.map.zoomDuration=f;e.defaults.map.panDuration=x;d._refreshSavedExtents();d.projectGeometry(d._convertExtentToPolygon(k),d.nadirSpatialReference).then(function(a){d.emit("extent-change",
{extent:a[0]})})})}if(!a)return console.error("Object ID of raster to be displayed not provided");var d=this,l,f,x,m=c&&(c.spatialReference.icsid||c.spatialReference.ics)?c:null,k;this.imageSpatialReference=new E({icsid:a,url:this.imageServiceUrl});c&&c.spatialReference&&!c.spatialReference.ics&&!c.spatialReference.icsid?(d.nadirExtent=c.getExtent(),d.projectGeometry(d.nadirExtent,d.imageSpatialReference).then(b)):this.projectGeometry(this._convertExtentToPolygon(this._adjustExtentAspectRatio(c)),
this.nadirSpatialReference).then(function(a){d.nadirExtent=a[0].getExtent().setSpatialReference(d.nadirSpatialReference);d.projectGeometry(c.getCenter(),d.imageSpatialReference).then(b)})},locate:function(a){if(!a)return console.error("Geometry not specified.");var c=this,b=a.type&&"extent"===a.type?a:a.getExtent();this.search(a).then(function(a){c.setData(a.features,b)})},search:function(a){if(!a)return console.error("Oblique viewer: no geometry provided for search.");var c,b=new w,d=this;c=new t;
c.geometry=a;c.outFields=this._getQueryFields()||[this.imageServiceLayer.objectIdField,this.azimuthField];c.returnGeometry=!0;c.where=this.elevationField+"\x3c"+this.elevationThreshold;c.outSpatialReference=a.spatialReference;c.spatialRel="esriSpatialRelContains";this.obliqueRecordsQueryTask.execute(c).then(function(c){b.resolve({features:d.sorter(d._processRecords(c.features),a)})});return b.promise},_sortSpatially:function(a,c){if(a&&a.length&&this.map.loaded){var b=0,d=0,l=a[0],e,g,m,k,b=0,h;h=
this.nadirExtent||this.map.extent;c&&("extent"===c.type&&c.spatialReference.equals(a[0].geometry.spatialReference))&&(h=c);h=h.getCenter();this.selectedRaster&&this._extentContained(this.selectedRaster,this.nadirExtent)&&(f.some(a,function(b,c){if(b.attributes[this.imageServiceLayer.objectIdField]===this.selectedRasterId)return m=a[c],a[c]=l,a[0]=m,!0},this),b=1);for(;b<a.length;b++){e=Math.sqrt((a[b].center.x-h.x)*(a[b].center.x-h.x)+(a[b].center.y-h.y)*(a[b].center.y-h.y));k=b;for(d=b+1;d<a.length;d++)g=
Math.sqrt((a[d].center.x-h.x)*(a[d].center.x-h.x)+(a[d].center.y-h.y)*(a[d].center.y-h.y)),e>g&&(l=a[d],e=g,k=d);b!==k&&(m=a[b],a[b]=l,a[k]=m)}}return a},_filterByAzimuth:function(){this.filteredRecords=[];f.forEach(this.records,function(a){Math.min(Math.abs(a.attributes[this.azimuthField]-this.azimuthAngle),Math.abs(a.attributes[this.azimuthField]-this.azimuthAngle-360))<=this.azimuthTolerance&&this.filteredRecords.push(a)},this);this.filteredRecords&&this.filteredRecords.length&&(this.filteredRecords[0].attributes.selected=
!0)},_processRecords:function(a){var c;f.forEach(a,function(a){c=(new p(a.geometry)).setSpatialReference(this.nadirSpatialReference).getCentroid();a.center=c},this);return a},_computeAzimuthFilter:function(){var a=(this.azimuthAngle+350)%360,c=(this.azimuthAngle+10)%360;return a<c?this.azimuthField+" BETWEEN "+a+" AND "+c:"("+this.azimuthField+" BETWEEN 0 AND "+c+" OR "+this.azimuthField+" BETWEEN "+a+" AND 360)"},_getIds:function(a){var c=[],b=this;f.forEach(a,function(a){c.push(a.attributes[b.imageServiceLayer.objectIdField])});
return c},_adjustExtentAspectRatio:function(a){var c;if(!this._azimuthExtentChanged){var b=0.45*a.getHeight(),d=0.45*a.getWidth();c=a.getCenter();return a=new n(c.x-d,c.y-b,c.x+d,c.y+b,a.spatialReference)}var e;c=a.getCenter();d=a.getWidth();b=a.getHeight();e=b>d?0.8<d/b?0.5:0.36:0.7<b/d?0.5:0.65;b=Math.min(b,d)*e;return a=new n(c.x-b,c.y-b,c.x+b,c.y+b,a.spatialReference)},_setRasterListRefreshAttr:function(a){this._set("rasterListRefresh",a);a&&this._refreshListDijit(this.isNadir?this.records:this.filteredRecords)},
_extentContained:function(a,c){if(!a||!c)return!1;var b=(new p(a.geometry)).getExtent();return this._trimExtent(b,0.2).contains(c)},setData:function(a,c){if(!a)return console.error("Oblique viewer: records not provided.");c=c||this.map.extent;this._set("records",a);this._filterByAzimuth();if(this.filteredRecords&&this.filteredRecords.length)if(this._refreshListDijit(this.filteredRecords),this.imageServiceLayer.loaded)this._setSelectedRaster(c);else this.imageServiceLayer.on("load",r.hitch(this,function(){this._setSelectedRaster(c)}));
else this.selectedRasterId=this.selectedRaster=null,this.emit("raster-select",{selectedRasterId:null})},_setSelectedRaster:function(a){this.selectedRaster=this.filteredRecords[0];this.selectedRasterId=this.selectedRaster.attributes[this.imageServiceLayer.objectIdField];this.setImage(this.selectedRaster.attributes[this.imageServiceLayer.objectIdField],a);this.emit("raster-select",{selectedRasterId:this.selectedRasterId})},setExtent:function(a){var c=new w,b=this;this.projectGeometry(a,this.map.spatialReference).then(function(a){b._verifyExtent(a[0])&&
b.map.setExtent(a[0]).then(function(){c.resolve()})});return c.promise},zoomToSelectedImage:function(){if(!s.isDefined(this.selectedRasterId))return console.error("Oblique viewer: no selected raster.");if(this.isNadir)return console.log("Viewer in nadir mode, no selected raster.");var a=this,c;this._getImageGeometry(this.selectedRasterId,this.map.spatialReference).then(function(b){b.features&&b.features.length&&(c=(new p(b.features[0].geometry)).setSpatialReference(a.map.spatialReference),a.map.setExtent(c.getExtent()))})},
_getImageGeometry:function(a,c){var b=new t;b.objectIds=[a];b.returnGeometry=!0;b.outSpatialReference=c;return this.obliqueRecordsQueryTask.execute(b)},_getQueryFields:function(){var a=[];f.forEach(this.rasterInfoFields,function(c){c.name&&a.push(c.name)});0>f.indexOf(a,this.azimuthField)&&a.push(this.azimuthField);0>f.indexOf(a,this.imageServiceLayer.objectIdField)&&a.push(this.imageServiceLayer.objectIdField);return a},_trimExtent:function(a,c){var b,d,e;c=c||0.15;b=a.ymax-a.ymin;d=b*(1-c);b*=1-
c;e=a.getCenter();return new n({xmin:e.x-b/2,ymin:e.y-d/2,xmax:e.x+b/2,ymax:e.y+d/2,spatialReference:a.spatialReference})}});y("extend-esri")&&r.setObject("dijit.ObliqueViewer",q,z);return q});