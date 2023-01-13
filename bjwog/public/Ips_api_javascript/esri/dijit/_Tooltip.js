// All material copyright ESRI, All Rights Reserved, unless otherwise specified.
// See http://js.arcgis.com/3.17/esri/copyright.txt for details.
//>>built
define("esri/dijit/_Tooltip",["dijit/Tooltip","dojo/_base/array","dojo/_base/declare","dojo/_base/lang","dojo/dom"],function(f,d,k,g,l){return k(null,{declaredClass:"esri.dijit._Tooltip",_tooltips:null,constructor:function(){this._tooltips=[]},startup:function(){this.inherited(arguments);this._started||d.forEach(this._tooltips,function(a){a.startup()})},destroy:function(){this.inherited(arguments);d.forEach(this._tooltips,function(a){a.destroy()});this._tooltips=null},createTooltips:function(a){d.forEach(a,
function(a){this.createTooltip(a.node,a.label)},this)},createTooltip:function(a,c){var b=this._getConnectId(a);b&&(b="object"===typeof c?g.mixin({},c,{connectId:b}):{connectId:b,label:c},b=new f(b),this._started&&b.startup(),this._tooltips.push(b))},_getConnectId:function(a){var c,b;if(a){if(g.isArray(a)){if(c=[],d.forEach(a,function(a){(b=this._getNode(a))&&c.push(b)}),0===c.length)return}else if(c=this._getNode(a),!c)return;return c}},_getNode:function(a){return l.byId(a.domNode||a)},findTooltip:function(a){var c=
this._getNode(a),b,e,f;if(a){a=this._tooltips;b=a.length;for(var h=0;h<b;h++)if(e=a[h],f=g.isArray(e.connectId)?-1<d.indexOf(e.connectId,c):e.connectId===c)return e}}})});