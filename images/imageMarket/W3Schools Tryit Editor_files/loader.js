!function(e){var n={};function t(r){if(n[r])return n[r].exports;var a=n[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,t),a.l=!0,a.exports}t.m=e,t.c=n,t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{enumerable:!0,get:r})},t.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},t.t=function(e,n){if(1&n&&(e=t(e)),8&n)return e;if(4&n&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(t.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&n&&"string"!=typeof e)for(var a in e)t.d(r,a,function(n){return e[n]}.bind(null,a));return r},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,n){return Object.prototype.hasOwnProperty.call(e,n)},t.p="",t(t.s=0)}([function(e,n,t){var r=t(1);r.init();var a=r.get();try{!function(e,n,r,o,i){var s,c,u={scripts:[{name:"qchoice",loadModule:function(){return t(3)}},{name:"adconsent",skipLoadOnExists:!0,loadModule:function(){return t(4)},onLoad:{emitEvent:"adnginLoaderReady",scripts:[{name:"pbjs",obj:{que:[]},queue:"que",path:"?v="+escape(e)},{name:"apstag",obj:{init:function(){this._Q.push(["i",arguments])},fetchBids:function(){this._Q.push(["f",arguments])},setDisplayBids:function(){},targetingKeys:function(){return[]},_Q:[]}},{name:"gpt",obj:{cmd:[]},queue:"cmd"},{name:"adsbygoogle",obj:[]},{name:"adngin",obj:{queue:[],metrics:{timing:{}}},queue:"queue",path:"/"+escape(n)+"/"+escape(e)+"/adngin.js"},{name:"scripts",argus:{obj:{cmd:[]},queue:"cmd"}}]}}]},l=window.performance,d=l.now?function(){return o(l.now())}:function(){return-1},f=function(e,n){var t=function(e){return(l.getEntriesByType?l.getEntriesByType("resource"):[]).find((function(n){return e(n.name)}))||{startTime:-1,responseEnd:-1}}(n),r=y[e]||(y[e]={});r.requested=[o(t.startTime)],r.loaded=[o(t.responseEnd)],r.ready=[d()]},p=function(e,n,t){var r=a.resources||(a.resources={}),o=document.createElement("script");o.type="text/javascript",o.async=!0,o.onload=function(){f(e,(function(e){return e.toLowerCase().indexOf(n.toLowerCase())>=0})),r[e].loaded=!0,t&&t()},y[e]||(y[e]={}),y[e].queued=[d()],r[e]={scriptElement:o,loaded:!1},o.src=n,document.head.appendChild(o)},g=function(e,n,t){e.scripts.forEach((function(e){var a=r[e.name]||{};!i(a)&&a.load&&n(a.objName,e),e.onLoad&&e.onLoad.scripts&&t(e.onLoad)}))},v=function(e,n){var t=n.obj;if(t)if(window[e]){var r=window[e];for(var a in t)r[a]=r[a]||t[a]}else window[e]=t},m=function(e,n){var t=n.queue;t&&window[e][t].push((function(){var t;(y[t=n.name||e]||(y[t]={})).apiReady=[d()]}))};((s=window).adsbygoogle||(s.adsbygoogle=[])).pauseAdRequests=1,(c=window).snigelPubConf||(c.snigelPubConf={}),function e(n){return g(n,v,e)}(u);var b=window[r.adngin.objName],y=b.metrics.timing;f("loader",(function(e){return/.*snigel.*loader.js$/i.test(e)})),function e(n){return g(n,m,e)}(u),function e(n){if(!n)return!1;n.emitEvent&&(window.dispatchEvent(new CustomEvent(n.emitEvent)),b[n.emitEvent]=!0,y.loader[n.emitEvent]=[d()]),n.scripts&&n.scripts.forEach((function(n){var t=r[n.name]||{},a=function(){var e=!!window[t.objName];return t.load&&(!e||e&&!n.skipLoadOnExists)};i(t)?t.forEach((function(e){if(void 0===e.freq||o(100*Math.random())<e.freq){var t=e.name,r=n[t]||{};v(t,r),m(t,r),p(e.name||e.url,e.url)}})):(a()&&n.loadModule&&n.loadModule(),a()&&t.url?function(e,n){var t=r[e.name].queryParameters,a=r[e.name].url+(e.path||"")+(t?"?"+t:"");p(e.name,a,n)}(n,(function(){return e(n.onLoad)})):e(n.onLoad))}))}(u)}(a.version,a.site,a.settings,Math.floor,Array.isArray)}catch(e){if(!0===a.passThroughException)throw e;console.error(e)}},function(e,n,t){function r(e){return(r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function a(e,n){return function(e){if(Array.isArray(e))return e}(e)||function(e,n){var t=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null==t)return;var r,a,o=[],i=!0,s=!1;try{for(t=t.call(e);!(i=(r=t.next()).done)&&(o.push(r.value),!n||o.length!==n);i=!0);}catch(e){s=!0,a=e}finally{try{i||null==t.return||t.return()}finally{if(s)throw a}}return o}(e,n)||function(e,n){if(!e)return;if("string"==typeof e)return o(e,n);var t=Object.prototype.toString.call(e).slice(8,-1);"Object"===t&&e.constructor&&(t=e.constructor.name);if("Map"===t||"Set"===t)return Array.from(e);if("Arguments"===t||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t))return o(e,n)}(e,n)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()}function o(e,n){(null==n||n>e.length)&&(n=e.length);for(var t=0,r=new Array(n);t<n;t++)r[t]=e[t];return r}var i=t(2),s=function(e,n){console.warn("Override detected: '"+n);var t=function(){var n=document.getElementById("sn-session-override-warnings");n||((n=document.createElement("div")).id="sn-session-override-warnings",n.setAttribute("style","background: darkred; position: fixed; bottom: 0; left: 0; right: 0; z-index: 1000000; padding: 0.25em; color: white; font-family: monospace; font-size: small;"),n.innerHTML="(!) Session overrides:",n.addEventListener("mouseover",(function(){return n.style.opacity="0.20"})),n.addEventListener("mouseout",(function(){return n.style.opacity="1"})),document.body.appendChild(n)),n.innerHTML+=e},r=document.readyState;"interactive"===r||"complete"===r?t():document.addEventListener("DOMContentLoaded",(function e(){document.removeEventListener("DOMContentLoaded",e,!1),t()}),!1)};e.exports={init:function(){try{var e,n=(e=window)._snigelConfig||(e._snigelConfig={}),t=window.localStorage;for(var o in i)"exp"!=o&&(n[o]=i[o]);if(i.exp){var c,u,l=a((t.getItem("_sn_exp")||"").split(";"),2);c=l[0],u=l[1],c!=i.cfgVer&&(c=i.cfgVer,u=void 0),i.exp.some((function(e){if(u==e.id||null==u&&Math.random()<e.freq){var t="exp="+(u=e.id),r=e.settings.adngin.queryParameters;return e.settings.adngin.queryParameters=r?r+"&"+t:t,n.settings=e.settings,!0}return!1}))||(u=0),t.setItem("_sn_exp",c+";"+u)}else t.removeItem("_sn_exp");var d=JSON.parse(window.sessionStorage.getItem("snSessionOverrides"));if(null!==d){var f=d.products,p=d.adEngineCoreConfig;f&&"object"===r(f)&&!Array.isArray(f)&&Object.entries(f).forEach((function(e){var n=a(e,2),t=n[0],r=n[1],o=i.settings[t],c=r.message||"";o.url=r.url,o.queryParameters=r.queryParameters,s(" (".concat(t,", ").concat(c,")"),t+"': "+c)})),p&&(n.adEngineCoreConfigOverride=p,s(" (AdEngine coreConfig overriden) ","AdEngine coreConfig'."))}}catch(e){}},get:function(){return window._snigelConfig||{}}}},function(e){e.exports=JSON.parse('{"site":"w3schools.com","version":"9602-1710858873871","cfgVer":10365,"settings":{"adconsent":{"load":true,"objName":"adconsent","url":"//cdn.snigelweb.com/adconsent/adconsent.js","consentWall":false},"pbjs":{"load":true,"objName":"pbjs","url":"//cdn.snigelweb.com/prebid/8.26.0/prebid.js"},"gpt":{"load":true,"objName":"googletag","url":"//securepubads.g.doubleclick.net/tag/js/gpt.js"},"adngin":{"load":true,"objName":"adngin","url":"//adengine.snigelweb.com"},"apstag":{"load":true,"objName":"apstag","url":"//c.amazon-adsystem.com/aax2/apstag.js"},"scripts":[{"url":"//cdn.snigelweb.com/argus/argus.js","freq":100,"name":"argus"},{"url":"//boot.pbstck.com/v1/tag/6b8021b6-6874-4ef7-a983-9bb3141ccb5c","freq":5,"name":"pubstack"},{"url":"https://cdnx.snigelweb.com/315b44bc-10e5-45a8-8f58-064d6e7317c0.js","freq":100,"name":"pubx"}]}}')},function(e,n){},function(e,n,t){"use strict";!function(e,n,t,r,a,o,i,s){var c=e._snigelConfig;if(c)try{t=c.settings.adconsent.objName}catch(e){}var u=void 0,l=229,d="__"+t,f="stub",p="loaded",g="pwuserstatus",v={tcfeuv2:{z:1,v:2,sid:2,api:a,f:a,s:"getTCData",c:"euconsent-v2",n:"GDPR"},uspv1:{z:2,v:1,sid:6,api:i,f:i,s:"getUSPData",c:"usprivacy",n:"CCPA"},tcfcav1:{z:3,v:2,sid:5,api:t+".pipeda",f:"__tcfca",s:"getTCData",c:"caconsent",n:"PIPEDA"},usnat:{z:4,v:1,sid:7,api:t+".usnat",f:"__usnat",s:"getUSData",c:"usconsent",n:"USNATIONAL"},usca:{z:5,v:1,sid:8,api:t+".usnat",f:"__usnat",s:"getUSData",c:"uscaconsent",n:"US-CALIFORNIA"},usco:{z:6,v:1,sid:10,api:t+".usnat",f:"__usnat",s:"getUSData",c:"uscoconsent",n:"US-COLORADO"},usct:{z:7,v:1,sid:12,api:t+".usnat",f:"__usnat",s:"getUSData",c:"usctconsent",n:"US-CONNECTICUT"},usva:{z:8,v:1,sid:9,api:t+".usnat",f:"__usnat",s:"getUSData",c:"usvaconsent",n:"US-VIRGINIA"},usut:{z:9,v:1,sid:11,api:t+".usnat",f:"__usnat",s:"getUSData",c:"usutconsent",n:"US-UTAH"}},m=[1,2],b={gppVersion:"1.1",supportedAPIs:Object.keys(v).map((function(e){return v[e].sid+":"+e})),cmpStatus:f,cmpDisplayStatus:"disabled",cmpId:l};function y(e){return"function"==typeof e}function h(e){return"string"==typeof e}try{s=localStorage}catch(e){}var S,C,w=e.performance,E=w&&w.now?function(){return Math.floor(w.now())}:function(){return 0};function I(e){if(window.argus){var n=1===e.length&&e[0]instanceof Error?{stack:e[0].stack}:{log:e,stack:(new Error).stack};window.argus.cmd.push((function(){window.argus.queueError("adconsent",n)}))}}!function(){if(y(e.CustomEvent))return!1;function t(e,t){t=t||{bubbles:!1,cancelable:!1,detail:u};var r=n.createEvent("CustomEvent");return r.initCustomEvent(e,t.bubbles,t.cancelable,t.detail),r}t.prototype=e.Event.prototype,e.CustomEvent=t}();try{var _=function(n,t,r,a){e.console[n]&&B.level>=t&&console[n].apply(console,function(e,n,t){return e=[].slice.call(e),n&&e.unshift(n),e.unshift("display: inline-block; color: #fff; background: "+t+"; padding: 1px 4px; border-radius: 3px;"),e.unshift("%cAdConsent"),e}(r,n.toUpperCase()+":",a))},L=function(n){return n===r?function(t,r,a){e[n](t,a,r,u)}:function(t,r,a){e[n](t,u,a,r)}},A=function(e,n,t){return!n||n===e.version||(D(t,null,!1),W("Wrong framework version detected: "+n),!1)},j=function(e,n,t){var r=Y.applies?u:Y.applies,a={tcString:u,tcfPolicyVersion:4,cmpId:l,cmpVersion:81,gdprApplies:r,eventStatus:!1===r?"tcloaded":u,cmpStatus:Y.status,listenerId:n,isServiceSpecific:!0,useNonStandardStacks:!1,publisherCC:J.publisherCC,purposeOneTreatment:!1};return W("Sending TCData structure:",a,t),D(t,a,!0),a},O=function(e,n,t,r,a){e.queue.push({command:n,version:t,parameter:a,callback:r})},P=function(n){for(var t=Array.isArray(n)?n:(n||"").split("."),r=t.length>1,a=t.length-1,o=t[a],i=e,s=0;s<a&&(i=i[t[s]]);s++);return{r:i,e:o,apiParts:t,api:i?i[o]:u,internal:r}},x=function(t,a){var o=function(n){var a=n.data,o=h(a);try{var i=(o?JSON.parse(a):a)[t+"Call"];if(i){var s=function(e,r){try{if(n&&n.source&&n.source.postMessage){var a={};a[t+"Return"]={returnValue:e,success:r===u||r,callId:i.callId},n.source.postMessage(o?JSON.stringify(a):a,"*")}}catch(e){}};t===r?e[t](i.command,s,i.parameter,i.version):e[t](i.command,i.version,s,i.parameter)}}catch(e){}},i=P(t);if(!i.internal){!function t(r){if(!e.frames[r]){var a=n.body;if(a){var o=n.createElement("iframe");o.style.display="none",o.name=r,a.appendChild(o)}else setTimeout(t,5,r)}}(t+"Locator")}i.r&&!y(i.api)&&(i.r[i.e]=function(e,n,o,s){var c=P(i.apiParts).api;if(!c.queue)return c(e,n,o,s);var l=!1;for(var d in a)if(e===d)return l=!0,(0,a[d])(c,e,n,o,s);if(!l)if(t===r){var f=(e||"none").split("."),p=2===f.length?v[f[0]]:u;if(p){var g=P(p.api);g.internal?g.api(f[1],o,n):g.api(f[1],p.v,n,o)}else $("Unknown "+t+"() API call '"+e+"'")}else i.internal?O(c,e,s,o,n):O(c,e,n,o,s)},i.r[i.e].queue=[],i.internal||(e.addEventListener?e.addEventListener("message",o,!1):e.attachEvent("onmessage",o)))},D=function(e,n,t){y(e)&&setTimeout((function(){e(n,t)}),0)},k=function(e){if(s){var n="_sn_"+e;try{var t=s.getItem(n).split("~");if(2===t.length&&parseInt(t[0])>=Date.now())return t[1];s.removeItem(n)}catch(e){s.removeItem(n)}}},N=function(e,n){return e&&3!==e||3!==n?e||n?e&&1!==e||1!==n?2:1:0:3},q=function(n,t,r,a,o){if(r||Q("setConsentRegion is deprecated and should be only used in debug mode."),F.region===u)if(K[o]){for(var s in v){var c=X[s];c.applies=c.region==o,c.applies?b.currentAPI=s:(c.loaded=!0,c.status=p)}F.region=o,b.applicableSections=[b.currentAPI?v[b.currentAPI].sid:-1],H("Configured consent region "+K[o]),function(){if(F.region!==v.tcfeuv2.z&&R.processListeners(j),F.region!==v.uspv1.z){var n=e[i],t=n.queue;if(t){n.queue=[];for(var r=0;r<t.length;r++){var a=t[r];n(a.command,a.version,a.callback,a.parameter)}}}}()}else $("Incorrect consent region "+o)},T=function(e,n){for(var t in G.eventListeners)"id"!==t&&D(G.eventListeners[t],M(e,t,n))},U=function(e,n,t){var r=JSON.parse(JSON.stringify(b));return D(t,r,!0),r},z=function(e,n,t,a){var o=h(a)&&v[a];if(o){var i=P(o.api);return i.internal?i.api(o.s,u,t):i.api(o.s,o.v,t)}return function(e,n,t){var a=r+"() API call '"+e+"': "+t;return $(a),D(n,{message:a},!1),null}(n,t,"Unknown section '"+a+"'.")},M=function(e,n,t){return{eventName:e,listenerId:Number.parseInt(n),data:t,pingData:U()}},V=L(d);V.utils={},V.constants={},V.constants.pwUserStatusStorageName=g,V.gdpr=L(a);var R=V.gdpr;R.listenerId=1,R.tcfListeners=[],R.addEventListener=function(e,n,t){if(A(Y,e,n)){W("Adding event listener "+R.listenerId,n);var r={id:R.listenerId++,callback:n||function(){}};R.tcfListeners.push(r),t(null,r.id,r.callback)}},R.removeEventListener=function(e,n,t,r,a){if(A(Y,t,r)){W("Removing event listener "+a);for(var o=0;o<R.tcfListeners.length;o++)if(R.tcfListeners[o].id==a)return R.tcfListeners.splice(o,1),void D(r,!0);Q("Couldn't find listener id "+a+"."),D(r,!1)}},R.getTCData=function(e,n,t,r){if(A(Y,t,r))return j(0,0,r)},R.processListeners=function(e){for(var n=R.tcfListeners.slice(),t=0;t<n.length;t++)e(null,n[t].id,n[t].callback)},V.ccpa=L(i),V.gpp=L(r);var G=V.gpp;G.eventListeners={id:0},G.fibonacciEncode=function(e){var n=function e(n,t){if(t=t||[],!n)return t;for(var r=0;n>=m[r];)++r>=m.length&&m.push(m[r-1]+m[r-2]);return t.push(r),e(n-m[r-1],t)}(e),t="";if(n.length){var r,a=0,o=n[0],i=n[a];t="1";for(var s=o;s>0;s--)r="0",s===i&&(r="1",++a<n.length&&(i=n[a])),t=r+t}return t},G.fibonacciDecode=function(e){var n=0;if(e.length>1)for(var t=0;t<e.length-1;t++)t>=m.length&&m.push(m[t-1]+m[t-2]),"1"===e.charAt(t)&&(n+=m[t]);return n},V.version=81,V.cmpId=l,V.cfg=c&&c.adConsentConfigOverrides?c.adConsentConfigOverrides:{apiBaseUrl:"https://cdn.snigelweb.com/adconsent/81",publisherCC:"US",storage:0};var J=V.cfg;V.log={levels:{off:0,error:1,warning:2,info:3,debug:4},level:2,error:function(){I(arguments),_("error",1,arguments,"#ff0000")},warn:function(){_("warn",2,arguments,"#ffe600")},info:function(){_("info",3,arguments,"#3b88a3")},debug:function(){_("debug",4,arguments,"#808080")}};var B=V.log,W=B.debug,H=B.info,Q=B.warn,$=B.error;V.consent=function(){var e={regions:{0:"NONE"},region:u,api:{}};for(var n in v){var t=v[n];e.regions[t.z]=t.n,e.api[n]={region:t.z,loaded:!1,applies:u,version:t.v,status:f}}return e}();var F=V.consent,K=F.regions,X=F.api,Y=X.tcfeuv2,Z=X.uspv1;V.analytics={enabled:!1,callback:u,send:function(e){ee.sendEvent(K[F.region],e,E())},sendEvent:function(n,t,r){H("Sending analytics event action"+(ee.enabled?"":" disabled")+": "+n+", label: "+t+", value: "+r),ee.enabled&&(ee.callback||function(n){e.gtag?gtag("event",n.action,{event_category:n.category,event_label:n.label,event_value:n.value}):e.ga?ga("send",{hitType:"event",eventCategory:n.category,eventAction:n.action,eventLabel:n.label,eventValue:n.value,nonInteraction:n.nonInteraction}):Q("Unable to find Google Analytics module (gtag or ga).")})({category:"AdConsent",action:n,label:t||n,value:r||0,nonInteraction:!0})}};var ee=V.analytics,ne=ee.send;V.event={fired:{},dispatchCustomEvent:function(e,t,r){r&&re[e]||(re[e]=!0,W("Emitting custom event "+e+" with details: ",t),n.dispatchEvent(new CustomEvent(e,t)))},dispatchCustomEventConsent:function(e,n){var t={0:"N/A",1:"NoConsent",2:"PartialConsent",3:"FullConsent"};ne(t[n]),F.region!=v.tcfeuv2.z&&F.region!=v.tcfcav1.z||0==e||ne("Publisher"+t[e]);var r=N(e,n);te.dispatchCustomEvent("cmpConsentAvailable",{detail:{consentSummary:{mapping:{0:"not available",1:"no consent",2:"partial consent",3:"full consent"},publisherConsent:e,vendorsConsent:n,globalConsent:r,gdprApplies:Y.applies,uspApplies:Z.applies,currentAPI:b.currentAPI}}})}};var te=V.event,re=te.fired,ae=(C=e.location.search)?C.replace(/^\?/,"").split("&").reduce((function(e,n){var t=n.split("="),r=t[0],a=t.length>1?t[1]:u;return/\[\]$/.test(r)?(e[r=r.replace("[]","")]=e[r]||[],e[r].push(a)):e[r]=a||"",e}),{}):{},oe=("true"==ae.sn_debug?"debug":null)||("true"==ae.adconsent_debug?"debug":null)||ae.adconsent_log;if(B.level=B.levels[oe]||B.level,e[t])return void $("Stub is tried to load again!");if(e[a]||e[i]||e[r])return void Q("A cmp is already registered in the system. AdConsent is stopping.");e[t]=V,V.utils.getStorageItem=k,V.resolveGlobalConsent=N;var ie=!1;x(a,{ping:function(e,n,t,r){D(r,{gdprApplies:Y.applies,cmpLoaded:Y.loaded,cmpStatus:Y.status,displayStatus:"disabled",apiVersion:"2.0",cmpVersion:81,cmpId:l,gvlVersion:u,tcfPolicyVersion:4},!0)},getTCData:R.getTCData,addEventListener:function(e,n,t,r,a){R.addEventListener(t,r,j)},removeEventListener:R.removeEventListener}),x(i,{getUSPData:function(e,n,t,r,a){if(!1===Z.applies){if(A(Z,t,r)){var o={version:v.uspv1.v,uspString:v.uspv1.v+"---"};return D(r,o,!0),o}}else O(e,n,t,r,a)}}),S=function(t){var r=!0,a=b.cmpStatus;b.cmpStatus=p;var o=b.cmpDisplayStatus,i=t.type;if("cmpGUIShow"===i?(b.cmpDisplayStatus="visible",b.signalStatus="not ready",T("signalStatus","not ready"),r=!1):"cmpGUISubmit"===i&&(b.cmpDisplayStatus="hidden",T("sectionChange",b.currentAPI)),o!==b.cmpDisplayStatus?T("cmpDisplayStatus",b.cmpDisplayStatus):a!==p?T("cmpStatus",p):r=!1,r){var c=function(t){var r={sectionId:3,gppVersion:1,parsedSections:{}},a=function(e,n,t){var r=h(e)?e:Number(e).toString(2);if(n)for(var a=(n-r.length%n)%n,o=0;o<a;o++)t?r+="0":r="0"+r;return r},o={},i=[];for(var c in v){var u=v[c];if(u&&u.c){var l="_sn_"+u.c,d=(s&&s.getItem(l)||"").split("~");if(d&&2===d.length)try{parseInt(d[0])>=(new Date).getTime()?(o[u.sid]=d[1],i.push(u.sid)):s.removeItem(l)}catch(e){}else{var f=("; "+n.cookie).split("; "+u.c+"=");f.length>=2&&(o[u.sid]=f[f.length-1].split(";").shift(),i.push(u.sid))}r.parsedSections[c]=z(0,null,null,c)}}var p="",g="";p+=a(r.sectionId,6),p+=a(r.gppVersion,6),p+=a(i.length,12);var m=0;return r.sectionList=i.sort((function(e,n){return e-n})),r.sectionList.forEach((function(e){p+=a(0,1);var n=e-m;p+=G.fibonacciEncode(n),g+="~"+o[e],m=e})),p=a(p,6,!0),r.gppString=function(n){for(var t=a(n,8,!0),r="",o=0;o<t.length;o+=8)r+=String.fromCharCode(parseInt(t.substr(o,8),2));return e.btoa(r).replace(/\+/g,"-").replace(/\//g,"_").replace(/=/g,"")}(p)+g,r}();b.signalStatus="ready",b.sectionList=c.sectionList,b.gppString=c.gppString,b.parsedSections=c.parsedSections,T("signalStatus","ready")}},n.addEventListener("cmpGUIShow",S),n.addEventListener("cmpGUISubmit",S),n.addEventListener("cmpConsentAvailable",S),x(v.tcfcav1.api,{}),x(v.usnat.api,{}),x(d,{start:function t(r,a,o,i,c){if(F.region!==u){if(!ie)if(ie=!0,0==F.region)te.dispatchCustomEventConsent(3,3);else if(b.currentAPI){var l=n.createElement("script");l.type="text/javascript",l.async=!0,l.charset="utf-8",l.src=V.cfg.apiBaseUrl+"/adconsent"+v[b.currentAPI].f+".js",n.head.appendChild(l)}}else!function(n,t){if((!n||!n.country)&&(n=null,s)){var r=s.getItem("snconsent_geo");if(r){var a=s.getItem("snconsent_geo_exp");if(a)try{parseInt(a)>=(new Date).getTime()&&(n=JSON.parse(e.atob(r)))}catch(e){}}}if(n)t(n);else{var o=new XMLHttpRequest;o.open("GET","https://pro.ip-api.com/json/?fields=24582&key=33arzTfj1gigDqW"),o.timeout=5e3,o.onload=function(){var n=o.responseText.toLowerCase(),r=JSON.parse(n);r={country:r.countrycode,region:r.region},s&&(s.setItem("snconsent_geo",e.btoa(JSON.stringify(r))),s.setItem("snconsent_geo_exp",(new Date).getTime()+36e5)),t(r)},o.onerror=o.ontimeout=function(){t(null)},o.send()}}(c,(function(e){if(e&&(J.country=e.country?e.country.toLowerCase():null,J.region=(e.region||"").toLowerCase()),k(g))q(0,0,1,0,v.tcfeuv2.z);else if("us"===J.country)switch(J.region){case"ca":q(0,0,1,0,v.uspv1.z);break;default:q(0,0,1,0,0)}else-1!=="at be bg hr cy cz dk ee fi fr de gr hu is ie it lv li lt lu mt nl no pl pt ro sk si es se gb ch".indexOf(J.country)?q(0,0,1,0,v.tcfeuv2.z):(J.country||(ne("ErrorGeotargeting"),$("Geotargeting failed")),q(0,0,1,0,0));t()}))},setStorageType:function(e,n,t,r,a){0!==a&&1!==a?D(r,{message:"Invalid storage type: should be 0 (cookie) or 1 (local storage)."},!1):1!==a||s?(J.storage=a,D(r,null,!0)):D(r,{message:"Storage type 'localStorage' was selected, but local storage is not available. Reverting to cookie storage."},!1)},setPublisherCC:function(e,n,t,r,a){h(a)&&2==a.length?(J.publisherCC=a.toUpperCase(),D(r,null,!0)):D(r,{message:"Invalid publisher country code detected. Ignoring call."},!1)},setConsentRegion:q,enableGoogleAnalytics:function(e,n,t,r,a){ee.enabled=a===u||!!a,ee.callback=r},isConsentWallUser:function(e,n,t,r){D(r,{},!0)},isConsentWallEnabled:function(e,n,t,r){D(r,{consentWallEnabled:!1},!0)}})}catch(e){if(I(e),c&&c.passThroughException)throw e;console.error(e)}}(window,document,"adconsent","__gpp","__tcfapi",0,"__uspapi")}]);