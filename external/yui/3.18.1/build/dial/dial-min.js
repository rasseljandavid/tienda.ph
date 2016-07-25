/*
YUI 3.18.1 (build f7e7bcb)
Copyright 2014 Yahoo! Inc. All rights reserved.
Licensed under the BSD License.
http://yuilibrary.com/license/
*/

YUI.add("dial",function(e,t){function o(e){o.superclass.constructor.apply(this,arguments)}function u(t){return e.ClassNameManager.getClassName(o.NAME,t)}var n=!1;e.UA.ie&&e.UA.ie<9&&(n=!0);var r=e.Lang,i=e.Widget,s=e.Node;o.NAME="dial",o.ATTRS={min:{value:-220},max:{value:220},diameter:{value:100},handleDiameter:{value:.2},markerDiameter:{value:.1},centerButtonDiameter:{value:.5},value:{value:0,validator:function(e){return this._validateValue(e)}},minorStep:{value:1},majorStep:{value:10},stepsPerRevolution:{value:100},decimalPlaces:{value:0},strings:{valueFn:function(){return e.Intl.get("dial")}},handleDistance:{value:.75}},o.CSS_CLASSES={label:u("label"),labelString:u("label-string"),valueString:u("value-string"),northMark:u("north-mark"),ring:u("ring"),ringVml:u("ring-vml"),marker:u("marker"),markerVml:u("marker-vml"),markerMaxMin:u("marker-max-min"),centerButton:u("center-button"),centerButtonVml:u("center-button-vml"),resetString:u("reset-string"),handle:u("handle"),handleVml:u("handle-vml"),hidden:u("hidden"),dragging:e.ClassNameManager.getClassName("dd-dragging")},o.LABEL_TEMPLATE='<div class="'+o.CSS_CLASSES.label+'"><span id="" class="'+o.CSS_CLASSES.labelString+'">{label}</span><span class="'+o.CSS_CLASSES.valueString+'"></span></div>',n===!1?(o.RING_TEMPLATE='<div class="'+o.CSS_CLASSES.ring+'"><div class="'+o.CSS_CLASSES.northMark+'"></div></div>',o.MARKER_TEMPLATE='<div class="'+o.CSS_CLASSES.marker+" "+o.CSS_CLASSES.hidden+'"></div>',o.CENTER_BUTTON_TEMPLATE='<div class="'+o.CSS_CLASSES.centerButton+'"><div class="'+o.CSS_CLASSES.resetString+" "+o.CSS_CLASSES.hidden+'">{resetStr}</div></div>',o.HANDLE_TEMPLATE='<div class="'+o.CSS_CLASSES.handle+'" aria-labelledby="" aria-valuetext="" aria-valuemax="" aria-valuemin="" aria-valuenow="" role="slider"  tabindex="0" title="{tooltipHandle}">'):(o.RING_TEMPLATE='<div class="'+o.CSS_CLASSES.ring+" "+o.CSS_CLASSES.ringVml+'">'+'<div class="'+o.CSS_CLASSES.northMark+'"></div>'+'<v:oval strokecolor="#ceccc0" strokeweight="1px"><v:fill type=gradient color="#8B8A7F" color2="#EDEDEB" angle="45"/></v:oval>'+"</div>"+"",o.MARKER_TEMPLATE='<div class="'+o.CSS_CLASSES.markerVml+" "+o.CSS_CLASSES.hidden+'">'+'<v:oval stroked="false">'+'<v:fill opacity="20%" color="#000"/>'+"</v:oval>"+"</div>"+"",o.CENTER_BUTTON_TEMPLATE='<div class="'+o.CSS_CLASSES.centerButton+" "+o.CSS_CLASSES.centerButtonVml+'">'+'<v:oval strokecolor="#ceccc0" strokeweight="1px">'+'<v:fill type=gradient color="#C7C5B9" color2="#fefcf6" colors="35% #d9d7cb, 65% #fefcf6" angle="45"/>'+'<v:shadow on="True" color="#000" opacity="10%" offset="2px, 2px"/>'+"</v:oval>"+'<div class="'+o.CSS_CLASSES.resetString+" "+o.CSS_CLASSES.hidden+'">{resetStr}</div>'+"</div>"+"",o.HANDLE_TEMPLATE='<div class="'+o.CSS_CLASSES.handleVml+'" aria-labelledby="" aria-valuetext="" aria-valuemax="" aria-valuemin="" aria-valuenow="" role="slider"  tabindex="0" title="{tooltipHandle}">'+'<v:oval stroked="false">'+'<v:fill opacity="20%" color="#6C3A3A"/>'+"</v:oval>"+"</div>"+""),e.extend(o,i,{renderUI:function(){this._renderLabel(),this._renderRing(),this._renderMarker(),this._renderCenterButton(),this._renderHandle(),this.contentBox=this.get("contentBox"),this._originalValue=this.get("value"),this._minValue=this.get("min"),this._maxValue=this.get("max"),this._stepsPerRevolution=this.get("stepsPerRevolution"),this._minTimesWrapped=Math.floor(this._minValue/this._stepsPerRevolution-1),this._maxTimesWrapped=Math.floor(this._maxValue/this._stepsPerRevolution+1),this._timesWrapped=0,this._angle=this._getAngleFromValue(this.get("value")),this._prevAng=this._angle,this._setTimesWrappedFromValue(this._originalValue),this._handleNode.set("aria-valuemin",this._minValue),this._handleNode.set("aria-valuemax",this._maxValue)},_setBorderRadius:function(){this._ringNode.setStyles({WebkitBorderRadius:this._ringNodeRadius+"px",MozBorderRadius:this._ringNodeRadius+"px",borderRadius:this._ringNodeRadius+"px"}),this._handleNode.setStyles({WebkitBorderRadius:this._handleNodeRadius+"px",MozBorderRadius:this._handleNodeRadius+"px",borderRadius:this._handleNodeRadius+"px"}),this._markerNode.setStyles({WebkitBorderRadius:this._markerNodeRadius+"px",MozBorderRadius:this._markerNodeRadius+"px",borderRadius:this._markerNodeRadius+"px"}),this._centerButtonNode.setStyles({WebkitBorderRadius:this._centerButtonNodeRadius+"px",MozBorderRadius:this._centerButtonNodeRadius+"px",borderRadius:this._centerButtonNodeRadius+"px"})},_handleCenterButtonEnter:function(){this._resetString.removeClass(o.CSS_CLASSES.hidden)},_handleCenterButtonLeave:function(){this._resetString.addClass(o.CSS_CLASSES.hidden)},bindUI:function(){this.after("valueChange",this._afterValueChange);var t=this.get("boundingBox"),n=e.UA.opera?"press:":"down:",r=n+"38,40,33,34,35,36",i=n+"37,39",s=n+"37+meta,39+meta",o=e.DD.Drag;e.on("key",e.bind(this._onDirectionKey,this),t,r),e.on("key",e.bind(this._onLeftRightKey,this),t,i),t.on("key",this._onLeftRightKeyMeta,s,this),e.on("mouseenter",e.bind(this._handleCenterButtonEnter,this),this._centerButtonNode),e.on("mouseleave",e.bind(this._handleCenterButtonLeave,this),this._centerButtonNode),e.on("gesturemovestart",e.bind(this._resetDial,this),this._centerButtonNode),e.on("gesturemoveend",e.bind(this._handleCenterButtonMouseup,this),this._centerButtonNode),e.on(o.START_EVENT,e.bind(this._handleHandleMousedown,this),this._handleNode),e.on(o.START_EVENT,e.bind(this._handleMousedown,this),this._ringNode),e.on("gesturemoveend",e.bind(this._handleRingMouseup,this),this._ringNode),this._dd1=new o({node:this._handleNode,on:{"drag:drag":e.bind(this._handleDrag,this),"drag:start":e.bind(this._handleDragStart,this),"drag:end":e.bind(this._handleDragEnd,this)}}),e.bind(this._dd1.addHandle(this._ringNode),this)},_setTimesWrappedFromValue:function(e){e%this._stepsPerRevolution===0?this._timesWrapped=e/this._stepsPerRevolution:this._timesWrapped=Math.floor(e/this._stepsPerRevolution)},_getAngleFromHandleCenter:function(e,t){var n=Math.atan((
this._dialCenterY-t)/(this._dialCenterX-e))*(180/Math.PI);return n=this._dialCenterX-e<0?n+90:n+90+180,n},_calculateDialCenter:function(){this._dialCenterX=this._ringNode.get("offsetWidth")/2,this._dialCenterY=this._ringNode.get("offsetHeight")/2},_handleRingMouseup:function(){this._handleNode.focus()},_handleCenterButtonMouseup:function(){this._handleNode.focus()},_handleHandleMousedown:function(){this._handleNode.focus()},_handleDrag:function(e){var t,n,r,i;t=parseInt(this._handleNode.getStyle("left"),10)+this._handleNodeRadius,n=parseInt(this._handleNode.getStyle("top"),10)+this._handleNodeRadius,r=this._getAngleFromHandleCenter(t,n),this._prevAng>270&&r<90?this._timesWrapped<this._maxTimesWrapped&&(this._timesWrapped=this._timesWrapped+1):this._prevAng<90&&r>270&&this._timesWrapped>this._minTimesWrapped&&(this._timesWrapped=this._timesWrapped-1),i=this._getValueFromAngle(r),i>this._maxValue+this._stepsPerRevolution?this._timesWrapped--:i<this._minValue-this._stepsPerRevolution&&this._timesWrapped++,this._prevAng=r,this._handleValuesBeyondMinMax(e,i)},_handleMousedown:function(t){if(this._ringNode.compareTo(t.target)){var n=this._getAngleFromValue(this._minValue),r=this._getAngleFromValue(this._maxValue),i,s,o,u,a;e.UA.ios?(o=t.clientX-this._ringNode.getX(),u=t.clientY-this._ringNode.getY()):(o=t.clientX+e.one("document").get("scrollLeft")-this._ringNode.getX(),u=t.clientY+e.one("document").get("scrollTop")-this._ringNode.getY()),a=this._getAngleFromHandleCenter(o,u);if(this._maxValue-this._minValue>this._stepsPerRevolution)Math.abs(this._prevAng-a)>180?this._timesWrapped>this._minTimesWrapped&&this._timesWrapped<this._maxTimesWrapped&&(this._timesWrapped=this._prevAng-a>0?this._timesWrapped+1:this._timesWrapped-1):this._timesWrapped===this._minTimesWrapped&&a-this._prevAng<180&&this._timesWrapped++;else if(this._maxValue-this._minValue===this._stepsPerRevolution)a<n?this._timesWrapped=1:this._timesWrapped=0;else if(n>r)this._prevAng>=n&&a<=(n+r)/2?this._timesWrapped++:this._prevAng<=r&&a>(n+r)/2&&this._timesWrapped--;else if(a<n||a>r){s=((n+r)/2+180)%360,s>180?i=r<a&&a<s?this.get("max"):this.get("min"):i=n>a&&a>s?this.get("min"):this.get("max"),this._prevAng=this._getAngleFromValue(i),this.set("value",i),this._setTimesWrappedFromValue(i);return}i=this._getValueFromAngle(a),i>this._maxValue?this._prevAng=this._getAngleFromValue(this._maxValue):i<this._minValue?this._prevAng=this._getAngleFromValue(this._minValue):this._prevAng=a,this._handleValuesBeyondMinMax(t,i)}},_handleValuesBeyondMinMax:function(e,t){t>=this._minValue&&t<=this._maxValue?(this.set("value",t),e.currentTarget===this._ringNode&&this._dd1._handleMouseDownEvent(e)):t>this._maxValue?this.set("value",this._maxValue):t<this._minValue&&this.set("value",this._minValue)},_handleDragStart:function(e){this._markerNode.removeClass(o.CSS_CLASSES.hidden)},_handleDragEnd:function(){var t=this._handleNode;t.transition({duration:.08,easing:"ease-in",left:this._setNodeToFixedRadius(this._handleNode,!0)[0]+"px",top:this._setNodeToFixedRadius(this._handleNode,!0)[1]+"px"},e.bind(function(){var e=this.get("value");e>this._minValue&&e<this._maxValue?this._markerNode.addClass(o.CSS_CLASSES.hidden):(this._setTimesWrappedFromValue(e),this._prevAng=this._getAngleFromValue(e))},this))},_setNodeToFixedRadius:function(e,t){var n=this._angle-90,r=Math.PI/180,i=Math.round(Math.sin(n*r)*this._handleDistance),s=Math.round(Math.cos(n*r)*this._handleDistance),o=e.get("offsetWidth");i-=o*.5,s-=o*.5;if(t)return[this._ringNodeRadius+s,this._ringNodeRadius+i];e.setStyle("left",this._ringNodeRadius+s+"px"),e.setStyle("top",this._ringNodeRadius+i+"px")},syncUI:function(){this._setSizes(),this._calculateDialCenter(),this._setBorderRadius(),this._uiSetValue(this.get("value")),this._markerNode.addClass(o.CSS_CLASSES.hidden),this._resetString.addClass(o.CSS_CLASSES.hidden)},_setSizes:function(){var e=this.get("diameter"),t,n,r,i=function(e,t,n){var r="px";e.getElementsByTagName("oval").setStyle("width",t*n+r),e.getElementsByTagName("oval").setStyle("height",t*n+r),e.setStyle("width",t*n+r),e.setStyle("height",t*n+r)};i(this._ringNode,e,1),i(this._handleNode,e,this.get("handleDiameter")),i(this._markerNode,e,this.get("markerDiameter")),i(this._centerButtonNode,e,this.get("centerButtonDiameter")),this._ringNodeRadius=this._ringNode.get("offsetWidth")*.5,this._handleNodeRadius=this._handleNode.get("offsetWidth")*.5,this._markerNodeRadius=this._markerNode.get("offsetWidth")*.5,this._centerButtonNodeRadius=this._centerButtonNode.get("offsetWidth")*.5,this._handleDistance=this._ringNodeRadius*this.get("handleDistance"),t=this._ringNodeRadius-this._centerButtonNodeRadius,this._centerButtonNode.setStyle("left",t+"px"),this._centerButtonNode.setStyle("top",t+"px"),n=this._centerButtonNodeRadius-this._resetString.get("offsetWidth")*.5,r=this._centerButtonNodeRadius-this._resetString.get("offsetHeight")*.5,this._resetString.setStyles({left:n+"px",top:r+"px"})},_renderLabel:function(){var t=this.get("contentBox"),n=t.one("."+o.CSS_CLASSES.label);n||(n=s.create(e.Lang.sub(o.LABEL_TEMPLATE,this.get("strings"))),t.append(n)),this._labelNode=n,this._valueStringNode=this._labelNode.one("."+o.CSS_CLASSES.valueString)},_renderRing:function(){var e=this.get("contentBox"),t=e.one("."+o.CSS_CLASSES.ring);t||(t=e.appendChild(o.RING_TEMPLATE),t.setStyles({width:this.get("diameter")+"px",height:this.get("diameter")+"px"})),this._ringNode=t},_renderMarker:function(){var e=this.get("contentBox"),t=e.one("."+o.CSS_CLASSES.marker);t||(t=e.one("."+o.CSS_CLASSES.ring).appendChild(o.MARKER_TEMPLATE)),this._markerNode=t},_renderCenterButton:function(){var t=this.get("contentBox"),n=t.one("."+o.CSS_CLASSES.centerButton);n||(n=s.create(e.Lang.sub(o.CENTER_BUTTON_TEMPLATE,this.get("strings"))),t.one("."+o.CSS_CLASSES.ring).append(n)),this._centerButtonNode=n,this._resetString=this._centerButtonNode.one("."+o.CSS_CLASSES.resetString)},_renderHandle:function(){var t=o.CSS_CLASSES.label+e.guid(),n=this
.get("contentBox"),r=n.one("."+o.CSS_CLASSES.handle);r||(r=s.create(e.Lang.sub(o.HANDLE_TEMPLATE,this.get("strings"))),r.setAttribute("aria-labelledby",t),this._labelNode.one("."+o.CSS_CLASSES.labelString).setAttribute("id",t),n.one("."+o.CSS_CLASSES.ring).append(r)),this._handleNode=r},_setLabelString:function(e){this.get("contentBox").one("."+o.CSS_CLASSES.labelString).setHTML(e)},_setResetString:function(e){this.get("contentBox").one("."+o.CSS_CLASSES.resetString).setHTML(e)},_setTooltipString:function(e){this._handleNode.set("title",e)},_onDirectionKey:function(e){e.preventDefault();switch(e.charCode){case 38:this._incrMinor();break;case 40:this._decrMinor();break;case 36:this._setToMin();break;case 35:this._setToMax();break;case 33:this._incrMajor();break;case 34:this._decrMajor()}},_onLeftRightKey:function(e){e.preventDefault();switch(e.charCode){case 37:this._decrMinor();break;case 39:this._incrMinor()}},_onLeftRightKeyMeta:function(e){e.preventDefault();switch(e.charCode){case 37:this._setToMin();break;case 39:this._setToMax()}},_incrMinor:function(){var e=this.get("value")+this.get("minorStep");e=Math.min(e,this.get("max")),this.set("value",e.toFixed(this.get("decimalPlaces"))-0)},_decrMinor:function(){var e=this.get("value")-this.get("minorStep");e=Math.max(e,this.get("min")),this.set("value",e.toFixed(this.get("decimalPlaces"))-0)},_incrMajor:function(){var e=this.get("value")+this.get("majorStep");e=Math.min(e,this.get("max")),this.set("value",e.toFixed(this.get("decimalPlaces"))-0)},_decrMajor:function(){var e=this.get("value")-this.get("majorStep");e=Math.max(e,this.get("min")),this.set("value",e.toFixed(this.get("decimalPlaces"))-0)},_setToMax:function(){this.set("value",this.get("max"))},_setToMin:function(){this.set("value",this.get("min"))},_resetDial:function(e){e&&e.stopPropagation(),this.set("value",this._originalValue),this._resetString.addClass(o.CSS_CLASSES.hidden),this._handleNode.focus()},_getAngleFromValue:function(e){var t=e%this._stepsPerRevolution,n=t/this._stepsPerRevolution*360;return n<0?n+360:n},_getValueFromAngle:function(e){e<0?e=360+e:e===0&&(e=360);var t=e/360*this._stepsPerRevolution;return t+=this._timesWrapped*this._stepsPerRevolution,t.toFixed(this.get("decimalPlaces"))-0},_afterValueChange:function(e){this._uiSetValue(e.newVal)},_valueToDecimalPlaces:function(e){},_uiSetValue:function(e){this._angle=this._getAngleFromValue(e),this._handleNode.hasClass(o.CSS_CLASSES.dragging)===!1&&(this._setTimesWrappedFromValue(e),this._setNodeToFixedRadius(this._handleNode,!1),this._prevAng=this._getAngleFromValue(this.get("value"))),this._valueStringNode.setHTML(e.toFixed(this.get("decimalPlaces"))),this._handleNode.set("aria-valuenow",e),this._handleNode.set("aria-valuetext",e),this._setNodeToFixedRadius(this._markerNode,!1),e===this._maxValue||e===this._minValue?(this._markerNode.addClass(o.CSS_CLASSES.markerMaxMin),n===!0&&this._markerNode.getElementsByTagName("fill").set("color","#AB3232"),this._markerNode.removeClass(o.CSS_CLASSES.hidden)):(n===!0&&this._markerNode.getElementsByTagName("fill").set("color","#000"),this._markerNode.removeClass(o.CSS_CLASSES.markerMaxMin),this._handleNode.hasClass(o.CSS_CLASSES.dragging)===!1&&this._markerNode.addClass(o.CSS_CLASSES.hidden))},_validateValue:function(e){var t=this.get("min"),n=this.get("max");return r.isNumber(e)&&e>=t&&e<=n}}),e.Dial=o},"3.18.1",{requires:["widget","dd-drag","event-mouseenter","event-move","event-key","transition","intl"],lang:["en","es","hu"],skinnable:!0});
