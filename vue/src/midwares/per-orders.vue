<template>
	<div class="sub-content">
		<div class="sub-content-tab">
			<div class="all-title" v-link="{name:'order-type'}"> <!-- v-link="{name:'order-type'}" -->
				<label class="title">订单分类 </label>
				<span class="view" style="">查看所有订单</span>
				<div class="arrow"></div>
			</div>
			<div style="width:100%;height:58px;background: #efefef;">
				<div class="list licon fixed justify" style="border-bottom: 1px solid #ccc;padding:0px;margin:2% 2%">
					<div class="tap-type" :class="{'active':dtype == 1}" @click="getData(1)">
						<div class="icon unpay icon-ui icon-ui-fukuan"></div>
						<div class="title">待付款</div>
						<badge :text="count.unpay.toString()" class="my-badge" v-show="count.unpay > 0"></badge>
					</div>
					<div class="tap-type" :class="{'active':dtype == 2}" @click="getData(2)">
						<div class="icon unsend icon-ui icon-ui-daifahuo"></div>
						<div class="title">待发货</div>
						<badge :text="count.unsend.toString()" class="my-badge" v-show="count.unsend > 0"></badge>
					</div>
					<div class="tap-type" :class="{'active':dtype == 3}" @click="getData(3)">
						<div class="icon unget icon-ui icon-ui-daishouhuo"></div>
						<div class="title">待收货</div>
						<badge :text="count.unreceive.toString()" class="my-badge" v-show="count.unreceive > 0"></badge>
					</div>
					<div class="tap-type" :class="{'active':dtype == 4}" @click="getData(4)">
						<div class="icon comment icon-ui icon-ui-pingjia"></div>
						<div class="title">待评价</div>
						<badge :text="count.uncomment.toString()" class="my-badge" v-show="count.uncomment > 0"></badge>
					</div>
					<div class="tap-type" :class="{'active':dtype == 5}" @click="getData(5)">
						<div class="icon service icon-ui icon-ui-shouhou"></div>
						<div class="title">申请售后</div>
					</div>
				</div>
			</div>
		</div>
		<div id="customer">
			<template  v-for="item in qqservice">
				<ul class="service-ul">
					<li class="icon-service" v-if="item.name == 'QQ' ">
						<a href="javascript:void(0);" style="display: block;padding-top: 10px;"  @click="visiblepro()">
							<i class="little-icon qq-ui-icon"></i>
							<span class="service-txt">微信客服</span>
							<img src="../images/arrow.png" class="service-allow" alt="" />
						</a>
					</li>
					<li class="icon-service" v-if="item.name == 'tel' ">
						<a href="tel:{{ item.tel }}" style="display: block;padding-top: 10px;">
							<i class="little-icon call-icon"></i>
							<span class="service-txt">一键拨号</span>
							<img src="../images/arrow.png" class="service-allow" alt="" />
						</a>
					</li>
				</ul>
			</template>
		</div>
		<!--<separator :set-height="11.5"></separator>-->
		<div v-show="hiddenShop" class="hidden-list">
			<div class="list list-nothing" v-if="data == '' ">
				<img src="../images/cart.png" style="width:100%;height: 100%" alt="" />
				<p class="nothing-order not-text">暂时没有商品</p>
			</div>
			<div class="list" style="margin-top: 130px;" v-else>
				<card-orders :orders="data"></card-orders>
			</div>
		</div>

	</div>

	<!-- 弹出 -->
	<div class="prop-bg" @click="clearpro()" v-show="showpro"></div>
	<div class="prop-img" id="propimg" v-show="showpro">
		<div class="towcode">
			<img src="../../dist/assets/img35.png" style="width:100%;height:100%;" />
		</div>
		<div class="clear-style" @click="clearpro()"></div>
	</div>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>

</template>

