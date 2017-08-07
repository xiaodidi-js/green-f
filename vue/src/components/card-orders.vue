<template>
	<div class="wrapper" id="cardOrder" style="margin:0px;">
		<div class="card-box" v-for="item in orders">
			<div class="top-line">
				<div class="date">{{ item.orderid }}</div>
				<div class="status" v-if="item.pay == 0 && item.send == 0 && item.receive == 0 && item.status == 0">待付款</div>
				<div class="status" v-if="item.pay == 1 && item.send == 0 && item.receive == 0 && item.status == 0">待发货</div>
				<div class="status" v-if="item.pay == 1 && item.send == 1 && item.receive == 0 && item.status == 0">待收货</div>
				<div class="status" v-if="item.reject == 0 && item.status == 1">交易完成</div>
				<div class="status" v-if="item.reject == 0 && item.status == -1">已取消</div>
				<div class="status" v-if="item.reject == 0 && item.status == -2">申请售后</div>
				<div class="status" v-if="item.reject == 0 && item.status == -3">已关闭</div>
				<div class="status" v-if="item.reject == 1">已退货</div>
			</div>
			<div class="mid-line" v-link="{name:'order-detail',params:{oid:item.id}}">
				<div class="imgs" v-for="img in item.imgs">
					<img :src="img" style="width:100%;height:100%;" alt="" />
					<!--<div v-lazy:background-image="img" class="payment"></div>-->
				</div>
				<div class="arrow"></div>
			</div>
			<div class="btm-line">
				<div class="money">
					<span>总金额：</span>
					<label>¥{{ item.price }}</label>
				</div>
				<div class="button">
					<a class="manage-btn"
					   v-if="item.pay == 0 && item.send == 0 && item.receive == 0 && item.status == 0"
					   v-link="{name:'order-detail',params:{oid:item.id}}">去付款</a>

					<!--<a class="manage-btn"-->
					   <!--v-if="item.pay == 0 && item.send == 0 && item.receive == 0 && item.status == 0"-->
					   <!--@click="clickCancel">取消订单</a>-->

					<!--<a class="manage-btn"-->
					   <!--v-if="item.pay == 1 && (item.send == 1 || item.send == 0) && item.reject == 0 || item.status == 1"-->
					   <!--@click="buyAgain(item.id)">再次购买</a>-->

					<!--v-if="item.pay == 1 && item.send == 1 && item.receive == 0 && item.status == 0"-->
					<!--<a class="manage-btn"-->
					   <!--v-if="item.pay == 1"-->
					   <!--@click="clickExpress(item.id,item.snum)">查看快递</a>-->

					<!--<a class="manage-btn"-->
					   <!--v-if="item.pay == 1 && item.send == 1 && item.receive == 0 && item.status == 0"-->
					   <!--@click="clickConfirm()">确认收货</a>-->

					<a class="manage-btn" v-if="item.reject == 0 && item.status == 1"
					   v-link="{name:'comment-submit',params:{oid:item.id}}">客户评价</a>

				</div>
			</div>
			<!-- 确定弹框 -->
			<confirm :show.sync="confirmShow" :title="confirmTitle" confirm-text="确定" cancel-text="取消"
					 @on-confirm="myConfirmClcik(item.id)" @on-cancel="cancelClick">
				<p style="text-align:center;">{{ confirmText }}</p>
			</confirm>
		</div>
	</div>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>

	<!-- loading加载框 -->
	<loading :show="loadingShow" :text="loadingMessage"></loading>

</template>

