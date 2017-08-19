!function(t,e){"use strict";var i={},s=t.GreenSockGlobals=t.GreenSockGlobals||t;if(!s.TweenLite){var n,r,a,o,l,h=function(t){var e,i=t.split("."),n=s;for(e=0;e<i.length;e++)n[i[e]]=n=n[i[e]]||{};return n},_=h("com.greensock"),u=function(t){var e,i=[],s=t.length;for(e=0;e!==s;i.push(t[e++]));return i},f=function(){},c=function(){var t=Object.prototype.toString,e=t.call([]);return function(i){return null!=i&&(i instanceof Array||"object"==typeof i&&!!i.push&&t.call(i)===e)}}(),m={},p=function(e,n,r,a){this.sc=m[e]?m[e].sc:[],m[e]=this,this.gsClass=null,this.func=r;var o=[];this.check=function(l){for(var _,u,f,c,d,v=n.length,g=v;--v>-1;)(_=m[n[v]]||new p(n[v],[])).gsClass?(o[v]=_.gsClass,g--):l&&_.sc.push(this);if(0===g&&r){if(u=("com.greensock."+e).split("."),f=u.pop(),c=h(u.join("."))[f]=this.gsClass=r.apply(r,o),a)if(s[f]=i[f]=c,!(d="undefined"!=typeof module&&module.exports)&&"function"==typeof define&&define.amd)define((t.GreenSockAMDPath?t.GreenSockAMDPath+"/":"")+e.split(".").pop(),[],function(){return c});else if(d)if("TweenLite"===e){module.exports=i.TweenLite=c;for(v in i)c[v]=i[v]}else i.TweenLite&&(i.TweenLite[f]=c);for(v=0;v<this.sc.length;v++)this.sc[v].check()}},this.check(!0)},d=t._gsDefine=function(t,e,i,s){return new p(t,e,i,s)},v=_._class=function(t,e,i){return e=e||function(){},d(t,[],function(){return e},i),e};d.globals=s;var g=[0,0,1,1],T=v("easing.Ease",function(t,e,i,s){this._func=t,this._type=i||0,this._power=s||0,this._params=e?g.concat(e):g},!0),y=T.map={},w=T.register=function(t,e,i,s){for(var n,r,a,o,l=e.split(","),h=l.length,u=(i||"easeIn,easeOut,easeInOut").split(",");--h>-1;)for(r=l[h],n=s?v("easing."+r,null,!0):_.easing[r]||{},a=u.length;--a>-1;)o=u[a],y[r+"."+o]=y[o+r]=n[o]=t.getRatio?t:t[o]||new t};for((a=T.prototype)._calcEnd=!1,a.getRatio=function(t){if(this._func)return this._params[0]=t,this._func.apply(null,this._params);var e=this._type,i=this._power,s=1===e?1-t:2===e?t:t<.5?2*t:2*(1-t);return 1===i?s*=s:2===i?s*=s*s:3===i?s*=s*s*s:4===i&&(s*=s*s*s*s),1===e?1-s:2===e?s:t<.5?s/2:1-s/2},r=(n=["Linear","Quad","Cubic","Quart","Quint,Strong"]).length;--r>-1;)a=n[r]+",Power"+r,w(new T(null,null,1,r),a,"easeOut",!0),w(new T(null,null,2,r),a,"easeIn"+(0===r?",easeNone":"")),w(new T(null,null,3,r),a,"easeInOut");y.linear=_.easing.Linear.easeIn,y.swing=_.easing.Quad.easeInOut;var P=v("events.EventDispatcher",function(t){this._listeners={},this._eventTarget=t||this});(a=P.prototype).addEventListener=function(t,e,i,s,n){n=n||0;var r,a,h=this._listeners[t],_=0;for(this!==o||l||o.wake(),null==h&&(this._listeners[t]=h=[]),a=h.length;--a>-1;)(r=h[a]).c===e&&r.s===i?h.splice(a,1):0===_&&r.pr<n&&(_=a+1);h.splice(_,0,{c:e,s:i,up:s,pr:n})},a.removeEventListener=function(t,e){var i,s=this._listeners[t];if(s)for(i=s.length;--i>-1;)if(s[i].c===e)return void s.splice(i,1)},a.dispatchEvent=function(t){var e,i,s,n=this._listeners[t];if(n)for((e=n.length)>1&&(n=n.slice(0)),i=this._eventTarget;--e>-1;)(s=n[e])&&(s.up?s.c.call(s.s||i,{type:t,target:i}):s.c.call(s.s||i))};var b=t.requestAnimationFrame,k=t.cancelAnimationFrame,A=Date.now||function(){return(new Date).getTime()},S=A();for(r=(n=["ms","moz","webkit","o"]).length;--r>-1&&!b;)b=t[n[r]+"RequestAnimationFrame"],k=t[n[r]+"CancelAnimationFrame"]||t[n[r]+"CancelRequestAnimationFrame"];v("Ticker",function(t,e){var i,s,n,r,a,h=this,_=A(),u=!(!1===e||!b)&&"auto",c=500,m=33,p=function(t){var e,o,l=A()-S;l>c&&(_+=l-m),S+=l,h.time=(S-_)/1e3,e=h.time-a,(!i||e>0||!0===t)&&(h.frame++,a+=e+(e>=r?.004:r-e),o=!0),!0!==t&&(n=s(p)),o&&h.dispatchEvent("tick")};P.call(h),h.time=h.frame=0,h.tick=function(){p(!0)},h.lagSmoothing=function(t,e){c=t||1e10,m=Math.min(e,c,0)},h.sleep=function(){null!=n&&(u&&k?k(n):clearTimeout(n),s=f,n=null,h===o&&(l=!1))},h.wake=function(t){null!==n?h.sleep():t?_+=-S+(S=A()):h.frame>10&&(S=A()-c+5),s=0===i?f:u&&b?b:function(t){return setTimeout(t,1e3*(a-h.time)+1|0)},h===o&&(l=!0),p(2)},h.fps=function(t){if(!arguments.length)return i;r=1/((i=t)||60),a=this.time+r,h.wake()},h.useRAF=function(t){if(!arguments.length)return u;h.sleep(),u=t,h.fps(i)},h.fps(t),setTimeout(function(){"auto"===u&&h.frame<5&&"hidden"!==document.visibilityState&&h.useRAF(!1)},1500)}),(a=_.Ticker.prototype=new _.events.EventDispatcher).constructor=_.Ticker;var x=v("core.Animation",function(t,e){if(this.vars=e=e||{},this._duration=this._totalDuration=t||0,this._delay=Number(e.delay)||0,this._timeScale=1,this._active=!0===e.immediateRender,this.data=e.data,this._reversed=!0===e.reversed,K){l||o.wake();var i=this.vars.useFrames?$:K;i.add(this,i._time),this.vars.paused&&this.paused(!0)}});o=x.ticker=new _.Ticker,(a=x.prototype)._dirty=a._gc=a._initted=a._paused=!1,a._totalTime=a._time=0,a._rawPrevTime=-1,a._next=a._last=a._onUpdate=a._timeline=a.timeline=null,a._paused=!1;var R=function(){l&&A()-S>2e3&&o.wake(),setTimeout(R,2e3)};R(),a.play=function(t,e){return null!=t&&this.seek(t,e),this.reversed(!1).paused(!1)},a.pause=function(t,e){return null!=t&&this.seek(t,e),this.paused(!0)},a.resume=function(t,e){return null!=t&&this.seek(t,e),this.paused(!1)},a.seek=function(t,e){return this.totalTime(Number(t),!1!==e)},a.restart=function(t,e){return this.reversed(!1).paused(!1).totalTime(t?-this._delay:0,!1!==e,!0)},a.reverse=function(t,e){return null!=t&&this.seek(t||this.totalDuration(),e),this.reversed(!0).paused(!1)},a.render=function(t,e,i){},a.invalidate=function(){return this._time=this._totalTime=0,this._initted=this._gc=!1,this._rawPrevTime=-1,!this._gc&&this.timeline||this._enabled(!0),this},a.isActive=function(){var t,e=this._timeline,i=this._startTime;return!e||!this._gc&&!this._paused&&e.isActive()&&(t=e.rawTime())>=i&&t<i+this.totalDuration()/this._timeScale},a._enabled=function(t,e){return l||o.wake(),this._gc=!t,this._active=this.isActive(),!0!==e&&(t&&!this.timeline?this._timeline.add(this,this._startTime-this._delay):!t&&this.timeline&&this._timeline._remove(this,!0)),!1},a._kill=function(t,e){return this._enabled(!1,!1)},a.kill=function(t,e){return this._kill(t,e),this},a._uncache=function(t){for(var e=t?this:this.timeline;e;)e._dirty=!0,e=e.timeline;return this},a._swapSelfInParams=function(t){for(var e=t.length,i=t.concat();--e>-1;)"{self}"===t[e]&&(i[e]=this);return i},a._callback=function(t){var e=this.vars,i=e[t],s=e[t+"Params"],n=e[t+"Scope"]||e.callbackScope||this;switch(s?s.length:0){case 0:i.call(n);break;case 1:i.call(n,s[0]);break;case 2:i.call(n,s[0],s[1]);break;default:i.apply(n,s)}},a.eventCallback=function(t,e,i,s){if("on"===(t||"").substr(0,2)){var n=this.vars;if(1===arguments.length)return n[t];null==e?delete n[t]:(n[t]=e,n[t+"Params"]=c(i)&&-1!==i.join("").indexOf("{self}")?this._swapSelfInParams(i):i,n[t+"Scope"]=s),"onUpdate"===t&&(this._onUpdate=e)}return this},a.delay=function(t){return arguments.length?(this._timeline.smoothChildTiming&&this.startTime(this._startTime+t-this._delay),this._delay=t,this):this._delay},a.duration=function(t){return arguments.length?(this._duration=this._totalDuration=t,this._uncache(!0),this._timeline.smoothChildTiming&&this._time>0&&this._time<this._duration&&0!==t&&this.totalTime(this._totalTime*(t/this._duration),!0),this):(this._dirty=!1,this._duration)},a.totalDuration=function(t){return this._dirty=!1,arguments.length?this.duration(t):this._totalDuration},a.time=function(t,e){return arguments.length?(this._dirty&&this.totalDuration(),this.totalTime(t>this._duration?this._duration:t,e)):this._time},a.totalTime=function(t,e,i){if(l||o.wake(),!arguments.length)return this._totalTime;if(this._timeline){if(t<0&&!i&&(t+=this.totalDuration()),this._timeline.smoothChildTiming){this._dirty&&this.totalDuration();var s=this._totalDuration,n=this._timeline;if(t>s&&!i&&(t=s),this._startTime=(this._paused?this._pauseTime:n._time)-(this._reversed?s-t:t)/this._timeScale,n._dirty||this._uncache(!1),n._timeline)for(;n._timeline;)n._timeline._time!==(n._startTime+n._totalTime)/n._timeScale&&n.totalTime(n._totalTime,!0),n=n._timeline}this._gc&&this._enabled(!0,!1),this._totalTime===t&&0!==this._duration||(O.length&&J(),this.render(t,e,!1),O.length&&J())}return this},a.progress=a.totalProgress=function(t,e){var i=this.duration();return arguments.length?this.totalTime(i*t,e):i?this._time/i:this.ratio},a.startTime=function(t){return arguments.length?(t!==this._startTime&&(this._startTime=t,this.timeline&&this.timeline._sortChildren&&this.timeline.add(this,t-this._delay)),this):this._startTime},a.endTime=function(t){return this._startTime+(0!=t?this.totalDuration():this.duration())/this._timeScale},a.timeScale=function(t){if(!arguments.length)return this._timeScale;if(t=t||1e-10,this._timeline&&this._timeline.smoothChildTiming){var e=this._pauseTime,i=e||0===e?e:this._timeline.totalTime();this._startTime=i-(i-this._startTime)*this._timeScale/t}return this._timeScale=t,this._uncache(!1)},a.reversed=function(t){return arguments.length?(t!=this._reversed&&(this._reversed=t,this.totalTime(this._timeline&&!this._timeline.smoothChildTiming?this.totalDuration()-this._totalTime:this._totalTime,!0)),this):this._reversed},a.paused=function(t){if(!arguments.length)return this._paused;var e,i,s=this._timeline;return t!=this._paused&&s&&(l||t||o.wake(),i=(e=s.rawTime())-this._pauseTime,!t&&s.smoothChildTiming&&(this._startTime+=i,this._uncache(!1)),this._pauseTime=t?e:null,this._paused=t,this._active=this.isActive(),!t&&0!==i&&this._initted&&this.duration()&&(e=s.smoothChildTiming?this._totalTime:(e-this._startTime)/this._timeScale,this.render(e,e===this._totalTime,!0))),this._gc&&!t&&this._enabled(!0,!1),this};var C=v("core.SimpleTimeline",function(t){x.call(this,0,t),this.autoRemoveChildren=this.smoothChildTiming=!0});(a=C.prototype=new x).constructor=C,a.kill()._gc=!1,a._first=a._last=a._recent=null,a._sortChildren=!1,a.add=a.insert=function(t,e,i,s){var n,r;if(t._startTime=Number(e||0)+t._delay,t._paused&&this!==t._timeline&&(t._pauseTime=t._startTime+(this.rawTime()-t._startTime)/t._timeScale),t.timeline&&t.timeline._remove(t,!0),t.timeline=t._timeline=this,t._gc&&t._enabled(!0,!0),n=this._last,this._sortChildren)for(r=t._startTime;n&&n._startTime>r;)n=n._prev;return n?(t._next=n._next,n._next=t):(t._next=this._first,this._first=t),t._next?t._next._prev=t:this._last=t,t._prev=n,this._recent=t,this._timeline&&this._uncache(!0),this},a._remove=function(t,e){return t.timeline===this&&(e||t._enabled(!1,!0),t._prev?t._prev._next=t._next:this._first===t&&(this._first=t._next),t._next?t._next._prev=t._prev:this._last===t&&(this._last=t._prev),t._next=t._prev=t.timeline=null,t===this._recent&&(this._recent=this._last),this._timeline&&this._uncache(!0)),this},a.render=function(t,e,i){var s,n=this._first;for(this._totalTime=this._time=this._rawPrevTime=t;n;)s=n._next,(n._active||t>=n._startTime&&!n._paused)&&(n._reversed?n.render((n._dirty?n.totalDuration():n._totalDuration)-(t-n._startTime)*n._timeScale,e,i):n.render((t-n._startTime)*n._timeScale,e,i)),n=s},a.rawTime=function(){return l||o.wake(),this._totalTime};var D=v("TweenLite",function(e,i,s){if(x.call(this,i,s),this.render=D.prototype.render,null==e)throw"Cannot tween a null target.";this.target=e="string"!=typeof e?e:D.selector(e)||e;var n,r,a,o=e.jquery||e.length&&e!==t&&e[0]&&(e[0]===t||e[0].nodeType&&e[0].style&&!e.nodeType),l=this.vars.overwrite;if(this._overwrite=l=null==l?B[D.defaultOverwrite]:"number"==typeof l?l>>0:B[l],(o||e instanceof Array||e.push&&c(e))&&"number"!=typeof e[0])for(this._targets=a=u(e),this._propLookup=[],this._siblings=[],n=0;n<a.length;n++)(r=a[n])?"string"!=typeof r?r.length&&r!==t&&r[0]&&(r[0]===t||r[0].nodeType&&r[0].style&&!r.nodeType)?(a.splice(n--,1),this._targets=a=a.concat(u(r))):(this._siblings[n]=V(r,this,!1),1===l&&this._siblings[n].length>1&&X(r,this,null,1,this._siblings[n])):"string"==typeof(r=a[n--]=D.selector(r))&&a.splice(n+1,1):a.splice(n--,1);else this._propLookup={},this._siblings=V(e,this,!1),1===l&&this._siblings.length>1&&X(e,this,null,1,this._siblings);(this.vars.immediateRender||0===i&&0===this._delay&&!1!==this.vars.immediateRender)&&(this._time=-1e-10,this.render(Math.min(0,-this._delay)))},!0),I=function(e){return e&&e.length&&e!==t&&e[0]&&(e[0]===t||e[0].nodeType&&e[0].style&&!e.nodeType)},E=function(t,e){var i,s={};for(i in t)q[i]||i in e&&"transform"!==i&&"x"!==i&&"y"!==i&&"width"!==i&&"height"!==i&&"className"!==i&&"border"!==i||!(!G[i]||G[i]&&G[i]._autoCSS)||(s[i]=t[i],delete t[i]);t.css=s};(a=D.prototype=new x).constructor=D,a.kill()._gc=!1,a.ratio=0,a._firstPT=a._targets=a._overwrittenProps=a._startAt=null,a._notifyPluginsOfEnabled=a._lazy=!1,D.version="1.19.0",D.defaultEase=a._ease=new T(null,null,1,1),D.defaultOverwrite="auto",D.ticker=o,D.autoSleep=120,D.lagSmoothing=function(t,e){o.lagSmoothing(t,e)},D.selector=t.$||t.jQuery||function(e){var i=t.$||t.jQuery;return i?(D.selector=i,i(e)):"undefined"==typeof document?e:document.querySelectorAll?document.querySelectorAll(e):document.getElementById("#"===e.charAt(0)?e.substr(1):e)};var O=[],z={},F=/(?:(-|-=|\+=)?\d*\.?\d*(?:e[\-+]?\d+)?)[0-9]/gi,L=function(t){for(var e,i=this._firstPT;i;)e=i.blob?t?this.join(""):this.start:i.c*t+i.s,i.m?e=i.m(e,this._target||i.t):e<1e-6&&e>-1e-6&&(e=0),i.f?i.fp?i.t[i.p](i.fp,e):i.t[i.p](e):i.t[i.p]=e,i=i._next},N=function(t,e,i,s){var n,r,a,o,l,h,_,u=[t,e],f=0,c="",m=0;for(u.start=t,i&&(i(u),t=u[0],e=u[1]),u.length=0,n=t.match(F)||[],r=e.match(F)||[],s&&(s._next=null,s.blob=1,u._firstPT=u._applyPT=s),l=r.length,o=0;o<l;o++)_=r[o],c+=(h=e.substr(f,e.indexOf(_,f)-f))||!o?h:",",f+=h.length,m?m=(m+1)%5:"rgba("===h.substr(-5)&&(m=1),_===n[o]||n.length<=o?c+=_:(c&&(u.push(c),c=""),a=parseFloat(n[o]),u.push(a),u._firstPT={_next:u._firstPT,t:u,p:u.length-1,s:a,c:("="===_.charAt(1)?parseInt(_.charAt(0)+"1",10)*parseFloat(_.substr(2)):parseFloat(_)-a)||0,f:0,m:m&&m<4?Math.round:0}),f+=_.length;return(c+=e.substr(f))&&u.push(c),u.setRatio=L,u},U=function(t,e,i,s,n,r,a,o,l){"function"==typeof s&&(s=s(l||0,t));var h,_="get"===i?t[e]:i,u=typeof t[e],f="string"==typeof s&&"="===s.charAt(1),c={t:t,p:e,s:_,f:"function"===u,pg:0,n:n||e,m:r?"function"==typeof r?r:Math.round:0,pr:0,c:f?parseInt(s.charAt(0)+"1",10)*parseFloat(s.substr(2)):parseFloat(s)-_||0};if("number"!==u&&("function"===u&&"get"===i&&(h=e.indexOf("set")||"function"!=typeof t["get"+e.substr(3)]?e:"get"+e.substr(3),c.s=_=a?t[h](a):t[h]()),"string"==typeof _&&(a||isNaN(_))?(c.fp=a,c={t:N(_,s,o||D.defaultStringFilter,c),p:"setRatio",s:0,c:1,f:2,pg:0,n:n||e,pr:0,m:0}):f||(c.s=parseFloat(_),c.c=parseFloat(s)-c.s||0)),c.c)return(c._next=this._firstPT)&&(c._next._prev=c),this._firstPT=c,c},j=D._internals={isArray:c,isSelector:I,lazyTweens:O,blobDif:N},G=D._plugins={},M=j.tweenLookup={},Q=0,q=j.reservedProps={ease:1,delay:1,overwrite:1,onComplete:1,onCompleteParams:1,onCompleteScope:1,useFrames:1,runBackwards:1,startAt:1,onUpdate:1,onUpdateParams:1,onUpdateScope:1,onStart:1,onStartParams:1,onStartScope:1,onReverseComplete:1,onReverseCompleteParams:1,onReverseCompleteScope:1,onRepeat:1,onRepeatParams:1,onRepeatScope:1,easeParams:1,yoyo:1,immediateRender:1,repeat:1,repeatDelay:1,data:1,paused:1,reversed:1,autoCSS:1,lazy:1,onOverwrite:1,callbackScope:1,stringFilter:1,id:1},B={none:0,all:1,auto:2,concurrent:3,allOnStart:4,preexisting:5,true:1,false:0},$=x._rootFramesTimeline=new C,K=x._rootTimeline=new C,H=30,J=j.lazyRender=function(){var t,e=O.length;for(z={};--e>-1;)(t=O[e])&&!1!==t._lazy&&(t.render(t._lazy[0],t._lazy[1],!0),t._lazy=!1);O.length=0};K._startTime=o.time,$._startTime=o.frame,K._active=$._active=!0,setTimeout(J,1),x._updateRoot=D.render=function(){var t,e,i;if(O.length&&J(),K.render((o.time-K._startTime)*K._timeScale,!1,!1),$.render((o.frame-$._startTime)*$._timeScale,!1,!1),O.length&&J(),o.frame>=H){H=o.frame+(parseInt(D.autoSleep,10)||120);for(i in M){for(t=(e=M[i].tweens).length;--t>-1;)e[t]._gc&&e.splice(t,1);0===e.length&&delete M[i]}if((!(i=K._first)||i._paused)&&D.autoSleep&&!$._first&&1===o._listeners.tick.length){for(;i&&i._paused;)i=i._next;i||o.sleep()}}},o.addEventListener("tick",x._updateRoot);var V=function(t,e,i){var s,n,r=t._gsTweenID;if(M[r||(t._gsTweenID=r="t"+Q++)]||(M[r]={target:t,tweens:[]}),e&&(s=M[r].tweens,s[n=s.length]=e,i))for(;--n>-1;)s[n]===e&&s.splice(n,1);return M[r].tweens},W=function(t,e,i,s){var n,r,a=t.vars.onOverwrite;return a&&(n=a(t,e,i,s)),(a=D.onOverwrite)&&(r=a(t,e,i,s)),!1!==n&&!1!==r},X=function(t,e,i,s,n){var r,a,o,l;if(1===s||s>=4){for(l=n.length,r=0;r<l;r++)if((o=n[r])!==e)o._gc||o._kill(null,t,e)&&(a=!0);else if(5===s)break;return a}var h,_=e._startTime+1e-10,u=[],f=0,c=0===e._duration;for(r=n.length;--r>-1;)(o=n[r])===e||o._gc||o._paused||(o._timeline!==e._timeline?(h=h||Y(e,0,c),0===Y(o,h,c)&&(u[f++]=o)):o._startTime<=_&&o._startTime+o.totalDuration()/o._timeScale>_&&((c||!o._initted)&&_-o._startTime<=2e-10||(u[f++]=o)));for(r=f;--r>-1;)if(o=u[r],2===s&&o._kill(i,t,e)&&(a=!0),2!==s||!o._firstPT&&o._initted){if(2!==s&&!W(o,e))continue;o._enabled(!1,!1)&&(a=!0)}return a},Y=function(t,e,i){for(var s=t._timeline,n=s._timeScale,r=t._startTime;s._timeline;){if(r+=s._startTime,n*=s._timeScale,s._paused)return-100;s=s._timeline}return(r/=n)>e?r-e:i&&r===e||!t._initted&&r-e<2e-10?1e-10:(r+=t.totalDuration()/t._timeScale/n)>e+1e-10?0:r-e-1e-10};a._init=function(){var t,e,i,s,n,r,a=this.vars,o=this._overwrittenProps,l=this._duration,h=!!a.immediateRender,_=a.ease;if(a.startAt){this._startAt&&(this._startAt.render(-1,!0),this._startAt.kill()),n={};for(s in a.startAt)n[s]=a.startAt[s];if(n.overwrite=!1,n.immediateRender=!0,n.lazy=h&&!1!==a.lazy,n.startAt=n.delay=null,this._startAt=D.to(this.target,0,n),h)if(this._time>0)this._startAt=null;else if(0!==l)return}else if(a.runBackwards&&0!==l)if(this._startAt)this._startAt.render(-1,!0),this._startAt.kill(),this._startAt=null;else{0!==this._time&&(h=!1),i={};for(s in a)q[s]&&"autoCSS"!==s||(i[s]=a[s]);if(i.overwrite=0,i.data="isFromStart",i.lazy=h&&!1!==a.lazy,i.immediateRender=h,this._startAt=D.to(this.target,0,i),h){if(0===this._time)return}else this._startAt._init(),this._startAt._enabled(!1),this.vars.immediateRender&&(this._startAt=null)}if(this._ease=_=_?_ instanceof T?_:"function"==typeof _?new T(_,a.easeParams):y[_]||D.defaultEase:D.defaultEase,a.easeParams instanceof Array&&_.config&&(this._ease=_.config.apply(_,a.easeParams)),this._easeType=this._ease._type,this._easePower=this._ease._power,this._firstPT=null,this._targets)for(r=this._targets.length,t=0;t<r;t++)this._initProps(this._targets[t],this._propLookup[t]={},this._siblings[t],o?o[t]:null,t)&&(e=!0);else e=this._initProps(this.target,this._propLookup,this._siblings,o,0);if(e&&D._onPluginEvent("_onInitAllProps",this),o&&(this._firstPT||"function"!=typeof this.target&&this._enabled(!1,!1)),a.runBackwards)for(i=this._firstPT;i;)i.s+=i.c,i.c=-i.c,i=i._next;this._onUpdate=a.onUpdate,this._initted=!0},a._initProps=function(e,i,s,n,r){var a,o,l,h,_,u;if(null==e)return!1;z[e._gsTweenID]&&J(),this.vars.css||e.style&&e!==t&&e.nodeType&&G.css&&!1!==this.vars.autoCSS&&E(this.vars,e);for(a in this.vars)if(u=this.vars[a],q[a])u&&(u instanceof Array||u.push&&c(u))&&-1!==u.join("").indexOf("{self}")&&(this.vars[a]=u=this._swapSelfInParams(u,this));else if(G[a]&&(h=new G[a])._onInitTween(e,this.vars[a],this,r)){for(this._firstPT=_={_next:this._firstPT,t:h,p:"setRatio",s:0,c:1,f:1,n:a,pg:1,pr:h._priority,m:0},o=h._overwriteProps.length;--o>-1;)i[h._overwriteProps[o]]=this._firstPT;(h._priority||h._onInitAllProps)&&(l=!0),(h._onDisable||h._onEnable)&&(this._notifyPluginsOfEnabled=!0),_._next&&(_._next._prev=_)}else i[a]=U.call(this,e,a,"get",u,a,0,null,this.vars.stringFilter,r);return n&&this._kill(n,e)?this._initProps(e,i,s,n,r):this._overwrite>1&&this._firstPT&&s.length>1&&X(e,this,i,this._overwrite,s)?(this._kill(i,e),this._initProps(e,i,s,n,r)):(this._firstPT&&(!1!==this.vars.lazy&&this._duration||this.vars.lazy&&!this._duration)&&(z[e._gsTweenID]=!0),l)},a.render=function(t,e,i){var s,n,r,a,o=this._time,l=this._duration,h=this._rawPrevTime;if(t>=l-1e-7)this._totalTime=this._time=l,this.ratio=this._ease._calcEnd?this._ease.getRatio(1):1,this._reversed||(s=!0,n="onComplete",i=i||this._timeline.autoRemoveChildren),0===l&&(this._initted||!this.vars.lazy||i)&&(this._startTime===this._timeline._duration&&(t=0),(h<0||t<=0&&t>=-1e-7||1e-10===h&&"isPause"!==this.data)&&h!==t&&(i=!0,h>1e-10&&(n="onReverseComplete")),this._rawPrevTime=a=!e||t||h===t?t:1e-10);else if(t<1e-7)this._totalTime=this._time=0,this.ratio=this._ease._calcEnd?this._ease.getRatio(0):0,(0!==o||0===l&&h>0)&&(n="onReverseComplete",s=this._reversed),t<0&&(this._active=!1,0===l&&(this._initted||!this.vars.lazy||i)&&(h>=0&&(1e-10!==h||"isPause"!==this.data)&&(i=!0),this._rawPrevTime=a=!e||t||h===t?t:1e-10)),this._initted||(i=!0);else if(this._totalTime=this._time=t,this._easeType){var _=t/l,u=this._easeType,f=this._easePower;(1===u||3===u&&_>=.5)&&(_=1-_),3===u&&(_*=2),1===f?_*=_:2===f?_*=_*_:3===f?_*=_*_*_:4===f&&(_*=_*_*_*_),this.ratio=1===u?1-_:2===u?_:t/l<.5?_/2:1-_/2}else this.ratio=this._ease.getRatio(t/l);if(this._time!==o||i){if(!this._initted){if(this._init(),!this._initted||this._gc)return;if(!i&&this._firstPT&&(!1!==this.vars.lazy&&this._duration||this.vars.lazy&&!this._duration))return this._time=this._totalTime=o,this._rawPrevTime=h,O.push(this),void(this._lazy=[t,e]);this._time&&!s?this.ratio=this._ease.getRatio(this._time/l):s&&this._ease._calcEnd&&(this.ratio=this._ease.getRatio(0===this._time?0:1))}for(!1!==this._lazy&&(this._lazy=!1),this._active||!this._paused&&this._time!==o&&t>=0&&(this._active=!0),0===o&&(this._startAt&&(t>=0?this._startAt.render(t,e,i):n||(n="_dummyGS")),this.vars.onStart&&(0===this._time&&0!==l||e||this._callback("onStart"))),r=this._firstPT;r;)r.f?r.t[r.p](r.c*this.ratio+r.s):r.t[r.p]=r.c*this.ratio+r.s,r=r._next;this._onUpdate&&(t<0&&this._startAt&&-1e-4!==t&&this._startAt.render(t,e,i),e||(this._time!==o||s||i)&&this._callback("onUpdate")),n&&(this._gc&&!i||(t<0&&this._startAt&&!this._onUpdate&&-1e-4!==t&&this._startAt.render(t,e,i),s&&(this._timeline.autoRemoveChildren&&this._enabled(!1,!1),this._active=!1),!e&&this.vars[n]&&this._callback(n),0===l&&1e-10===this._rawPrevTime&&1e-10!==a&&(this._rawPrevTime=0)))}},a._kill=function(t,e,i){if("all"===t&&(t=null),null==t&&(null==e||e===this.target))return this._lazy=!1,this._enabled(!1,!1);e="string"!=typeof e?e||this._targets||this.target:D.selector(e)||e;var s,n,r,a,o,l,h,_,u,f=i&&this._time&&i._startTime===this._startTime&&this._timeline===i._timeline;if((c(e)||I(e))&&"number"!=typeof e[0])for(s=e.length;--s>-1;)this._kill(t,e[s],i)&&(l=!0);else{if(this._targets){for(s=this._targets.length;--s>-1;)if(e===this._targets[s]){o=this._propLookup[s]||{},this._overwrittenProps=this._overwrittenProps||[],n=this._overwrittenProps[s]=t?this._overwrittenProps[s]||{}:"all";break}}else{if(e!==this.target)return!1;o=this._propLookup,n=this._overwrittenProps=t?this._overwrittenProps||{}:"all"}if(o){if(h=t||o,_=t!==n&&"all"!==n&&t!==o&&("object"!=typeof t||!t._tempKill),i&&(D.onOverwrite||this.vars.onOverwrite)){for(r in h)o[r]&&(u||(u=[]),u.push(r));if((u||!t)&&!W(this,i,e,u))return!1}for(r in h)(a=o[r])&&(f&&(a.f?a.t[a.p](a.s):a.t[a.p]=a.s,l=!0),a.pg&&a.t._kill(h)&&(l=!0),a.pg&&0!==a.t._overwriteProps.length||(a._prev?a._prev._next=a._next:a===this._firstPT&&(this._firstPT=a._next),a._next&&(a._next._prev=a._prev),a._next=a._prev=null),delete o[r]),_&&(n[r]=1);!this._firstPT&&this._initted&&this._enabled(!1,!1)}}return l},a.invalidate=function(){return this._notifyPluginsOfEnabled&&D._onPluginEvent("_onDisable",this),this._firstPT=this._overwrittenProps=this._startAt=this._onUpdate=null,this._notifyPluginsOfEnabled=this._active=this._lazy=!1,this._propLookup=this._targets?{}:[],x.prototype.invalidate.call(this),this.vars.immediateRender&&(this._time=-1e-10,this.render(Math.min(0,-this._delay))),this},a._enabled=function(t,e){if(l||o.wake(),t&&this._gc){var i,s=this._targets;if(s)for(i=s.length;--i>-1;)this._siblings[i]=V(s[i],this,!0);else this._siblings=V(this.target,this,!0)}return x.prototype._enabled.call(this,t,e),!(!this._notifyPluginsOfEnabled||!this._firstPT)&&D._onPluginEvent(t?"_onEnable":"_onDisable",this)},D.to=function(t,e,i){return new D(t,e,i)},D.from=function(t,e,i){return i.runBackwards=!0,i.immediateRender=0!=i.immediateRender,new D(t,e,i)},D.fromTo=function(t,e,i,s){return s.startAt=i,s.immediateRender=0!=s.immediateRender&&0!=i.immediateRender,new D(t,e,s)},D.delayedCall=function(t,e,i,s,n){return new D(e,0,{delay:t,onComplete:e,onCompleteParams:i,callbackScope:s,onReverseComplete:e,onReverseCompleteParams:i,immediateRender:!1,lazy:!1,useFrames:n,overwrite:0})},D.set=function(t,e){return new D(t,0,e)},D.getTweensOf=function(t,e){if(null==t)return[];t="string"!=typeof t?t:D.selector(t)||t;var i,s,n,r;if((c(t)||I(t))&&"number"!=typeof t[0]){for(i=t.length,s=[];--i>-1;)s=s.concat(D.getTweensOf(t[i],e));for(i=s.length;--i>-1;)for(r=s[i],n=i;--n>-1;)r===s[n]&&s.splice(i,1)}else for(i=(s=V(t).concat()).length;--i>-1;)(s[i]._gc||e&&!s[i].isActive())&&s.splice(i,1);return s},D.killTweensOf=D.killDelayedCallsTo=function(t,e,i){"object"==typeof e&&(i=e,e=!1);for(var s=D.getTweensOf(t,e),n=s.length;--n>-1;)s[n]._kill(i,t)};var Z=v("plugins.TweenPlugin",function(t,e){this._overwriteProps=(t||"").split(","),this._propName=this._overwriteProps[0],this._priority=e||0,this._super=Z.prototype},!0);if(a=Z.prototype,Z.version="1.19.0",Z.API=2,a._firstPT=null,a._addTween=U,a.setRatio=L,a._kill=function(t){var e,i=this._overwriteProps,s=this._firstPT;if(null!=t[this._propName])this._overwriteProps=[];else for(e=i.length;--e>-1;)null!=t[i[e]]&&i.splice(e,1);for(;s;)null!=t[s.n]&&(s._next&&(s._next._prev=s._prev),s._prev?(s._prev._next=s._next,s._prev=null):this._firstPT===s&&(this._firstPT=s._next)),s=s._next;return!1},a._mod=a._roundProps=function(t){for(var e,i=this._firstPT;i;)(e=t[this._propName]||null!=i.n&&t[i.n.split(this._propName+"_").join("")])&&"function"==typeof e&&(2===i.f?i.t._applyPT.m=e:i.m=e),i=i._next},D._onPluginEvent=function(t,e){var i,s,n,r,a,o=e._firstPT;if("_onInitAllProps"===t){for(;o;){for(a=o._next,s=n;s&&s.pr>o.pr;)s=s._next;(o._prev=s?s._prev:r)?o._prev._next=o:n=o,(o._next=s)?s._prev=o:r=o,o=a}o=e._firstPT=n}for(;o;)o.pg&&"function"==typeof o.t[t]&&o.t[t]()&&(i=!0),o=o._next;return i},Z.activate=function(t){for(var e=t.length;--e>-1;)t[e].API===Z.API&&(G[(new t[e])._propName]=t[e]);return!0},d.plugin=function(t){if(!(t&&t.propName&&t.init&&t.API))throw"illegal plugin definition.";var e,i=t.propName,s=t.priority||0,n=t.overwriteProps,r={init:"_onInitTween",set:"setRatio",kill:"_kill",round:"_mod",mod:"_mod",initAll:"_onInitAllProps"},a=v("plugins."+i.charAt(0).toUpperCase()+i.substr(1)+"Plugin",function(){Z.call(this,i,s),this._overwriteProps=n||[]},!0===t.global),o=a.prototype=new Z(i);o.constructor=a,a.API=t.API;for(e in r)"function"==typeof t[e]&&(o[r[e]]=t[e]);return a.version=t.version,Z.activate([a]),a},n=t._gsQueue){for(r=0;r<n.length;r++)n[r]();for(a in m)m[a].func||t.console.log("GSAP encountered missing dependency: "+a)}l=!1}}("undefined"!=typeof module&&module.exports&&"undefined"!=typeof global?global:this||window);