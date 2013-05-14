(function(d){var b=["DOMMouseScroll","mousewheel"];if(d.event.fixHooks){for(var a=b.length;a;){d.event.fixHooks[b[--a]]=d.event.mouseHooks}}d.event.special.mousewheel={setup:function(){if(this.addEventListener){for(var e=b.length;e;){this.addEventListener(b[--e],c,false)}}else{this.onmousewheel=c}},teardown:function(){if(this.removeEventListener){for(var e=b.length;e;){this.removeEventListener(b[--e],c,false)}}else{this.onmousewheel=null}}};d.fn.extend({mousewheel:function(e){return e?this.bind("mousewheel",e):this.trigger("mousewheel")},unmousewheel:function(e){return this.unbind("mousewheel",e)}});function c(j){var h=j||window.event,g=[].slice.call(arguments,1),k=0,i=true,f=0,e=0;j=d.event.fix(h);j.type="mousewheel";if(h.wheelDelta){k=h.wheelDelta/120}if(h.detail){k=-h.detail/3}e=k;if(h.axis!==undefined&&h.axis===h.HORIZONTAL_AXIS){e=0;f=-1*k}if(h.wheelDeltaY!==undefined){e=h.wheelDeltaY/120}if(h.wheelDeltaX!==undefined){f=-1*h.wheelDeltaX/120}g.unshift(j,k,f,e);return(d.event.dispatch||d.event.handle).apply(this,g)}})(jQuery);

(function(c){var b={pos:[-260,-260]},d=3,h=document,g=h.documentElement,e=h.body,a,i;function f(){if(this===b.elem){b.pos=[-260,-260];b.elem=false;d=3}}c.event.special.mwheelIntent={setup:function(){var j=c(this).bind("mousewheel",c.event.special.mwheelIntent.handler);if(this!==h&&this!==g&&this!==e){j.bind("mouseleave",f)}j=null;return true},teardown:function(){c(this).unbind("mousewheel",c.event.special.mwheelIntent.handler).unbind("mouseleave",f);return true},handler:function(j,k){var l=[j.clientX,j.clientY];if(this===b.elem||Math.abs(b.pos[0]-l[0])>d||Math.abs(b.pos[1]-l[1])>d){b.elem=this;b.pos=l;d=250;clearTimeout(i);i=setTimeout(function(){d=10},200);clearTimeout(a);a=setTimeout(function(){d=3},1500);j=c.extend({},j,{type:"mwheelIntent"});return c.event.handle.apply(this,arguments)}}};c.fn.extend({mwheelIntent:function(j){return j?this.bind("mwheelIntent",j):this.trigger("mwheelIntent")},unmwheelIntent:function(j){return this.unbind("mwheelIntent",j)}});c(function(){e=h.body;c(h).bind("mwheelIntent.mwheelIntentDefault",c.noop)})})(jQuery);

