<template>
	<div class="msg-head">
		<div class="msg-back" @click="goback()"></div>
		<div class="msg-title">商品分类</div>
	</div>
	<div class="type-bg">
		<div type="popup" class="cla-wrapper" id="left_Menu" style="float: left;">
			<div id="scroller">
				<div class="menu-left">
					<ul id="touch-ui">
						<template v-for="item in types">
							<li class="cla-card-li" style="border:none;" :class="{'active':dtype == item.id}" @click="getChonse(item.id)">
								<div class="menu-item" @click="chooseSort(item.id)">{{ item.name }}</div>
							</li>
						</template>
					</ul>
				</div>
			</div>
		</div>
		<div type="popup" class="cla-message">
			<div style="background: #fff;">
				<div class="ele-fixed">
					<template v-for="item in pdata">
						<div class="main">
							<a style="display:block" v-link="{name:'detail',params:{pid:item.id}}"><!-- v-link="{name:'detail',params:{pid:item.id}}" -->
								<div class="shotcut" v-if="item.store == 0">
									<div class="qing">已售罄</div>
									<img :src="item.src" alt="" style="width:100%;height:100%;" />
									<!--<div class="shotcut-img" v-lazy:background-image="item.src"></div>-->
								</div>
								<div class="shotcut" v-else>
									<!--<div class="shotcut-img" v-lazy:background-image="item.src"></div>-->
									<img :src="item.src" alt="" style="width:100%;height:100%;" />
								</div>
								<div class="shotcut-txt">
									<p class="item-title" style="">{{ item.title }}</p>
									<p class="relative">
										<i>￥</i>
										<span class="money">{{item.price}}</span>
									</p>
								</div>
							</a>
							<div class="icon-card" @click="goCart(item)"></div>
						</div>
					</template>
				</div>
			</div>
		</div>
	</div>
	<!-- 回到顶部 -->
	<div class="goto-type" @click="todo()"></div>
	<!-- toast显示框 -->
	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>
	<!-- 弹出提示框 -->
	<alert :show.sync="alertShow" title="" button-text="知道了">
		<p>加入购物车成功!</p>
	</alert>
</template>