<script>
	import Loading from 'vux/src/components/loading'
    import Toast from 'vux/src/components/toast'
    import Confirm from 'vux/src/components/confirm'
    import { setCartAgain,clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
                setCartAgain,
				clearAll,
			}
		},
        components: {
            Loading,
            Toast,
            Confirm,
        },
		props: {
            disabled: {
                type: Boolean,
                default: false
            },
			orders: {
				type: Array,
				default() {
					return []
				}
			}
		},
		data() {
			return {
				loadingShow:false,
				loadingMessage:'',
                confirmShow: false,
                confirmTitle:'',
                confirmText: '',
                data: {
                    order:{},
                }
			}
		},
		ready() {

		},
		methods: {
            myConfirmClcik: function(id) {
                switch(this.clickType) {
                    case 1:
                        this.$deleteData('/index/user/getsubmitorder/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/oid/' + id).then((res)=>{
                            if(res.status === 1) {
                                this.data.order.statext = '用户取消';
                                this.data.order.status = -1;
                                this.btnStatus = false;
                                //刷新当前页面
                                location.reload();
                            }else if(res.status === -1) {
                                this.btnStatus = false;
                                this.toastMessage = res.info;
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
                                this.toastMessage = res.info;
                                this.toastShow = true;
                            }
                        },(res)=>{
                            this.toastMessage = '网络开小差了~';
                            this.toastShow = true;
                        });
                    case 2:
                        let pdata = {uid:this.$ustore.id,token:this.$ustore.token,oid:id};
                        if(pdata.oid === id) {
                            console.log(pdata.oid);
							console.log(1);
						} else {
                            console.log(pdata.oid);
                            console.log(2);
						}
                        return;
//                        this.$putData('/index/user/orderoperation',pdata).then((res)=>{
//                            //刷新当前页面
//                            location.reload();
//                        });
                }
			},
			buyAgain: function(oid){
				this.btnStatus = true;
				this.loadingMessage = '请稍候...';
				this.loadingShow = true;
				this.$getData('/index/user/orderoperation/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/oid/' + oid).then((res)=>{
					this.loadingShow = false;
					this.btnStatus = false;
					if(res.status === 1) {
						this.setCartAgain(res.list);
						this.$router.go({name:'cart'});
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
					}else{
						this.toastMessage = res.info;
						this.toastShow = true;
					}
				},(res)=>{
					this.btnStatus = false;
					this.toastMessage = '网络开小差了~';
					this.toastShow = true;
				});
			},
			clickExpress: function(scid,snum) {
//				location.href = 'http://www.kuaidi100.com/chaxun?com=' + scid + '&nu=' + snum;

				this.$router.go({
					name : 'express' ,
					params: {
						oid: scid,
					}
				});

			},
			clickCancel: function() {
                this.clickType = 1;
                this.confirmTitle = '取消订单';
                this.confirmText = '确定取消该订单吗,确认?';
                this.btnStatus = true;
                this.confirmShow = true;
			},
            clickConfirm: function () {
                this.clickType = 2;
                this.confirmTitle = '确认收货';
                this.confirmText = '请在收到货物后才确认收货,确认?';
                this.btnStatus = true;
                this.confirmShow = true;
            }
		}
	}
</script>

<style scoped>
	.wrapper{
		width:100%;
		padding:0;
		font-size:0;
		margin-top: 27px;
	}

	.card-box{
		width:96%;
		height:auto;
		margin:0% 0% 2% 0%;
		background-color:#fff;
		display:block;
		font-size:0;
		color:#333;
		box-shadow:1px 1px 2px #e2e2e2;
		padding:2%;
		border-radius:0.6rem;
	}

	.card-box .top-line,.card-box .mid-line{
		border-bottom:#F2F2F2 solid 1px;
	}

	.card-box .top-line,.card-box .btm-line{
		height:auto;
		line-height:2.5rem;
		/* height:3.5rem;
		line-height:3.2rem; */
	}

	.card-box .top-line,.card-box .mid-line,.card-box .btm-line{
		width:100%;
		max-width:100%;
		font-size:0;
		overflow:hidden;
	}

	.card-box .top-line div,.card-box .btm-line div{
		display: block;
		font-size: 1.4rem;
		color: #4D4D4D;
	}

	.card-box .top-line div.date,.card-box .btm-line div.money{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		text-align:left;
	}

	.card-box .top-line .date {
		float:left;
		width: 56%;
		height:3.5rem;
		line-height: 3.1rem;
	}

	.card-box .top-line .status {
		float:right;
		height:3.5rem;
		line-height: 3.1rem;
	}

	.card-box .btm-line div.money{
		width:100%;
		vertical-align:middle;
		padding-top:0.6rem;
	}

	.card-box .btm-line div.button{
		width:100%;
		vertical-align:middle;
		padding-top:0.6rem;
	}

	.card-box .btm-line div.money label{
		color:#F9AD0C;
	}

	.card-box .top-line div.status,.card-box .btm-line div.button{
		color:#81c429;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		text-align:right;
	}

	.card-box .btm-line div.button{
		font-size:0;
	}

	.card-box .mid-line .imgs{
		display:inline-block;
		vertical-align:middle;
		width:20%;
		margin:2% 1% 2% 0%;
		background-color:#eee;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
	}

	.card-box .mid-line .imgs .payment {
		width:100%;
		padding-top:100%;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
	}

	.card-box .mid-line .imgs:last-child{
		margin-right:0%;
	}

	.card-box .mid-line{
		position:relative;
	}

	.card-box .mid-line .arrow{
		width:3.5%;
		height:100%;
		background-repeat:no-repeat;
		background-position:center;
		background-size:contain;
		background-image:url('../images/arrow.png');
		position:absolute;
		top:0rem;
		right:1rem;
	}

	.manage-btn{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		color:#81c429;
		line-height:1.6rem;
		padding:0.5rem 0.6rem;
		border:#81c429 solid 1px;
		border-radius:0.3rem;
		margin-right:0.5rem;
		float:left;
	}

	.manage-btn:last-child{
		margin-right:0rem;
	}

	.manage-btn:active{
		background:#81c429;
		color:#fff;
	}
</style>