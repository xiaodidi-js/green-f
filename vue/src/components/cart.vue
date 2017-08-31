<template>
	<div class="msg-head">
		<div class="msg-back" @click="goback()"></div>
		<div class="msg-title">购物车</div>
	</div>
	<div class="col-wrapper" style="position: relative;margin-bottom: 0px;" v-if="cartList.length > 0">
		<div class="notify-box">
			<div class="ntips" v-show="editMode === 1">请选择删除商品</div>
			<div class="ntips" v-else>购物车中共有{{ cartList.length }}个商品</div>
			<div class="btn">
				<a @click="changMode">{{ modeText }}</a>
			</div>
		</div>
		<div class="card-wrapper" style="padding: 45px 0px 0px;">
			<cart-list :chosen.sync="choseArr" v-for="item in cartList" :pid="item.id"
					:img="item.shotcut" :pname="item.name" :pprice="item.price"
					:pnums="item.nums" :pstore="item.store" :mode="editMode"
					:pformat="item.format" :pfname="item.formatName" :store="item.store"
					:activestu="item.activestu" :pdelivery="item.deliverytime" :peisongok="item.peisongok" :activepay="item.activepay">
			</cart-list>

			<!-- 底部分隔 -->
			<separator :set-height="4.5"></separator>

			<div class="bottom" v-if="editMode === 1">
				<div class="left" style="color:#999;">
					<icon type="success" class="my-icon-chosen" @click="changAll(0)" v-show="allsel"></icon>
					<icon type="circle" class="my-icon" @click="changAll(1)" v-show="!allsel"></icon>
					<span>全选</span>
				</div>
				<div class="right">
					<x-button class="btn" @click="setDel">删除</x-button>
					<!--<div class="btn" @click="setDel">删除</div>-->
				</div>
			</div>
			<div class="bottom color" v-else>
				<div class="left color">
					<div class="choose">
						<icon type="success" class="my-icon-chosen" @click="changAll(0)" v-show="allsel"></icon>
						<icon type="circle" class="my-icon" @click="changAll(1)" v-show="!allsel"></icon>
						<label>全选</label>
					</div>
					<div class="sum">合计：¥{{ chosePrice }}</div>
				</div>
				<div class="right color gopay" @click="getOrders">
					<span>去结算</span>
					<span class="js-number">({{ choseArr.length }})</span>
				</div>
			</div>
		</div>
	</div>

	<div class="col-wrapper" style="padding: 10px 0px 0px;margin-bottom: 0px;" v-else>
		<div class="image"></div>
		<p class="tips">亲，您的购物车空空如也~</p>
		<x-button type="primary" text="逛一逛" class="public-bgcolor" v-link="{name:'index'}"></x-button>
	</div>

	<!-- <猜你喜欢> -->
	<cardlike></cardlike>
	<!-- <猜你喜欢> -->

	<!-- 确定弹框 -->
	<confirm :show.sync="confirmShow" title="删除商品" confirm-text="确定" cancel-text="取消" @on-confirm="confirmDel">
		<p style="text-align:center;">确定删除选中的商品吗？</p>
	</confirm>

	<!-- toast显示框 -->
	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>

</template>

<script>
    import { cartInfo } from 'vxpath/getters'
    import { setSelCartStorage,delMultiple,clearAll } from 'vxpath/actions'
    import Icon from 'vux/src/components/icon'
    import XButton from 'vux/src/components/x-button'
    import Confirm from 'vux/src/components/confirm'
    import Separator from 'components/separator'
    import CartList from 'components/cart-list'
    import CardRecommend from 'components/card-recommend'
    import Scroller from 'vux/src/components/scroller'
	import cardlike from 'components/buying-like'
    import Toast from 'vux/src/components/toast'
	import axios from 'axios'
	import qs from 'qs'

    export default{
        vuex: {
            getters: {
                cartList: cartInfo
            },
            actions: {
                setSelCart: setSelCartStorage,
                delMultiple,
                clearAll
            }
        },
        components: {
            Icon,
            XButton,
            Confirm,
            Separator,
            CartList,
            Scroller,
            CardRecommend,
            cardlike,
            Toast,
        },
        data() {
            return {
                modeText:'编辑',
                btnText:'删除',
                btnDis:false,
                editMode:0,
                confirmShow:false,
                toastMessage:'',
                toastShow:false,
                choseArr:[],
				likeOrder:[],
                data:{},
                ar: ['22:00','00:01'],
            }
        },
        ready() {
            this.modeText = "编辑";
            this.editMode = 0;
            $(".group ,.active").css({
                "color" : "#81c429",
            });
		},
        watch: {
			$route(to) {
				if(to.path === '/cart' || to.name === 'cart' || to.position === 0) {
                    this.modeText = "编辑";
                    this.editMode = 0;
                    $(".group ,.active").css({
						"color" : "#81c429",
					});
				}
			}
        },
        methods: {
            //	设置提交订单时间 如果超出时间范围则提交不了订单
            checkTime: function (ar) {
                var d = new Date(),	that = this;
                var current = d.getHours() * 60 + d.getMinutes();
                var ar_begin = ar[0].split(':');
                var ar_end = ar[1].split(':');
                var b = parseInt(ar_begin[0]) * 60 + parseInt(ar_begin[1]);
                var e = parseInt(ar_end[0]) * 60 + parseInt(ar_end[1]);
                for(let i in this.cartList) {
                    if (current >= b && current <= e) {
                        if (this.cartList[i].deliverytime == 0) {
                            alert("抱歉：订单已经超过了今天的截单时间，您的订单将会安排在后天配送。请注意！");
                        }
                    }
                }
            },
            goback () {
                window.history.back();
            },
            setDel: function() {
                this.confirmShow = true;
            },
            confirmDel: function(){
                if(this.cartList.length === this.choseArr.length) {
                    this.clearAll();
                }else if(this.choseArr.length > 0) {
                    this.delMultiple(this.choseArr);
                }
            },
			changMode: function() {
                this.$getData('/index/index/wxshare').then((res)=>{
                    $(".gopay").css("background" , res.color);
                });
                this.modeText = this.modeText === '编辑' ? '完成' : '编辑';
                this.editMode = this.editMode ? 0 : 1;
                this.choseArr = [];
                this.btnText = '删除';
            },
            changAll: function(type) {
                if(this.choseArr.length > 0) {
                    this.choseArr.splice(0,this.choseArr.length);
                }
                if(type === 1) {
                    for(let cl = 0;cl < this.cartList.length; cl++) {
                        this.choseArr.push({
							id:this.cartList[cl].id,
							format:this.cartList[cl].format
                        });
                    }
                }
            },
            getOrders: function() {
                let content = this;
                if(this.choseArr.length <= 0) {
                    this.$dispatch('showMes','还未选择商品');
                    return false;
                }
                content.checkTime(content.ar);
                content.setSelCart(this.choseArr);
                content.$router.go({name:'submit'});
            }
        },
        events: {
            goOver() {
                this.modeText = "编辑";
                this.editMode = 0;
                this.$getData('/index/index/wxshare').then((res)=>{
					$('.gopay').css('background',res.color);
				});

			}
		},
        filters: {
            fix: function(data) {
                return Math.round(data);
            }
        },
        computed: {
            allsel: function() {
                if(this.cartList.length === this.choseArr.length) {
                    return true;
                }
                return false;
            },
            chosePrice: function() {
                let sum = 0;
                if(this.choseArr.length <= 0) {
                    return sum.toFixed(2);
                }
                for(let ch = 0;ch < this.choseArr.length; ch++) {
                    for(let pl = 0;pl < this.cartList.length; pl++) {
                        if(this.choseArr[ch].id === this.cartList[pl].id && this.choseArr[ch].format === this.cartList[pl].format) {
                            sum = sum + this.cartList[pl].price * this.cartList[pl].nums;
                            break;
                        }
                    }
                }
                return sum.toFixed(2);
            }
        }
    }