<script>
    import Scroller from 'vux/src/components/scroller'
    import { setCartStorage,clearAll } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'
    import formatPop from 'components/format-pop'
    import Toast from 'vux/src/components/toast'
    import axios from 'axios'
    import qs from 'qs'
    import Alert from 'vux/src/components/alert'
    export default{
        vuex: {
            getters: {
                cartNums
            },
            actions: {
                setCart: setCartStorage,
                clearAll,
            }
        },
        props: {
            types: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        components: {
            Scroller,
            formatPop,
            Toast,
            Alert,
        },
        data() {
            return {
                pdata: [],
                item: [],
                myScroll: '',
                dtype: null,
                guige: [],
                popShow: false,
                proNums: 1,
                buyNums: 1,
                toastMessage: '',
                toastShow: false,
                activestu:0,
                intervalTime_left: null,
                myScroll_left: null,
                alertShow: false,
            }
        },
        watch: {
            $route(to) {
                if(to.name === 'classify') {
                    this.readyData();
                }
            }
        },
        created() {
            this.readyData();
        },
        ready() {
            $(function() {
                //菜单框架自动获取高度
                var doc_H = $(document).height();
                $(".type-bg").height(doc_H);
                window.onresize = function(){
                    var doc_H = $(document).height();
                    $(".type-bg").height(doc_H);
                }
            });
            this.onToure();
            //  窗体滚动事件
            $(window).scroll(function() {
                if($(window).scrollTop() >= 350) {
                    $(".goto-type").fadeIn(500);
                } else {
                    $(".goto-type").stop(true,true).fadeOut(500);
                }
            });
        },
        methods: {
            goback () {
                window.history.back();
            },
            readyData() {
                this.dtype = sessionStorage.getItem('number');
                if(this.dtype == null) {
                    this.chooseSort(26);
                    this.getChonse(26);
                    this.$router.go({name:'classify'});
                } else {
                    this.chooseSort(this.dtype);
                    this.getChonse(this.dtype);
                }
            },
            todo() {
                $(window).scrollTop(0);
            },
            onToure() {
                var content = this;
                try {
                    content.intervalTime_left = setInterval(function() {
                        var resultContentH = $("#left_Menu").height();
                        if (resultContentH > 0) {
                            $("#left_Menu").height(resultContentH);
                            setTimeout(function () {
                                clearInterval(content.intervalTime_left);
                                content.myScroll_left = new IScroll('#left_Menu', {
                                    vScroll: true,
                                    mouseWheel: true,
                                    vScrollbar: false,
                                    probeType: 2,
                                    click: true,
                                    preventDefault:true,
                                });
                                content.myScroll_left.refresh();
                            }, 100);
                        }
                    } ,10);
                } catch (e) {
                    throw e;
                }
            },
            getChonse: function(type) {
                if(this.dtype == type) return true;
                this.dtype = type;
                sessionStorage.setItem('number',this.dtype);
                $(window).scrollTop(0);
            },
            filters: {
            },
            chooseSort(cid){
                this.$getData('/index/index/classifylist/cid/' + cid).then((res) => {
                    if (res.status == 1) {
                        this.pdata = res.info.list;
                        $("#scroller2").css({
                            "transform" : "translate(0px, 0px)"
                        });
                    }
                }).catch(function(e) {
                    console.log(e);
                });
            },
            goCart: function(data) {
                var obj = {} , self = this, cart = JSON.parse(localStorage.getItem("myCart"));
                if(this.$ustore == null) {
                    alert("没有登录，请先登录！");
                    setTimeout(function () {
                        self.clearAll();
                        self.$router.go({name: 'login'});
                    }, 800);
                    return false;
                } else if (this.$ustore != null) {
                    this.$getData('/index/index/productdetail/uid/' + this.$ustore.id + '/pid/' + data.id).then((res) => {
                        obj = {
                            id:data.id,
                            name:data.title,
                            price:data.price,
                            shotcut:data.src,
                            deliverytime:data.deliverytime,
                            activestu:data.activestu,
                            peisongok:data.peisongok,
                            activeid:data.activeid,
                            activepay:data.activepay,
                            nums:this.buyNums,
                            store:this.proNums = res.store,
                            format:'',
                            formatName:'',
                        };
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
//                        } else if(data.store == 0) {
//                            alert("已售罄");
//                            return false;
//                        } else if (data.activeid == 1) {
//                            alert("这是限时抢购商品！");
//                            return false;
//                        } else if (data.activestu == 2) {
//                            alert("请点击商品图片，进入商品详情页进入分享购买！");
//                            return false;
//                        }
                        if(sessionStorage.getItem("myCart") != '') {
                            for(var y in cart) {
                                if (cart[y]["deliverytime"] != data.deliverytime) {
                                    if (data.deliverytime == 0) {
                                        alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                        return false;
                                    } else if (data.deliverytime == 1) {
                                        alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                        return false;
                                    }
                                }
                            }
                        }
                        self.setCart(obj);
                        obj = {};
                        alert("加入购物车成功！");
                    });
                }
            }
        },
    }
</script>

<style scoped>
	.type-bg {
		width: 100%;
		height: 100%;
		background: #fff;
		/*position: fixed;*/
		top: 46px;
		left: 0px;
		display: flex;
		z-index: 9;
	}
	.type-bg .cla-wrapper {
		width:29%;
		height:calc(100% - 100px);
		background: #f2f2f2;
		position: fixed;
		top: 46px;
		left:0px;
		overflow: scroll;
		z-index: 9;
		-webkit-overflow-scrolling: touch;
		-moz-overflow-scrolling: touch;
		-ms-overflow-scrolling: touch;
		-o-overflow-scrolling: touch;
		overflow-scrolling: touch;
	}
	.type-bg .cla-wrapper #scroller {
		position: absolute;
		z-index: 1;
		-webkit-tap-highlight-color: rgba(0,0,0,0);
		width: 100%;
		-webkit-transform: translateZ(0);
		-moz-transform: translateZ(0);
		-ms-transform: translateZ(0);
		-o-transform: translateZ(0);
		transform: translateZ(0);
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
		-webkit-text-size-adjust: none;
		-moz-text-size-adjust: none;
		-ms-text-size-adjust: none;
		-o-text-size-adjust: none;
		text-size-adjust: none;
	}
	.type-bg .cla-wrapper .menu-left {
		height:calc(100% - 100px);
		margin-bottom:50px;
	}
	@media screen and (min-width: 414px){
		.type-bg .cla-wrapper{
			height:87%;
		}
	}
	.cla-wrapper .menu-item{
		vertical-align: top;
		width: 100%;
		height: 45px;
		font-size: 1.4rem;
		text-align: center;
		max-width: 92%;
		color: #73a523;
		line-height: 45px;
		margin: 0px 4px;
		word-wrap:break-word;
		word-break:break-all;
	}
	.cla-message {
		float: right;
		width: 72%;
		height: 100%;
		position: absolute;
		top: 50px;
		right: 0px;
		margin-bottom: 75px;
		/*overflow-y: scroll;*/
		z-index: 1;
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		-webkit-overflow-scrolling: touch;
		-moz-overflow-scrolling: touch;
		-ms-overflow-scrolling: touch;
		-o-overflow-scrolling: touch;
		overflow-scrolling: touch;
	}
	.cla-message .ele-fixed {
		width: 100%;
		height: calc(100% - 100px);
		/*overflow:hidden;*/
		overflow-y:  scroll;
		margin-bottom: 112px;
	}
	.cla-message .main {
		width: 95%;
		height: 100%;
		margin: 0px auto;
		border-bottom: 1px solid #ccc;
		clear: both;
		display: table;
		position: relative;
		padding: 10px 0px 10px;
	}
	.cla-message .main .shotcut {
		width: 33%;
		height: 100%;
		background-size: cover;
		overflow: hidden;
		position: relative;
		float: left;
	}
	.cla-message .main .shotcut .qing {
		text-align:center;
		width:100%;
		height:100%;
		line-height: 76px;
		color:#fff;
		font-size:16px;
		position: absolute;
		top:0px;
		left:0px;
		z-index: 1;
		background: rgba(0,0,0,0.5);
	}
	.cla-message .main .shotcut .shotcut-img {
		width: 100%;
		padding-top:100%;
		background-repeat: no-repeat;
		background-size: 100%;
	}
	.shotcut-txt {
		width: 62%;
		float: left;
		line-height: 18px;
		font-size: 14px;
		text-align: left;
		margin-left: 10px;
		position: relative;
	}
	.item-title {
		height:35px;
		width:100%;
		overflow: hidden;
		text-overflow: ellipsis;
		color:#333;
	}
	.shotcut-txt .money {
		font-size:22px;
	}
	.shotcut-txt .relative {
		color:#f9ad0c;margin-top: 20px;
	}
	.main .icon-card {
		display:block;
		float:right;
		width: 30px;
		height: 30px;
		background: url('../images/addcart.png') no-repeat;
		background-size: 100%;
		position: absolute;
		top: 60px;
		right:0px;
	}
	#touch-ui {
		height: 550px;
	}
	#touch-ui .isChonse {
		background: #fff;
	}
	.active {background: #fff;}
	.type-bg .xs-container {
		width:100%;
		height:100%;
	}
	.fpmasker{
		position:fixed;
		top:0;
		left:0;
		width:0%;
		height:0%;
		z-index:98;
		background-color:transparent;
	}
	.fpmasker.show{
		width:100%;
		height:100%;
		background-color:rgba(0,0,0,0.6);
		display:block;
		transition:background .5s;
		-webkit-transition:background .5s;
	}
	.format-pop{
		width:100%;
		box-sizing:border-box;
		height:auto;
		background-color:#fff;
		padding:1rem;
		position:fixed;
		bottom:0rem;
		left:0;
		z-index:99;
		transform:scale(0);
		-webkit-transform:scale(0);
	}
	.format-pop .priceButton {
		width:100%;height:3.5rem;clear:both;
	}
	.format-pop .priceButton .price-pop {
		width:100%;height:100%;border:1px solid #c40000;color:#fff;background: #c40000;text-align:center;line-height:3.5rem;
	}
	.format-pop.show{
		transform:scale(1);
		-webkit-transform:scale(1);
		transition:transform .3s;
		-webkit-transition:transform .3s;
	}
	.format-pop .line .pimg{
		box-sizing:border-box;
		width:25%;
		padding-top:25%;
		border:#fff solid 0.3rem;
		border-radius:0.3rem;
		background-color:#efefef;
		background-position:center;
		background-size:cover;
		background-repeat:no-repeat;
		position:absolute;
		top:-5%;
	}
	.format-pop .line .pmes{
		box-sizing:border-box;
		width:65%;
		height:auto;
		position:absolute;
		top:0;
		left:30%;
		margin-top:3%;
	}
	.format-pop .line .pmes div{
		font-size:1.4rem;
		color:#808080;
	}
	.format-pop .line .pmes div.price{
		color:#F26C60;
	}
	.format-pop .close{
		width:1.8rem;
		height:1.8rem;
		border-radius:0.9rem;
		background:rgba(130,130,130,0.2);
		color:#fff;
		line-height:1.8rem;
		font-size:1.2rem;
		text-align:center;
		position:absolute;
		top:1rem;
		right:1rem;
	}
	.format-pop .line .title{
		font-size:1.4rem;
		color:#666;
		margin:0.68rem 0rem;
	}
	.format-pop .line .title.inline{
		display:inline-block;
		width:30%;
		vertical-align:middle;
		font-size:1.4rem;
	}
	.format-pop .line .con.inline{
		display:inline-block;
		width:70%;
		vertical-align:middle;
	}
	.format-pop .line .con.inline .num-counter{
		text-align:right;
	}
	.num-counter{
		max-width:100%;
		height:auto;
		text-align:left;
		font-size:0;
		overflow:hidden;
	}
	.num-counter .btns{
		display:inline-block;
		vertical-align:top;
		width:2.5rem;
		height:2.5rem;
		line-height:2.5rem;
		font-size:1.6rem;
		font-weight:bold;
		color:#333;
		border:#ccc solid 1px;
		text-align:center;
	}
	.num-counter .btns.disabled{
		color:#ccc;
	}
	.num-counter .btns.disabled:active{
		background-color:#fff;
	}
	.num-counter .btns:active{
		background-color:#ccc;
	}
	.num-counter .input{
		display:inline-block;
		vertical-align:top;
		width:6rem;
		height:2.5rem;
		line-height:2.5rem;
		font-size:1.4rem;
		color:#333;
		border-top:#ccc solid 1px;
		border-bottom:#ccc solid 1px;
		border-radius:0;
		text-align:center;
	}
	.fpmasker.show{
		width:100%;
		height:100%;
		background-color:rgba(0,0,0,0.3);
		display:block;
		transition:background .5s;
		-webkit-transition:background .5s;
	}
	.goto-type {
		width:3.7rem;
		height:3.7rem;
		background: url(../images/img13.png) no-repeat;
		background-size: 100%;
		position: fixed;
		right: 25px;
		bottom: 6.5rem;
		z-index:1000;
		display:block;
	}
</style>
