<template>
	<div class="msg-head">
		<div class="msg-back" @click="goback()"></div>
		<div class="msg-title message-title">搜索商品</div>
	</div>
	<div class="wrapper-search" style="padding: 50px 0px 20px;">
		<template v-for="item in list">
			<div class="ui_box">
				<div v-link="{name:'detail',params:{pid:item.id}}">
					<div class="img" v-if="item.store == 0">
						<div class="qing">已售罄</div>
						<!--<img :src="item.shotcut" alt="" style="width:100%;height:100%;" />-->
						<div class="shotcut" v-bind:style="{backgroundImage:'url('+ item.shotcut +')'}"></div>
					</div>
					<div class="img" v-else>
						<!--<img :src="item.shotcut" alt="" style="width:100%;height:100%;" />-->
						<!--<div class="shotcut" v-lazy:background-image="item.shotcut"></div>-->
						<div class="shotcut" v-bind:style="{backgroundImage:'url('+ item.shotcut +')'}"></div>
					</div>
					<div class="mes">
						<div class="name">{{ item.name }}</div>
					</div>
				</div>
				<div style="margin:0px 10px 10px;height: 20px;">
					<div class="money">
						<label class="unit">¥</label>{{ item.price }}
					</div>
					<div class="scar" @click="addCart(item)">
						<img src="../images/addcart.png" style="width:100%;height:100%;"/>
					</div>
				</div>
			</div>
		</template>
	</div>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	<div class="goto"></div>
	<!-- 弹出提示框 -->
	<alert :show.sync="alertShow" title="" button-text="知道了">
		<p>加入购物车成功!</p>
	</alert>
</template>

<script>

    import Toast from 'vux/src/components/toast'
    import { myActive,setCartStorage,clearAll } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'
    import axios from 'axios'
    import qs from 'qs'
    import Alert from 'vux/src/components/alert'

	export default{
		components: {
			Toast,
            Alert
		},
        vuex: {
            actions: {
                myActive,
                clearAll,
                setCart:setCartStorage
            }
        },
        props: {
            infoText: {}
        },
		data() {
			return {
                toastMessage:'',
                toastShow:false,
				searchKey: '',
				arr:this.$store.state.shopname,
				list: JSON.parse(sessionStorage.getItem("serach")),
                activestu:0,
                buyNums:1,
                proNums:1,
                alertShow: false,	//	弹窗开关
			}
		},
		ready() {
            $(".goto").click(function(){
                $("html,body").animate({
                    scrollTop:0
                },200);
            });
            $(".group").css({"color":"#81c429"});
		},
        watch: {
            $route(to) {
				if(to.name === 'search') {
                    $(".group").css({"color":"#ccc"});
					var listData = JSON.parse(sessionStorage.getItem("serach"));
					this.list = listData;
                    $(".group").css({"color":"#81c429"});
				}
            }
        },
		computed: {

		},
		methods: {
			goback () {
				window.history.back();
			},
            addCart (data){
                //购物车缓存
                var date = new Date(), hours = date.getHours();
                var cart = JSON.parse(localStorage.getItem("myCart")) , obj = {} , self = this;
                if(this.$ustore == null) {
                    alert("没有登录，请先登录！");
                    setTimeout(function () {
                        self.clearAll();
                        self.$router.go({name: 'login'});
                    }, 800);
                    return false;
				} else if (this.$ustore != null) {
                    this.$getData('/index/index/productdetail/uid/' + this.$ustore.id + '/pid/' + data.id).then((res) => {
                        switch (true) {
							case data.peisongok == 0 && data.deliverytime == 1:
                                alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                                return false;
                            case data.peisongok == 0 && data.deliverytime == 0:
                                alert("抱歉，次日配送商品已截单。请到当日配送专区选购，谢谢合作！");
                                return false;
							case data.store == 0:
                                alert("已售罄");
                                return false;
                            case data.activeid == 1:
                                alert("这是限时抢购商品！");
                                return false;
							case data.activestu == 2:
                                alert("请点击商品图片，进入商品详情页进行分享购买！");
                                return false;
						}
//                        if(data.peisongok == 0 && data.deliverytime == 1) {
//                            alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
//                            return false;
//                        } else if(data.peisongok == 0 && data.deliverytime == 0) {
//                            alert("抱歉，次日配送商品已截单。请到当日配送专区选购，谢谢合作！");
//                            return false;
//                        } else if (data.store == 0) {
//                            alert("已售罄");
//                            return false;
//                        } else if (data.activeid == 1) {
//                            alert("这是限时抢购商品！");
//                            return false;
//                        } else if (data.activestu == 2) {
//                            alert("请点击商品图片，进入商品详情页进行分享购买！");
//                            return false;
//                        }
                        if(cart != '') {
                            for(var y in cart) {
                                if (cart[y]["deliverytime"] != data.deliverytime) {
                                    if (self.list[y].deliverytime == 0) {
                                        alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                        return false;
                                    } else if (data.deliverytime == 1) {
                                        alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                        return false;
                                    }
                                }
                            }
                        }
                        obj = {
                            id:data.id,
                            name:data.name,
                            price:data.price,
                            shotcut:data.shotcut,
                            deliverytime:data.deliverytime,
                            peisongok:data.peisongok,
                            activestu:data.activestu,
                            nums:this.buyNums,
                            store:this.proNums = res.store,
                            format:'',
                            formatName:'',
                        }
                        this.setCart(obj);
                        alert("加入购物车成功！");
					});
				}
			}
		}
	}
