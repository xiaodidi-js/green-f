webpackJsonp([8],{123:function(t,e,a){var s,i;a(124),s=a(125),i=a(126),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},124:function(t,e){},125:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:{type:Boolean,default:!1},time:{type:Number,default:2e3},type:{type:String,default:"success"},transition:{type:String,default:"vux-fade"},width:{type:String,default:"7.6em"},text:String},computed:{toastClass:function(){return{weui_toast_forbidden:"warn"===this.type,weui_toast_cancel:"cancel"===this.type,weui_toast_success:"success"===this.type,weui_toast_text:"text"===this.type}}},watch:{show:function(t){var e=this;t&&(clearTimeout(this.timeout),this.timeout=setTimeout(function(){e.show=!1,e.$emit("on-hide")},this.time))}}}},126:function(t,e){t.exports=' <div class=vux-toast> <div class=weui_mask_transparent v-show=show></div> <div class=weui_toast :style="{width: width}" :class=toastClass v-show=show :transition=transition> <i class=weui_icon_toast v-show="type !== \'text\'"></i> <p class=weui_toast_content v-if=text v-html=text></p> <p class=weui_toast_content v-else><slot></slot></p> </div> </div> '},270:function(t,e,a){var s,i;a(271),s=a(272),i=a(273),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},271:function(t,e){},272:function(t,e,a){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var i=a(123),o=s(i),n=a(59),r=s(n),u=a(57);e.default={vuex:{actions:{clearAll:u.clearAll,myActive:u.myActive}},components:{Separator:r.default,Toast:o.default},data:function(){return{toastShow:!1,toastMessage:"",upsta:0,uimg:"",uname:"",uscore:0}},ready:function(){var t=this;this.myActive(1);var e=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");e=JSON.parse(e),this.$http.get(localStorage.apiDomain+"public/index/user/userinfo/uid/"+e.id+"/token/"+e.token).then(function(e){if(1===e.data.status)t.uname=e.data.uname,t.uscore=e.data.score,null!==e.data.shotcut&&(t.uimg=e.data.shotcut);else if(e.data.status===-1){t.toastMessage=e.data.info,t.toastShow=!0;var a=t;setTimeout(function(){a.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),a.$router.go({name:"login"})},800)}else t.toastMessage=e.data.info,t.toastShow=!0},function(e){t.toastMessage="网络开小差了~",t.toastShow=!0})},methods:{addShotcut:function(){return!this.upsta&&void document.getElementById("himg").click()},fileClick:function(t){t.stopPropagation()},getImage:function(){var t=document.getElementById("himg");return"undefined"!=typeof t.files[0]&&(this.upsta=1,this.handleFiles(t.files[0])===!1?(this.upsta=0,t.value="",!1):void 0)},handleFiles:function(t){return this.checkImg(t.type)?void this.getUpInfo(t):(this.toastMessage="上传文件类型不是图片",this.toastShow=!0,!1)},checkImg:function(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";if(""===t||"string"!=typeof t)return!1;var e=["jpg","jpeg","gif","png"],a=t.split("/")[1];return e.indexOf(a)>=0},getUpInfo:function(t){var e=this;if("undefined"==typeof t||null===t)return!1;var a=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");a=JSON.parse(a),this.$http.put(localStorage.apiDomain+"/public/index/user/makeInfoForUpyun",{"allow-file-type":"jpg,jpeg,gif,png","ext-param":"himg,"+a.id+",1",ftype:t.type}).then(function(a){var s=a.data;1===s.status?e.uploadImgToUpyun(s.domain,s.url,t,s.policy,s.signature,s.notify,s.param,s.thumb):(e.toastMessage=s.info,e.toastShow=!0,e.upsta=0)},function(t){e.toastMessage="网络开小差啦~",e.toastShow=!0,e.upsta=0})},uploadImgToUpyun:function(t,e,a,s,i,o,n){var r=this,u=arguments.length>7&&void 0!==arguments[7]?arguments[7]:"",c=new FormData;c.append("file",a),c.append("policy",s),c.append("signature",i),c.append("notify-url",o),c.append("ext-param",n),c.append("x-gmkerl-thumb",u);var l=this;this.$http.post(e,c).then(function(e){var a=t+JSON.parse(e.data).url;l.upsta=0,l.uimg=a},function(t){r.toastMessage="网络开小差啦~",r.toastShow=!0,r.upsta=0})}}}},273:function(t,e,a){t.exports=' <div class=container _v-2399f9fa=""> <div class="top-message white-bg" _v-2399f9fa=""> <div class=shotcut :style="{backgroundImage:\'url(\'+uimg+\')\'}" @click=addShotcut _v-2399f9fa=""> <span v-show=upsta _v-2399f9fa=""></span> <img src='+a(274)+' v-show=upsta _v-2399f9fa=""> </div> <div class=nickname _v-2399f9fa="">{{ uname }}</div> <div class=score v-link="{name:\'integral\'}" _v-2399f9fa=""> <span _v-2399f9fa="">签到积分:</span> <span _v-2399f9fa="">{{ uscore }}</span> </div> <input type=file id=himg @click=fileClick @change=getImage accept=image/jpeg,image/png,image/gif style=display:none _v-2399f9fa=""> </div> <div class="mid-card white-bg" _v-2399f9fa=""> <div class="tap-logo orders" v-link="{name:\'per-orders\'}" _v-2399f9fa=""> <div class=arrow :class="{\'actived\':$route.name === \'per-orders\' || $route.name===\'per-default\'}" _v-2399f9fa=""></div> </div> <div class="tap-logo coupons" v-link="{name:\'per-coupons\'}" _v-2399f9fa=""> <div class=arrow :class="{\'actived\':$route.name === \'per-coupons\'}" _v-2399f9fa=""></div> </div> <div class="tap-logo collections" v-link="{name:\'per-collections\'}" _v-2399f9fa=""> <div class=arrow :class="{\'actived\':$route.name === \'per-collections\'}" _v-2399f9fa=""></div> </div> <div class="tap-logo addresses" v-link="{name:\'per-addresses\'}" _v-2399f9fa=""> <div class=arrow :class="{\'actived\':$route.name === \'per-addresses\'}" _v-2399f9fa=""></div> </div> <div class="tap-logo settings" v-link="{name:\'per-settings\'}" _v-2399f9fa=""> <div class=arrow :class="{\'actived\':$route.name === \'per-settings\'}" _v-2399f9fa=""></div> </div> </div> <separator :set-height=21 _v-2399f9fa=""></separator> <router-view _v-2399f9fa=""></router-view> <toast :show.sync=toastShow type=text _v-2399f9fa="">{{ toastMessage}}</toast> </div> '},274:function(t,e){t.exports="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiIgd2lkdGg9IjMyIiBoZWlnaHQ9IjMyIiBmaWxsPSJ3aGl0ZSI+DQogIDxwYXRoIG9wYWNpdHk9Ii4yNSIgZD0iTTE2IDAgQTE2IDE2IDAgMCAwIDE2IDMyIEExNiAxNiAwIDAgMCAxNiAwIE0xNiA0IEExMiAxMiAwIDAgMSAxNiAyOCBBMTIgMTIgMCAwIDEgMTYgNCIvPg0KICA8cGF0aCBkPSJNMTYgMCBBMTYgMTYgMCAwIDEgMzIgMTYgTDI4IDE2IEExMiAxMiAwIDAgMCAxNiA0eiI+DQogICAgPGFuaW1hdGVUcmFuc2Zvcm0gYXR0cmlidXRlTmFtZT0idHJhbnNmb3JtIiB0eXBlPSJyb3RhdGUiIGZyb209IjAgMTYgMTYiIHRvPSIzNjAgMTYgMTYiIGR1cj0iMC44cyIgcmVwZWF0Q291bnQ9ImluZGVmaW5pdGUiIC8+DQogIDwvcGF0aD4NCjwvc3ZnPg0K"}});