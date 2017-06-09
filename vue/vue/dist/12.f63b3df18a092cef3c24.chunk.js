webpackJsonp([12],{89:function(t,e,s){t.exports={default:s(90),__esModule:!0}},90:function(t,e,s){var a=s(14);t.exports=function(t,e,s){return a.setDesc(t,e,s)}},123:function(t,e,s){var a,i;s(124),a=s(125),i=s(126),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},124:function(t,e){},125:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:{type:Boolean,default:!1},time:{type:Number,default:2e3},type:{type:String,default:"success"},transition:{type:String,default:"vux-fade"},width:{type:String,default:"7.6em"},text:String},computed:{toastClass:function(){return{weui_toast_forbidden:"warn"===this.type,weui_toast_cancel:"cancel"===this.type,weui_toast_success:"success"===this.type,weui_toast_text:"text"===this.type}}},watch:{show:function(t){var e=this;t&&(clearTimeout(this.timeout),this.timeout=setTimeout(function(){e.show=!1,e.$emit("on-hide")},this.time))}}}},126:function(t,e){t.exports=' <div class=vux-toast> <div class=weui_mask_transparent v-show=show></div> <div class=weui_toast :style="{width: width}" :class=toastClass v-show=show :transition=transition> <i class=weui_icon_toast v-show="type !== \'text\'"></i> <p class=weui_toast_content v-if=text v-html=text></p> <p class=weui_toast_content v-else><slot></slot></p> </div> </div> '},145:function(t,e,s){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}e.__esModule=!0;var i=s(89),o=a(i);e.default=function(t,e,s){return e in t?(0,o.default)(t,e,{value:s,enumerable:!0,configurable:!0,writable:!0}):t[e]=s,t}},240:function(t,e,s){var a,i;s(241),a=s(242),i=s(243),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},241:function(t,e){},242:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{type:String},computed:{className:function(){return"weui_icon weui_icon_"+this.type}}}},243:function(t,e){t.exports=" <i class={{className}}></i> "},244:function(t,e,s){var a,i;s(245),a=s(246),i=s(247),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},245:function(t,e){},246:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{type:{default:"default"},disabled:Boolean,mini:Boolean,plain:Boolean,text:String},computed:{classes:function(){return[{weui_btn_disabled:this.disabled,weui_btn_mini:this.mini},"weui_btn_"+this.type,this.plain?"weui_btn_plain_"+this.type:""]}}}},247:function(t,e){t.exports=" <button class=weui_btn :class=classes :disabled=disabled> {{text}}<slot></slot> </button> "},248:function(t,e,s){var a,i;s(249),a=s(250),i=s(255),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},249:function(t,e){},250:function(t,e,s){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var i=s(251),o=a(i);e.default={components:{Dialog:o.default},props:{show:{type:Boolean,default:!1,twoWay:!0},title:{type:String,required:!0},confirmText:{type:String,default:"confirm"},cancelText:{type:String,default:"cancel"},maskTransition:{type:String,default:"vux-fade"},dialogTransition:{type:String,default:"vux-dialog"}},methods:{onConfirm:function(){this.show=!1,this.$emit("on-confirm")},onCancel:function(){this.show=!1,this.$emit("on-cancel")}}}},251:function(t,e,s){var a,i;s(252),a=s(253),i=s(254),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},252:function(t,e){},253:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:{type:Boolean,default:!1},maskTransition:{type:String,default:"vux-fade"},dialogTransition:{type:String,default:"vux-dialog"},hideOnBlur:Boolean,scroll:{type:Boolean,default:!0}},watch:{show:function(t){this.$emit(t?"on-show":"on-hide")}}}},254:function(t,e){t.exports=' <div class=weui_dialog_alert @touchmove="!this.scroll && $event.preventDefault()"> <div class=weui_mask @click="hideOnBlur && (show = false)" v-show=show :transition=maskTransition></div> <div class=weui_dialog v-show=show :transition=dialogTransition> <slot></slot> </div> </div> '},255:function(t,e){t.exports=' <dialog class=weui_dialog_confirm :show=show :mask-transition=maskTransition :dialog-transition=dialogTransition @on-hide="$emit(\'on-hide\')" @on-show="$emit(\'on-show\')"> <div class=weui_dialog_hd><strong class=weui_dialog_title>{{title}}</strong></div> <div class=weui_dialog_bd><slot></slot></div> <div class=weui_dialog_ft> <a href=javascript:; class="weui_btn_dialog default" @click=onCancel>{{cancelText}}</a> <a href=javascript:; class="weui_btn_dialog primary" @click=onConfirm>{{confirmText}}</a> </div> </dialog> '},311:function(t,e,s){var a,i;s(312),a=s(313),i=s(319),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},312:function(t,e){},313:function(t,e,s){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var i=s(123),o=a(i),n=s(314),d=a(n),l=s(57);e.default={vuex:{actions:{clearAll:l.clearAll}},components:{CardAddress:d.default,Toast:o.default},data:function(){return{toastShow:!1,toastMessage:"",data:[]}},route:{},ready:function(){var t=this,e=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");e=JSON.parse(e),this.$http.get(localStorage.apiDomain+"public/index/user/addresslist/uid/"+e.id+"/token/"+e.token).then(function(e){if(1===e.data.status)t.data=e.data.list;else if(e.data.status===-1){t.toastMessage=e.data.info,t.toastShow=!0;var s=t;setTimeout(function(){s.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),s.$router.go({name:"login"})},800)}},function(e){t.toastMessage="网络开小差了~",t.toastShow=!0})},events:{showMes:function(t){"string"==typeof t&&t.length>0&&(this.toastMessage=t,this.toastShow=!0)}}}},314:function(t,e,s){var a,i;s(315),s(316),a=s(317),i=s(318),t.exports=a||{},t.exports.__esModule&&(t.exports=t.exports.default),i&&(("function"==typeof t.exports?t.exports.options:t.exports).template=i)},315:function(t,e){},316:function(t,e){},317:function(t,e,s){"use strict";function a(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var i,o=s(145),n=a(o),d=s(10),l=a(d),r=s(240),c=a(r),u=s(244),f=a(u),p=s(248),v=a(p),h=s(57);e.default=(i={vuex:{actions:{clearAll:h.clearAll}},computed:{},components:{Icon:c.default,XButton:f.default,Confirm:v.default}},(0,n.default)(i,"computed",{}),(0,n.default)(i,"props",{addresses:{type:Array,default:function(){return[]}}}),(0,n.default)(i,"data",function(){return{confirmShow:!1,delItem:0,issel:0,order_list:[],chosens:[],radio:"1",isActive:!1,address:!0}}),(0,n.default)(i,"ready",function(){this.siblingsDom(),this.chosenfun()}),(0,n.default)(i,"methods",{isActiveFun:function(){for(var t=document.getElementById("Ele-chonse"),e=t.children,s=this,a=0;a<e.length;a++)e[a].index=a,e[a].onclick=function(){this.className="isActive",s.siblings(this,function(){this.className="address"})}},chosenfun:function(){var t=this,e=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");e=JSON.parse(e),this.getType=this.$parent.deliverType;var s=this;this.$http.get(localStorage.apiDomain+"public/index/user/addresschosen/uid/"+e.id+"/token/"+e.token+"/type/"+this.getType).then(function(e){if(1===e.data.status){console.log(e.data),t.showStatus=!1,t.showTips="加载中...",t.chosens=e.data.list;for(var a=0;a<t.chosens.length;a++)t.chosens[a].index=a,1==t.chosens[a].is_default&&s.isActiveFun()}else if(e.data.status===-1){t.$parent.toastMessage=e.data.info,t.$parent.toastShow=!0;var i=t;setTimeout(function(){i.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),i.$router.go({name:"login"})},800)}else t.address=[],t.chosen=0,t.showTips="暂无添加地址",t.showStatus=!0},function(e){t.$parent.toastMessage="网络开小差了~",t.$parent.toastShow=!0})},setChosen:function(t){var e=this;if("object"===("undefined"==typeof t?"undefined":(0,l.default)(t))){var s=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");s=JSON.parse(s);var a="";this.$parent.cartIds.length>0&&(a=this.$parent.cartIds.join(","));var i={uid:s.id,token:s.token,type:this.$parent.deliverType,ids:a,area:t.area};this.$http.post(localStorage.apiDomain+"public/index/user/addresschosen",i).then(function(s){if(1===s.data.status)e.chosen=t.id,e.$parent.data.address=t,e.$parent.freight=s.data.freight;else if(s.data.status===-1){e.$parent.toastMessage=s.data.info,e.$parent.toastShow=!0;var a=e;setTimeout(function(){a.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),a.$router.go({name:"login"})},800)}else e.$parent.toastMessage=s.data.info,e.$parent.toastShow=!0},function(t){e.$parent.toastMessage="网络开小差了~",e.$parent.toastShow=!0})}},$id:function(t){return document.getElementById(t)},siblings:function(t,e){var s=t.parentElement,a=[].slice.call(s.children);a.filter(function(s){s!=t&&e.call(s)})},siblingsDom:function(){for(var t=this.$id("card"),e=t.children,s=e.length,a=0;a<s;a++){e[a].index=a;var i=this;e[a].onclick=function(){this.className="active",i.siblings(this,function(){this.className=""});var t=document.getElementById("content").children[this.index];t.style.display="block",i.siblings(t,function(){this.style.display="none"})}}},isDefault:function(t,e){var s=this,a=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");a=JSON.parse(a);var i={uid:a.id,token:a.token,state:0,addressid:e},o=this;this.$http.put(localStorage.apiDomain+"public/index/Usercenter/addressmoren",i).then(function(e){if(1===e.data.status){console.log(e.data);for(var a=0;a<s.chosens.length;a++)a!=t&&0!=s.chosens[a].is_default&&(s.chosens[a].is_default=0);o.isActiveFun(),s.chosens[t].is_default=1}else if(e.data.status===-1){s.$dispatch("showMes",e.data.info);var i=s;setTimeout(function(){i.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),i.$router.go({name:"login"})},800)}else s.$dispatch("showMes",e.data.info)},function(t){s.$dispatch("showMes","网络开小差了~")})},setDefault:function(t,e){var s=this,a=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");a=JSON.parse(a);var i={uid:a.id,token:a.token,aid:e};this.$http.put(localStorage.apiDomain+"public/index/user/addresslist",i).then(function(e){if(1===e.data.status){console.log(e.data);for(var a=0;a<s.addresses.length;a++)a!=t&&0!=s.addresses[a].is_default&&(s.addresses[a].is_default=0);s.addresses[t].is_default=1}else if(e.data.status===-1){s.$dispatch("showMes",e.data.info);var i=s;setTimeout(function(){i.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),i.$router.go({name:"login"})},800)}else s.$dispatch("showMes",e.data.info)},function(t){s.$dispatch("showMes","网络开小差了~")})},changeActive:function(t){t.preventDefault(),t.stopPropagation(),this.$dispatch("setChosen",this.obj)},setDel:function(t){this.delItem=t,this.confirmShow=!0},confirmDel:function(){var t=this;if(!this.delItem)return!1;var e=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");e=JSON.parse(e);var s=localStorage.apiDomain+"public/index/user/addressinfo/uid/"+e.id+"/token/"+e.token+"/aid/"+this.delItem;this.$http.delete(s).then(function(e){if(1===e.data.status){for(var s=0;s<t.addresses.length;s++)if(t.addresses[s].id===t.delItem){t.addresses.splice(s,1);break}}else if(e.data.status===-1){t.$dispatch("showMes",e.data.info);var a=t;setTimeout(function(){a.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),a.$router.go({name:"login"})},800)}else t.$dispatch("showMes",e.data.info),console.log("Yes...");t.delItem=0},function(e){t.delItem=0,t.$dispatch("showMes","网络开小差了~")})},cancelDel:function(){this.delItem=0}}),i)},318:function(t,e){t.exports=' <div class=addresses_table _v-2d476a9a=""> <ul id=card _v-2d476a9a=""> <li class=active _v-2d476a9a=""> <span _v-2d476a9a="">自提点</span> </li> <li _v-2d476a9a=""> <span _v-2d476a9a="">快递地址</span> </li> </ul> </div> <div id=content _v-2d476a9a=""> <div id=ziti _v-2d476a9a=""> <div class=main_ziti id=Ele-chonse _v-2d476a9a=""> <div class=address :class="{\'isActive\':item.is_default === 1}" v-for="item in chosens" _v-2d476a9a=""> <ul class=address_list style="width: 85%" @click=isDefault($index,item.id) _v-2d476a9a=""> <li _v-2d476a9a=""> <span class=left-title _v-2d476a9a="">自提点：</span> <span class=right-title _v-2d476a9a="">{{ item.name }}</span> </li> <li _v-2d476a9a=""> <span class=left-title _v-2d476a9a="">电话:</span> <span class=right-title _v-2d476a9a="">{{ item.tel }}</span> </li> <li _v-2d476a9a=""> <span class=left-title _v-2d476a9a="">收货地址：</span> <span class=right-title _v-2d476a9a="">{{ item.address }}</span> </li> <li _v-2d476a9a=""> <span class=left-title _v-2d476a9a="">服务范围：</span> <span class=right-title _v-2d476a9a="">{{ item.address }}</span> </li> </ul> <div class=yuan _v-2d476a9a=""> <icon type=success v-show="item.is_default === 1" _v-2d476a9a=""></icon> <icon type=circle v-show="item.is_default !== 1" _v-2d476a9a=""></icon> </div> </div> </div> <div class=comfire-chonse _v-2d476a9a=""> <x-button text=确认 _v-2d476a9a=""></x-button> </div> </div> <div id=cardbox style="display:none;position: relative;top: 60px" _v-2d476a9a=""> <div class=card-box v-for="item in addresses" style="background: #f2f2f2;box-shadow: none;border:none" _v-2d476a9a=""> <div class=half-div style="float: left" _v-2d476a9a="">{{ item.name }}</div> <div class="half-div text-right" _v-2d476a9a="">{{ item.tel }}</div> <div class=address style=background:none _v-2d476a9a="">{{ item.address }}</div> <div class=half-div @click=setDefault($index,item.id) style="float: left" _v-2d476a9a=""> <icon type=success class=my-icon-chosen v-show="item.is_default === 1" _v-2d476a9a=""></icon> <icon type=circle class=my-icon v-show="item.is_default !== 1" _v-2d476a9a=""></icon> <i _v-2d476a9a="">默认地址</i> </div> <div class="half-div text-right" _v-2d476a9a=""> <div class="icon img edit" v-link="{name:\'address-edit\',params:{aid:item.id}}" _v-2d476a9a=""></div> <div class="icon separator" _v-2d476a9a=""></div> <div class="icon img del" @click=setDel(item.id) _v-2d476a9a=""></div> </div> </div> <div class=add-address _v-2d476a9a=""> <x-button text=新增地址 class=address-comfirm v-link="{name:\'address-add\'}" _v-2d476a9a=""></x-button> </div> </div> </div> <confirm :show.sync=confirmShow title=删除地址 confirm-text=确定 cancel-text=取消 @on-confirm=confirmDel @on-cancel=cancelDel _v-2d476a9a=""><p style=text-align:center _v-2d476a9a="">确定删除该地址吗？</p></confirm> '},319:function(t,e){t.exports=' <div class=sub-content _v-7867d144=""> <card-address :addresses=data _v-7867d144=""></card-address> </div> <toast type=text :show.sync=toastShow _v-7867d144="">{{ toastMessage }}</toast> '}});