</script>

<style>
	.wrapper-search {
		font-size:0;
		margin: 0px 2px 25px;
		overflow: hidden;
	}

	.wrapper-search.nopadding{
		padding-bottom: 0;
	}

	.wrapper-search .title{
		display:block;
		margin:0.5rem 0rem 1rem 0rem;
		font-size:1.4rem;
		color:#F9AD0C;
		font-weight:normal;
		letter-spacing:1px;
		border-left:#F9AD0C solid 5px;
		padding-left:0.8rem;
	}

	.wrapper-search .ui_box {
		width: 48%;
		height: auto;
		background-color: #fff;
		display: block;
		float:left;
		font-size: 1.6rem;
		margin: 4px 2.9px;
		color: #333;
		box-shadow: 1px 1px 2px #e2e2e2;
	}

	.wrapper-search .ui_box:nth-child(even){
		margin-right:0%;
	}

	.wrapper-search .ui_box:nth-last-child(2),.wrapper-search .ui_box:last-child{
		/*margin-bottom:3%;*/
	}

	.parent{
		width:100%;
		height:auto;
		margin:0;
		padding:0;
	}


	.wrapper-search .ui_box .mes{
		padding:0.7rem 0.5rem;

	}

	.wrapper-search .ui_box .mes .name{
		font-size:1.4rem;
		color:#333;
		line-height:1.8rem;
		max-height:3.6rem;
		height:3.6rem;
		overflow:hidden;
		text-overflow:ellipsis;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		word-wrap:break-word;
		font-weight:600;
	}

	.wrapper-search .ui_box .money{
		font-size:1.6rem;
		color:#F9AD0C;
		width: 40%;
		float: left;
	}

	.mes .money .unit{
		font-size:1.2rem;
		margin-right:0.2rem;
		float:left;
	}

	.wrapper-search .ui_box .scar {
		width: 30px;
		height: 30px;
		position: relative;
		top: -7px;
		float: right;
	}

	.wrapper-search .ui_box .img {
		position: relative;
		width:100%;
		height: auto;
	}

	.wrapper-search .ui_box .img .qing {
		position: absolute;
		top:0px;
		left:0px;
		width:100%;
		height: 100%;
		text-align:center;
		font-size:3rem;
		background: rgba(0,0,0,0.5);
		line-height: 16rem;
		color:#fff;
		z-index: 1;
	}

	.wrapper-search .ui_box .img .shotcut {
		width: 100%;
		padding-top: 100%;
		background-size: 100%;
		background-repeat: no-repeat;
	}

</style>