(function(b,a,c){b.fn.jScrollPane=function(e){function d(D,O){var ay,Q=this,Y,aj,v,al,T,Z,y,q,az,aE,au,i,I,h,j,aa,U,ap,X,t,A,aq,af,am,G,l,at,ax,x,av,aH,f,L,ai=true,P=true,aG=false,k=false,ao=D.clone(false,false).empty(),ac=b.fn.mwheelIntent?"mwheelIntent.jsp":"mousewheel.jsp";aH=D.css("paddingTop")+" "+D.css("paddingRight")+" "+D.css("paddingBottom")+" "+D.css("paddingLeft");f=(parseInt(D.css("paddingLeft"),10)||0)+(parseInt(D.css("paddingRight"),10)||0);function ar(aQ){var aL,aN,aM,aJ,aI,aP,aO=false,aK=false;ay=aQ;if(Y===c){aI=D.scrollTop();aP=D.scrollLeft();D.css({overflow:"hidden",padding:0});aj=D.innerWidth()+f;v=D.innerHeight();D.width(aj);Y=b('<div class="jspPane" />').css("padding",aH).append(D.children());al=b('<div class="jspContainer" />').css({width:aj+"px",height:v+"px"}).append(Y).appendTo(D)}else{D.css("width","");aO=ay.stickToBottom&&K();aK=ay.stickToRight&&B();aJ=D.innerWidth()+f!=aj||D.outerHeight()!=v;if(aJ){aj=D.innerWidth()+f;v=D.innerHeight();al.css({width:aj+"px",height:v+"px"})}if(!aJ&&L==T&&Y.outerHeight()==Z){D.width(aj);return}L=T;Y.css("width","");D.width(aj);al.find(">.jspVerticalBar,>.jspHorizontalBar").remove().end()}Y.css("overflow","auto");if(aQ.contentWidth){T=aQ.contentWidth}else{T=Y[0].scrollWidth}Z=Y[0].scrollHeight;Y.css("overflow","");y=T/aj;q=Z/v;az=q>1;aE=y>1;if(!(aE||az)){D.removeClass("jspScrollable");Y.css({top:0,width:al.width()-f});n();E();R();w()}else{D.addClass("jspScrollable");aL=ay.maintainPosition&&(I||aa);if(aL){aN=aC();aM=aA()}aF();z();F();if(aL){N(aK?(T-aj):aN,false);M(aO?(Z-v):aM,false)}J();ag();an();if(ay.enableKeyboardNavigation){S()}if(ay.clickOnTrack){p()}C();if(ay.hijackInternalLinks){m()}}if(ay.autoReinitialise&&!av){av=setInterval(function(){ar(ay)},ay.autoReinitialiseDelay)}else{if(!ay.autoReinitialise&&av){clearInterval(av)}}aI&&D.scrollTop(0)&&M(aI,false);aP&&D.scrollLeft(0)&&N(aP,false);D.trigger("jsp-initialised",[aE||az])}function aF(){if(az){al.append(b('<div class="jspVerticalBar" />').append(b('<div class="jspCap jspCapTop" />'),b('<div class="jspTrack" />').append(b('<div class="jspDrag" />').append(b('<div class="jspDragTop" />'),b('<div class="jspDragBottom" />'))),b('<div class="jspCap jspCapBottom" />')));U=al.find(">.jspVerticalBar");ap=U.find(">.jspTrack");au=ap.find(">.jspDrag");if(ay.showArrows){aq=b('<a class="jspArrow jspArrowUp" />').bind("mousedown.jsp",aD(0,-1)).bind("click.jsp",aB);af=b('<a class="jspArrow jspArrowDown" />').bind("mousedown.jsp",aD(0,1)).bind("click.jsp",aB);if(ay.arrowScrollOnHover){aq.bind("mouseover.jsp",aD(0,-1,aq));af.bind("mouseover.jsp",aD(0,1,af))}ak(ap,ay.verticalArrowPositions,aq,af)}t=v;al.find(">.jspVerticalBar>.jspCap:visible,>.jspVerticalBar>.jspArrow").each(function(){t-=b(this).outerHeight()});au.hover(function(){au.addClass("jspHover")},function(){au.removeClass("jspHover")}).bind("mousedown.jsp",function(aI){b("html").bind("dragstart.jsp selectstart.jsp",aB);au.addClass("jspActive");var s=aI.pageY-au.position().top;b("html").bind("mousemove.jsp",function(aJ){V(aJ.pageY-s,false)}).bind("mouseup.jsp mouseleave.jsp",aw);return false});o()}}function o(){ap.height(t+"px");I=0;X=ay.verticalGutter+ap.outerWidth();Y.width(aj-X-f);try{if(U.position().left===0){Y.css("margin-left",X+"px")}}catch(s){}}function z(){if(aE){al.append(b('<div class="jspHorizontalBar" />').append(b('<div class="jspCap jspCapLeft" />'),b('<div class="jspTrack" />').append(b('<div class="jspDrag" />').append(b('<div class="jspDragLeft" />'),b('<div class="jspDragRight" />'))),b('<div class="jspCap jspCapRight" />')));am=al.find(">.jspHorizontalBar");G=am.find(">.jspTrack");h=G.find(">.jspDrag");if(ay.showArrows){ax=b('<a class="jspArrow jspArrowLeft" />').bind("mousedown.jsp",aD(-1,0)).bind("click.jsp",aB);x=b('<a class="jspArrow jspArrowRight" />').bind("mousedown.jsp",aD(1,0)).bind("click.jsp",aB);
if(ay.arrowScrollOnHover){ax.bind("mouseover.jsp",aD(-1,0,ax));x.bind("mouseover.jsp",aD(1,0,x))}ak(G,ay.horizontalArrowPositions,ax,x)}h.hover(function(){h.addClass("jspHover")},function(){h.removeClass("jspHover")}).bind("mousedown.jsp",function(aI){b("html").bind("dragstart.jsp selectstart.jsp",aB);h.addClass("jspActive");var s=aI.pageX-h.position().left;b("html").bind("mousemove.jsp",function(aJ){W(aJ.pageX-s,false)}).bind("mouseup.jsp mouseleave.jsp",aw);return false});l=al.innerWidth();ah()}}function ah(){al.find(">.jspHorizontalBar>.jspCap:visible,>.jspHorizontalBar>.jspArrow").each(function(){l-=b(this).outerWidth()});G.width(l+"px");aa=0}function F(){if(aE&&az){var aI=G.outerHeight(),s=ap.outerWidth();t-=aI;b(am).find(">.jspCap:visible,>.jspArrow").each(function(){l+=b(this).outerWidth()});l-=s;v-=s;aj-=aI;G.parent().append(b('<div class="jspCorner" />').css("width",aI+"px"));o();ah()}if(aE){Y.width((al.outerWidth()-f)+"px")}Z=Y.outerHeight();q=Z/v;if(aE){at=Math.ceil(1/y*l);if(at>ay.horizontalDragMaxWidth){at=ay.horizontalDragMaxWidth}else{if(at<ay.horizontalDragMinWidth){at=ay.horizontalDragMinWidth}}h.width(at+"px");j=l-at;ae(aa)}if(az){A=Math.ceil(1/q*t);if(A>ay.verticalDragMaxHeight){A=ay.verticalDragMaxHeight}else{if(A<ay.verticalDragMinHeight){A=ay.verticalDragMinHeight}}au.height(A+"px");i=t-A;ad(I)}}function ak(aJ,aL,aI,s){var aN="before",aK="after",aM;if(aL=="os"){aL=/Mac/.test(navigator.platform)?"after":"split"}if(aL==aN){aK=aL}else{if(aL==aK){aN=aL;aM=aI;aI=s;s=aM}}aJ[aN](aI)[aK](s)}function aD(aI,s,aJ){return function(){H(aI,s,this,aJ);this.blur();return false}}function H(aL,aK,aO,aN){aO=b(aO).addClass("jspActive");var aM,aJ,aI=true,s=function(){if(aL!==0){Q.scrollByX(aL*ay.arrowButtonSpeed)}if(aK!==0){Q.scrollByY(aK*ay.arrowButtonSpeed)}aJ=setTimeout(s,aI?ay.initialDelay:ay.arrowRepeatFreq);aI=false};s();aM=aN?"mouseout.jsp":"mouseup.jsp";aN=aN||b("html");aN.bind(aM,function(){aO.removeClass("jspActive");aJ&&clearTimeout(aJ);aJ=null;aN.unbind(aM)})}function p(){w();if(az){ap.bind("mousedown.jsp",function(aN){if(aN.originalTarget===c||aN.originalTarget==aN.currentTarget){var aL=b(this),aO=aL.offset(),aM=aN.pageY-aO.top-I,aJ,aI=true,s=function(){var aR=aL.offset(),aS=aN.pageY-aR.top-A/2,aP=v*ay.scrollPagePercent,aQ=i*aP/(Z-v);if(aM<0){if(I-aQ>aS){Q.scrollByY(-aP)}else{V(aS)}}else{if(aM>0){if(I+aQ<aS){Q.scrollByY(aP)}else{V(aS)}}else{aK();return}}aJ=setTimeout(s,aI?ay.initialDelay:ay.trackClickRepeatFreq);aI=false},aK=function(){aJ&&clearTimeout(aJ);aJ=null;b(document).unbind("mouseup.jsp",aK)};s();b(document).bind("mouseup.jsp",aK);return false}})}if(aE){G.bind("mousedown.jsp",function(aN){if(aN.originalTarget===c||aN.originalTarget==aN.currentTarget){var aL=b(this),aO=aL.offset(),aM=aN.pageX-aO.left-aa,aJ,aI=true,s=function(){var aR=aL.offset(),aS=aN.pageX-aR.left-at/2,aP=aj*ay.scrollPagePercent,aQ=j*aP/(T-aj);if(aM<0){if(aa-aQ>aS){Q.scrollByX(-aP)}else{W(aS)}}else{if(aM>0){if(aa+aQ<aS){Q.scrollByX(aP)}else{W(aS)}}else{aK();return}}aJ=setTimeout(s,aI?ay.initialDelay:ay.trackClickRepeatFreq);aI=false},aK=function(){aJ&&clearTimeout(aJ);aJ=null;b(document).unbind("mouseup.jsp",aK)};s();b(document).bind("mouseup.jsp",aK);return false}})}}function w(){if(G){G.unbind("mousedown.jsp")}if(ap){ap.unbind("mousedown.jsp")}}function aw(){b("html").unbind("dragstart.jsp selectstart.jsp mousemove.jsp mouseup.jsp mouseleave.jsp");if(au){au.removeClass("jspActive")}if(h){h.removeClass("jspActive")}}function V(s,aI){if(!az){return}if(s<0){s=0}else{if(s>i){s=i}}if(aI===c){aI=ay.animateScroll}if(aI){Q.animate(au,"top",s,ad)}else{au.css("top",s);ad(s)}}function ad(aI){if(aI===c){aI=au.position().top}al.scrollTop(0);I=aI;var aL=I===0,aJ=I==i,aK=aI/i,s=-aK*(Z-v);if(ai!=aL||aG!=aJ){ai=aL;aG=aJ;D.trigger("jsp-arrow-change",[ai,aG,P,k])}u(aL,aJ);Y.css("top",s);D.trigger("jsp-scroll-y",[-s,aL,aJ]).trigger("scroll")}function W(aI,s){if(!aE){return}if(aI<0){aI=0}else{if(aI>j){aI=j}}if(s===c){s=ay.animateScroll}if(s){Q.animate(h,"left",aI,ae)
}else{h.css("left",aI);ae(aI)}}function ae(aI){if(aI===c){aI=h.position().left}al.scrollTop(0);aa=aI;var aL=aa===0,aK=aa==j,aJ=aI/j,s=-aJ*(T-aj);if(P!=aL||k!=aK){P=aL;k=aK;D.trigger("jsp-arrow-change",[ai,aG,P,k])}r(aL,aK);Y.css("left",s);D.trigger("jsp-scroll-x",[-s,aL,aK]).trigger("scroll")}function u(aI,s){if(ay.showArrows){aq[aI?"addClass":"removeClass"]("jspDisabled");af[s?"addClass":"removeClass"]("jspDisabled")}}function r(aI,s){if(ay.showArrows){ax[aI?"addClass":"removeClass"]("jspDisabled");x[s?"addClass":"removeClass"]("jspDisabled")}}function M(s,aI){var aJ=s/(Z-v);V(aJ*i,aI)}function N(aI,s){var aJ=aI/(T-aj);W(aJ*j,s)}function ab(aV,aQ,aJ){var aN,aK,aL,s=0,aU=0,aI,aP,aO,aS,aR,aT;try{aN=b(aV)}catch(aM){return}aK=aN.outerHeight();aL=aN.outerWidth();al.scrollTop(0);al.scrollLeft(0);while(!aN.is(".jspPane")){s+=aN.position().top;aU+=aN.position().left;aN=aN.offsetParent();if(/^body|html$/i.test(aN[0].nodeName)){return}}aI=aA();aO=aI+v;if(s<aI||aQ){aR=s-ay.verticalGutter}else{if(s+aK>aO){aR=s-v+aK+ay.verticalGutter}}if(aR){M(aR,aJ)}aP=aC();aS=aP+aj;if(aU<aP||aQ){aT=aU-ay.horizontalGutter}else{if(aU+aL>aS){aT=aU-aj+aL+ay.horizontalGutter}}if(aT){N(aT,aJ)}}function aC(){return -Y.position().left}function aA(){return -Y.position().top}function K(){var s=Z-v;return(s>20)&&(s-aA()<10)}function B(){var s=T-aj;return(s>20)&&(s-aC()<10)}function ag(){al.unbind(ac).bind(ac,function(aL,aM,aK,aI){var aJ=aa,s=I;Q.scrollBy(aK*ay.mouseWheelSpeed,-aI*ay.mouseWheelSpeed,false);return aJ==aa&&s==I})}function n(){al.unbind(ac)}function aB(){return false}function J(){Y.find(":input,a").unbind("focus.jsp").bind("focus.jsp",function(s){ab(s.target,false)})}function E(){Y.find(":input,a").unbind("focus.jsp")}function S(){var s,aI,aK=[];aE&&aK.push(am[0]);az&&aK.push(U[0]);Y.focus(function(){D.focus()});D.attr("tabindex",0).unbind("keydown.jsp keypress.jsp").bind("keydown.jsp",function(aN){if(aN.target!==this&&!(aK.length&&b(aN.target).closest(aK).length)){return}var aM=aa,aL=I;switch(aN.keyCode){case 40:case 38:case 34:case 32:case 33:case 39:case 37:s=aN.keyCode;aJ();break;case 35:M(Z-v);s=null;break;case 36:M(0);s=null;break}aI=aN.keyCode==s&&aM!=aa||aL!=I;return !aI}).bind("keypress.jsp",function(aL){if(aL.keyCode==s){aJ()}return !aI});if(ay.hideFocus){D.css("outline","none");if("hideFocus" in al[0]){D.attr("hideFocus",true)}}else{D.css("outline","");if("hideFocus" in al[0]){D.attr("hideFocus",false)}}function aJ(){var aM=aa,aL=I;switch(s){case 40:Q.scrollByY(ay.keyboardSpeed,false);break;case 38:Q.scrollByY(-ay.keyboardSpeed,false);break;case 34:case 32:Q.scrollByY(v*ay.scrollPagePercent,false);break;case 33:Q.scrollByY(-v*ay.scrollPagePercent,false);break;case 39:Q.scrollByX(ay.keyboardSpeed,false);break;case 37:Q.scrollByX(-ay.keyboardSpeed,false);break}aI=aM!=aa||aL!=I;return aI}}function R(){D.attr("tabindex","-1").removeAttr("tabindex").unbind("keydown.jsp keypress.jsp")}function C(){if(location.hash&&location.hash.length>1){var aK,aI,aJ=escape(location.hash.substr(1));try{aK=b("#"+aJ+', a[name="'+aJ+'"]')}catch(s){return}if(aK.length&&Y.find(aJ)){if(al.scrollTop()===0){aI=setInterval(function(){if(al.scrollTop()>0){ab(aK,true);b(document).scrollTop(al.position().top);clearInterval(aI)}},50)}else{ab(aK,true);b(document).scrollTop(al.position().top)}}}}function m(){if(b(document.body).data("jspHijack")){return}b(document.body).data("jspHijack",true);b(document.body).delegate("a[href*=#]","click",function(s){var aI=this.href.substr(0,this.href.indexOf("#")),aK=location.href,aO,aP,aJ,aM,aL,aN;if(location.href.indexOf("#")!==-1){aK=location.href.substr(0,location.href.indexOf("#"))}if(aI!==aK){return}aO=escape(this.href.substr(this.href.indexOf("#")+1));aP;try{aP=b("#"+aO+', a[name="'+aO+'"]')}catch(aQ){return}if(!aP.length){return}aJ=aP.closest(".jspScrollable");aM=aJ.data("jsp");aM.scrollToElement(aP,true);if(aJ[0].scrollIntoView){aL=b(a).scrollTop();aN=aP.offset().top;if(aN<aL||aN>aL+b(a).height()){aJ[0].scrollIntoView()}}s.preventDefault()
})}function an(){var aJ,aI,aL,aK,aM,s=false;al.unbind("touchstart.jsp touchmove.jsp touchend.jsp click.jsp-touchclick").bind("touchstart.jsp",function(aN){var aO=aN.originalEvent.touches[0];aJ=aC();aI=aA();aL=aO.pageX;aK=aO.pageY;aM=false;s=true}).bind("touchmove.jsp",function(aQ){if(!s){return}var aP=aQ.originalEvent.touches[0],aO=aa,aN=I;Q.scrollTo(aJ+aL-aP.pageX,aI+aK-aP.pageY);aM=aM||Math.abs(aL-aP.pageX)>5||Math.abs(aK-aP.pageY)>5;return aO==aa&&aN==I}).bind("touchend.jsp",function(aN){s=false}).bind("click.jsp-touchclick",function(aN){if(aM){aM=false;return false}})}function g(){var s=aA(),aI=aC();D.removeClass("jspScrollable").unbind(".jsp");D.replaceWith(ao.append(Y.children()));ao.scrollTop(s);ao.scrollLeft(aI);if(av){clearInterval(av)}}b.extend(Q,{reinitialise:function(aI){aI=b.extend({},ay,aI);ar(aI)},scrollToElement:function(aJ,aI,s){ab(aJ,aI,s)},scrollTo:function(aJ,s,aI){N(aJ,aI);M(s,aI)},scrollToX:function(aI,s){N(aI,s)},scrollToY:function(s,aI){M(s,aI)},scrollToPercentX:function(aI,s){N(aI*(T-aj),s)},scrollToPercentY:function(aI,s){M(aI*(Z-v),s)},scrollBy:function(aI,s,aJ){Q.scrollByX(aI,aJ);Q.scrollByY(s,aJ)},scrollByX:function(s,aJ){var aI=aC()+Math[s<0?"floor":"ceil"](s),aK=aI/(T-aj);W(aK*j,aJ)},scrollByY:function(s,aJ){var aI=aA()+Math[s<0?"floor":"ceil"](s),aK=aI/(Z-v);V(aK*i,aJ)},positionDragX:function(s,aI){W(s,aI)},positionDragY:function(aI,s){V(aI,s)},animate:function(aI,aL,s,aK){var aJ={};aJ[aL]=s;aI.animate(aJ,{duration:ay.animateDuration,easing:ay.animateEase,queue:false,step:aK})},getContentPositionX:function(){return aC()},getContentPositionY:function(){return aA()},getContentWidth:function(){return T},getContentHeight:function(){return Z},getPercentScrolledX:function(){return aC()/(T-aj)},getPercentScrolledY:function(){return aA()/(Z-v)},getIsScrollableH:function(){return aE},getIsScrollableV:function(){return az},getContentPane:function(){return Y},scrollToBottom:function(s){V(i,s)},hijackInternalLinks:b.noop,destroy:function(){g()}});ar(O)}e=b.extend({},b.fn.jScrollPane.defaults,e);b.each(["mouseWheelSpeed","arrowButtonSpeed","trackClickSpeed","keyboardSpeed"],function(){e[this]=e[this]||e.speed});return this.each(function(){var f=b(this),g=f.data("jsp");if(g){g.reinitialise(e)}else{b("script",f).filter("[type=text/javascript],not([type])").remove();g=new d(f,e);f.data("jsp",g)}})};b.fn.jScrollPane.defaults={showArrows:false,maintainPosition:true,stickToBottom:false,stickToRight:false,clickOnTrack:true,autoReinitialise:false,autoReinitialiseDelay:500,verticalDragMinHeight:0,verticalDragMaxHeight:99999,horizontalDragMinWidth:0,horizontalDragMaxWidth:99999,contentWidth:c,animateScroll:false,animateDuration:300,animateEase:"linear",hijackInternalLinks:false,verticalGutter:4,horizontalGutter:4,mouseWheelSpeed:0,arrowButtonSpeed:0,arrowRepeatFreq:50,arrowScrollOnHover:false,trackClickSpeed:0,trackClickRepeatFreq:70,verticalArrowPositions:"split",horizontalArrowPositions:"split",enableKeyboardNavigation:true,hideFocus:false,keyboardSpeed:0,initialDelay:300,speed:30,scrollPagePercent:0.8}})(jQuery,this);