<script>
	//待付款
	import CardOrders from 'components/card-orders'
	import Separator from 'components/separator'
	import Toast from 'vux/src/components/toast'
	import Badge from 'vux/src/components/badge'

	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		components: {
			CardOrders,
			Separator,
			Toast,
			Badge,
		},
		data() {
			return {
			    dtype: -1, /* this.$store.state.dtype */
                willShow:true,
				toastShow: false,
				toastMessage: '',
				count:{
					unpay: 0,
					unsend: 0,
					unreceive: 0,
					uncomment: 0,
					service: 0
				},
				data:[],
				qqservice: null,
                showpro: false,
                hiddenShop: true,
			}
		},
		ready() {
            this.kefu();
            this.getData(1);
            this.getColorVisible();
		},
        watch: {
			$route(to) {
                this.getData(1);
                this.getColorVisible();
			}
        },
		methods: {
		    getColorVisible () {
                if(this.$store.state.dtype == 5) {
                    this.getData(this.$store.state.dtype);
                    $("#cardOrder").css("display","none");
                } else {
                    $("#cardOrder").css("display","block");
                    this.getData(1);
                }
			},
            visiblepro: function () {
				this.showpro = true;
            },
            clearpro: function () {
                this.showpro = false;
            },
		    kefu(){
		        let _this = this;
                this.$getData('/index/Usercenter/onlie').then((res)=> {
					_this.qqservice = res.list;
                });
            },
		    $id: function(id){
				return document.getElementById(id);
			},
			getData: function(type) {
		        if(type === 5) {
                    $("#customer").css("display","block");
					$("#cardOrder").css("display","none");
					this.hiddenShop = false;
				} else {
                    $("#customer").css("display","none");
                    $("#cardOrder").css("display","block");
                    this.hiddenShop = true;
				}
                if(this.dtype == type && this.data){
                    return true;
                }
				this.dtype = type;
				this.$getData('/index/user/orderselection/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/type/' + type).then((res)=>{
					if(res.status === 1) {
						document.body.scrollTop = 0;
						this.count = res.count;
						this.data = res.list;
					}else if(res.status === -1) {
						this.toastMessage = res.info;
						this.toastShow = true;
						let context = this;
						setTimeout(function(){
							context.clearAll();
							sessionStorage.removeItem('userInfo');
							localStorage.removeItem('userInfo');
							context.$router.go({name:'login'});
						},800);
					} else {
						this.toastMessage = res.info;
						this.toastShow = true;
					}
				},(response)=>{
					this.toastMessage = '网络开小差了~';
					this.toastShow = true;
				});
			}
		}
	}
