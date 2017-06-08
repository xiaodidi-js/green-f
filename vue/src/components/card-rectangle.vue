<style scoped>

	.wrapper{
		width:100%;
		padding:0rem 0rem 1rem 0rem;
		font-size:0;
	}

	.title{
		display:block;
		margin:0.5rem 0rem 1rem 0rem;
		font-size:1.4rem;
		color:#F9AD0C;
		font-weight:normal;
		letter-spacing:1px;
		border-left:#F9AD0C solid 5px;
		padding-left:0.8rem;
	}

	.card-box{
		width:90%;
		height:auto;
		margin:0% 3% 2% 3%;
		background-color:#fff;
		display:block;
		font-size:0;
		color:#333;
		box-shadow:1px 1px 2px #e2e2e2;
		padding:2%;
	}

	.card-box:last-child{
		margin-bottom:0%;
	}

	.card-box .img{
		display:inline-block;
		vertical-align:middle;
		width:35%;
		padding-top:35%;
		margin-right:2%;
		background-color:#eee;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		position:relative;
	}

	.card-box .img .prize{
		width:30%;
		height:auto;
		position:absolute;
		top:-10%;
		left:-12%;
	}

	.card-box .mes{
		display:inline-block;
		vertical-align:middle;
		width:63%;
		font-size:1.4rem;
	}

	.card-box .mes .name{
		font-size:1.5rem;
		color:#999;
		line-height:1.8rem;
		max-height:3.6rem;
		overflow:hidden;
		text-overflow:ellipsis;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		font-weight:normal;
		margin-bottom:0.5rem;
	}

	.card-box .mes .desc{
		font-size:1.2rem;
		color:#fff;
		background-color:#F9AD0C;
		border-radius:0.3rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		max-width:96%;
		padding:0.6% 2%;
		display:inline-block;
	}

	.card-box .mes .money{
		font-size:1.7rem;
		color:#F9AD0C;
	}

	.card-box .mes .money .unit{
		font-size:1.3rem;
		margin-right:0.3rem
	}

	.index-conten{
		width:100%;
		clear:both;
		background: #fff;
		padding-bottom: 35px;
	}

	.index-conten .content_main{
		display: flex;
		flex-wrap:wrap;
		box-sizing:border-box;
	}

	.index-conten .content_main .href-ui {
		display:block;
		width:100%;
		height:100%;
	}


	.content_main .box{
		/*width:100%;*/
		height: auto;
		background:#fff;
		margin-left:1%;
		border-radius:2px;
		margin-top:3px;
		position:relative;
	}

	.content_main .box-two {
		width:100%;
		height: auto;
		background:#fff;
		border-radius:2px;
		margin-top:3px;
		position:relative;
		margin-bottom: 10px;
	}

	.content_main .box-two .slide-banner {
		width:100%;
		height:12rem;
	}

	.content_main .box-two .shop-class {
		background: #fff;
		width:100%;
		height:40px;
		line-height: 40px;
		border-bottom: 1px solid #ccc;
	}

	.content_main .box-two .shop-class p {
		height: 40px;
	}

	.content_main .box-two .shop-class .class-item{
		float:left;color:#000;font-size:16px;
		padding-left:10px;
	}

	.content_main .box-two .shop-class  .shop-move {
		font-size:14px;
		float:right;color:#b3b3b3;
		padding-right:10px;
	}

	.content_main .box-two .shop-item {
		width: 32.1%;
		height: auto;
		background: #fff;
		float: left;
		margin: 0px 1.5px 1rem;
	}

	.content_main .box-two .shop-item .box-money {
		float: left;
		font-size: 14px;
		float: left;
		color: #f9ad0c;
		width: 75%;
		margin-top: 10px;
	}

	.content_main .box-two .shop-item .shop-name {
		height: 3.6rem;
		font-size: 13px;
		width: 100%;
		background: #fff;
		line-height: 20px;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	.content_main .box-two .shop-item .add-cart {
		width:25px;
		height:22px;
		display:block;
		float: right;
		background: url('../images/shopcar_youlike.png') no-repeat;
		background-size: 100%;
		margin-top: 10px;
	}

	.content_main .box .box-author {
		clear:both;
		position: absolute;
		bottom:0px;
		left:15%;
		font-size:14px;
	}

	.index-conten .imported-main {
		display: flex;
		flex-wrap:wrap;
		box-sizing:border-box;
	}

	.index-conten .imported-main .box {
		width: 33%;
		height: 100px;
		position: relative;
		border: 1px solid #ccc;
		border-bottom: none;
		border-right: none;
	}

	.index-conten .imported-main .box .style {
		/* padding: 2px; */
		background: #39b54a;
		width: 8px;
		height: 8px;
		display: block;
		float:left;
		margin: 4px 8px 0px 1px ;
	}

	.index-conten .imported-main .box .shop-name {
		position: absolute;
		top: 3px;
		left: 5px;
		display: block;
		width: 90%;
		height: 30px;
		font-size: 12px;
	}

	.index-conten .imported-main .box .shop-name span {
		color:#000;
		display: block;
	}


	.content_tianding .tainding_header {
		height:30px;
		width:100%;
		border-bottom:1px solid #ccc;
		clear:both;
	}

	.index-conten .tainding_header{
		width:100%;
		height:100%;
		box-sizing:border-box;
		border-bottom:1px solid #ccc;height:40px;line-height:4rem;
		background: #fff;
	}

	.index-conten .tainding_header p{color:#000000;font-size:12px;}

	.index-conten .tainding-main {
		width:100%;
		height:150px;
	}
	.index-conten .tainding-main .box {
		width:33.3%;
		height: 170px;
		float:left;
		position: relative;
		background: #fff;
	}

	.index-conten .tainding-main .box ul li {
		width:96%;
		height:30px;
		text-align:left;
		line-height:15px;
		margin:5px 0px 0px 5px;
		overflow: hidden;
		text-overflow: ellipsis;
	}

	.index-conten .tainding-main .box .add-cart {
		position: absolute;
		bottom: 15px;
		right: 6px;
		width: 22px;
		height: 20px;
	}

</style>

<template>


	<div class="index-conten">
		<div class="content_main">
			<template v-for='item in testarr'>
				<template v-if="item.type == 0">
					<div style="width: 100%;clear:both;">
						<template v-for='item1 in item.arr'>
							<template v-if="item.arr.length == 1">
								<div style="width:100%;float:left;">
									<a class="href-ui">
										<img :src="item1.url" alt="" style="width:100%;" />
									</a>
								</div>
							</template>
							<template v-if="item.arr.length == 2">
								<div style="width:50%;float:left;">
									<a class="href-ui" :href="'//'+item1.htmlurl">
										<img :src="item1.url" alt="" style="width:100%;" />
									</a>
								</div>
							</template>
							<template v-if="item.arr.length == 3">
								<div style="width:33.3%;float:left;">
									<a class="href-ui" :href="'//'+item1.htmlurl">
										<img :src="item1.url" alt="" style="width:100%;" />
									</a>
								</div>
							</template>
							<template v-if="item.arr.length == 4">
								<div style="width:25%;float:left;">
									<a class="href-ui" :href="'//'+item1.htmlurl" > <!-- :href="'//'+item1.htmlurl"  -->
										<img :src="item1.url" alt="" style="width:100%;" />
									</a>
								</div>
							</template>
						</template>
					</div>
				</template>

				<template v-if="item.type == 1 || item.type == 2 || item.type == 3">
					<div class="box-two" style="clear:both;">
						<template v-for='item1 in item.arr'>
							<div class="shop-item">
								<div style="width:100%;">
									<img :src="item1.shopshotcut" style="width: 100%;height:100%;" v-link="{name:'detail',params:{pid:item1.shopid}}" />
								</div>
								<p class="shop-name" style="">{{ item1.shopname }}</p>
								<p class="box-money" style="float:left;">
									<i style="font-size: 12px;">￥</i>
									<span style="font-size: 18px;">{{ item1.shopprice }}</span>
								</p>
								<p class="add-cart" @click="gocart(
									   item1.shopid,
									   item1.shopname,
									   item1.shopprice,
									   item1.shopshotcut,
									   item1.deliverytime,
									   item1.peisongok,
									   item1.activeid,
									   item1.activestu)" style="float:right;"></p>
							</div>
						</template>
					</div>
				</template>
				<template style="clear: both;"></template>
			</template>
		</div>
	</div>

	<!-- toast显示框 -->
	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>

</template>

<script>

    import Swiper from 'vux/src/components/swiper'
    import { setCartStorage } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'
    import Toast from 'vux/src/components/toast'
    import axios from 'axios'
    import qs from 'qs'

    export default{
        vuex: {
            getters: {
                cartNums
            },
            actions: {
                setCart: setCartStorage
            }
        },
		props: {
			testarr: [],
			list: []
		},
		data() {
			return {
                toastMessage: '',
                toastShow: false,
                buyNums: 1,
                proNums: 1,

			}
		},
        vuex: {
            getters: {
                cartNums
            },
            actions: {
                setCart: setCartStorage
            }
        },
		ready() {

        },
        components: {
            Swiper,
            Toast
        },
        methods: {
            gocart: function (oid,name,price,img,deliverytime,peisongok,activestu,activeid) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                let getUrl = '' , self = this;
                if(ustore == null) {
                    alert("没有登录，请先登录！");
                    setTimeout(function () {
                        self.$router.go({name: 'login'});
                    }, 800);
                    return false;
                } else if (ustore != null) {
                    var cart = JSON.parse(sessionStorage.getItem("myCart")), obj = {};
                    axios({
                        method: 'get',
                        url: localStorage.apiDomain + 'public/index/index/productdetail/uid/' + ustore.id + '/pid/' + oid,
                    }).then((response) => {
                        obj = {
                            id: oid,
                            name: name,
                            price: price,
                            shotcut: img,
                            deliverytime:deliverytime,
                            nums:this.buyNums,
                            store:this.proNums = response.data.store,
                            format: '',
                            formatName: '',
                            activestu: activestu,
                            peisongok:peisongok
                        }
                        if(peisongok == 0 && deliverytime == 1) {
                            alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                            return false;
                        } else if (activeid > 0) {
                            alert("这是限时抢购商品！");
                            return false;
                        }
                        if(sessionStorage.getItem("myCart") != '') {
                            for(var y in cart) {
                                if (cart[y]["deliverytime"] != deliverytime) {
                                    if (deliverytime == 0) {
                                        alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                        return false;
                                    } else if (deliverytime == 1) {
                                        alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                        return false;
                                    }
                                }
                            }
                        }
                        self.setCart(obj);
                        alert("加入购物车成功！");
                    });
				}
            }
		}
	}
</script>