//Auto re-size
(function(c){var e="hidden",b="border-box",i="lineHeight",a='<textarea tabindex="-1" style="position:absolute; top:-9999px; left:-9999px; right:auto; bottom:auto; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden;">',f=["fontFamily","fontSize","fontWeight","fontStyle","letterSpacing","textTransform","wordSpacing","textIndent"],h="oninput",d="onpropertychange",g=c(a)[0];g.setAttribute(h,"return");if(c.isFunction(g[h])||d in g){c(g).css(i,"99px");if(c(g).css(i)==="99px"){f.push(i)}c.fn.autosize=function(j){return this.each(function(){var p=this,m=c(p),q,t=m.height(),s=parseInt(m.css("maxHeight"),10),n,o=f.length,l,k=0;if(m.css("box-sizing")===b||m.css("-moz-box-sizing")===b||m.css("-webkit-box-sizing")===b){k=m.outerHeight()-m.height()}if(m.data("mirror")||m.data("ismirror")){return}else{q=c(a).data("ismirror",true).addClass(j||"autosizejs")[0];l=m.css("resize")==="none"?"none":"horizontal";m.data("mirror",c(q)).css({overflow:e,overflowY:e,wordWrap:"break-word",resize:l})}s=s&&s>0?s:90000;function r(){var u,v;if(!n){n=true;q.value=p.value;q.style.overflowY=p.style.overflowY;q.style.width=m.css("width");q.scrollTop=0;q.scrollTop=90000;u=q.scrollTop;v=e;if(u>s){u=s;v="scroll"}else{if(u<t){u=t}}p.style.overflowY=v;p.style.height=u+k+"px";setTimeout(function(){n=false},1)}}while(o--){q.style[f[o]]=m.css(f[o])}c("body").append(q);if(d in p){if(h in p){p[h]=p.onkeyup=r}else{p[d]=r}}else{p[h]=r}c(window).resize(r);m.bind("autosize",r);m.text(m.text());r()})}}else{c.fn.autosize=function(){return this}}}(jQuery));

