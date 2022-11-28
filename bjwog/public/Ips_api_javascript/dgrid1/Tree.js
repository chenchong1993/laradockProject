//>>built
define("dgrid1/Tree","dojo/_base/declare dojo/_base/lang dojo/_base/array dojo/aspect dojo/dom-construct dojo/dom-class dojo/on dojo/query dojo/when ./util/has-css3 ./Grid dojo/has!touch?./util/touch".split(" "),function(w,x,y,B,q,n,z,t,A,v,C,r){return w(null,{collapseOnRefresh:!1,enableTreeTransitions:!0,treeIndentWidth:9,constructor:function(){this._treeColumnListeners=[]},shouldExpand:function(a,b,c){return c},expand:function(a,b,c){if(this._treeColumn){var d=this,e=a.element?a:this.row(a),h=!!this._expanded[e.id],
m=v("transitionend"),p;a=e.element;a=-1<a.className.indexOf("dgrid-expando-icon")?a:t(".dgrid-expando-icon",a)[0];c=c||!this.enableTreeTransitions;if(a&&a.mayHaveChildren&&(c||b!==h)){var g=void 0===b?!this._expanded[e.id]:b;n.replace(a,"ui-icon-triangle-1-"+(g?"se":"e"),"ui-icon-triangle-1-"+(g?"e":"se"));n.toggle(e.element,"dgrid-row-expanded",g);b=e.element;var f=b.connected,k,u,l={};if(!f){var f=l.container=b.connected=q.create("div",{className:"dgrid-tree-container"},b,"after"),s=function(a){var b=
d._renderedCollection.getChildren(e.data);d.sort&&0<d.sort.length&&(b=b.sort(d.sort));b.track&&d.shouldTrackCollection&&(f._rows=a.rows=[],b=b.track(),f._handles=[b.tracking,d._observeCollection(b,f,a)]);return"start"in a?b.fetchRange({start:a.start,end:a.start+a.count}):b.fetch()};"level"in a&&(f.level=s.level=a.level+1);if(this.renderQuery)p=this.renderQuery(s,l);else{var r=q.create("div",null,f);p=this._trackError(function(){return d.renderQueryResults(s(l),r,x.mixin({rows:l.rows},"level"in s?
{queryLevel:s.level}:null)).then(function(a){q.destroy(r);return a})})}m&&z(f,m,this._onTreeTransitionEnd)}f.hidden=!g;k=f.style;!m||c?(k.display=g?"block":"none",k.height=""):(g?(k.display="block",u=f.scrollHeight,k.height="0px"):(n.add(f,"dgrid-tree-resetting"),k.height=f.scrollHeight+"px"),setTimeout(function(){n.remove(f,"dgrid-tree-resetting");k.height=g?u?u+"px":"auto":"0px"},0));g?this._expanded[e.id]=!0:delete this._expanded[e.id]}return A(p)}},_configColumns:function(){var a=this.inherited(arguments);
this._expanded={};for(var b=0,c=a.length;b<c;b++)if(a[b].renderExpando){this._configureTreeColumn(a[b]);break}return a},insertRow:function(a,b,c,d,e){e=e||{};var h=e.queryLevel="queryLevel"in e?e.queryLevel:"level"in b?b.level:0,m=this.inherited(arguments),p=this.row(m);(h=this.shouldExpand(p,h,this._expanded[p.id]))&&this.expand(m,!0,!0);(h||!this.collection.mayHaveChildren||this.collection.mayHaveChildren(a))&&n.add(m,"dgrid-row-expandable");return m},removeRow:function(a,b){var c=a.connected,d=
{};c&&(c._handles&&(y.forEach(c._handles,function(a){a.remove()}),delete c._handles),c._rows&&(d.rows=c._rows),t("\x3e.dgrid-row",c).forEach(function(a){this.removeRow(a,!0,d)},this),c._rows&&(c._rows.length=0,delete c._rows),b||q.destroy(c));this.inherited(arguments)},_refreshCellFromItem:function(a,b){if(!a.column.renderExpando)return this.inherited(arguments);this.inherited(arguments,[a,b,{queryLevel:t(".dgrid-expando-icon",a.element)[0].level}])},cleanup:function(){this.inherited(arguments);this.collapseOnRefresh&&
(this._expanded={})},_destroyColumns:function(){this.inherited(arguments);for(var a=this._treeColumnListeners,b=a.length;b--;)a[b].remove();this._treeColumnListeners=[];this._treeColumn=null},_calcRowHeight:function(a){var b=a.connected;return this.inherited(arguments)+(b?b.offsetHeight:0)},_configureTreeColumn:function(a){var b=this,c=".dgrid-content .dgrid-column-"+a.id,d;this._treeColumn=a;if(!a._isConfiguredTreeColumn){var e=a.renderCell||this._defaultRenderCell;a._isConfiguredTreeColumn=!0;a.renderCell=
function(c,d,g,f){var k=f&&"queryLevel"in f?f.queryLevel:0,h=!b.collection.mayHaveChildren||b.collection.mayHaveChildren(c),l;l=a.renderExpando(k,h,b._expanded[b.collection.getIdentity(c)],c);l.level=k;l.mayHaveChildren=h;(c=e.call(a,c,d,g,f))&&c.nodeType?(g.appendChild(l),g.appendChild(c)):g.insertBefore(l,g.firstChild)};"function"!==typeof a.renderExpando&&(a.renderExpando=this._defaultRenderExpando)}var h=this._treeColumnListeners;0===h.length&&(h.push(this.on(a.expandOn||".dgrid-expando-icon:click,"+
c+":dblclick,"+c+":keydown",function(a){var c=b.row(a);(!b.collection.mayHaveChildren||b.collection.mayHaveChildren(c.data))&&(("keydown"!==a.type||32===a.keyCode)&&!("dblclick"===a.type&&d&&1<d.count&&c.id===d.id&&-1<a.target.className.indexOf("dgrid-expando-icon")))&&b.expand(c);-1<a.target.className.indexOf("dgrid-expando-icon")&&(d&&d.id===b.row(a).id?d.count++:d={id:b.row(a).id,count:1})})),v("touch")&&h.push(this.on(r.selector(c,r.dbltap),function(){b.expand(this)})))},_defaultRenderExpando:function(a,
b,c){var d=this.grid.isRTL?"right":"left",e="dgrid-expando-icon";b&&(e+=" ui-icon ui-icon-triangle-1-"+(c?"se":"e"));return q.create("div",{className:e,innerHTML:"\x26nbsp;",style:"margin-"+d+": "+a*this.grid.treeIndentWidth+"px; float: "+d+";"})},_onNotification:function(a,b){"delete"===b.type&&delete this._expanded[b.id];this.inherited(arguments)},_onTreeTransitionEnd:function(a){var b=this,c=this.style.height;c&&(this.style.display="0px"===c?"none":"block");a&&(n.add(this,"dgrid-tree-resetting"),
setTimeout(function(){n.remove(b,"dgrid-tree-resetting")},0));this.style.height=""}})});