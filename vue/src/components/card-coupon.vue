<style scoped>
	.notify-box{
		width:94%;
		height:20px;
		padding:10px 3%;
		background-color:#81c429;
		font-size:0;
		position:fixed;
		top:22.2rem;
		left:0;
		z-index:100;
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
	.notify-box div.tips{
		width:65%;
		margin-right:10%;
	}

	.notify-box div.btn{
		width:25%;
		text-align:right;
	}

	.wrapper{
		width:100%;
		height:auto;
	}
</style>

<style>
	.weui_btn_dialog.primary{
		color:#F9AD0C !important;
	}

	input.pass-code{
		width:96%;
		padding:3% 2%;
		background-color:#F2F2F2;
		color:#333;
	}
</style>

<template>
	<div class="notify-box">
		<div class="tips">当前有 {{ data.length }} 张可用优惠劵</div>
		<div class="btn">
			<!-- <a @click="showConfirm">口令兑换</a> -->
		</div>
	</div>

	<separator :set-height="40" unit="px"></separator>

	<div class="wrapper">
		<coupon-list v-for="item in data" :obj="item" :showing.sync="choseArr"></coupon-list>
	</div>

	<!-- 确定弹框 -->
	<confirm :show.sync="confirmShow" title="口令兑换" confirm-text="确定" cancel-text="取消" @on-confirm="confirmPassword">
		<input type="text" class="pass-code" value="" placeholder="输入兑换码" />
	</confirm>
</template>

<script>
	import Confirm from 'vux/src/components/confirm'
	import Separator from './separator'
	import CouponList from 'components/coupon-list'
	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		components:{
			Confirm,
			Separator,
			CouponList
		},
		data() {
			return {
				confirmShow:false,
				choseArr:[],
				data:[]
			}
		},
		methods: {
			showConfirm: function(){
				this.confirmShow = true;
			},
			confirmPassword: function(){

			}
		},
		ready() {
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			this.$http.get(localStorage.apiDomain+'public/index/user/couponinfo/uid/'+ustore.id+'/token/'+ustore.token).then((response)=>{
				if(response.data.status===1){
					this.data = response.data.coupon;
				}else if(response.data.status===-1){
					this.$dispatch('showMes',response.data.info);
					let context = this;
					setTimeout(function(){
						context.clearAll();
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
						context.$router.go({name:'login'});
					},800);
				}else{
					this.$dispatch('showMes',response.data.info);
				}
		},(response)=>{
				this.$dispatch('showMes','网络开小差了~');
			});
		}
	}
</script>