</script>

<style scoped>
	.col-wrapper,.card-wrapper {
		width:100%;
		height:auto;
	}

	.col-wrapper, .card-wrapper {
		position: relative;
		margin-top: 4.6rem;
	}

	.notify-box {
		width:94%;
		height:20px;
		padding:10px 3%;
		position: absolute;
		top: 0px;
		left: 0px;
	}

	.notify-box div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		line-height:20px;
		color:#fff;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}
	.notify-box div.ntips{
		width:65%;
		margin-right:10%;
	}

	.notify-box div.btn{
		width:25%;
		text-align:right;
	}

	.col-wrapper .image{
		width:45%;
		padding-top:45%;
		margin:10% auto;
		background-image:url('../images/cart.png');
		background-position:center;
		background-size:contain;
		background-repeat:no-repeat;
	}

	.col-wrapper .tips{
		font-size:1.8rem;
		color:#999;
		text-align:center;
	}

	.col-wrapper .public-bgcolor {
		width:40%;
		margin:2rem auto;
		font-size: 16px;
	}

	.my-icon:before{
		color:#ccc;
	}

	.my-icon-chosen:before{
		color:#f9ad0c;
	}

	.bottom{
		width:100%;
		height:auto;
		position:fixed;
		bottom:50px;
		left:0;
		font-size:0;
		background: #f2f2f2;
		z-index: 5;
	}

	.bottom.color{
		background-color:#343136;
		color:#fff;
		z-index:10;
	}

	.bottom>div{
		display:inline-block;
		vertical-align:middle;
	}

	.bottom>div.left{
		width:70%;
		text-align:left;
		font-size:1.6rem;
	}

	.bottom>div.left.color{
		font-size:0;
	}

	.bottom>div.left.color>div{
		display:inline-block;
		vertical-align:middle;
		font-size:14px;
	}

	.bottom>div.left.color>div.choose{
		width:15%;
		text-align:center;
	}

	.bottom>div.left.color>div.choose>label{
		font-size:1.2rem;
		display:block;
	}

	.bottom>div.left .my-icon,.bottom>div.left .my-icon-chosen{
		margin-left:4.5%;
	}

	.bottom>div.left.color .my-icon,.bottom>div.left.color .my-icon-chosen{
		margin-left:0%;
	}

	.bottom>div.left.color .my-icon:before,.bottom>div.left.color .my-icon-chosen:before{
		font-size:2.1rem;
	}

	.bottom>div.left.color .sum{
		width:80%;
		margin-left:5%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.bottom>div.right{
		width:30%;
		text-align:center;
		font-size:1.4rem;
		height:4.5rem;
		line-height:2.9rem;
	}

	.bottom>div.right .btn{
		width: 100%;
		text-align: center;
		color: #81c429;
		margin: 0rem auto;
		height: 100%;
		line-height: 3.5rem;
	}

	.bottom>div.right .btn:after{
		border:none;
		border-radius: 0px;
	}

	.bottom>div.right span{
		height:18px;
		display:block;
	}

	.bottom>div.right .js-number {
		overflow: hidden;
		width: 95%;
		text-overflow: ellipsis;
		margin: -1px 2px;
		height: 28px;
	}

	.isChonse .addcon .address .weui_icon_success:before {
		color:#fff;
	}

</style>
