webpackJsonp([37],{292:function(i,s,a){var c,v;a(293),c=a(294),v=a(295),i.exports=c||{},i.exports.__esModule&&(i.exports=i.exports.default),v&&(("function"==typeof i.exports?i.exports.options:i.exports).template=v)},293:function(i,s){},294:function(i,s){"use strict";Object.defineProperty(s,"__esModule",{value:!0}),s.default={props:{},data:function(){return{isShow:!1}},methods:{changeShow:function(){var i=this.showing.indexOf(this.obj.id);i<0?this.showing.push(this.obj.id):this.showing.splice(i,1)},toggle:function(){this.isShow=!this.isShow}},computed:{className:function(){return this.showing.indexOf(this.obj.id)>=0},disOff:function(){var i=0;return 2!=this.obj.type&&4!=this.obj.type||(i=10*this.obj.discount.toFixed(2),i%10===0&&(i/=10)),i}}}},295:function(i,s){i.exports=' <div class=card-coupon-box _v-7c1f1bab=""> <div class=top _v-7c1f1bab=""> <div class=divider _v-7c1f1bab=""> <div class=shotcut _v-7c1f1bab=""></div> </div> <div class=divider _v-7c1f1bab=""> <label class=unit _v-7c1f1bab="">￥</label> <label class=number _v-7c1f1bab="">30</label> </div> <div class="divider nowrap" _v-7c1f1bab=""> <label class=mes _v-7c1f1bab="">满300元使用</label> <label class=mes _v-7c1f1bab="">无门槛</label> <label class=mes _v-7c1f1bab="">剩余天数<span _v-7c1f1bab="">23</span>天</label> </div> </div> <div class=wave _v-7c1f1bab=""></div> <div class=btm _v-7c1f1bab=""> <div class="con detail" @click=toggle() _v-7c1f1bab=""> <a _v-7c1f1bab=""> 详细信息<div class=arrow _v-7c1f1bab=""></div> </a> </div> <div class="con deadline" _v-7c1f1bab="">2016-07-13 至 2016-08-13</div> <div class=addition v-show=isShow _v-7c1f1bab=""> <div class=line _v-7c1f1bab=""> <div class=title _v-7c1f1bab="">品牌信息：</div> <div class=content _v-7c1f1bab="">适用于绿秧田购物商城</div> </div> <div class=line _v-7c1f1bab=""> <div class=title _v-7c1f1bab="">限定平台：</div> <div class=content _v-7c1f1bab="">限绿秧田购物商城微信版、绿秧田购物商城网页版</div> </div> <div class=line _v-7c1f1bab=""> <div class=title _v-7c1f1bab="">限定城市：</div> <div class=content _v-7c1f1bab="">所有城市通用</div> </div> <div class=line _v-7c1f1bab=""> <div class=title _v-7c1f1bab="">限定商品:</div> <div class=content _v-7c1f1bab="">部分限时抢购商品及特价商品不可用</div> </div> </div> </div> </div> '}});