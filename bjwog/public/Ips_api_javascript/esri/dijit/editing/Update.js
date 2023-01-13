// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.17/esri/copyright.txt for details.
//>>built
define("esri/dijit/editing/Update","dojo/_base/array dojo/_base/declare dojo/_base/lang dojo/has ../../kernel ../../geometry/jsonUtils ./EditOperationBase".split(" "),function(d,f,c,g,h,e,k){d=f(k,{declaredClass:"esri.dijit.editing.Update",type:"edit",label:"Update Features",constructor:function(a){var b;a=a||{};if(a.featureLayer)if(this._featureLayer=a.featureLayer,a.preUpdatedGraphics){this._preUpdatedGraphicsGeometries=[];this._preUpdatedGraphicsAttributes=[];for(b=0;b<a.preUpdatedGraphics.length;b++)this._preUpdatedGraphicsGeometries.push(a.preUpdatedGraphics[b].geometry.toJson()),
this._preUpdatedGraphicsAttributes.push(a.preUpdatedGraphics[b].attributes);if(a.postUpdatedGraphics){this._postUpdatedGraphics=a.postUpdatedGraphics;this._postUpdatedGraphicsGeometries=[];this._postUpdatedGraphicsAttributes=[];for(b=0;b<a.postUpdatedGraphics.length;b++)this._postUpdatedGraphicsGeometries.push(a.postUpdatedGraphics[b].geometry.toJson()),this._postUpdatedGraphicsAttributes.push(c.clone(a.postUpdatedGraphics[b].attributes))}else console.error("In constructor of 'esri.dijit.editing.Update', postUpdatedGraphics not provided")}else console.error("In constructor of 'esri.dijit.editing.Update', preUpdatedGraphics not provided");
else console.error("In constructor of 'esri.dijit.editing.Update', featureLayer not provided")},updateObjectIds:function(a,b){this.updateIds(this._featureLayer,this._preUpdatedGraphicsAttributes,a,b);this.updateIds(this._featureLayer,this._postUpdatedGraphicsAttributes,a,b)},performUndo:function(){var a;for(a=0;a<this._postUpdatedGraphics.length;a++)this._postUpdatedGraphics[a].setGeometry(e.fromJson(this._preUpdatedGraphicsGeometries[a])),this._postUpdatedGraphics[a].setAttributes(this._preUpdatedGraphicsAttributes[a]);
return this._featureLayer.applyEdits(null,this._postUpdatedGraphics,null).then(c.hitch(this,function(){return{layer:this._featureLayer,operation:this}}))},performRedo:function(){var a;for(a=0;a<this._postUpdatedGraphics.length;a++)this._postUpdatedGraphics[a].setGeometry(e.fromJson(this._postUpdatedGraphicsGeometries[a])),this._postUpdatedGraphics[a].setAttributes(this._postUpdatedGraphicsAttributes[a]);return this._featureLayer.applyEdits(null,this._postUpdatedGraphics,null).then(c.hitch(this,function(){return{layer:this._featureLayer,
operation:this}}))}});g("extend-esri")&&c.setObject("dijit.editing.Update",d,h);return d});