<style scoped>
	.card-coupon-box{
		width: 96%;
		height: auto;
		margin: 2% 2%;
	}
	
	.card-coupon-box:first-child{
		margin-top:4%;
	}

	.card-coupon-box .top{
		width:92%;
		height:auto;
		background-color:#fbe7bc;
		padding:4%;
		font-size:0;
	}

	.card-coupon-box .top .divider{
		display:inline-block;
		vertical-align:middle;
		width:30%;
		max-width:30%;
		height:auto;
		/*overflow:hidden;*/
	}

	.card-coupon-box .top .divider:first-child{
		padding-right:2.5%;
		/*border-right:#D6E0F1 1px dashed;*/
	}

	.card-coupon-box .top .divider:last-child{
		/*padding-left:2%;*/
	}

	.card-coupon-box .top .divider:nth-child(even){
		padding-right:2.5%;
		color:#f9ad0c;
		text-align:center;
	}

	.card-coupon-box .top .divider .shotcut{
		width:90%;
		padding-top:90%;
		margin:auto;
		border-radius:50%;
		background-repeat:no-repeat;
		background-size:cover;
		background-position:center;
		background-image:url('../images/logo_lv.png');
	}

	.card-coupon-box .top .divider .unit{
		font-size:1.4rem;
		position: relative;
		top: -5px;
	}

	.card-coupon-box .top .divider .number{
		font-size:5rem;
	}

	.card-coupon-box .top .divider .number.discount{
		font-size:4.5rem;
	}

	.card-coupon-box .top .divider .mes{
		display:block;
		font-size:1.3rem;
		color:#f9ad0c;
		line-height:2rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		/*overflow:hidden;*/
	}

	.card-coupon-box .top .divider .mes span{
		font-size:1.6rem;
		margin:0rem 0.2rem;
	}

	.card-coupon-box .wave{
		width:100%;
		height:0.45rem;
		background-image:url('../images/wave1.png');
		background-repeat:repeat-x;
		background-size:contain;
	}

	.card-coupon-box .btm{
		width:96%;
		height:auto;
		background-color:#FFF;
		padding:3% 2%;
		font-size:0;
	}

	.card-coupon-box .btm .con{
		display:inline-block;
		vertical-align:middle;
		font-size:1.3rem;
		color:#999;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.card-coupon-box .btm .con.detail{
		width:25%;
		margin-right:5%;
		text-align:left;
	}

	.card-coupon-box .btm .con.detail .arrow{
		display:inline-block;
		width:0.5rem;
		height:0.93rem;
		background-repeat:no-repeat;
		background-position:center;
		background-size:contain;
		background-image:url('../images/arrow.png');
		transform:rotate(90deg);
		-webkit-transform:rotate(90deg);
		margin-left:1.5rem;
		vertical-align:middle;
		margin-top:-0.2rem;
	}

	.card-coupon-box .btm .con.detail .arrow.show{
		transform:rotate(270deg);
		-webkit-transform:rotate(270deg);
	}

	.card-coupon-box .btm .con.deadline{
		width:70%;
		text-align:right;
	}

	.card-coupon-box .btm .addition{
		width:100%;
		padding:1.5rem 0rem 0rem;
		overflow:hidden;
	}

	.card-coupon-box .btm .addition .line{
		width:100%;
		overflow:hidden;
		text-align:left;
		font-size:0;
		margin-bottom:1.5rem;
	}

	.card-coupon-box .btm .addition .line:last-child{
		margin-bottom:0rem;
	}

	.card-coupon-box .btm .addition .line .title{
		display:inline-block;
		vertical-align:top;
		width:25%;
		color:#B3B3B3;
		font-size:1.3rem;
	}

	.card-coupon-box .btm .addition .line .content{
		display:inline-block;
		vertical-align:top;
		width:75%;
		color:#999;
		font-size:1.3rem;
	}
</style>

<template>
	<div class="card-coupon-box">
		<div class="top">
			<div class="divider">
				<div class="shotcut"></div>
			</div>
			<div class="divider">
				<label class="unit">￥</label>
				<label class="number">30</label>
			</div>
			<div class="divider nowrap">
				<label class="mes">满300元使用</label>
				<label class="mes">无门槛</label>
				<label class="mes">剩余天数<span>23</span>天</label>
			</div>
		</div>
		<div class="wave"></div>
		<div class="btm">
			<div class="con detail" @click="toggle()">
				<a >
					详细信息<div class="arrow" ></div>
				</a>
			</div>
			<div class="con deadline">2016-07-13 至 2016-08-13</div>
			<!--<div class="con deadline">{{ obj.etime }}前使用</div>-->
			<div class="addition" v-show="isShow">
				<div class="line">
					<div class="title">品牌信息：</div>
					<div class="content">适用于绿秧田购物商城</div>
				</div>
				<div class="line">
					<div class="title">限定平台：</div>
					<div class="content">限绿秧田购物商城微信版、绿秧田购物商城网页版</div>
				</div>
				<div class="line">
					<div class="title">限定城市：</div>
					<div class="content">所有城市通用</div>
				</div>
				<div class="line">
					<div class="title">限定商品:</div>
					<div class="content">部分限时抢购商品及特价商品不可用</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props: {

		},
		data() {
			return {
                isShow:false,
			}
		},
		methods: {
			changeShow: function() {
				let sindex = this.showing.indexOf(this.obj.id);
				if(sindex < 0) {
					this.showing.push(this.obj.id);
				}else{
					this.showing.splice(sindex,1);
				}
			},
            toggle: function() {
                this.isShow = !this.isShow;
            }
		},
		computed: {
			className: function() {
				if(this.showing.indexOf(this.obj.id) >= 0) {
					return true;
				}
				return false;
			},
			disOff: function() {
				let offnum = 0;
				if(this.obj.type == 2 || this.obj.type == 4){
					offnum = this.obj.discount.toFixed(2) * 10;
					if(offnum % 10 === 0){
						offnum = offnum / 10;
					}
				}
				return offnum;
			}
		}
	}
</script>