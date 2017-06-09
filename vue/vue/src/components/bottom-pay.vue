<style scoped>
	.bottom-buy{
		width:100%;
		height:auto;
		background-color:#343136;
		font-size:0;
	}

	.bottom-buy.fixed{
		position:fixed;
		bottom:0;
		left:0;
		z-index:100;
	}

	.bottom-buy>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.6rem;
		color:#fff;
	}

	.bottom-buy>div.mes{
		width: 61%;
		text-align: left;
		margin: 0% 2%;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
		line-height: 44px;
		float: left;
	}

	.bottom-buy .btn{
		width:35%;
		text-align:center;
		color:#FFF;
		height:4.5rem;
		line-height:4.5rem;
		font-size: 1.5rem;
		border:none;
	}

	.bottom-buy .addCar{
		background-color:#81c429;
	}

	.bottom-buy .addCar:active{
		background-color:#81c429;
	}
</style>

<template>
	<div class="bottom-buy" :class="{'fixed':fixed}" :style="{bottom:fixed===true&&btm>0 ? btm+unit : 0}">
		<div class="mes">
			<span>合计：</span>
			<span style="margin-left:12px;">¥{{ sum }}</span>
		</div>
		<!--<div class="btn addCar" disabled="disabled" @click="submit">提交订单</div>-->
		<button class="btn addCar" @click="submit">提交订单</button>
	</div>
</template>

<script>

	export default{
		props: {
			sum: {
				type: String,
				default: '0.00'
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
			submit: function(){
				this.$dispatch('submitOrder');
			}
		}
	}
</script>