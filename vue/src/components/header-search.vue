<template>
	<div class="search-header" :class="{'fixed':fixed}" :style="{backgroundColor : bgcolor,top : fixed===true && top > 0 ? top+unit : 0}">
		<div class="left">
			<div class="arrow" @click="goBack"></div>
		</div>
		<div class="center">
			<img src="../images/search-1.png">
			<input type="text" placeholder="请输入您要搜索的商品" v-model="searchKey" />
		</div>
		<div class="right" @click="goSearch">搜索</div>
	</div>
</template>

<script>

	export default{
		components: {

		},
		props: {
			bgcolor: {
				type: String,
				default: ''
			},
			fixed: {
				type: Boolean,
				default: false
			},
			top: {
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
				searchKey:''
			}
		},
		methods: {
			"goBack": function(){
				window.history.back();
			},
			"goSearch": function(){
				this.searchKey = this.searchKey.replace(/(^\s*)|(\s*$)/g,'');
				if(this.searchKey.length<=0){
					return false;
				}
				this.$dispatch('goSearch',this.searchKey);
			}
		}
	}
</script>

<style scoped>
	.search-header{
		width:100%;
		height:30px;
		background-color:#343136;
		padding:8px 0px;
		font-size:0;
	}

	.search-header>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.6rem;
		color:#fff;
		overflow:hidden;
	}

	.search-header>div.left{
		width:20%;
		text-align:center;
		font-size:0;
	}

	.search-header>div.left .arrow{
		display:inline-block;
		vertical-align:middle;
		width:22%;
		padding-top:22%;
		border-top:#FFF solid 0.1rem;
		border-left:#FFF solid 0.1rem;
		transform:rotate(-45deg);
		-webkit-transform:rotate(-45deg);
	}

	.search-header>div.center{
		width:60%;
		text-align:left;
		font-size:0;
		background-color:#FFF;
		border-radius:0.1rem;
		overflow:hidden;
	}

	.search-header>div.center img{
		display:inline-block;
		vertical-align:middle;
		width:1.4rem;
		height:auto;
		margin:0% 0.5% 0% 2%;
		padding:2% 0%;
	}

	.search-header>div.center input{
		display:inline-block;
		vertical-align:middle;
		width:84.7%;
		height:24px;
		line-height:24px;
		padding:3px 2%;
		border:none;
		background-color:transparent;
		font-size:1.4rem;
		color:#333;
	}

	.search-header>div.right{
		width:20%;
		text-align:center;
	}

	.search-header.fixed{
		position:fixed;
		top:0;
		left:0;
		z-index:100;
	}

	.search-header>div.right:active{
		-webkit-animation-duration: 2s;
		animation-duration: 2s;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
		-webkit-animation-name: searchFade;
		animation-name: searchFade;
	}

	@-webkit-keyframes searchFade{
		from {
			opacity:0.3;
		}
		to {
			opacity:1;
		}
	}

	@keyframes searchFade{
		from {
			opacity:0.3;
		}
		to {
			opacity:1;
		}
	}
</style>