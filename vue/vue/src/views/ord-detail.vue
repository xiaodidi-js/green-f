<style scoped>
	.bl-info-box{
		width:94%;
		padding:2% 3%;
		background-color:#fff;
		margin-bottom:3%;
		font-size:1.4rem;
	}

	.bl-info-box.status{
		font-size:0;
		text-align:left;
	}

	.bl-info-box.status .icon,.bl-info-box.status .content{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
	}

	.bl-info-box.status .icon{
		width:8%;
		margin-right:2%;
		text-align:center;
	}

	.bl-info-box.status .icon>img{
		width:80%;
		height:auto;
	}

	.bl-info-box.status .content{
		width:90%;
	}

	.bl-info-box.status .content .sta-line{
		width:100%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		color:#808080;
		padding-bottom:2%;
	}

	.bl-info-box.status .content .sta-line .peisongdate {
		font-size:14px;
		color:#c40000;
	}

	.bl-info-box.status .content .sta-line:last-child{
		padding-bottom:0%;
	}

	.bl-info-box.status .content .sta-line .stit{
		color:#333;
	}

	.bl-info-box.status .content .sta-line .stat{
		color:#81c429;
	}

	.bl-info-box.express{

	}

	.bl-info-box.express .ex-line{
		width:100%;
		padding-bottom:2%;
		border-bottom:#f2f2f2 solid 0.1rem;
		font-size:0;
	}

	.bl-info-box.express .ex-line:last-child{
		padding-bottom:0%;
		border-bottom:none;
	}

	.bl-info-box.express .ex-line>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		color:#808080;
	}

	.bl-info-box.express .ex-line .icon{
		width:8%;
		margin-right:2%;
		text-align:center;
	}

	.bl-info-box.express .ex-line .arrow{
		width:8%;
		margin-left:2%;
		text-align:center;
	}

	.bl-info-box.express .ex-line .icon>img{
		width:80%;
		height:auto;
		vertical-align:middle;
	}

	.bl-info-box.express .ex-line .arrow>img{
		width:30%;
		height:auto;
		vertical-align:middle;
	}

	.bl-info-box.express .content{
		width:80%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.bl-info-box.express .content.address{
		width:90%;
		white-space:normal;
		font-size:0;
	}

	.bl-info-box.express .content>label{
		color:#333;
	}

	.bl-info-box.express .content>label.type{
		color:#808080;
	}

	.bl-info-box.express .content .aname{
		display:inline-block;
		width:100%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		vertical-align:middle;
		font-size:1.4rem;
		text-align:left;
		color:#333;
		padding-top:0.5rem;
	}

	.bl-info-box.express .content .astr{
		width:100%;
		margin-top:0.6rem;
		line-height:1.6rem;
		font-size:1.2rem;
		white-space:normal;
	}

	.bl-express-box{
		width:90%;
		font-size:0;
		position:relative;
		margin:8% auto;
	}

	.bl-express-box .mid-line{
		width:75%;
		height:0.1rem;
		background-color:#ccc;
		position:absolute;
		left:0;
		top:2.95rem;
		z-index:-1;
		margin:0% 12.5%;
	}

	.bl-express-box .item{
		width:21%;
		text-align:center;
		padding:0% 2%;
		display:inline-block;
		vertical-align:middle;
	}

	.bl-express-box .item>div{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		width:100%;
		font-size:1.4rem;
		color:#333;
		line-height:1.6rem;
	}

	.bl-express-box .item>div.top{
		height:1.6rem;
		max-height:1.6rem;
	}

	.bl-express-box .item>div.btm{
		height:2.4rem;
		max-height:2.4rem;
		font-size:1rem;
		white-space:normal;
		line-height:1.2rem;
	}

	.bl-express-box .item>div.ball{
		width:1.2rem;
		height:1.2rem;
		margin:0.8rem auto;
		background-color:#81c429;
		border-radius:0.6rem;
	}

	.bl-express-box .item>div.ball.active{
		background-color:transparent;
		background-image:url('../images/epoint.png');
		background-position:center;
		background-size:contain;
		animation:zoom 2.5s linear infinite normal;
		-webkit-animation:zoom 2.5s linear infinite normal;
	}

	.bl-express-box .item>div.ball.none{
		background-color:#ccc;
	}

	@keyframes zoom{
		0% {opacity:1;transform:scale(1.5);}
		25% {opacity:0.85;transform:scale(1.3);}
		50% {opacity:0.8;transform:scale(1);}
		75% {opacity:0.85;transform:scale(1.3);}
		100% {opacity:1;transform:scale(1.5);}
	}

	@-webkit-keyframes zoom{
		0% {opacity:1;transform:scale(1.5);}
		25% {opacity:0.85;transform:scale(1.3);}
		50% {opacity:0.8;transform:scale(1);}
		75% {opacity:0.85;transform:scale(1.3);}
		100% {opacity:1;transform:scale(1.5);}
	}

	.comment{
		width:100%;
		padding:1rem 0rem;
		background-color:#fff;
		text-align:center;
		margin-bottom:3%;
	}

	.comment>a{
		display:inline-block;
		padding:0.8rem 0rem;
		width:93%;
		border-radius:0.3rem;
		color:#fff;
		background-color:#f9ad0c;
		margin:auto;
		font-size:1.6rem;
		letter-spacing:0.2rem;
	}

	.comment>a:active{
		background-color:#dc990c;
	}

	.give-container {
		width:100%;
		background: #fff;
		height: 100%;
		margin: 0px 0px 10px;
	}

	.give-container .give-title {
		height:45px;
		line-height:4.5rem;
		color:#808080;
		font-size:1.4rem;
	}

	.give-container .give-title .icon-img1 {
		background: url("../images/list.png") no-repeat;
		width: 6%;
		height: 43%;
		display: block;
		background-size: 95%;
		float:left;
		margin:13px 0px;
	}

	.give-container .give-title span {
		padding-left: 10px;
		width:100%;
	}

	.give-container .give-order {
		clear:both;
		height: 145px;
	}

	.give-container .give-order ul .notActive {
		width: 29.4%;
		float:left;
		margin: 0px 5px;
		transition:0.5s;
		border:2px solid #fff;
	}

	.give-container .give-order ul .activeGift {
		width: 29.4%;
		float:left;
		margin: 0px 5px;
		border:2px solid #c40000;
		transition:0.5s;
	}

	.give-container .give-order ul li .shop-img {
		width: 100%;
		height: 95px;
	}

	.give-container .give-order ul li p {
		font-size:14px;
		line-height: 30px;
		text-align:center;
	}


	.bal-wrapper .changePay {
		width: 100%;
		height: 8rem;
		background: #fff;
		margin: 10px 0px;
		text-align: center;
	}

	.bal-wrapper .changePay .prompt {
		color: #333;
		width: 100%;
		height: 48px;
		line-height: 60px;
		text-align: center;
		font-size: 14px;
	}

	.bal-wrapper .changePay .countdown {
		color: #81c429;
		font-size:14px;
	}


</style>

<template>
	<div class="bal-wrapper" style="margin-top:80px;">
		<!-- 快递状态 -->
		<div class="bl-express-box">
			<div class="mid-line"></div>
			<div class="item" v-for="pitem in data.process">
				<div class="top">{{ pitem.title }}</div>
				<div class="ball" :class="{'active':data.pindex==$index,'none':pitem.status!=1}"></div>
				<div class="btm" v-if="pitem.status==1">{{ pitem.time }}</div>
				<div class="btm" v-else></div>
			</div>
		</div>

		<!--倒计时-->
		<surplus :showele="showTime" :time="data.process[0].endtime - data.process[0].nowtime" :clickType="clickType"></surplus>

		<!--<div class="changePay" v-show="showTime">-->
			<!--<div class="prompt">请在15分钟内完成付款,晚了就给人抢了</div>-->
			<!--<div class="countdown">剩余支付时间{{ minute }} : {{ second }} </div>-->
		<!--</div>-->

		<!-- 订单状态 -->
		<div class="bl-info-box status">
			<div class="icon">
				<img src="../images/ordersgray.png" />
			</div>
			<div class="content">
				<div class="sta-line">
					<label class="stit">订单状态：</label>
					<label class="stat">{{ data.order.statext }}</label>
				</div>
				<div class="sta-line">
					支付方式：<label v-if="data.order.paytype == 1">微信支付</label><label v-else>支付宝支付</label>
				</div>
				<div class="sta-line">
					<span>订单总计：</span>
					<label>￥{{ data.order.money }} （含运费 ￥{{ data.order.freight }}）</label>

				</div>
				<div class="sta-line" style="color:#c40000">
					配送时间：<label class="peisongdate">{{ stime | time}}</label>
				</div>
				<div class="sta-line">
					订单编号：<label>{{ data.order.orderid }}</label>
				</div>
			</div>
		</div>

		<!-- 收货地址 -->
		<div class="bl-info-box express">
			<div class="ex-line" style="line-height:1.6rem;" @click="jumpExpress">
				<div class="icon">
					<img src="../images/position.png" />
				</div>
				<div class="content">
					<label>配送方式：</label>
					<label class="type" v-if="data.order.stype=='express'">快递配送</label>
					<label class="type" v-else>到店自提</label>
				</div>
				<div class="arrow">
					<img src="../images/arrow.png" />
				</div>
			</div>
			<div class="ex-line">
				<div class="icon"></div>
				<div class="content address">
					<div class="aname">{{ data.order.person }} {{ data.order.tel }}</div>
					<div class="astr">{{ data.order.address }}</div>
				</div>
			</div>
		</div>

		<!-- 商品列表 -->
		<balance-two :list="data.products" :show-top="true" :show-btm="false" :visi="vieible"></balance-two>

		<div class="comment" v-if="data.order.pay == 1 && data.order.receive == 1">
			<a v-if="data.order.comment==1" v-link="{name:'comment-detail',params:{oid:this.$route.params.oid}}">查看评价</a>
			<a v-else v-link="{name:'comment-submit',params:{oid:this.$route.params.oid}}">我要评价</a>
		</div>

		<!-- 价格详情 -->
		<balance-price :sum="data.order.sum" :coupon="data.order.coupon" :score="data.order.score"
				:freight="data.order.freight"
				:show-sum="true"></balance-price>
	</div>

	<separator :set-height="4.5" v-show="data.order.status!=-1"></separator>

	<!-- 底部确认按钮 -->
	<bottom-confirm :fixed="true" :disabled="btnStatus" :pay="data.order.pay" :send="data.order.send"
					:receive="data.order.receive" v-show="data.order.status!=-1"></bottom-confirm>

	<!-- toast显示框 -->
	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>

	<!-- 确定弹框 -->
	<confirm :show.sync="confirmShow" :title="confirmTitle"
			 confirm-text="确定"
			 cancel-text="取消"
			 @on-confirm="confirmClcik"
			 @on-cancel="cancelClick">
		<p style="text-align:center;">{{ confirmText }}</p>
	</confirm>

	<!-- loading加载框 -->
	<loading :show="loadingShow" :text="loadingMessage"></loading>
</template>

<script>
import BalanceTwo from 'components/balance-two'
import BalancePrice from 'components/balance-price'
import BottomConfirm from 'components/bottom-confirm'
import Separator from 'components/separator'
import Toast from 'vux/src/components/toast'
import Loading from 'vux/src/components/loading'
import Confirm from 'vux/src/components/confirm'
import Scroller from 'vux/src/components/scroller'
import { setCartAgain,clearAll } from 'vxpath/actions'
import Surplus from 'components/surplus'


export default{
	vuex: {
		actions: {
			setCartAgain,
			clearAll
		}
	},
	data() {
		return {
			loadingShow:false,
			loadingMessage:'',
			toastMessage:'',
			toastShow:false,
			btnStatus:false,
			confirmShow:false,
			confirmTitle:'',
			confirmText:'',
			clickType:0,
			data: {
				pindex:0,
				process:[],
				order:{},
				products:[],
				payment:{}
			},
            stime: '',
            showGive: true,
            listGift: [],
            minute: 0,
            second: 0,
            TimeText: '',
            vieible: false,
            stop: false,
            interval: '',
            showTime: false,
			nowtime: 0,
        }
	},
	components: {
        BalanceTwo,
		BalancePrice,
		BottomConfirm,
		Separator,
		Toast,
		Loading,
		Confirm,
        Scroller,
        Surplus
	},
	route: {
		data(transition) {
			if(typeof transition.to.params.oid==='undefined'||!transition.to.params.oid){
				transition.abort();
				transition.go({name:'index'});
			}
		}
	},
	ready() {

		let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
		ustore = JSON.parse(ustore);
		var self = this;
		this.$http.get(localStorage.apiDomain+'public/index/user/getsubmitorder/uid/' + ustore.id + '/token/' + ustore.token + '/oid/' + this.$route.params.oid).then((response)=>{
			if(response.data.status === 1) {
			    //获取数据
				this.data.pindex = response.data.pindex;
				this.data.process = response.data.process;
				this.data.order = response.data.order;
				this.data.products = response.data.products;

                this.TimeText = this.data.process[0].endtime - this.data.process[0].stime;
                console.log(this.TimeText);

                if(this.data.order.statext == '用户取消'){
                    this.showTime = false;
                } else if(this.data.order.statext == '待支付') {
                    this.showTime = true;
                } else if(this.data.order.statext == '确认收货') {
                    this.showTime = false;
				} else if(this.data.order.statext == '待发货' || this.data.order.statext == '待收货' || this.data.order.statext == '待评价') {
                    this.showTime = false;
				} else if (this.minute == '0' && this.second == "0") {
                    //取消订单
                    this.clickType = 1;
                    this.$router({name: 'ord-detail'});
                    this.showTime = false;
                }

                //判断是否有赠品
				for(var i in this.data.products) {
                    if(self.data.products[i].activity == -1) {
                        self.vieible = true
						console.log(this.vieible);
					} else if(self.data.products[i].activity > 0) {
                        self.vieible = false;
                        console.log(this.vieible);
					}
				}
				for(let i in this.data.products) {
                    this.stime = this.data.products[i].stime;
				}
			} else if (response.data.status===-1) {
				this.toastMessage = response.data.info;
				this.toastShow = true;
				let context = this;
				setTimeout(function() {
					context.clearAll();
					sessionStorage.removeItem('userInfo');
					localStorage.removeItem('userInfo');
					context.$router.go({name:'login'});
				},800);
			} else {
				this.toastMessage = response.data.info;
				this.toastShow = true;
			}
		},(response)=>{
			this.toastMessage = '网络开小差了~';
			this.toastShow = true;
		});

		this.update_timer();
		this.startTimer();

	},
    watch: {
        payment: function () {
            this.startTimer();
        }
    },
	methods: {
	    runTime() {

        },
		update_timer () {
			if (this.second === 0) {
				if (this.minute < 0) {
					clearInterval(this.Interval)
					if(this.payInfo){
						this.$store.commit('showToast', {type:'cancel',msg:'订单超时！'})
					}
					this.minute = 0
					this.second = 0
				} else {
					this.second = 59
					this.minute--
				}
			} else {
				this.second--
			}
		},
        startTimer () {
            if (this.stop === false) {
                this.showTime = true;
                this.Interval = setInterval(this.update_timer, 1000)
            } else {
                this.showTime = false;
                clearInterval(this.Interval)
            }
            this.stop = !this.stop
        },
		jumpExpress: function() {
			if(this.data.order.pay !=1 || this.data.order.send !=1 || !this.data.order.snum) {
				return false;
			}
			location.href='http://www.kuaidi100.com/chaxun?com='+this.data.order.scid+'&nu='+this.data.order.snum;
		},
		jsApiCall: function() {
			let context = this;
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest',
				context.data.payment,
				function(res){
					if(res.err_msg == "get_brand_wcpay_request:ok"){
						let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
						ustore = JSON.parse(ustore);
						let opid = sessionStorage.getItem('openid');
						let pdata = {uid:ustore.id,token:ustore.token,oid:context.$route.params.oid,opid:opid,paysuccess:1};
						context.$http.put(localStorage.apiDomain+'public/index/user/getsubmitorder',pdata).then((response)=>{
						    console.log(response.data);
							context.toastMessage = response.data.info;
							context.toastShow = true;
							if(response.data.status===1){
								context.data.pindex = 1;
								context.data.process[1].status = 1;
								context.data.process[1].time = response.data.time;
								context.data.order.status = '待发货';
								context.data.order.pay = 1;
							}else if(response.data.status===-1){
								setTimeout(function(){
									context.clearAll();
									sessionStorage.removeItem('userInfo');
									localStorage.removeItem('userInfo');
									context.$router.go({name:'login'});
								},800);
							}
							context.btnStatus = false;
						},(response)=>{
							context.btnStatus = false;
							context.toastMessage = '网络开小差了~';
							context.toastShow = true;
						});
					}else{
						context.btnStatus = false;
						context.toastMessage = '订单支付失败';
						context.toastShow = true;
					}
				}
			);
		},
		callpay: function(){
			if (typeof WeixinJSBridge == "undefined"){
			    if(document.addEventListener ){
			        document.addEventListener('WeixinJSBridgeReady',this.jsApiCall, false);
			    }else if (document.attachEvent){
			        document.attachEvent('WeixinJSBridgeReady',this.jsApiCall);
			        document.attachEvent('onWeixinJSBridgeReady',this.jsApiCall);
			    }
			}else{
			    this.jsApiCall();
			}
		},
		confirmClcik: function(){
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			switch(this.clickType){
				case 1:
					//取消订单
					this.$http.delete(localStorage.apiDomain+'public/index/user/getsubmitorder/uid/'+ustore.id+'/token/'+ustore.token+'/oid/'+this.$route.params.oid).then((response)=>{
						if(response.data.status===1){
						    console.log(response.data + '1');
							this.data.order.statext = '用户取消';
							this.data.order.status = -1;
							this.btnStatus = false;
                            document.location.reload();
						}else if(response.data.status === -1) {
							this.btnStatus = false;
							this.toastMessage = response.data.info;
							this.toastShow = true;
							let context = this;
							setTimeout(function(){
								context.clearAll();
								sessionStorage.removeItem('userInfo');
								localStorage.removeItem('userInfo');
								context.$router.go({name:'login'});
							},800);
						}else{
							this.btnStatus = false;
							this.toastMessage = response.data.info;
							this.toastShow = true;
						}
					},(response) => {
						this.btnStatus = false;
						this.toastMessage = '网络开小差了~';
						this.toastShow = true;
					});
					break;
				case 2:
					//确认收货
					this.loadingMessage = '正在确认';
					this.loadingShow = true;
					let pdata = {uid:ustore.id,token:ustore.token,oid:this.$route.params.oid};
					this.$http.put(localStorage.apiDomain+'public/index/user/orderoperation',pdata).then((response)=>{
						this.loadingShow = false;
						this.toastMessage = response.data.info;
						this.toastShow = true;
						this.btnStatus = false;
						if(response.data.status===1) {
							this.data.order.receive = 1;
							this.data.pindex = 3;
							this.data.process[3].status = 1;
							this.data.process[3].time = response.data.time;
							this.data.order.statext = '确认收货';
							this.data.order.status = 1;
						}else if(response.data.status===-1){
							let context = this;
							setTimeout(function(){
								context.clearAll();
								sessionStorage.removeItem('userInfo');
								localStorage.removeItem('userInfo');
								context.$router.go({name:'login'});
							},800);
						}
					},(response)=>{
						this.loadingShow = false;
						this.btnStatus = false;
						this.toastMessage = '网络开小差了~';
						this.toastShow = true;
					});
					break;
				default:
					break;
			}
		},
		cancelClick: function(){
			this.btnStatus = false;
			this.clickType = 0;
			this.confirmTitle = '';
			this.confirmText = '';
		},
        //首单赠品
        oneGift: function (oid,money) {
            let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
            ustore = JSON.parse(ustore);
            this.$http.get(localStorage.apiDomain + 'public/index/user/manjiusong/uid/' + ustore.id + '/token/' + ustore.token +'/sinceid/' + oid + '/money/' + money).then((response)=>{
                if(response.data.status === 1) {
                    this.showGive = true;
                    this.listGift = response.data.maxmoney;
                    console.log(response.data.maxmoney);
                    this.giftstu = 1;
                } else if(response.data.status=== -1) {
                    this.toastMessage = response.data.info;
                    this.toastShow = true;
                    let context = this;
                    setTimeout(function(){
                        context.clearAll();
                        sessionStorage.removeItem('userInfo');
                        localStorage.removeItem('userInfo');
                        context.$router.go({name:'login'});
                    },800);
                } else if(response.data.status === 0) {
                    this.showGive = true;
                    this.giftstu = 0;
                    this.$http.get(localStorage.apiDomain + 'public/index/user/shoudan/uid/' + ustore.id + '/token/' + ustore.token +'/sinceid/' + oid + '/money/' + money).then((response)=>{
                        this.listGift = response.data.shoudan_data;
                        console.log(this.listGift);
                    },(response)=>{
                        this.toastMessage = '网络开小差了~';
                        this.toastShow = true;
                    });
                }
            },(response)=>{
                this.toastMessage = '网络开小差了~';
                this.toastShow = true;
            });
        }
	},
    filters: {
        time: function (value) {
            let d = new Date(parseInt(value) * 1000);
            var years = d.getFullYear();
            var month = d.getMonth() + 1;
            var days = d.getDate();
            var hours = d.getHours();
            var minutes = d.getMinutes();
            var seconds = d.getSeconds();
            return years + "-" + month + "-" + days + " " + (hours > 9 ? hours : '0' + hours) + ':' + (minutes > 9 ? minutes : '0' + minutes);
        }
    },
	events: {
		payOrder: function(){
            this.$router.go({name: 'order-detail'});
			this.btnStatus = true;
			switch(this.data.order.paytype){
				case 1:
					//微信支付
					if(typeof this.data.payment.appId === 'string' && typeof this.data.payment.package === 'string') {
						this.callpay();
						return;
					}
					let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
					ustore = JSON.parse(ustore);
					let opid = sessionStorage.getItem('openid');
					let pdata = {uid:ustore.id,token:ustore.token,oid:this.$route.params.oid,opid:opid};
					this.$http.put(localStorage.apiDomain+'public/index/user/getsubmitorder',pdata).then((response)=>{
						if(response.data.status === 1) {
							this.data.payment = JSON.parse(response.data.payment);
							this.callpay();
						}else if(response.data.status === -1) {
							this.btnStatus = false;
							this.toastMessage = response.data.info;
							this.toastShow = true;
							let context = this;
							setTimeout(function(){
								context.clearAll();
								sessionStorage.removeItem('userInfo');
								localStorage.removeItem('userInfo');
								context.$router.go({name:'login'});
							},800);
						}else{
							this.btnStatus = false;
							this.toastMessage = response.data.info;
							this.toastShow = true;
						}
					},(response)=>{
						this.btnStatus = false;
						this.toastMessage = '网络开小差了~';
						this.toastShow = true;
					});
					break;
				case 2:
					//支付宝支付
					break;
				default:
					//其他支付
					break;
			}
		},
        overtime () {
            let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
            ustore = JSON.parse(ustore);
            //取消订单
            this.$http.delete(localStorage.apiDomain+'public/index/user/getsubmitorder/uid/'+ustore.id+'/token/'+ustore.token+'/oid/'+this.$route.params.oid).then((response)=>{
                if(response.data.status===1){
                    console.log(response.data + '1');
                    this.data.order.statext = '用户取消';
                    this.data.order.status = -1;
                    this.btnStatus = false;
                    document.location.reload();
                }else if(response.data.status === -1) {
                    this.btnStatus = false;
                    this.toastMessage = response.data.info;
                    this.toastShow = true;
                    let context = this;
                    setTimeout(function(){
                        context.clearAll();
                        sessionStorage.removeItem('userInfo');
                        localStorage.removeItem('userInfo');
                        context.$router.go({name:'login'});
                    },800);
                }else{
                    this.btnStatus = false;
                    this.toastMessage = response.data.info;
                    this.toastShow = true;
                }
            },(response) => {
                this.btnStatus = false;
                this.toastMessage = '网络开小差了~';
                this.toastShow = true;
            });
        },
		orderCancel: function(){
			if(this.data.order.pay==1 || this.data.order.send == 1 || this.data.order.receive == 1){
				this.toastMessage = '订单已支付';
				this.toastShow = true;
				return false;
			}
			this.clickType = 1;
			this.confirmTitle = '取消订单';
			this.confirmText = '确定取消该订单吗?';
			this.confirmShow = true;
			this.btnStatus = true;
		},
		orderConfirm: function(){
			if(this.data.order.pay !=1) {
				this.toastMessage = '订单未支付';
				this.toastShow = true;
				return false;
			}else if(this.data.order.send !=1) {
				this.toastMessage = '订单未发货';
				this.toastShow = true;
				return false;
			}else if(this.data.order.receive == 1) {
				this.toastMessage = '订单已确认收货';
				this.toastShow = true;
				return false;
			}
			this.clickType = 2;
			this.confirmTitle = '确认收货';
			this.confirmText = '请在收到货物后才确认收货,确认?';
			this.confirmShow = true;
			this.btnStatus = true;
		},
		payAgain: function(){
			this.btnStatus = true;
			this.loadingMessage = '请稍候...';
			this.loadingShow = true;
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			this.$http.get(localStorage.apiDomain + 'public/index/user/orderoperation/uid/' + ustore.id + '/token/' + ustore.token + '/oid/' + this.$route.params.oid).then((response)=>{
				this.loadingShow = false;
				this.btnStatus = false;
				if (response.data.status === 1) {
				    console.log(response.data.list);
					this.setCartAgain(response.data.list);
					this.$router.go({name:'cart'});
				} else if (response.data.status === -1) {
					this.toastMessage = response.data.info;
					this.toastShow = true;
					let context = this;
					setTimeout(function() {
						context.clearAll();
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
						context.$router.go({name:'login'});
					},800);
				}else{
					this.toastMessage = response.data.info;
					this.toastShow = true;
				}
			},(response)=>{
				this.btnStatus = false;
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
			});
		},
		serviceApply: function(){
			if(this.data.order.pay!=1){
				this.toastMessage = '订单未支付';
				this.toastShow = true;
				return false;
			}else if(this.data.order.send!=1){
				this.toastMessage = '订单未发货';
				this.toastShow = true;
				return false;
			}
			if(this.data.order.status==-2){
				this.$router.go({name:'service',params:{oid:this.$route.params.oid}});
			}else{
				this.$router.go({name:'service-apply',params:{oid:this.$route.params.oid}});
			}
		}
	}
}

</script>