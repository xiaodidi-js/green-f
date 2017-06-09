<style scoped>
	.masker{
		position:fixed;
		top:0;
		left:0;
		width:0%;
		height:0%;
		z-index:1000;
		background-color:transparent;
	}

	.masker.show{
		width:100%;
		height:100%;
		background-color:rgba(0,0,0,0.6);
		display:block;
		transition:background .6s;
		-webkit-transition:background .6s;
	}

	.panel{
		position:fixed;
		bottom:0;
		left:0;
		width:100%;
		max-height:100%;
		z-index:5000;
		transform:translateY(100%);
		-webkit-transform:translateY(100%);
		backface-visibility:hidden;
		-webkit-backface-visibility:hidden;
		-webkit-transition:-webkit-transform .3s;
		transition:transform .3s,-webkit-transform .3s;
		background-color:#FFF;
	}

	.panel.show{
		transform:translate(0);
		-webkit-transform:translate(0);
	}

	.panel .con-box{
		width:94%;
		padding:0% 3% 0% 3%;
		max-height:20rem;
		overflow-x:hidden;
		overflow-y:scroll;
		-webkit-overflow-scrolling:touch;
		margin-bottom:5%;
	}

	.panel .title{
		width:100%;
		font-size:1.6rem;
		color:#333;
		letter-spacing:0.2rem;
		text-align:center;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		padding-bottom:5%;
		background-color:#fff;
		padding-top:5%;
	}

	.panel .btn{
		width:100%;
		padding:3% 0%;
		background-color:#81c429;
		text-align:center;
		font-size:1.6rem;
		color:#fff;
		letter-spacing:0.2rem;
	}

	.my-icon:before{
		font-size:1.6rem;
		color:#cccccc;
	}

	.my-icon-chosen:before{
		font-size:1.6rem;
		color:#f9ad0c;
	}

	.emline{
		width:100%;
		font-size:1.4rem;
		color:#ccc;
		text-align:center;
	}
</style>

<template>
	<div class="masker" :class="{'show':show}" @click="hidePanel" @touchmove.stop.prevent @touchend.stop @touchstart.stop></div>
	<div class="panel" :class="{'show':show}" @touchmove.stop.prevent @touchend.stop @touchstart.stop>
		<div class="title">{{ title }}</div>
		<div class="con-box" v-on:touchmove="conMove">
			<div class="emline" v-show="showStatus">
				{{ showTips }}
			</div>
			<coupop-list v-for="item in coupon" :obj="item" :chose-id="chosen"></coupop-list>
		</div>
		<div class="btn" v-if="showConfirm" @click="hidePanel">{{ confirmText }}</div>
	</div>
</template>

<script>
	import Icon from 'vux/src/components/icon'
	import CoupopList from 'components/coupop-list'
	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		components: {
			Icon,
			CoupopList
		},
		props: {
			show: {
				type:Boolean,
				required:true,
				twoWay:true
			},
			title: {
				type: String,
				default: ''
			},
			showConfirm: Boolean,
		    confirmText: {
			    type: String,
			    default: '确定'
		    },
		    price: {
		    	type: [String,Number],
		    	default: 0
		    },
		    chosen: {
		    	type: Number,
		    	required: true,
		    	default: 0,
		    	twoWay: true
		    }
		},
		data() {
			return {
				showStatus: true,
				showTips: '加载中...',
				coupon: []
			}
		},
		ready() {
			
		},
		computed: {
			getPrice: function(){
				let fee = this.price;
				if(typeof fee==='string'){
					fee = parseFloat(fee);
				}
				return fee.toFixed(2);
			}
		},
		methods: {
			hidePanel: function(){
				this.show = false;
			},
			conMove: function(evt){
				evt.stopPropagation();
			}
		},
		events: {
			setChosen: function(obj){
				if(typeof obj === 'object') {
					this.chosen = obj.id;
					this.$parent.couponObj = obj;
				}
			}
		},
		watch: {
			show: function(nval,oval){
				if(nval===true&&this.coupon.length<=0){
					let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
					ustore = JSON.parse(ustore);
					this.$http.get(localStorage.apiDomain+'public/index/user/couponlist/uid/'+ustore.id+'/token/'+ustore.token+'/price/'+this.getPrice).then((response)=>{
						if(response.data.status===1){
							if(response.data.coupon.length<=0){
								this.showTips = '暂无可用优惠券';
							}else{
								this.showStatus = false;
								this.showTips = '加载中...';
								this.coupon = response.data.coupon;
							}
						}else if(response.data.status===-1){
							this.$parent.toastMessage = response.data.info;
							this.$parent.toastShow = true;
							let context = this;
							setTimeout(function(){
								context.clearAll();
								sessionStorage.removeItem('userInfo');
								localStorage.removeItem('userInfo');
								context.$router.go({name:'login'});
							},800);
						}else{
							this.showTips = '暂无可用优惠券';
						}
					},(response)=>{
						this.$parent.toastMessage = '网络开小差了~';
						this.$parent.toastShow = true;
					});
				}
			}
		}
	}
</script>