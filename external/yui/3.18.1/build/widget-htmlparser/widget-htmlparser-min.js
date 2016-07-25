/*
YUI 3.18.1 (build f7e7bcb)
Copyright 2014 Yahoo! Inc. All rights reserved.
Licensed under the BSD License.
http://yuilibrary.com/license/
*/

YUI.add("widget-htmlparser",function(e,t){var n=e.Widget,r=e.Node,i=e.Lang,s="srcNode",o="contentBox";n.HTML_PARSER={},n._buildCfg={aggregates:["HTML_PARSER"]},n.ATTRS[s]={value:null,setter:r.one,getter:"_getSrcNode",writeOnce:!0},e.mix(n.prototype,{_getSrcNode:function(e){return e||this.get(o)},_preAddAttrs:function(e,t,n){var r={id:e.id,boundingBox:e.boundingBox,contentBox:e.contentBox,srcNode:e.srcNode};this.addAttrs(r,t,n),delete e.boundingBox,delete e.contentBox,delete e.srcNode,delete e.id,this._applyParser&&this._applyParser(t)},_applyParsedConfig:function(t,n,r){return r?e.mix(n,r,!1):n},_applyParser:function(t){var n=this,r=this._getNodeToParse(),s=n._getHtmlParser(),o,u;s&&r&&e.Object.each(s,function(e,t,s){u=null,i.isFunction(e)?u=e.call(n,r):i.isArray(e)?(u=r.all(e[0]),u.isEmpty()&&(u=null)):u=r.one(e),u!==null&&u!==undefined&&(o=o||{},o[t]=u)}),t=n._applyParsedConfig(r,t,o)},_getNodeToParse:function(){var e=this.get("srcNode");return this._cbFromTemplate?null:e},_getHtmlParser:function(){var t=this._getClasses(),n={},r,i;for(r=t.length-1;r>=0;r--)i=t[r].HTML_PARSER,i&&e.mix(n,i,!0);return n}})},"3.18.1",{requires:["widget-base"]});
