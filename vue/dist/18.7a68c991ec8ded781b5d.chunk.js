webpackJsonp([18,38],{123:function(t,e,s){var i,o;s(124),i=s(125),o=s(126),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},124:function(t,e){},125:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:{type:Boolean,default:!1},time:{type:Number,default:2e3},type:{type:String,default:"success"},transition:{type:String,default:"vux-fade"},width:{type:String,default:"7.6em"},text:String},computed:{toastClass:function(){return{weui_toast_forbidden:"warn"===this.type,weui_toast_cancel:"cancel"===this.type,weui_toast_success:"success"===this.type,weui_toast_text:"text"===this.type}}},watch:{show:function(t){var e=this;t&&(clearTimeout(this.timeout),this.timeout=setTimeout(function(){e.show=!1,e.$emit("on-hide")},this.time))}}}},126:function(t,e){t.exports=' <div class=vux-toast> <div class=weui_mask_transparent v-show=show></div> <div class=weui_toast :style="{width: width}" :class=toastClass v-show=show :transition=transition> <i class=weui_icon_toast v-show="type !== \'text\'"></i> <p class=weui_toast_content v-if=text v-html=text></p> <p class=weui_toast_content v-else><slot></slot></p> </div> </div> '},127:function(t,e,s){var i,o;s(128),i=s(129),o=s(130),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},128:function(t,e){},129:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:Boolean,text:{type:String,default:"Loading"},position:String}}},130:function(t,e){t.exports=' <div class=weui_loading_toast v-show=show> <div class=weui_mask_transparent></div> <div class=weui_toast :style="{position: position}"> <div class=weui_loading> <div class=weui_loading_leaf v-for="i in 12" :class="[\'weui_loading_leaf_\' + i]"></div> </div> <p class=weui_toast_content>{{text}}<slot></slot></p> </div> </div> '},242:function(t,e,s){var i,o;s(243),i=s(244),o=s(245),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},243:function(t,e){},244:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{type:{default:"default"},disabled:Boolean,mini:Boolean,plain:Boolean,text:String},computed:{classes:function(){return[{weui_btn_disabled:this.disabled,weui_btn_mini:this.mini},"weui_btn_"+this.type,this.plain?"weui_btn_plain_"+this.type:""]}}}},245:function(t,e){t.exports=" <button class=weui_btn :class=classes :disabled=disabled> {{text}}<slot></slot> </button> "},390:function(t,e,s){var i,o;s(391),i=s(392),o=s(393),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},391:function(t,e){},392:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={ready:function(){this.updateStyle()},props:{max:{type:Number,default:5},value:{type:Number,default:0},disabled:Boolean,star:{type:String,default:"★"},activeColor:{type:String,default:"#fc6"},margin:{type:Number,default:2},fontSize:{type:Number,default:25}},computed:{sliceValue:function(){var t=this.value.toString().split(".");return 1===t.length?[t[0],0]:t},cutIndex:function(){return 1*this.sliceValue[0]},cutPercent:function(){return 10*this.sliceValue[1]}},methods:{handleClick:function(t,e){this.disabled&&!e||(this.value===t+1?(this.value=t,this.updateStyle()):this.value=t+1)},updateStyle:function(){for(var t=0;t<this.max;t++)t<=this.value-1?this.colors.$set(t,this.activeColor):this.colors.$set(t,"#ccc")}},data:function(){return{colors:[],cutIndex:-1,cutPercent:0}},watch:{value:function(t){this.updateStyle()}}}},393:function(t,e){t.exports=" <div class=vux-rater> <a class=vux-rater-box v-for=\"i in max\" @click=handleClick(i) :class=\"{'is-active':value > i}\" :style=\"{color: colors && colors[i] ? colors[i] : '#ccc',marginRight:margin+'px',fontSize: fontSize + 'px', width: fontSize + 'px', height: fontSize + 'px', lineHeight: fontSize + 'px'}\"> <span class=vux-rater-inner>{{star}}<span class=vux-rater-outer :style=\"{color: activeColor, width: cutPercent + '%'}\" v-if=\"cutPercent > 0 && cutIndex === i\">{{star}}</span></span> </a> </div> "},423:function(t,e,s){var i,o;s(424),s(425),i=s(426),o=s(441),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},424:function(t,e){},425:function(t,e){},426:function(t,e,s){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var o=s(10),a=i(o),n=s(427),r=i(n),u=s(242),c=i(u),l=s(123),d=i(l),p=s(127),f=i(p),m=s(57);e.default={vuex:{actions:{clearAll:m.clearAll}},data:function(){return{loadingShow:!1,loadingMessage:"",toastMessage:"",toastShow:!1,btnDis:!1,data:{createtime:"",list:[]}}},components:{CommentGroup:r.default,XButton:c.default,Toast:d.default,Loading:f.default},route:{data:function(t){"undefined"!=typeof t.to.params.oid&&t.to.params.oid||(t.abort(),t.go({name:"index"}))}},ready:function(){var t=this,e=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");e=JSON.parse(e),this.$http.get(localStorage.apiDomain+"public/index/user/productscommention/uid/"+e.id+"/token/"+e.token+"/oid/"+this.$route.params.oid).then(function(e){if(1===e.data.status)t.data.createtime=e.data.createtime,t.data.uyhost=e.data.uyhost,t.data.list=e.data.list;else if(e.data.status===-1){t.toastMessage=e.data.info,t.toastShow=!0;var s=t;setTimeout(function(){s.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),s.$router.go({name:"login"})},800)}else t.toastMessage=e.data.info,t.toastShow=!0},function(e){t.toastMessage="网络开小差了~",t.toastShow=!0})},methods:{submitComment:function(){var t=this;if(this.data.list.length<=0)return this.toastMessage="提交数据为空",this.toastShow=!0,!1;for(var e=0;e<this.data.list.length;e++){if(this.data.list[e].stars<=0)return this.toastMessage="还有未完成的评分",this.toastShow=!0,!1;if(""==this.data.list[e].content)return this.toastMessage="还有未填写的评论",this.toastShow=!0,!1}this.btnDis=!0,this.loadingMessage="正在提交",this.toastShow=!0;var s=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");s=JSON.parse(s);var i={uid:s.id,token:s.token,oid:this.$route.params.oid,comments:(0,a.default)(this.data.list)};this.$http.post(localStorage.apiDomain+"public/index/user/productscommention",i).then(function(e){if(t.loadingShow=!1,t.toastMessage=e.data.info,t.toastShow=!0,1===e.data.status){var s=t;setTimeout(function(){s.$router.replace({name:"order-detail",params:{oid:s.$route.params.oid}})},800)}else if(e.data.status===-1){var i=t;setTimeout(function(){i.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),i.$router.go({name:"login"})},800)}else t.btnDis=!1},function(e){t.toastMessage="网络开小差了~",t.toastShow=!0,t.btnDis=!1})}}}},427:function(t,e,s){var i,o;s(428),i=s(429),o=s(440),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},428:function(t,e){},429:function(t,e,s){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var o=s(390),a=i(o),n=s(430),r=i(n),u=s(123),c=i(u);e.default={components:{Rater:a.default,PicUploader:r.default,Toast:c.default},props:{products:{type:Array,twoWay:!0,default:function(){return[]}}},data:function(){return{toastMessage:"",toastShow:!1}}}},430:function(t,e,s){var i,o;s(431),i=s(432),o=s(439),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},431:function(t,e){},432:function(t,e,s){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var o=s(433),a=i(o);e.default={props:{pid:{type:[String,Number],default:0},imgs:{type:Array,required:!0,twoWay:!0},toastMessage:{type:String,default:"",twoWay:!0},toastShow:{type:Boolean,default:!1,twoWay:!0},ftype:{type:String,default:"file"}},components:{Spinner:a.default},data:function(){return{}},methods:{addPic:function(t){return 0!==this.imgs[t].state||void document.getElementById("img"+this.pid+t).click()},delPic:function(t){var e=!1,s=window.event;s.stopPropagation(),this.imgs[t].state=0,this.imgs[t].url="",document.getElementById("img"+this.pid+t).value="";for(var i=0;i<this.imgs.length;i++)e===!1&&0===this.imgs[i].state?(e=!0,this.imgs[i].active=1):e===!0&&0===this.imgs[i].state&&(this.imgs[i].active=0)},fileClick:function(t){var e=window.event;e.stopPropagation(),document.getElementById("img"+this.pid+t).value=""},getImage:function(t){var e=document.getElementById("img"+this.pid+t);if(this.imgs[t].state=1,this.handleFiles(e.files[0],t)===!1)return this.imgs[t].state=0,e.value="",!1},handleFiles:function(t,e){return this.checkImg(t.type)?void this.getUpInfo(t,e):(this.toastMessage="上传文件类型不是图片",this.toastShow=!0,!1)},checkImg:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";if(""===t||"string"!=typeof t)return!1;var e=["jpg","jpeg","gif","png"],s=t.split("/")[1];return e.indexOf(s)>=0},getUpInfo:function(t,e){var s=this;if("undefined"==typeof t||null===t)return!1;var i=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");i=JSON.parse(i),this.$http.put(localStorage.apiDomain+"/public/index/user/makeInfoForUpyun",{"allow-file-type":"jpg,jpeg,gif,png","ext-param":this.ftype+","+i.id+",1",ftype:t.type}).then(function(i){var o=i.data;1===o.status?s.uploadImgToUpyun(o.url,t,o.policy,o.signature,e,o.domain,o.notify,o.param,o.thumb):(s.toastMessage=o.info,s.toastShow=!0,s.uploadFailed(e))},function(t){s.toastMessage="网络开小差啦~",s.toastShow=!0,s.uploadFailed(e)})},uploadImgToUpyun:function(t,e,s,i,o,a,n,r){var u=this,c=arguments.length>8&&void 0!==arguments[8]?arguments[8]:"",l=new FormData;l.append("file",e),l.append("policy",s),l.append("signature",i),l.append("notify-url",n),l.append("ext-param",r),l.append("x-gmkerl-thumb",c);var d=this;this.$http.post(t,l).then(function(t){var e=JSON.parse(t.data),s=a+e.url;d.imgs[o].state=2,d.imgs[o].url=s,d.imgs[o].w=e["image-width"],d.imgs[o].h=e["image-height"],o<3&&(d.imgs[o+1].active=1)},function(t){u.toastMessage="网络开小差啦~",u.toastShow=!0,u.uploadFailed(o)})},uploadFailed:function(t){this.imgs[t].state=0,document.getElementById("img"+this.pid+t).value=""}}}},433:function(t,e,s){var i,o;s(434),i=s(435),o=s(438),t.exports=i||{},t.exports.__esModule&&(t.exports=t.exports.default),o&&(("function"==typeof t.exports?t.exports.options:t.exports).template=o)},434:function(t,e){},435:function(t,e,s){"use strict";function i(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var o=s(436),a=i(o),n=["android","ios","ios-small","bubbles","circles","crescent","dots","lines","ripple","spiral"];e.default={ready:function(){(0,a.default)(this.$el,this.type)},props:{type:{type:String,default:"ios"}},computed:{className:function(){for(var t={},e=0;e<n.length;e++)t["vux-spinner-"+n[e]]=this.type===n[e];return t}}}},436:function(t,e,s){"use strict";function i(t,e,s,a){var n,r,u,c=document.createElement(f[t]||t);for(n in e)if("[object Array]"===Object.prototype.toString.call(e[n]))for(r=0;r<e[n].length;r++)if(e[n][r].fn)for(u=0;u<e[n][r].t;u++)i(n,e[n][r].fn(u,a),c,a);else i(n,e[n][r],c,a);else o(c,n,e[n]);s.appendChild(c)}function o(t,e,s){t.setAttribute(f[e]||e,s)}function a(t,e){var s=t.split(";"),i=s.slice(e),o=s.slice(0,s.length-i.length);return s=i.concat(o).reverse(),s.join(";")+";"+s[0]}function n(t,e){return t/=e/2,t<1?.5*t*t*t:(t-=2,.5*(t*t*t+2))}Object.defineProperty(e,"__esModule",{value:!0}),e.default=function(t,e){function s(){g[o]&&(a=g[o](t)())}var o,a;o=e;var n=document.createElement("div");return i("svg",{viewBox:"0 0 64 64",g:[v[o]]},n,o),t.innerHTML=n.innerHTML,s(),t},s(437);var r="translate(32,32)",u="stroke-opacity",c="round",l="indefinite",d="750ms",p="none",f={a:"animate",an:"attributeName",at:"animateTransform",c:"circle",da:"stroke-dasharray",os:"stroke-dashoffset",f:"fill",lc:"stroke-linecap",rc:"repeatCount",sw:"stroke-width",t:"transform",v:"values"},m={v:"0,32,32;360,32,32",an:"transform",type:"rotate",rc:l,dur:d},h={sw:4,lc:c,line:[{fn:function(t,e){return{y1:"ios"===e?17:12,y2:"ios"===e?29:20,t:r+" rotate("+(30*t+(t<6?180:-180))+")",a:[{fn:function(){return{an:u,dur:d,v:a("0;.1;.15;.25;.35;.45;.55;.65;.7;.85;1",t),rc:l}},t:1}]}},t:12}]},v={android:{c:[{sw:6,da:128,os:82,r:26,cx:32,cy:32,f:p}]},ios:h,"ios-small":h,bubbles:{sw:0,c:[{fn:function(t){return{cx:24*Math.cos(2*Math.PI*t/8),cy:24*Math.sin(2*Math.PI*t/8),t:r,a:[{fn:function(){return{an:"r",dur:d,v:a("1;2;3;4;5;6;7;8",t),rc:l}},t:1}]}},t:8}]},circles:{c:[{fn:function(t){return{r:5,cx:24*Math.cos(2*Math.PI*t/8),cy:24*Math.sin(2*Math.PI*t/8),t:r,sw:0,a:[{fn:function(){return{an:"fill-opacity",dur:d,v:a(".3;.3;.3;.4;.7;.85;.9;1",t),rc:l}},t:1}]}},t:8}]},crescent:{c:[{sw:4,da:128,os:82,r:26,cx:32,cy:32,f:p,at:[m]}]},dots:{c:[{fn:function(t){return{cx:16+16*t,cy:32,sw:0,a:[{fn:function(){return{an:"fill-opacity",dur:d,v:a(".5;.6;.8;1;.8;.6;.5",t),rc:l}},t:1},{fn:function(){return{an:"r",dur:d,v:a("4;5;6;5;4;3;3",t),rc:l}},t:1}]}},t:3}]},lines:{sw:7,lc:c,line:[{fn:function(t){return{x1:10+14*t,x2:10+14*t,a:[{fn:function(){return{an:"y1",dur:d,v:a("16;18;28;18;16",t),rc:l}},t:1},{fn:function(){return{an:"y2",dur:d,v:a("48;44;36;46;48",t),rc:l}},t:1},{fn:function(){return{an:u,dur:d,v:a("1;.8;.5;.4;1",t),rc:l}},t:1}]}},t:4}]},ripple:{f:p,"fill-rule":"evenodd",sw:3,circle:[{fn:function(t){return{cx:32,cy:32,a:[{fn:function(){return{an:"r",begin:t*-1+"s",dur:"2s",v:"0;24",keyTimes:"0;1",keySplines:"0.1,0.2,0.3,1",calcMode:"spline",rc:l}},t:1},{fn:function(){return{an:u,begin:t*-1+"s",dur:"2s",v:".2;1;.2;0",rc:l}},t:1}]}},t:2}]},spiral:{defs:[{linearGradient:[{id:"sGD",gradientUnits:"userSpaceOnUse",x1:55,y1:46,x2:2,y2:46,stop:[{offset:.1,class:"stop1"},{offset:1,class:"stop2"}]}]}],g:[{sw:4,lc:c,f:p,path:[{stroke:"url(#sGD)",d:"M4,32 c0,15,12,28,28,28c8,0,16-4,21-9"},{d:"M60,32 C60,16,47.464,4,32,4S4,16,4,32"}],at:[m]}]}},g={android:function(t){function e(){if(!s.stop){var t=n(Date.now()-i,650),l=1,d=0,p=188-58*t,f=182-182*t;a%2&&(l=-1,d=-64,p=128- -58*t,f=182*t);var m=[0,-101,-90,-11,-180,79,-270,-191][a];o(c,"da",Math.max(Math.min(p,188),128)),o(c,"os",Math.max(Math.min(f,182),0)),o(c,"t","scale("+l+",1) translate("+d+",0) rotate("+m+",32,32)"),r+=4.1,r>359&&(r=0),o(u,"t","rotate("+r+",32,32)"),t>=1&&(a++,a>7&&(a=0),i=Date.now()),requestAnimationFrame(e)}}var s=this;this.stop=!1;var i,a=0,r=0,u=t.querySelector("g"),c=t.querySelector("circle");return function(){return i=Date.now(),e(),s}}}},437:function(t,e){"use strict";for(var s=0,i=["webkit","moz"],o=0;o<i.length&&!window.requestAnimationFrame;++o)window.requestAnimationFrame=window[i[o]+"RequestAnimationFrame"],window.cancelAnimationFrame=window[i[o]+"CancelAnimationFrame"]||window[i[o]+"CancelRequestAnimationFrame"];window.requestAnimationFrame||(window.requestAnimationFrame=function(t,e){var i=(new Date).getTime(),o=Math.max(0,16-(i-s)),a=window.setTimeout(function(){t(i+o)},o);return s=i+o,a}),window.cancelAnimationFrame||(window.cancelAnimationFrame=function(t){clearTimeout(t)})},438:function(t,e){t.exports=" <span class=vux-spinner :class=className></span> "},439:function(t,e){t.exports=' <div class=img-area _v-5112bd0a=""> <div class=image @click=addPic($index) :class="{\'unupload\':img.state===0,\'loading\':img.state===1,\'uploaded\':img.state===2,\'active\':img.active===1}" :style="{backgroundImage:img.url.length>0 ? \'url(\'+img.url+\')\' : \'\'}" v-for="img in imgs" _v-5112bd0a=""> <spinner type=bubbles class=white-spinner _v-5112bd0a=""></spinner> <input type=file id="img{{ pid }}{{ $index }}" name=imgs[] @click=fileClick($index) @change=getImage($index) accept=image/jpeg,image/png,image/gif _v-5112bd0a=""> <div class=cross @click=delPic($index) _v-5112bd0a="">×</div> </div> </div> '},440:function(t,e){t.exports=' <div class=com-wrapper _v-385905d7=""> <div class=card-box v-for="item in products" style="width:96%;padding:0px;box-shadow: none" _v-385905d7=""> <div class=pro-mes _v-385905d7=""> <div class=shotcut v-lazy:background-image=item.shotcut _v-385905d7=""></div> <div class=words _v-385905d7=""> <div class=name _v-385905d7="">{{ item.name }}</div> <div class=format _v-385905d7="">{{ item.fname }}</div> </div> </div> <div class=pro-mes _v-385905d7=""> <rater :value.sync=item.stars :margin=20 active-color=#F9AD0C :font-size=30 style=width:100%;text-align:center _v-385905d7=""></rater> <textarea class=com-text placeholder=请写下你对宝贝的感受 v-model=item.content _v-385905d7=""></textarea> <pic-uploader :imgs.sync=item.imgs :toast-message.sync=toastMessage :toast-show.sync=toastShow :pid=$index ftype=comimg _v-385905d7=""></pic-uploader> </div> </div> </div> <toast :show.sync=toastShow type=text _v-385905d7="">{{ toastMessage }}</toast> '},441:function(t,e){t.exports=' <div class="htimer nowrap" _v-fdc971c4="">成交时间:{{ data.createtime }}</div> <comment-group :products.sync=data.list _v-fdc971c4=""></comment-group> <x-button text=发表评价 :disabled=btnDis class=fixbtn @click=submitComment style=z-index:100 _v-fdc971c4=""></x-button> <toast :show.sync=toastShow type=text _v-fdc971c4="">{{ toastMessage }}</toast> <loading :show=loadingShow :text=loadingMessage _v-fdc971c4=""></loading> '}});