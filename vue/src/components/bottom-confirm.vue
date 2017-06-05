<style scoped>
	.bottom-buy{
		width:100%;
		height:auto;
		font-size:0;
	}

	.bottom-buy.fixed{
		position:fixed;
		bottom:0;
		left:0;
		z-index:100;
	}

	.bottom-buy>div{
		width:100%;
		height:auto;
	}

	.bottom-buy>div>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.6rem;
		color:#fff;
	}

	.bottom-buy>div>div.btn{
		width:50%;
		text-align:center;
		height:4.5rem;
		line-height:4.5rem;
	}

	.bottom-buy>div>div.btn.again{
		background-color:#f9ad0c;
	}

	.bottom-buy>div>div.btn.again.disabled,.bottom-buy>div>div.btn.again.disabled:active{
		background-color:#ffde9a;
	}

	.bottom-buy>div>div.btn.again:active{
		background-color:#E29D0A;
	}

	.bottom-buy>div>div.btn.confirm{
		background-color:#81c429;
	}

	.bottom-buy>div>div.btn.confirm.disabled,.bottom-buy>div>div.btn.confirm.disabled:active{
		background-color:#ffa097;
	}

	.bottom-buy>div>div.btn.confirm:active{
		background-color:#DE6156;
	}

	.bottom-buy>div>div.btn.service{
		background-color:#b3b3b3;
	}

	.bottom-buy>div>div.btn.service.disabled,.bottom-buy>div>div.btn.service.disabled:active{
		background-color:#dadada;
	}

	.bottom-buy>div>div.btn.service:active{
		background-color:#9a9a9a;
	}
</style>

<template>
	<div class="bottom-buy" :class="{'fixed':fixed}" :style="{bottom:fixed===true&&btm>0 ? btm+unit : 0}">
			<div v-if="pay==0&&send==0&&receive==0">
				<div class="btn service" :class="{'disabled':disabled}" @click="clickCancel">取消订单</div>
			<div class="btn again" :class="{'disabled':disabled}" @click="clickPay">确认支付</div>
		</div>
		<div v-if="pay==1&&(send==0||send==1)&&receive==0">
			<div class="btn confirm" :class="{'disabled':disabled}" @click="clickConfirm">确认收货</div>
			<div class="btn again" :class="{'disabled':disabled}" @click="clickAgain">再次购买</div>
		</div>
		<div v-if="pay==1&&send==1&&receive==1">
			<div class="btn service" :class="{'disabled':disabled}" @click="clickService">申请售后</div>
			<div class="btn again" :class="{'disabled':disabled}" @click="clickAgain">再次购买</div>
		</div>
	</div>
</template>

<script>

	export default{
		props: {
			disabled: {
				type: Boolean,
				default: false
			},
			pay: {
				type: Number,
				default: 0
			},
			send: {
				type: Number,
				default: 0
			},
			receive: {
				type: Number,
				default: 0
			},
			fixed: {
				type: Boolean,
				default: false
			},
			btm: {
				type: Number,
				default: 0
			},
			unit: {
				type: String,
				default: 'rem'
			}
		},
		data() {
			return {
				
			}
		},
		methods: {
			clickPay: function(){
				if(this.disabled){
					return true;
				}
				this.$dispatch('payOrder');
			},
			clickAgain: function(){
				if(this.disabled){
					return true;
				}
				this.$dispatch('payAgain');
			},
			clickConfirm: function(){
				if(this.disabled){
					return true;
				}
				this.$dispatch('orderConfirm');
			},
			clickCancel: function(){
				if(this.disabled){
				    console.log(1);
					return true;
				}
				this.$dispatch('orderCancel');
			},
			clickService: function(){
				if(this.disabled){
					return true;
				}
				this.$dispatch('serviceApply');
			}
		}
	}
</script>