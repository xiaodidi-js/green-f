<style scoped>
	.bl-wrapper{
		width: 94%;
		padding: 2% 3% 2%;
		background-color: #fff;
		margin-bottom: 35px;
		margin-top:1rem;
	}

	.bl-wrapper .line{
		width:100%;
		padding:2% 0%;
		font-size:0rem;
		line-height:1.6rem;
	}

	.bl-wrapper .line>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		width:50%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.bl-wrapper .line>div.left{
		text-align:left;
		color:#808080;
	}

	.bl-wrapper .line>div.right{
		text-align:right;
		color:#f9ad0c;
	}

	.bl-wrapper .line.bottom{
		border-top:#f2f2f2 solid 1px;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		text-align:right;
		font-size:1.4rem;
		color:#808080;
		padding-top:2%;
		padding-bottom:0%;
	}

	.bl-wrapper .line.bottom>label{
		color:#f9ad0c;
	}
</style>

<template>
	<div class="bl-wrapper">
		<div class="line" style="border:none;">
			<div class="left">商品金额：</div>
			<div class="right">
				{{ sfee }}
			</div>
		</div>
		<div class="line" style="border:none;">
			<div class="left">优惠券抵扣：</div>
			<div class="right">
				<label>-</label>
				{{ cfee }}
			</div>
		</div>
		<div class="line" style="border:none;">
			<div class="left">积分抵扣：</div>
			<div class="right">
				<label>-</label>
				{{ scfee }}
			</div>
		</div>
		<div class="line" style="border:none;">
			<div class="left">快递运费：</div>
			<div class="right">
				{{ ffee }}
			</div>
		</div>
		<div class="line bottom" v-if="showSum" style="border:none;">
			应付金额：<label>¥{{ lastSum }}</label>
		</div>
	</div>
</template>

<script>
	export default{
		props: {
			sum: {
				type: [String,Number],
				default: 0
			},
			coupon: {
				type: [String,Number],
				default: 0
			},
			score: {
				type: [String,Number],
				default: 0
			},
			freight: {
				type: [String,Number],
				default: 0
			},
			showSum: {
				type: Boolean,
				default: false
			}
		},
		data() {
			return {
				
			}
		},
		ready() {
			
		},
		computed: {
			sfee: function() {
				let fee = this.sum;
				if(typeof fee === 'string') {
					fee = parseFloat(fee);
				}
				return fee.toFixed(2);
			},
			cfee: function() {
				let fee = this.coupon;
				if(typeof fee === 'string') {
					fee = parseFloat(fee);
				}
				return fee.toFixed(2);
			},
			scfee: function() {
				let fee = this.score;
				if(typeof fee === 'string') {
					fee = parseFloat(fee);
				}
				return fee.toFixed(2);
			},
			ffee: function() {
				let fee = this.freight;
				if(typeof fee === 'string') {
					fee = parseFloat(fee);
				}
				return fee.toFixed(2);
			},
			lastSum: function(){
				let getSum = (this.sum + this.freight) - (this.coupon + this.score);
				if(getSum <= 0) {
					getSum = 0.02;
				}
				return getSum.toFixed(2);
			}
		}
	}
</script>