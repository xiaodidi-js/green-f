<style scoped>
	.bottom-buy{
		width:100%;
		height:auto;
		background-color:#343136;
		font-size:0;
	}

	.bottom-buy>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.6rem;
		color:#fff;
	}

	.bottom-buy>div.collect,.bottom-buy>div.car{
		width:15%;
		text-align:center;
		font-size:1.2rem;
		color:#FFF;
		line-height:1.6rem;
		padding-top:1.2%;
		position:relative;
	}

	.bottom-buy>div.collect .bage,.bottom-buy>div.car .bage{
		min-width: 1.2rem;
		height: 1.2rem;
		background: #81c429;
		padding: 0.2rem;
		color: #FFF;
		text-align: center;
		border-radius: 0.8rem;
		font-size: 1.3rem;
		line-height: 1.3rem;
		position: absolute;
		top: -2px;
		right: 7px;
	}

	@media screen and (max-width: 414px) {
		.bottom-buy>div.collect .bage,.bottom-buy>div.car .bage{
			position: absolute;
			top: 2px;
			right: 12px;
		}
	}

	@media screen and (max-width: 412px) {
		.bottom-buy>div.collect .bage,.bottom-buy>div.car .bage{
			position: absolute;
			top: 2px;
			right: 12px;
		}
	}

	@media screen and (max-width: 375px) {
		.bottom-buy>div.collect .bage,.bottom-buy>div.car .bage{
			position: absolute;
			top: 0px;
			right: 9px;
		}
	}

	@media screen and (max-width: 320px) {
		.bottom-buy>div.collect .bage,.bottom-buy>div.car .bage{
			position: absolute;
			top: -2px;
			right: 7px;
		}
	}

	.bottom-buy>div.collect.active,.bottom-buy>div.car.active{
		color:#81c429;
	}

	.bottom-buy>div.collect .img,.bottom-buy>div.car .img{
		width:100%;
		padding-top:38%;
		background-position:center;
		background-repeat:no-repeat;
		background-size:contain;
	}

	.bottom-buy>div.collect .img{
		background-image:url('../images/shoucang.png');
	}

	.bottom-buy>div.collect.active .img{
		background-image:url('../images/shoucang2.png');
	}

	.bottom-buy>div.car .img{
		background-image:url('../images/img12.png');
	}

	.bottom-buy>div.car.active .img{
		background-image:url('../images/img12.png');
	}

	.bottom-buy>div.btn{
		width:35%;
		text-align:center;
		color:#FFF;
		height:4.5rem;
		line-height:4.5rem;
		font-size:14px;
	}

	.bottom-buy>div.btn.doBuy{
		background-color:#81c429;

	}

	.bottom-buy>div.btn.doBuy:active{
		background-color:#DE6156;
	}

	.bottom-buy>div.btn.addCar{
		background-color:#F9AD0C;
	}

	.bottom-buy>div.btn.addCar:active{
		background-color:#E29D0A;
	}

	.bottom-buy>div.btn.noBuy{
		width:70%;
		background-color:#d6d6d6;
		box-shadow:0.2rem 0.2rem 1rem #969696 inset;
	}

	.bottom-buy.fixed{
		position:fixed;
		bottom:0;
		left:0;
		z-index:100;
	}

	.doBuyButton {
		display:block;
		width:35%;
		height:4.5rem;
		line-height: 4.5rem;
		float:right;
		background: #F9AD0C;
		border:1px solid #f9ad0c;
		color:#fff;
		font-size:14px;
	}

</style>

<template>
	<div class="bottom-buy" :class="{'fixed' : fixed}" :style="{bottom : fixed===true && btm > 0 ? btm + unit : 0}">
		<div class="collect" :class="{active : collect}" @click="setCollect">
			<div class="img"></div>
			<p>收藏</p>
		</div>
		<div class="car" v-link="{name:'cart'}">
			<div class="img"></div>
			<p>购物车</p>
			<div class="bage" v-show="bage > 0">{{ bage }}</div>
		</div>
		<div class="btn doBuy" @click="clickBuy" v-show="store > 0">立即购买</div>
		<button class="btn addCar doBuyButton" @click="clickCart" v-show="store > 0">加入购物车</button>
		<div class="btn noBuy" v-show="store <= 0">暂时缺货</div>
	</div>
</template>

<script>

	export default{
		props: {
			bage: {
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
			},
			collect: {
				type: Boolean,
				default: false
			},
			pid: {
				type:Number,
				default: 0
			},
			store: {
				type: Number,
				required: true
			}
		},
		data() {
			return {
				
			}
		},
		methods: {
			setCollect: function(){
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				if(!ustore){
					this.$router.go({name:'login'});
					return false;
				}
				ustore = JSON.parse(ustore);
				this.$http.put(localStorage.apiDomain+'public/index/user/usercollection',{uid:ustore.id,pid:this.$route.params.pid,token:ustore.token,action:this.collect}).then((response)=>{
					if(response.data.status === 1) {
						this.collect = !this.collect;
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
                    }
					this.$dispatch('showSonMes',response.data.info);
				},(response)=>{
					this.$dispatch('showSonMes','网络开小差了~');
				});
			},
			clickBuy: function(){
				this.$dispatch('buyNow');
			},
			clickCart: function(){
				this.$dispatch('addCart');
			}
		}
	}
</script>