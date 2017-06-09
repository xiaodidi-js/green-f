webpackJsonp([9],{123:function(t,e,i){var s,a;i(124),s=i(125),a=i(126),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),a&&(("function"==typeof t.exports?t.exports.options:t.exports).template=a)},124:function(t,e){},125:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:{type:Boolean,default:!1},time:{type:Number,default:2e3},type:{type:String,default:"success"},transition:{type:String,default:"vux-fade"},width:{type:String,default:"7.6em"},text:String},computed:{toastClass:function(){return{weui_toast_forbidden:"warn"===this.type,weui_toast_cancel:"cancel"===this.type,weui_toast_success:"success"===this.type,weui_toast_text:"text"===this.type}}},watch:{show:function(t){var e=this;t&&(clearTimeout(this.timeout),this.timeout=setTimeout(function(){e.show=!1,e.$emit("on-hide")},this.time))}}}},126:function(t,e){t.exports=' <div class=vux-toast> <div class=weui_mask_transparent v-show=show></div> <div class=weui_toast :style="{width: width}" :class=toastClass v-show=show :transition=transition> <i class=weui_icon_toast v-show="type !== \'text\'"></i> <p class=weui_toast_content v-if=text v-html=text></p> <p class=weui_toast_content v-else><slot></slot></p> </div> </div> '},127:function(t,e,i){var s,a;i(128),s=i(129),a=i(130),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),a&&(("function"==typeof t.exports?t.exports.options:t.exports).template=a)},128:function(t,e){},129:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:Boolean,text:{type:String,default:"Loading"},position:String}}},130:function(t,e){t.exports=' <div class=weui_loading_toast v-show=show> <div class=weui_mask_transparent></div> <div class=weui_toast :style="{position: position}"> <div class=weui_loading> <div class=weui_loading_leaf v-for="i in 12" :class="[\'weui_loading_leaf_\' + i]"></div> </div> <p class=weui_toast_content>{{text}}<slot></slot></p> </div> </div> '},248:function(t,e,i){var s,a;i(249),s=i(250),a=i(255),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),a&&(("function"==typeof t.exports?t.exports.options:t.exports).template=a)},249:function(t,e){},250:function(t,e,i){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(251),o=s(a);e.default={components:{Dialog:o.default},props:{show:{type:Boolean,default:!1,twoWay:!0},title:{type:String,required:!0},confirmText:{type:String,default:"confirm"},cancelText:{type:String,default:"cancel"},maskTransition:{type:String,default:"vux-fade"},dialogTransition:{type:String,default:"vux-dialog"}},methods:{onConfirm:function(){this.show=!1,this.$emit("on-confirm")},onCancel:function(){this.show=!1,this.$emit("on-cancel")}}}},251:function(t,e,i){var s,a;i(252),s=i(253),a=i(254),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),a&&(("function"==typeof t.exports?t.exports.options:t.exports).template=a)},252:function(t,e){},253:function(t,e){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default={props:{show:{type:Boolean,default:!1},maskTransition:{type:String,default:"vux-fade"},dialogTransition:{type:String,default:"vux-dialog"},hideOnBlur:Boolean,scroll:{type:Boolean,default:!0}},watch:{show:function(t){this.$emit(t?"on-show":"on-hide")}}}},254:function(t,e){t.exports=' <div class=weui_dialog_alert @touchmove="!this.scroll && $event.preventDefault()"> <div class=weui_mask @click="hideOnBlur && (show = false)" v-show=show :transition=maskTransition></div> <div class=weui_dialog v-show=show :transition=dialogTransition> <slot></slot> </div> </div> '},255:function(t,e){t.exports=' <dialog class=weui_dialog_confirm :show=show :mask-transition=maskTransition :dialog-transition=dialogTransition @on-hide="$emit(\'on-hide\')" @on-show="$emit(\'on-show\')"> <div class=weui_dialog_hd><strong class=weui_dialog_title>{{title}}</strong></div> <div class=weui_dialog_bd><slot></slot></div> <div class=weui_dialog_ft> <a href=javascript:; class="weui_btn_dialog default" @click=onCancel>{{cancelText}}</a> <a href=javascript:; class="weui_btn_dialog primary" @click=onConfirm>{{confirmText}}</a> </div> </dialog> '},260:function(t,e){t.exports="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABsAAAAyCAYAAACtd6CrAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMDY3IDc5LjE1Nzc0NywgMjAxNS8wMy8zMC0yMzo0MDo0MiAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTUgKFdpbmRvd3MpIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkFBREJBNjQ4OEFBRDExRTZBNDI5QThGRURDNzE1QkQxIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkFBREJBNjQ5OEFBRDExRTZBNDI5QThGRURDNzE1QkQxIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QUFEQkE2NDY4QUFEMTFFNkE0MjlBOEZFREM3MTVCRDEiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QUFEQkE2NDc4QUFEMTFFNkE0MjlBOEZFREM3MTVCRDEiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4SRpbUAAACjElEQVR42ryYz0tUURTH3xsrQoQIkhaWm1zmNrf+QCEaXaiLKHQXg7OP0X9AJ/8AZWgjohExiaiEaFkUCrUpqKWu1FVtapHgr+l75AxcTufpzHvnzoPDgXce73O/551z3703CPgqFAqTsHzg8UoxiCBPYTmfwBS/POfcI+C4L2W3lftjAI76gA3DXiixCWtgyN+sDm4W9khTmclk8mYwBl6CW4D1Ks9lAZw2qUa68LJjuEHYsvLcFAYzYqbMUXgFruhDYajdZOAqrEOESrAhAOcTpdG98LJDuDTsvTK4WQzmsZkyR2E93Iqi8JRaplqF4UUPMJAU3hOhE1g/gEuJ0ihS+heuB/ZFhKg3ixhMn5kyR+E1uDVF4RG1TCUKw2pyzsBPsFYRooK6D+BGojSKlP6G64L9ECFqlRUMptNMmaOwEY5U3BWhA2qZKIVh3NmAgVuwFhGiguoE8HOiNIqU/uT+2xEhapU1DKbNTJmj8BbcB9gdEfpDLeMqTAxzgFvKX58Kqh3Ab4nSKFK6R98Jti9C1CrrGEyrmTJHYQuntEmEftFgUpYwKNyGe6KEbsBepjwoe66ESNnDsFYphOrvVtXYzNXYpJQ/VeNXk2rkst+IAPWUQYmrsZqGTjo33oTbVEA0GXcDtGkyN/Ik/DYClNZAsZTF/b3E+VNfh/uogGhp8ACgdZM/NS8JViNAgxeBKlZmsdipdN3YAPdOAdFCdQCgRZN1Iy9QlyJAw9WAzlVmvfQ+bxdzFe6NAgp4FzNnsovh7dKrCFA2Lug/ZT43gnJPfRnutfc9NZ8WzESAxixAZ8pqdSxRVlYTUBm2q9zPW4PcEx73sOwZQObnVrK/vJ83hqVSKajV9U+AAQBF7AnC/7/QtQAAAABJRU5ErkJggg=="},276:function(t,e,i){var s,a;i(277),s=i(278),a=i(283),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),a&&(("function"==typeof t.exports?t.exports.options:t.exports).template=a)},277:function(t,e){},278:function(t,e,i){(function(t){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(279),o=s(a),n=i(59),d=s(n),l=i(123),c=s(l),r=i(53),u=s(r),v=i(57);e.default={vuex:{actions:{clearAll:v.clearAll}},components:{CardOrders:o.default,Separator:d.default,Toast:c.default,Badge:u.default},data:function(){return{dtype:-1,willShow:!0,toastShow:!1,toastMessage:"",count:{unpay:0,unsend:0,unreceive:0,uncomment:0,service:0},data:[],qqservice:null,showpro:!1}},route:{},ready:function(){this.getData(1),this.kefu(),5==this.$store.state.dtype?(this.getData(this.$store.state.dtype),t("#cardOrder").css("display","none")):(t("#cardOrder").css("display","block"),this.getData(1))},methods:{visiblepro:function(){this.showpro=!0},clearpro:function(){this.showpro=!1},kefu:function(){var t=this;this.$http.get(localStorage.apiDomain+"public/index/Usercenter/onlie").then(function(e){t.qqservice=e.data.list,console.log(t.qqservice)})},$id:function(t){return document.getElementById(t)},getData:function(e){var i=this;if(5===e?(this.$id("customer").style.display="block",t("#cardOrder").css("display","none")):(this.$id("customer").style.display="none",t("#cardOrder").css("display","block")),this.dtype==e&&this.data)return!0;this.dtype=e;var s=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");s=JSON.parse(s),this.$http.get(localStorage.apiDomain+"public/index/user/orderselection/uid/"+s.id+"/token/"+s.token+"/type/"+e).then(function(t){if(1===t.data.status)document.body.scrollTop=0,i.count=t.data.count,i.data=t.data.list,console.log(i.data);else if(t.data.status===-1){i.toastMessage=t.data.info,i.toastShow=!0;var e=i;setTimeout(function(){e.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),e.$router.go({name:"login"})},800)}else i.toastMessage=t.data.info,i.toastShow=!0},function(t){i.toastMessage="网络开小差了~",i.toastShow=!0})}}}}).call(e,i(2))},279:function(t,e,i){var s,a;i(280),s=i(281),a=i(282),t.exports=s||{},t.exports.__esModule&&(t.exports=t.exports.default),a&&(("function"==typeof t.exports?t.exports.options:t.exports).template=a)},280:function(t,e){},281:function(t,e,i){(function(t){"use strict";function s(t){return t&&t.__esModule?t:{default:t}}Object.defineProperty(e,"__esModule",{value:!0});var a=i(127),o=s(a),n=i(123),d=s(n),l=i(248),c=s(l),r=i(57);e.default={vuex:{actions:{setCartAgain:r.setCartAgain,clearAll:r.clearAll}},components:{Loading:o.default,Toast:d.default,Confirm:c.default},props:{disabled:{type:Boolean,default:!1},orders:{type:Array,default:function(){return[]}}},data:function(){return{loadingShow:!1,loadingMessage:"",confirmShow:!1,confirmTitle:"",confirmText:"",data:{order:{}}}},ready:function(){},methods:{myConfirmClcik:function(e){var i=this,s=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");switch(s=JSON.parse(s),console.log(1),this.clickType){case 1:({uid:s.id,token:s.token,oid:e});this.$http.delete(localStorage.apiDomain+"public/index/user/getsubmitorder/uid/"+s.id+"/token/"+s.token+"/oid/"+e).then(function(e){if(1===e.data.status)console.log(e.data+"1"),i.data.order.statext="用户取消",i.data.order.status=-1,i.btnStatus=!1,t("#cancel-btn").css("display","none"),t("#detail-btn").css("display","none");else if(e.data.status===-1){i.btnStatus=!1,i.toastMessage=e.data.info,i.toastShow=!0;var s=i;setTimeout(function(){s.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),s.$router.go({name:"login"})},800)}else i.btnStatus=!1,i.toastMessage=e.data.info,i.toastShow=!0},function(t){i.toastMessage="网络开小差了~",i.toastShow=!0})}},buyAgain:function(t){var e=this;this.btnStatus=!0,this.loadingMessage="请稍候...",this.loadingShow=!0;var i=sessionStorage.getItem("userInfo")||localStorage.getItem("userInfo");i=JSON.parse(i),this.$http.get(localStorage.apiDomain+"public/index/user/orderoperation/uid/"+i.id+"/token/"+i.token+"/oid/"+t).then(function(t){if(e.loadingShow=!1,e.btnStatus=!1,1===t.data.status)e.setCartAgain(t.data.list),e.$router.go({name:"cart"});else if(t.data.status===-1){e.toastMessage=t.data.info,e.toastShow=!0;var i=e;setTimeout(function(){i.clearAll(),sessionStorage.removeItem("userInfo"),localStorage.removeItem("userInfo"),i.$router.go({name:"login"})},800)}else e.toastMessage=t.data.info,e.toastShow=!0},function(t){e.btnStatus=!1,e.toastMessage="网络开小差了~",e.toastShow=!0})},clickExpress:function(t,e){location.href="http://www.kuaidi100.com/chaxun?com="+t+"&nu="+e},clickCancel:function(){this.clickType=1,this.confirmTitle="取消订单",this.confirmText="确定取消该订单吗,确认?",this.btnStatus=!0,this.confirmShow=!0}}}}).call(e,i(2))},282:function(t,e){t.exports=' <div class=wrapper id=cardOrder style=margin:0px _v-6d814388=""> <div class=card-box v-for="item in orders" _v-6d814388=""> <div class=top-line _v-6d814388=""> <div class=date _v-6d814388="">{{ item.createtime }}</div> <div class=status v-if="item.pay ==0 &amp;&amp; item.send == 0 &amp;&amp; item.receive == 0 &amp;&amp; item.status == 0" _v-6d814388="">待付款</div> <div class=status v-if="item.pay ==1 &amp;&amp; item.send == 0 &amp;&amp; item.receive == 0 &amp;&amp; item.status == 0" _v-6d814388="">待发货</div> <div class=status v-if="item.pay ==1 &amp;&amp; item.send == 1 &amp;&amp; item.receive == 0 &amp;&amp; item.status == 0" _v-6d814388="">待收货</div> <div class=status v-if="item.reject == 0 &amp;&amp; item.status == 1" _v-6d814388="">交易完成</div> <div class=status v-if="item.reject == 0 &amp;&amp; item.status == -1" _v-6d814388="">已取消</div> <div class=status v-if="item.reject == 0 &amp;&amp; item.status == -2" _v-6d814388="">申请售后</div> <div class=status v-if="item.reject == 0 &amp;&amp; item.status == -3" _v-6d814388="">已关闭</div> <div class=status v-if="item.reject == 1" _v-6d814388="">已退货</div> </div> <div class=mid-line v-link="{name:\'order-detail\',params:{oid:item.id}}" _v-6d814388=""> <div class=imgs v-for="img in item.imgs" _v-6d814388=""> <img :src=img style=width:100%;height:100% alt="" _v-6d814388=""> </div> <div class=arrow _v-6d814388=""></div> </div> <div class=btm-line _v-6d814388=""> <div class=money _v-6d814388=""> 总金额：<label _v-6d814388="">¥{{ item.price }}</label> </div> <div class=button _v-6d814388=""> <a class=manage-btn v-if="item.pay==0&amp;&amp;item.send==0&amp;&amp;item.receive==0&amp;&amp;item.status==0" v-link="{name:\'order-detail\',params:{oid:item.id}}" _v-6d814388="">去付款</a> <a class=manage-btn v-if="item.pay==1&amp;&amp;item.send==1&amp;&amp;item.receive==0&amp;&amp;item.status==0" @click=clickExpress(item.scid,item.snum) _v-6d814388="">查看快递</a> <a class=manage-btn v-if="item.pay==1&amp;&amp;(item.send==1||item.send==0)&amp;&amp;item.reject==0 || item.status==1" @click=buyAgain(item.id) _v-6d814388="">再次购买</a> <a class=manage-btn v-if="item.reject == 0 &amp;&amp; item.status == 1" v-link="{name:\'comment-submit\',params:{oid:item.id}}" _v-6d814388="">客户评价</a> </div> </div> <confirm :show.sync=confirmShow :title=confirmTitle confirm-text=确定 cancel-text=取消 @on-confirm=myConfirmClcik(item.id) @on-cancel=cancelClick _v-6d814388=""> <p style=text-align:center _v-6d814388="">{{ confirmText }}</p> </confirm> </div> </div> <toast :show.sync=toastShow type=text _v-6d814388="">{{ toastMessage }}</toast> <loading :show=loadingShow :text=loadingMessage _v-6d814388=""></loading> '},283:function(t,e,i){t.exports=' <div class=sub-content _v-5a64bd07=""> <div class=sub-content-tab _v-5a64bd07=""> <div class=all-title v-link="{name:\'order-type\'}" _v-5a64bd07=""> <label class=title _v-5a64bd07="">订单分类 </label> <span class=view style="" _v-5a64bd07="">查看所有订单</span> <div class=arrow _v-5a64bd07=""></div> </div> <div style="width:100%;height:58px;background: #efefef" _v-5a64bd07=""> <div class="list licon fixed justify" style="border-bottom: 1px solid #ccc;padding:0px;margin:0% 2%" _v-5a64bd07=""> <div class=tap-type :class="{\'active\':dtype == 1}" @click=getData(1) _v-5a64bd07=""> <div class="icon unpay icon-ui icon-ui-fukuan" _v-5a64bd07=""></div> <div class=title _v-5a64bd07="">待付款</div> <badge :text=count.unpay.toString() class=my-badge v-show="count.unpay > 0" _v-5a64bd07=""></badge> </div> <div class=tap-type :class="{\'active\':dtype == 2}" @click=getData(2) _v-5a64bd07=""> <div class="icon unsend icon-ui icon-ui-daifahuo" _v-5a64bd07=""></div> <div class=title _v-5a64bd07="">待发货</div> <badge :text=count.unsend.toString() class=my-badge v-show="count.unsend > 0" _v-5a64bd07=""></badge> </div> <div class=tap-type :class="{\'active\':dtype == 3}" @click=getData(3) _v-5a64bd07=""> <div class="icon unget icon-ui icon-ui-daishouhuo" _v-5a64bd07=""></div> <div class=title _v-5a64bd07="">待收货</div> <badge :text=count.unreceive.toString() class=my-badge v-show="count.unreceive > 0" _v-5a64bd07=""></badge> </div> <div class=tap-type :class="{\'active\':dtype == 4}" @click=getData(4) _v-5a64bd07=""> <div class="icon comment icon-ui icon-ui-pingjia" _v-5a64bd07=""></div> <div class=title _v-5a64bd07="">待评价</div> <badge :text=count.uncomment.toString() class=my-badge v-show="count.uncomment > 0" _v-5a64bd07=""></badge> </div> <div class=tap-type :class="{\'active\':dtype == 5}" @click=getData(5) _v-5a64bd07=""> <div class="icon service icon-ui icon-ui-shouhou" _v-5a64bd07=""></div> <div class=title _v-5a64bd07="">申请售后</div> </div> </div> </div> </div> <div id=customer _v-5a64bd07=""> <ul class=service-ul v-for="item in qqservice" _v-5a64bd07=""> <li class=icon-service v-if="item.name == \'QQ\' " _v-5a64bd07=""> <a href=javascript:void(0); style="display: block;padding-top: 7px" @click=visiblepro() _v-5a64bd07=""> <i class="little-icon qq-ui-icon" _v-5a64bd07=""></i> <span class=service-txt _v-5a64bd07="">微信客服</span> <img src='+i(260)+' class=service-allow alt="" _v-5a64bd07=""> </a> </li> <li class=icon-service v-if="item.name == \'tel\' " _v-5a64bd07=""> <a href="tel:{{ item.tel }}" style="display: block;padding-top: 7px" _v-5a64bd07=""> <i class="little-icon call-icon" _v-5a64bd07=""></i> <span class=service-txt _v-5a64bd07="">一键拨号</span> <img src='+i(260)+' class=service-allow alt="" _v-5a64bd07=""> </a> </li> </ul> </div> <div class=list style=margin-top:112px _v-5a64bd07=""> <card-orders :orders=data _v-5a64bd07=""></card-orders> </div> </div> <div class=prop-bg @click=clearpro() v-show=showpro _v-5a64bd07=""></div> <div class=prop-img id=propimg v-show=showpro _v-5a64bd07=""> <div class=towcode _v-5a64bd07=""><img src='+i(284)+' style=width:100%;height:100% _v-5a64bd07=""></div> <div class=clear-style @click=clearpro() _v-5a64bd07=""></div> </div> <toast :show.sync=toastShow type=text _v-5a64bd07="">{{ toastMessage }}</toast> '},284:function(t,e,i){t.exports=i.p+"assets/cbfbd460.qq-img.jpg"}});