//smoke
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('m 2={P:[],E:b,16:1n,i:0,R:6(7){m q=a.1x(\'o\');q.1y(\'7\',\'2-U-\'+7);q.S=\'2-T\';q.1A.1B=2.16;2.16++;a.1m.1F(q)},G:6(){m 3=1J 1M().1O();3=1Q.1R(1,1S)+3;5(!2.E){2.s(D,"15",6(){2.R(3)})}z{2.R(3)}v 3},1P:6(){},F:6(e,f){2.i++;f.1K=2.i;e=e.1k(/\\n/g,\'<19 />\');e=e.1k(/\\r/g,\'<19 />\');m k=\'\',c=\'1E\',j=\'1C\',I=\'\',w=\'\',9;5(f.4===\'k\'){k=\'<o A="C-k">\'+\'<Y 7="C-Y-\'+f.3+\'" 4="1z" \'+(f.h.J?\'J="\'+f.h.J+\'"\':\'\')+\' />\'+\'</o>\'}5(f.h.c){c=f.h.c}5(f.h.j){j=f.h.j}5(f.h.I){I=f.h.I}5(f.4!==\'M\'){w=\'<o A="C-w">\';5(f.4===\'x\'){w+=\'<p 7="x-c-\'+f.3+\'">\'+c+\'</p>\'}z 5(f.4===\'k\'||f.4===\'B\'){5(f.h.1t){w+=\'<p 7="\'+f.4+\'-c-\'+f.3+\'">\'+c+\'</p>\'+\'<p 7="\'+f.4+\'-j-\'+f.3+\'" A="j">\'+j+\'</p>\'}z{w+=\'<p 7="\'+f.4+\'-j-\'+f.3+\'" A="j">\'+j+\'</p>\'+\'<p 7="\'+f.4+\'-c-\'+f.3+\'">\'+c+\'</p>\'}}w+=\'</o>\'}9=\'<o 7="2-1b-\'+f.3+\'" A="1s"></o>\'+\'<o A="C 2 \'+I+\'">\'+\'<o A="C-1r">\'+e+k+w+\'</o>\'+\'</o>\';5(!2.E){2.s(D,"15",6(){2.Z(e,f,9)})}z{2.Z(e,f,9)}},Z:6(e,f,9){m q=a.l(\'2-U-\'+f.3);q.S=\'2-T 2-1q  2-\'+f.4;q.K=9;1p(q.K===""){q.K=9}5(2.P[f.3]){1D(2.P[f.3])}2.s(a.l(\'2-1b-\'+f.3),"t",6(){2.d(f.4,f.3);5(f.4===\'k\'||f.4===\'B\'){f.8(b)}z 5(f.4===\'x\'&&y f.8!==\'N\'){f.8()}});1o(f.4){O\'x\':2.1g(e,f,9);Q;O\'B\':2.1d(e,f,9);Q;O\'k\':2.1c(e,f,9);Q;O\'M\':2.1a(e,f,9);Q;1u:1v"1w 4: "+f.4;}},1g:6(e,f,9){2.s(a.l(\'x-c-\'+f.3),"t",6(){2.d(f.4,f.3);5(y f.8!==\'N\'){f.8()}});a.L=6(e){5(!e){e=D.W}5(e.u===13||e.u===17||e.u===V){2.d(f.4,f.3);5(y f.8!==\'N\'){f.8()}}}},1d:6(e,f,9){2.s(a.l(\'B-j-\'+f.3),"t",6(){2.d(f.4,f.3);f.8(b)});2.s(a.l(\'B-c-\'+f.3),"t",6(){2.d(f.4,f.3);f.8(X)});a.L=6(e){5(!e){e=D.W}5(e.u===13||e.u===17){2.d(f.4,f.3);f.8(X)}z 5(e.u===V){2.d(f.4,f.3);f.8(b)}}},1c:6(e,f,9){m H=a.l(\'C-Y-\'+f.3);1h(6(){H.1G();H.1H()},1I);2.s(a.l(\'k-j-\'+f.3),"t",6(){2.d(f.4,f.3);f.8(b)});2.s(a.l(\'k-c-\'+f.3),"t",6(){2.d(f.4,f.3);f.8(H.J)});a.L=6(e){5(!e){e=D.W}5(e.u===13){2.d(f.4,f.3);f.8(H.J)}z 5(e.u===V){2.d(f.4,f.3);f.8(b)}}},1a:6(e,f,9){2.P[f.3]=1h(6(){2.d(f.4,f.3)},f.1e)},d:6(4,7){m 9=a.l(\'2-U-\'+7),10=a.l(4+\'-c-\'+7),11=a.l(4+\'-j-\'+7);9.S=\'2-T\';5(10){2.12(10,"t",6(){});a.L=1L}5(11){2.12(11,"t",6(){})}2.i=0;9.K=\'\'},x:6(e,f,g){5(y f!==\'14\'){f=b}m 7=2.G();2.F(e,{4:\'x\',8:g,h:f,3:7})},M:6(e,f){5(y f===\'N\'){f=1N}m 7=2.G();2.F(e,{4:\'M\',1e:f,h:b,3:7})},B:6(e,f,g){5(y g!==\'14\'){g=b}m 7=2.G();2.F(e,{4:\'B\',8:f,h:g,3:7})},k:6(e,f,g){5(y g!==\'14\'){g=b}m 7=2.G();v 2.F(e,{4:\'k\',8:f,h:g,3:7})},s:6(e,f,g){5(e.1f){v e.1f(f,g,b)}5(e.1l){v e.1l(\'1j\'+f,g)}v b},12:6(e,f,g){5(e.1i){v e.1i("t",g,b)}5(e.18){v e.18(\'1j\'+f,g)}v b}};5(!2.E){2.s(D,"15",6(){2.E=X})}',62,117,'||smoke|newid|type|if|function|id|callback|box|document|false|ok|destroy||||params||cancel|prompt|getElementById|var||div|button|ff||listen|click|keyCode|return|buttons|alert|typeof|else|class|confirm|dialog|window|init|build|newdialog|pi|classname|value|innerHTML|onkeyup|signal|undefined|case|smoketimeout|break|bodyload|className|base|out|27|event|true|input|finishbuild|okButton|cancelButton|stoplistening||object|load|zindex|32|detachEvent|br|finishbuildSignal|bg|finishbuildPrompt|finishbuildConfirm|timeout|addEventListener|finishbuildAlert|setTimeout|removeEventListener|on|replace|attachEvent|body|1000|switch|while|visible|inner|smokebg|reverseButtons|default|throw|Unknown|createElement|setAttribute|text|style|zIndex|Cancel|clearTimeout|OK|appendChild|focus|select|100|new|stack|null|Date|5000|getTime|forceload|Math|random|99'.split('|'),0,{}));


