<template>
	<div class="wrapper" style="margin-bottom:0px;padding:0px;overflow:none;">
		<!-- 购物车 -->
		<div class="group-cart" v-link="{name:'cart'}" @click="goCart()">
			<i class="icons icon-icon22fuzhi"></i>
			<div class="name">购物车</div>
			<badge :text="cartNumsText" class="my-badge cart-bor" v-show="cartNums > 0"></badge>
		</div>
		<div id="card">
			<!-- 选项卡一 -->
			<div class="group" :class="{'actives':$route.position === 1}" @click="goPage('index')">
				<i class="icons icon-home"></i>
				<div class="name public-color">首页</div>
			</div>
			<!-- 选项卡二 -->
			<div class="group" :class="{'actives':$route.position === 2}" style="position: relative;left: -15px;" @click="goPage('classify')">
				<i class="icons icon-zizhuxiadan"></i>
				<div class="name public-color">下单</div>
			</div>
			<!-- 选项卡三 -->
			<div class="group" :class="{'actives':$route.position === 3}" style="position: relative;left: 15px;" @click="goPage('card-image')">
				<i class="icons icon-huodong"></i>
				<div class="name public-color">活动</div>
			</div>
			<!-- 选项卡四 -->
			<div class="group" :class="{'actives':$route.position === 4}" @click="goConter()">
				<i class="icons icon-gerenzhongxin"></i>
				<div class="name public-color">个人中心</div>
			</div>
		</div>
	</div>
</template>

<script>
	import { cartNums } from 'vxpath/getters'
	import Badge from 'vux/src/components/badge'
    import { myActive } from 'vxpath/actions'

	export default{
		components: {
			Badge
		},
		vuex: {
			getters: {
				cartNums,
			},
            actions: {
                myActive
			}
		},
		data() {
			return {

			}
		},
		ready() {
            $(".actives").css({
				"color" : "#f67816",
			});
//            this.$getData('/index/index/wxshare').then((res) => {
//                $(".active").css({
//                    "color" : res.color,
//                });
//            });
		},
        watch: {
            $route(to) {
                switch(to.position) {
					case 1:
                        this.$getData('/index/index/wxshare').then((res) => {
                            $(".group").css({
                                "color" : "#81c429",
                            });
                            $(".actives").css({
                                "color" : "#f67816",
                            });
                        });
                    case 2:
                        this.$getData('/index/index/wxshare').then((res) => {
                            $(".group").css({
                                "color" : "#81c429",
                            });
                            $(".actives").css({
                                "color" : "#f67816",
                            });
                        });
                    case 3:
                        this.$getData('/index/index/wxshare').then((res) => {
                            $(".group").css({
                                "color" : "#81c429",
                            });
                            $(".actives").css({
                                "color" : "#f67816",
                            });
                        });
                    case 4:
                        this.$getData('/index/index/wxshare').then((res) => {
                            $(".group").css({
                                "color" : "#81c429",
                            });
                            $(".actives").css({
                                "color" : "#f67816",
                            });
                        });
				}
			},
		},
        methods: {
            goPage(name) {
				this.$router.go({name : name});
			},
		    goBack() {
                let openid = sessionStorage.getItem("openid");
                this.$getData('/index/index/guanzhu?openid=' + openid).then((response)=>{
                    if(response.status == 0) {
                        this.$router.go({name: 'sao'});
                        return;
                    }
                });
			},
		    goConter: function() {
				this.goBack();
                this.myActive(1);
                this.$router.go({name: 'per-orders'})
			},
            goCart: function() {
                this.goBack();
                var cardDom = document.getElementById("card"), active = cardDom.children;
                for(var i in active) {
                    try {
                        if(active[i]) {
                            active[i].className = "group";
                            active[i].style.color = "#81c429";
						}
					} catch(e) {
                        throw "呵呵哒！";
					} finally {}
                }
			},
		},
		computed: {
			cartNumsText() {
				return this.cartNums.toString()
			}
		}
	}
</script>

<style scoped>
	@import '../fonts/iconfont.css';

	/* wrapper start */
	.wrapper{
		width:100%;
		height:4.9rem;
		background-color:#fff;
		box-shadow:1px 0px 2px #e4e4e4;
		border-top:#eee solid 1px;
		font-size:0;
		position:fixed;
		left:0;
		bottom:0;
		z-index:10;
		background-color: #fff;
		box-shadow: 0 0 10px 0 rgba(155,143,143,0.6);
		-webkit-box-shadow: 0 0 10px 0 rgba(155,143,143,0.6);
		-moz-box-shadow: 0 0 10px 0 rgba(155,143,143,0.6);

	}

	.wrapper .group-cart {
		width:55px;
		height:55px;
		text-align:center;
		color:#fff;
		background: #81c429;
		border-radius:100%;
		position:fixed;
		left:0px;
		right:0px;
		bottom:10px;
		margin:0px auto;
		z-index:99;
	}

	.wrapper .goCart {
		width:55px;
		height:55px;text-align:center;color:#fff;
		background: #81c429;
		border-radius:100%;
		position:fixed;
		left:0px;
		right:0px;
		bottom:10px;
		margin:0px auto;
		z-index:99;
	}

	.cart-bor {
		position: absolute;
		top: 0px;
		right: -12px;
		padding: 5px;
		background: #ecb01f;
		border-radius: 100%;
	}

	.wrapper .group-cart .icon-gouwuche {
		position: relative;
		top:5px;
	}

	.wrapper .group-cart .name{
		line-height: 32px;
	}

	.wrapper .group {
		display: inline-block;
		width: 25%;
		height: auto;
		text-align: center;
		color: #81c429;
		padding: 0.7rem 0rem;
		vertical-align: middle;
	}

	.wrapper .icons {
		display: block;
		width: 2rem;
		height: 2rem;
		margin: 0px auto;
	}

	.wrapper .icon-icon22fuzhi {
		background: url('../images/img32.png') no-repeat;
		background-size: 100%;
		position: relative;
		top: 10px;
		left: -2px;
	}

	.wrapper .icon-home {
		background: url('../images/img15.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .icon-zizhuxiadan {
		background: url('../images/img17.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .icon-huodong {
		background: url('../images/img19.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .icon-gerenzhongxin {
		background: url('../images/img21.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .actives .icon-home {
		background: url('../images/tarbar/1.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .actives .icon-zizhuxiadan {
		background: url('../images/tarbar/2.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .actives .icon-huodong {
		background: url('../images/tarbar/3.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .actives .icon-gerenzhongxin {
		background: url('../images/tarbar/4.png') no-repeat;
		background-size: 100%;
	}

	.wrapper .actives {
		color: #f67816;
		display:inline-block;
		width:25%;
		height:auto;
		text-align:center;
		padding:0.7rem 0rem;
		vertical-align:middle;
	}

	.group.selected {
		color:#7fc72b;
	}

	.iconfont,.name{
		display:block;
	}

	.iconfont {
		font-size:2.4rem;
		line-height:2.5rem;
	}

	.iconfont.icon-gouwuche{
		font-size:2.5rem;
	}

	.name{
		font-size: 1.2rem;
		line-height: 1.9rem;
	}

	.cart {
		position: absolute;
		top: 0px;
		left: 118px;
		width:40px;
		height:40px;
		border-radius:100px;
		background: #3cc51f;
	}

	.wrapper .group .my-badge{
		background: #f9ad0c;
		position: absolute;
		top: 2%;
		right: 30%;
	}
	/* wrapper start */

</style>





