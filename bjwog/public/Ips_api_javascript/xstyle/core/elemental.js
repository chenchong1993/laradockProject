//>>built
define("xstyle/core/elemental",["put-selector/put","xstyle/core/utils"],function(z,A){function l(a,b,d,e){function c(a){if(!d)return e(a);var b=a.target;do if(m(b,d))return e(a);while((b=b.parentNode)&&1===b.nodeType)}B?a.addEventListener(b,c,!!s[b]):C(a,s[b]||b,c)}function C(a,b,d){b="on"+b;var e=a[b];a[b]=function(a){a=a||window.event;a.target=a.target||a.srcElement;e&&e(a);d(a)}}function t(a){/e/.test(k.readyState||"")?a():k.addEventListener("DOMContentLoaded",a)}function u(a){for(var b=k.querySelectorAll(a.selector),
d=a.name,e=0,c=b.length;e<c;e++){var g=b[e],f=g.elementalStyle;f||(f=g.elementalStyle={},g.elementalSpecificities={});var h=g.renderings;h||(h=g.renderings=[],n.push(g));h.push({name:d,rendered:f[d]==a.propertyValue,renderer:a});f[d]=a.propertyValue}}function v(){for(;n.length;){for(var a=n.shift(),b=a.renderings,d=a.elementalStyle;b.length;){var e=b.shift(),c=e.renderer,g=c.rendered;p=d[e.name]==c.propertyValue;if(!g&&p)try{c.render(a)}catch(f){console.error(f,f.stack),z(a,"div.error",f.toString())}g&&
(!p&&c.unrender)&&c.unrender(a)}a.renderings=void 0}}function w(a,b){for(var d=0,e=f.length;d<e;d++){var c=f[d];(!b||b==c.selector)&&m(a,c.rule)&&c.render(a)}}function x(a,b){var d={selector:a.selector,rule:a,render:b};f.push(d);q&&u(d);v();return{remove:function(){f.splice(f.indexOf(d),1)}}}var k=document,D=1,B=!!k.addEventListener,s={blur:"focusout",focus:"focusin"};l(k,"change",null,function(a){a=a.target;for(var b=0,d=r.length;b<d;b++){var e=r[b];if(-1<(" "+a.className+" ").indexOf(e.rule.selector.slice(1))){var c=
e.definition.valueOf();c&&c.forRule&&(c=c.forRule(e.rule));c&&c.forElement&&(c=c.forElement(a));var g="checkbox"===a.type?a.checked:a.value;"number"===typeof c&&isFinite(g)&&(g=+g);(c=e.definition.put(g))&&c.forRule&&(c=c.forRule(e.rule));c&&c.forElement&&c.forElement(a)}}});navigator.userAgent.match(/MSIE|Trident/)&&l(k,"keydown",null,function(a){if(13==a.keyCode){var b=a.target;if(document.createEvent)a=document.createEvent("Events"),a.initEvent("change",!0,!0),b.dispatchEvent(a);else document.onchange({target:b})}});
var h=k.createElement("div"),E={"dom-qsa2.1":!!h.querySelectorAll},y=h.matches||h.matchesSelector||h.webkitMatchesSelector||h.mozMatchesSelector||h.msMatchesSelector||h.oMatchesSelector,f=[],r=[],n=[],q;t(function(){if(!q)if(q=!0,E["dom-qsa2.1"]){for(var a=0,b=f.length;a<b;a++)u(f[a]);v()}else for(var d=k.all,a=0,b=d.length;a<b;a++)w(d[a])});var p,m=y?function(a,b){return y.call(a,b.selector)}:function(a,b){b.ieId||b.setStyle(b.ieId="x-ie-"+D++,"true");return!!a.currentStyle[b.ieId]};return{ready:t,
on:l,matchesRule:m,addRenderer:x,addInputConnector:function(a,b){r.push({rule:a,definition:b})},update:w,clearRenderers:function(){f=[]},observeForElement:function(a,b,d){return A.when(a,function(a){function c(a){a.observe?a.observe(d):d(a)}a.forElement?x(b,function(b){c(a.forElement(b))}):c(a)})}}});