(function(){
	ItemInfo.Initialize(RefreshProgresses);
	$("#container select").change(RefreshProgresses);
	$("input[type='text']").keyup(RefreshProgresses);
	$("textarea").keyup(RefreshProgresses);
	$("#stats").autosize();
	//Bottom Button controls
	$(".buttons button").click(function(){
		var rel = $(this).attr("rel");
		if (rel == "close") {
			window.external.Close();
		}else if (rel == "reset"){
			window.location.reload(false);
		}else if (rel == "analyze"){
			if ($("#quality").val() == "Unknown" || $("#type").val() == "Unknown") {
				alert("Please enter a valid Quality and Type");
				return false;
			}
			var src = "http://d3up.com/ajax/compare/?battletag=" + encodeURIComponent($("#battletag").val()) +
				"&build=" + encodeURIComponent($("#build").val()) +
				"&name=" + encodeURIComponent($("#name").val()) +
				"&quality=" + encodeURIComponent($("#quality").val()) +
				"&type=" + encodeURIComponent($("#type").val()) +
				"&dps=" + encodeURIComponent($("#dps").val()) +
				"&meta=" + encodeURIComponent($("#meta").val()) +
				"&stats=" + encodeURIComponent($("#stats").val());
			var status = $(this).attr("data-status");
			if (status == "hidden"){
				$("#d3up-frame").fadeIn(function(){
					$("#d3up-frame iframe").attr("src", src);
				});
				$(this).attr("data-status", "shown");
			}else{
				$("#d3up-frame").fadeOut();
				$(this).attr("data-status", "hidden");
			}
		}else if (rel == "upload"){
			if ($("#quality").val() == "Unknown" || $("#type").val() == "Unknown") {
				alert("Please enter a valid Quality and Type");
				return false;
			}
			$("#upload-overlay").fadeIn();
			$("#d3up-frame").fadeOut();
		}
	});

	//Upload logic
	$("select#album").change(function(){$("#album-destin").click();});
	$("button.upload").click(function(){
		var destin = $('input:radio[name=destin]:checked').val();
		if (destin == "album") {
			if ($("#album").val() == "new") {
				var albumName = prompt("Enter the new album name", "");
				if (albumName.length < 3){
					alert("Please enter a longer album name");
					return false;
				}else{
					$.get("/ajax/album/", {a: "add", name:albumName, secret:$("#secret").val()}, function(response){
						if (typeof response.id != "undefined"){
							Upload(response.id+"");
						}else{
							$("#upload-overlay").fadeOut(function(){
								smoke.signal("Network/Server Error", 5000);
							});
						}
					}, "json");
				}
			}else{
				destin = parseInt($("#album").val())+"";
				Upload(destin);
			}
    }else if (destin == "auctionr") {
      $.post("http://auctionrs.com/d3/api/post/", {
        auctionrName: $("#auctionrName").val(),
        battletag: $("#auctionrName").val(),
        build: $("#build").val(),
        name: $("#name").val(),
        quality: $("#quality").val(),
        type: $("#type").val(),
        dps: $("#dps").val(),
        meta: $("#meta").val(),
        stats: $("#stats").val()
      }, function(response) {
        $("#upload-overlay").fadeOut(function(){
          if (response && response.msg)
            smoke.signal(response.msg, 5000);
        });
      }, "jsonp");
		}else{
			Upload(destin);
		}
	});
	$("button.cancel").click(function(){
		$("#upload-overlay").fadeOut();
	});
	//End of Upload Logic

	$("#wrapper").jScrollPane();

	function Upload(destin){
		$("#upload-overlay").fadeOut(function(){
			smoke.signal("Uploading . . .", 10000);
			window.external.Upload(destin, $("#name").val(), $("#quality").val(), $("#type").val(), $("#dps").val(), $("#stats").val());
		});
	}

	function RefreshProgresses(){
		var itemInfo = new ItemInfo($("#stats").val(), $("#type").val(), $("#dps").val());
		//Stats
		$("#stats-progress").html("");
		for (var i in itemInfo.stats) {
			var stat = itemInfo.stats[i];
			var statHolder = $('<div class="stat cf" />');
			var nameHolder = $('<div class="name" />');
			var progressHolder = $('<div class="progress" />');
			var valueHolder = $('<div class="value" />');
			var progressBar = $('<div />');
			progressHolder.append(progressBar);
			nameHolder.text(stat.name);
			progressBar.width(stat.progress+"%");
			valueHolder.html(stat.value + '(<span class="max-value">'+(stat.max==0?"--":stat.max)+'</span>)');
			statHolder.append(nameHolder).append(progressHolder).append(valueHolder);
			$("#stats-progress").append(statHolder);
		}
		//Rating
		var ratingHolder = $("#rating");
		ratingHolder.html("");
		var rating = $('<div class="starRating big"><div></div></div>');
		var ratingProgress = $("<div />");
		ratingProgress.width((itemInfo.starsRating * 10) + "%");
		rating.append(ratingProgress);
		ratingHolder.append(rating);

		$("#wrapper").jScrollPane();
	}
})();

function Signal(text) {
	$(".smoke-base").remove();
	smoke.signal(text);
}