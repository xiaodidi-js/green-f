webpackJsonp([21],{123:function(t,e,i){var a,s;i(124),a=i(125),s=i(126),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),s&&(("function"==typeof t.exports?t.exports.options:t.exports).template=s)},124:function(t,e){},125:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:{type:Boolean,default:!1},time:{type:Number,default:2e3},type:{type:String,default:"success"},transition:{type:String,default:"vux-fade"},width:{type:String,default:"7.6em"},text:String},computed:{toastClass:function(){return{weui_toast_forbidden:"warn"===this.type,weui_toast_cancel:"cancel"===this.type,weui_toast_success:"success"===this.type,weui_toast_text:"text"===this.type}}},watch:{show:function(t){var e=this;t&&(clearTimeout(this.timeout),this.timeout=setTimeout(function(){e.show=!1,e.$emit("on-hide")},this.time))}}}},126:function(t,e){t.exports=' <div class=vux-toast> <div class=weui_mask_transparent v-show=show></div> <div class=weui_toast :style="{width: width}" :class=toastClass v-show=show :transition=transition> <i class=weui_icon_toast v-show="type !== \'text\'"></i> <p class=weui_toast_content v-if=text v-html=text></p> <p class=weui_toast_content v-else><slot></slot></p> </div> </div> '},127:function(t,e,i){var a,s;i(128),a=i(129),s=i(130),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),s&&(("function"==typeof t.exports?t.exports.options:t.exports).template=s)},128:function(t,e){},129:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:Boolean,text:{type:String,default:"Loading"},position:String}}},130:function(t,e){t.exports=' <div class=weui_loading_toast v-show=show> <div class=weui_mask_transparent></div> <div class=weui_toast :style="{position: position}"> <div class=weui_loading> <div class=weui_loading_leaf v-for="i in 12" :class="[\'weui_loading_leaf_\' + i]"></div> </div> <p class=weui_toast_content>{{text}}<slot></slot></p> </div> </div> '},243:function(t,e,i){var a,s;i(244),a=i(245),s=i(246),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),s&&(("function"==typeof t.exports?t.exports.options:t.exports).template=s)},244:function(t,e){},245:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{type:{default:"default"},disabled:Boolean,mini:Boolean,plain:Boolean,text:String},computed:{classes:function(){return[{weui_btn_disabled:this.disabled,weui_btn_mini:this.mini},"weui_btn_"+this.type,this.plain?"weui_btn_plain_"+this.type:""]}}}},246:function(t,e){t.exports=" <button class=weui_btn :class=classes :disabled=disabled> {{text}}<slot></slot> </button> "},431:function(t,e,i){var a,s;i(432),a=i(433),s=i(440),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),s&&(("function"==typeof t.exports?t.exports.options:t.exports).template=s)},432:function(t,e){},433:function(t,e,i){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var s=i(434),n=a(s);e.default={props:{pid:{type:[String,Number],default:0},imgs:{type:Array,required:!0,twoWay:!0},toastMessage:{type:String,default:"",twoWay:!0},toastShow:{type:Boolean,default:!1,twoWay:!0},ftype:{type:String,default:"file"}},components:{Spinner:n.default},data:function(){return{}},methods:{addPic:function(t){return 0!==this.imgs[t].state||void document.getElementById("img"+this.pid+t).click()},delPic:function(t){var e=!1,i=window.event;i.stopPropagation(),this.imgs[t].state=0,this.imgs[t].url="",document.getElementById("img"+this.pid+t).value="";for(var a=0;a<this.imgs.length;a++)e===!1&&0===this.imgs[a].state?(e=!0,this.imgs[a].active=1):e===!0&&0===this.imgs[a].state&&(this.imgs[a].active=0)},fileClick:function(t){var e=window.event;e.stopPropagation(),document.getElementById("img"+this.pid+t).value=""},getImage:function(t){var e=document.getElementById("img"+this.pid+t);if(this.imgs[t].state=1,this.handleFiles(e.files[0],t)===!1)return this.imgs[t].state=0,e.value="",!1},handleFiles:function(t,e){return this.checkImg(t.type)?void this.getUpInfo(t,e):(this.toastMessage="上传文件类型不是图片",this.toastShow=!0,!1)},checkImg:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";if(""===t||"string"!=typeof t)return!1;var e=["jpg","jpeg","gif","png"],i=t.split("/")[1];return e.indexOf(i)>=0},getUpInfo:function(t,e){var i=this;if("undefined"==typeof t||null===t)return!1;var a=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");a=JSON.parse(a),this.$http.put(localStorage.apiDomain+"/public/index/user/makeInfoForUpyun",{"allow-file-type":"jpg,jpeg,gif,png","ext-param":this.ftype+","+a.id+",1",ftype:t.type}).then(function(a){var s=a.data;1===s.status?i.uploadImgToUpyun(s.url,t,s.policy,s.signature,e,s.domain,s.notify,s.param,s.thumb):(i.toastMessage=s.info,i.toastShow=!0,i.uploadFailed(e))},function(t){i.toastMessage="网络开小差啦~",i.toastShow=!0,i.uploadFailed(e)})},uploadImgToUpyun:function(t,e,i,a,s,n,o,r){var u=this,c=arguments.length>8&&void 0!==arguments[8]?arguments[8]:"",l=new FormData;l.append("file",e),l.append("policy",i),l.append("signature",a),l.append("notify-url",o),l.append("ext-param",r),l.append("x-gmkerl-thumb",c);var d=this;this.$http.post(t,l).then(function(t){console.log(t.data);var e=t.data,i=n+e.url;d.imgs[s].state=2,d.imgs[s].url=i,d.imgs[s].w=e["image-width"],d.imgs[s].h=e["image-height"],s<3&&(d.imgs[s+1].active=1)},function(t){u.toastMessage="网络开小差啦~",u.toastShow=!0,u.uploadFailed(s)})},uploadFailed:function(t){this.imgs[t].state=0,document.getElementById("img"+this.pid+t).value=""}}}},434:function(t,e,i){var a,s;i(435),a=i(436),s=i(439),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),s&&(("function"==typeof t.exports?t.exports.options:t.exports).template=s)},435:function(t,e){},436:function(t,e,i){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var s=i(437),n=a(s),o=["android","ios","ios-small","bubbles","circles","crescent","dots","lines","ripple","spiral"];e.default={ready:function(){(0,n.default)(this.$el,this.type)},props:{type:{type:String,default:"ios"}},computed:{className:function(){for(var t={},e=0;e<o.length;e++)t["vux-spinner-"+o[e]]=this.type===o[e];return t}}}},437:function(t,e,i){"use strict";function a(t,e,i,n){var o,r,u,c=document.createElement(f[t]||t);for(o in e)if("[object Array]"===Object.prototype.toString.call(e[o]))for(r=0;r<e[o].length;r++)if(e[o][r].fn)for(u=0;u<e[o][r].t;u++)a(o,e[o][r].fn(u,n),c,n);else a(o,e[o][r],c,n);else s(c,o,e[o]);i.appendChild(c)}function s(t,e,i){t.setAttribute(f[e]||e,i)}function n(t,e){var i=t.split(";"),a=i.slice(e),s=i.slice(0,i.length-a.length);return i=a.concat(s).reverse(),i.join(";")+";"+i[0]}function o(t,e){return t/=e/2,t<1?.5*t*t*t:(t-=2,.5*(t*t*t+2))}Object.defineProperty(e,"__esModule",{value:!0}),e.default=function(t,e){function i(){h[s]&&(n=h[s](t)())}var s,n;s=e;var o=document.createElement("div");return a("svg",{viewBox:"0 0 64 64",g:[v[s]]},o,s),t.innerHTML=o.innerHTML,i(),t},i(438);var r="translate(32,32)",u="stroke-opacity",c="round",l="indefinite",d="750ms",p="none",f={a:"animate",an:"attributeName",at:"animateTransform",c:"circle",da:"stroke-dasharray",os:"stroke-dashoffset",f:"fill",lc:"stroke-linecap",rc:"repeatCount",sw:"stroke-width",t:"transform",v:"values"},m={v:"0,32,32;360,32,32",an:"transform",type:"rotate",rc:l,dur:d},g={sw:4,lc:c,line:[{fn:function(t,e){return{y1:"ios"===e?17:12,y2:"ios"===e?29:20,t:r+" rotate("+(30*t+(t<6?180:-180))+")",a:[{fn:function(){return{an:u,dur:d,v:n("0;.1;.15;.25;.35;.45;.55;.65;.7;.85;1",t),rc:l}},t:1}]}},t:12}]},v={android:{c:[{sw:6,da:128,os:82,r:26,cx:32,cy:32,f:p}]},ios:g,"ios-small":g,bubbles:{sw:0,c:[{fn:function(t){return{cx:24*Math.cos(2*Math.PI*t/8),cy:24*Math.sin(2*Math.PI*t/8),t:r,a:[{fn:function(){return{an:"r",dur:d,v:n("1;2;3;4;5;6;7;8",t),rc:l}},t:1}]}},t:8}]},circles:{c:[{fn:function(t){return{r:5,cx:24*Math.cos(2*Math.PI*t/8),cy:24*Math.sin(2*Math.PI*t/8),t:r,sw:0,a:[{fn:function(){return{an:"fill-opacity",dur:d,v:n(".3;.3;.3;.4;.7;.85;.9;1",t),rc:l}},t:1}]}},t:8}]},crescent:{c:[{sw:4,da:128,os:82,r:26,cx:32,cy:32,f:p,at:[m]}]},dots:{c:[{fn:function(t){return{cx:16+16*t,cy:32,sw:0,a:[{fn:function(){return{an:"fill-opacity",dur:d,v:n(".5;.6;.8;1;.8;.6;.5",t),rc:l}},t:1},{fn:function(){return{an:"r",dur:d,v:n("4;5;6;5;4;3;3",t),rc:l}},t:1}]}},t:3}]},lines:{sw:7,lc:c,line:[{fn:function(t){return{x1:10+14*t,x2:10+14*t,a:[{fn:function(){return{an:"y1",dur:d,v:n("16;18;28;18;16",t),rc:l}},t:1},{fn:function(){return{an:"y2",dur:d,v:n("48;44;36;46;48",t),rc:l}},t:1},{fn:function(){return{an:u,dur:d,v:n("1;.8;.5;.4;1",t),rc:l}},t:1}]}},t:4}]},ripple:{f:p,"fill-rule":"evenodd",sw:3,circle:[{fn:function(t){return{cx:32,cy:32,a:[{fn:function(){return{an:"r",begin:t*-1+"s",dur:"2s",v:"0;24",keyTimes:"0;1",keySplines:"0.1,0.2,0.3,1",calcMode:"spline",rc:l}},t:1},{fn:function(){return{an:u,begin:t*-1+"s",dur:"2s",v:".2;1;.2;0",rc:l}},t:1}]}},t:2}]},spiral:{defs:[{linearGradient:[{id:"sGD",gradientUnits:"userSpaceOnUse",x1:55,y1:46,x2:2,y2:46,stop:[{offset:.1,class:"stop1"},{offset:1,class:"stop2"}]}]}],g:[{sw:4,lc:c,f:p,path:[{stroke:"url(#sGD)",d:"M4,32 c0,15,12,28,28,28c8,0,16-4,21-9"},{d:"M60,32 C60,16,47.464,4,32,4S4,16,4,32"}],at:[m]}]}},h={android:function(t){function e(){if(!i.stop){var t=o(Date.now()-a,650),l=1,d=0,p=188-58*t,f=182-182*t;n%2&&(l=-1,d=-64,p=128- -58*t,f=182*t);var m=[0,-101,-90,-11,-180,79,-270,-191][n];s(c,"da",Math.max(Math.min(p,188),128)),s(c,"os",Math.max(Math.min(f,182),0)),s(c,"t","scale("+l+",1) translate("+d+",0) rotate("+m+",32,32)"),r+=4.1,r>359&&(r=0),s(u,"t","rotate("+r+",32,32)"),t>=1&&(n++,n>7&&(n=0),a=Date.now()),requestAnimationFrame(e)}}var i=this;this.stop=!1;var a,n=0,r=0,u=t.querySelector("g"),c=t.querySelector("circle");return function(){return a=Date.now(),e(),i}}}},438:function(t,e){"use strict";for(var i=0,a=["webkit","moz"],s=0;s<a.length&&!window.requestAnimationFrame;++s)window.requestAnimationFrame=window[a[s]+"RequestAnimationFrame"],window.cancelAnimationFrame=window[a[s]+"CancelAnimationFrame"]||window[a[s]+"CancelRequestAnimationFrame"];window.requestAnimationFrame||(window.requestAnimationFrame=function(t,e){var a=(new Date).getTime(),s=Math.max(0,16-(a-i)),n=window.setTimeout(function(){t(a+s)},s);return i=a+s,n}),window.cancelAnimationFrame||(window.cancelAnimationFrame=function(t){clearTimeout(t)})},439:function(t,e){t.exports=" <span class=vux-spinner :class=className></span> "},440:function(t,e){t.exports=' <div class=img-area _v-6447cecd=""> <div class=image @click=addPic($index) :class="{\'unupload\':img.state===0,\'loading\':img.state===1,\'uploaded\':img.state===2,\'active\':img.active===1}" :style="{backgroundImage:img.url.length>0 ? \'url(\'+img.url+\')\' : \'\'}" v-for="img in imgs" _v-6447cecd=""> <spinner type=bubbles class=white-spinner _v-6447cecd=""></spinner> <input type=file id="img{{ pid }}{{ $index }}" name=imgs[] @click=fileClick($index) @change=getImage($index) accept=image/jpeg,image/png,image/gif _v-6447cecd=""> <div class=cross @click=delPic($index) _v-6447cecd="">×</div> </div> </div> '},456:function(t,e,i){var a,s;i(457),i(458),a=i(459),s=i(460),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),s&&(("function"==typeof t.exports?t.exports.options:t.exports).template=s)},457:function(t,e){},458:function(t,e){},459:function(t,e,i){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var s=i(10),n=a(s),o=i(243),r=a(o),u=i(123),c=a(u),l=i(431),d=a(l),p=i(127),f=a(p),m=i(57);e.default={vuex:{actions:{clearAll:m.clearAll}},data:function(){return{loadingShow:!1,loadingMessage:"",toastMessage:"",toastShow:!1,btnDis:!1,data:{createtime:"",shotcut:"",name:"",price:"",imgs:[{url:"",state:0,active:1},{url:"",state:0,active:0},{url:"",state:0,active:0},{url:"",state:0,active:0}],content:"",count:0}}},components:{XButton:r.default,Toast:c.default,PicUploader:d.default,Loading:f.default},route:{},ready:function(){var t=this,e=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");e=JSON.parse(e),this.$http.get(localStorage.apiDomain+"public/index/user/afterservice/uid/"+e.id+"/token/"+e.token+"/oid/"+this.$route.params.oid).then(function(e){if(1===e.data.status)t.data.createtime=e.data.createtime,t.data.shotcut=e.data.shotcut,t.data.name=e.data.name,t.data.price=e.data.price,t.data.count=e.data.count;else if(e.data.status===-1){t.toastMessage=e.data.info,t.toastShow=!0;var i=t;setTimeout(function(){i.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),i.$router.go({name:"login"})},800)}else t.toastMessage=e.data.info,t.toastShow=!0},function(e){t.toastMessage="网络开小差了~",t.toastShow=!0})},methods:{submit:function(){var t=this,e=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");e=JSON.parse(e);var i={uid:e.id,token:e.token,oid:this.$route.params.oid,content:this.data.content,imgs:(0,n.default)(this.data.imgs)};this.btnDis=!0,this.loadingMessage="正在提交",this.loadingShow=!0,this.$http.post(localStorage.apiDomain+"public/index/user/afterservice",i).then(function(e){if(t.loadingShow=!1,t.btnDis=!1,t.toastMessage=e.data.info,t.toastShow=!0,1===e.data.status){var i=t;setTimeout(function(){i.$router.replace({name:"service",params:{oid:i.$route.params.oid}})},800)}else if(e.data.status===-1){var a=t;setTimeout(function(){a.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),a.$router.go({name:"login"})},800)}},function(e){t.loadingShow=!1,t.btnDis=!1,t.toastMessage="网络开小差了~",t.toastShow=!0})}}}},460:function(t,e){t.exports=' <div class=com-wrapper style="margin-top: 46px" _v-3856245e=""> <div class="htimer nowrap" _v-3856245e="">成交时间:{{ data.createtime }}</div> <div class=card-box _v-3856245e=""> <div class=pro-mes _v-3856245e=""> <div class=shotcut :style="{backgroundImage:\'url(\'+data.shotcut+\')\'}" _v-3856245e=""></div> <div class=words _v-3856245e=""> <div class=name _v-3856245e="">{{ data.name }}<label v-if="data.count>1" _v-3856245e="">等多件商品</label></div> <div class=money _v-3856245e=""> <label class=unit _v-3856245e="">¥</label> {{ data.price }} </div> </div> </div> <div class=pro-mes _v-3856245e=""> <textarea class=com-text placeholder=请输入申请售后的原因 v-model=data.content _v-3856245e=""></textarea> <pic-uploader :imgs.sync=data.imgs :toast-show.sync=toastShow :toast-message.sync=toastMessage _v-3856245e=""></pic-uploader> </div> </div> </div> <x-button text=提交申请 :disabled=btnDis style=position:fixed;bottom:0;left:0;border-radius:0;margin:0 @click=submit _v-3856245e=""></x-button> <toast :show.sync=toastShow type=text _v-3856245e="">{{ toastMessage }}</toast> <loading :show=loadingShow :text=loadingMessage _v-3856245e=""></loading> '}});