</script>
<style scoped>
	.list{
		width:96%;
		height:auto;
		padding:1px 0px;
		margin:4% 2%;
		border-bottom:#ccc solid 1px;
		position:relative;
	}

	.list-nothing {
		width: 95px;
		height: 80px;
		margin: 155px auto 30px;
	}

	.list .not-text {
		font-size: 14px;
		line-height: 3.5rem;
		width: 100%;
		height: 3.5rem;
	}

	.list-all-order{
		width:100%;
	}
	.list.justify{
		font-size:0;
		text-align:justify;
		text-align-last:justify;
	}
	.list.justify:after{
		content:'';
		width:100%;
		display:inline-block;
	}
	.list:last-child{
		border-bottom:none;
	}
	.all-title{
		height: 4rem;
		line-height: 4rem;
		border-bottom: 1px solid #ccc;
		position: relative;
	}
	.all-title .title{
		font-size: 14px;
		line-height: 4rem;
		color: #333;
		text-align: left;
		text-indent: 1em;
		display: block;
		float: left;
	}
	.all-title.active .title{
		color:#81c429;
	}
	.all-title .arrow{
		width:1.5%;
		height:100%;
		position:absolute;
		top:0.1rem;
		right:0.5rem;
		background-image:url('../images/arrow.png');
		background-size:contain;
		background-repeat:no-repeat;
		background-position:center;
	}
	.all-title .view{
		float:right;font-size:14px;color:#999;margin-right: 20px;
	}
	.list .tap-type{
		display: inline-block;
		width: 5rem;
		height: auto;
		font-size: 1.2rem;
		vertical-align: middle;
		position: relative;
		padding: 0px 0px 5px;
		border-bottom: 3px solid #efefef;
	}
	.list .tap-type.active{
		border-bottom:3px solid #81c429;
	}
	.list .tap-type .active{
		background: #81c429;
		top: 64px;
		left: 3px;
	}
	.list .tap-type:last-child{
		margin-right:0%;
	}
	.list .icon-ui {
		width: 3.5rem;
		height: 3.4rem;
		/*background: url("../images/icon-s.png") no-repeat;*/
		margin:0px auto;
	}
	.list .icon-ui-fukuan {
		background: url("../images/unpay.png") no-repeat;
		/*background-position: 1px -72px;*/
		background-size: 100%;
	}
	.list .active .icon-ui-fukuan {
		background: url("../images/unpay2.png") no-repeat;
		/*background-position: 1px -104px;*/
		background-size: 100%;
	}
	.list .icon-ui-daifahuo {
		background: url("../images/unsend.png") no-repeat;
		/*background-position: -42px -72px;*/
		background-size: 100%;
	}
	.list .active .icon-ui-daifahuo {
		background: url("../images/unsend2.png") no-repeat;
		/*background-position: -42px -104px;*/
		background-size: 100%;
	}
	.list .icon-ui-daishouhuo {
		background: url("../images/img26.png") no-repeat;
		/*background-position: -42px -104px;*/
		background-size: 100%;
	}
	.list .active .icon-ui-daishouhuo {
		background: url("../images/img27.png") no-repeat;
		/*background-position: -42px -104px;*/
		background-size: 100%;
	}
	.list .icon-ui-pingjia {
		background: url("../images/img28.png") no-repeat;
		/*background-position: -42px -104px;*/
		background-size: 100%;
	}
	.list .active .icon-ui-pingjia {
		background: url("../images/img29.png") no-repeat;
		/*background-position: -42px -104px;*/
		background-size: 100%;
	}
	.list .icon-ui-shouhou {
		background: url("../images/img30.png") no-repeat;
		/*background-position: -42px -104px;*/
		background-size: 100%;
	}
	.list .active .icon-ui-shouhou {
		background: url("../images/img31.png") no-repeat;
		/*background-position: -42px -104px;*/
		background-size: 100%;
	}
	/* 改变图标样式 开始 */
	/*.list .tap-type .icon{*/
	/*width: 52%;*/
	/*padding-top: 8%;*/
	/*margin: auto;*/
	/*background-size: contain;*/
	/*background-repeat: no-repeat;*/
	/*background-position: center;*/
	/*font-size: 26px;*/
	/*color:#666;*/
	/*}*/
	.list .tap-type.active .icon.unpay{
		color:#81c429;
	}
	.list .tap-type.active .icon.unsend{
		color:#81c429;
	}
	.list .tap-type.active .title{
		color:#81c429;
	}
	.list .tap-type.active .icon.unget{
		color:#81c429;
	}
	.list .tap-type.active .icon.comment{
		color:#81c429;
	}
	.list .tap-type.active .icon.service{
		color:#81c429;
	}
	.list .tap-type .title{
		width:100%;
		height:auto;
		font-size:1.2rem;
		color:#808080;
		white-space:nowrap;
		overflow:hidden;
		text-overflow:ellipsis;
		text-align:center;
		text-align-last:center;
	}
	/* 改变图标样式 开始 */
	.list.ltit{
		height:2rem;
	}
	.list.fixed{
		position:fixed;
		left:0;
		z-index:100;
		background-color:#efefef;
	}
	.list .tap-type .my-badge{
		background-color: #f9ad0c;
		position: absolute;
		top: -0.9rem;
		right: 2px;
		text-align-last: center;
	}
	
	#customer{
		display:none;
		padding-top: 120px;
	}

	.sub-content-tab{
		clear: both;
		position: fixed;
		z-index: 99;
		width: 100%;
		top: 222px;
		height: 102px;
		background: #efefef;
	}
	/* servier start */
	.service-ul{
		width:100%;
	}
	.service-ul .icon-service {
		margin: 0px 10px;
		height: 50px;
		border-bottom: 1px solid #CACACA;
		/* padding: 5px 0px; */
		width: 93%;
		text-align: left;
	}
	.service-ul .icon-service .little-icon {
		width:4rem;
		display:block;
		height:4rem;
		background: url("../images/icon-s.png") no-repeat;
		float:left;
	}
	.service-ul .icon-service .qq-ui-icon{
		background-position: 0px -177px;
		background-size: 685%;
	}
	.service-ul .icon-service .call-icon {
		background-position: -35px -178px;
		background-size: 685%;
	}
	.service-ul li a .service-txt{
		font-size:14px;
		color:#4d4d4d;
		padding-left: 5px;
		line-height: 35px;
	}
	.service-ul li a .service-allow{
		width:10px;
		height: 18px;
		float: right;
		margin: 10px 0px;
	}
	/* servier end */

	/* prop-img start*/

	.prop-bg {
		width:100%;
		height:100%;
		position: fixed;
		top:0px;
		left:0px;
		z-index: 100;
		background: rgba(0,0,0,0.5);
	}

	.prop-img {
		width: 80%;
		height: 380px;
		position: fixed;
		top: 39px;
		left: 0px;
		z-index: 100;
		right: 0px;
		margin: 0px auto;
	}

	.prop-img .towcode {
		width: 100%;
		height: 100%;
	}

	.prop-img .clear-style {
		width: 45px;
		height: 45px;
		background: url('../images/gou3.png') no-repeat;
		border-radius: 100px;
		margin:30px auto 0px;
	}
	/* prop-img end*/
</style>