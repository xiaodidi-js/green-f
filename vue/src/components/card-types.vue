<style scoped>


	.type-bg {
		width:100%;
		height:100%;
		background: #fff;
		position: fixed;
		top:46px;
		left:0px;
	}


	.type-bg .cla-wrapper{
		width:29%;
		height:calc(100% - 100px);
		background: #f2f2f2;
		position:relative;
		top:0px;
		left:0px;
		overflow: hidden;
		overflow-y: auto;
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
		top: 0px;
		right: 0px;
		margin-bottom: 75px;
		overflow-x:hidden;
		overflow:hidden;
		overflow-y: auto;
		-webkit-overflow-scrolling: touch;
		-moz-overflow-scrolling: touch;
		-ms-overflow-scrolling: touch;
		-o-overflow-scrolling: touch;
		overflow-scrolling: touch;
	}

	.cla-message .ele-fixed {
		width: 100%;
		height: calc(100% - 100px);
		overflow:hidden;
		overflow-y:  auto;
		margin-bottom: 112px;
		transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1);
		transition-duration: 0ms;
		transform: translate(0px, 0px) translateZ(0px);
	}

	.cla-message .main {
		width: 95%;
		height: 87px;
		margin: 10px auto;
		border-bottom: 1px solid #ccc;
		clear: both;
		display: table;
		position: relative;
	}

	.cla-message .main .shotcut{
		width: 33%;
		height: 76px;
		background-color: #EFEFEF;
		background-size: cover;
		overflow: hidden;
		float: left;
	}

	.cla-message .main .shotcut .shotcut-img {
		width:100%;
		height:100%;
	}

	.shotcut-txt {
		width: 55%;
		float: left;
		line-height: 18px;
		font-size: 14px;
		text-align: left;
		margin-left: 10px;
		position: relative;
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
		width: 2.5rem;
		height: 2.2rem;
		background: url(../images/gouwuche.png) no-repeat;
		background-size: 100%;
		position: absolute;
		top:52px;
		right:0px;
	}

	#touch-ui {
		transition-timing-function: cubic-bezier(0.165, 0.84, 0.44, 1);
		transition-duration: 0ms;
		transform: translate(0px, 0px) translateZ(0px);
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

</style>

<template>
	<div class="type-bg" keep-alive>
		<div type="popup" class="cla-wrapper" id="left_Menu" style="float: left;">
			<div id="scroller">
				<div class="menu-left">
					<ul id="touch-ui">
						<li class="cla-card-li" style="border:none;" :class="{'active':dtype == item.id}" v-for="item in types" @click="getChonse(item.id)">
							<div class="menu-item" @click="chooseSort(item.id)">{{ item.name }}</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div type="popup" class="cla-message" id="right_Menu">
			<div id="scroller2">
				<div class="ele-fixed">
					<template v-for="item in pdata">
						<div class="main">
							<div v-link="{name:'detail',params:{pid:item.id}}">
								<div class="shotcut">
									<img :src="item.src" alt="{{ item.title }}" class="shotcut-img" style="width:100%;height:100%;" />
								</div>
								<div class="shotcut-txt">
									<p style="height:35px;width:100%;overflow: hidden;text-overflow: ellipsis;">{{ item.title }}</p>
									<p class="relative">
										<i>￥</i>
										<span class="money">{{item.price}}</span>
									</p>
								</div>
							</div>
							<div class="icon-card" @click="goCart(item)"></div>
						</div>
					</template>
				</div>
			</div>
		</div>
	</div>

	<!-- toast显示框 -->
	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>

</template>

<script>

    import Scroller from 'vux/src/components/scroller'
    import { setCartStorage } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'
	import formatPop from 'components/format-pop'
    import Toast from 'vux/src/components/toast'

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
            types: {
                type: Array,
                default() {
                    return []
                }
            }
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
                activestu:0
            }
        },
        ready() {
            this.dtype = sessionStorage.getItem('number');

            if(this.dtype == null) {
                this.chooseSort(26);
                this.getChonse(26);
                this.$router.go({name:'classify'});
			} else {
                this.chooseSort(this.dtype);
                this.getChonse(this.dtype);
			}

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
        },
        components: {
            Scroller,
            formatPop,
            Toast
		},
        methods: {
            addNums: function(){
                if(this.buyNums>=this.proNums){
                    return false;
                }
                this.buyNums++;
            },
            reduceNums: function() {
                if(this.buyNums <= 1) {
                    return false;
                }
                this.buyNums--;
            },
            hidePop: function(evt){
                evt.stopPropagation();
                this.popShow = false;
            },
            showFormatPop: function(){
                this.popShow = true;
            },
            onToure:function() {
                var myScroll_left;
                var myScroll_right;
                var intervalTime_left = null , intervalTime_right = null;
                intervalTime_left = setInterval(function() {
                    var resultContentH = $("#left_Menu").height();
                    if (resultContentH > 0) {
                        $("#left_Menu").height(resultContentH);
                        setTimeout(function () {
                            clearInterval(intervalTime_left);
                            myScroll_left = new IScroll('#left_Menu', {
                                vScroll: true,
                                mouseWheel: true,
                                vScrollbar: false,
                                probeType: 2,
                                click: true
                            });
                            myScroll_left.refresh();
                        }, 100);
                    }
                } ,10);

                intervalTime_right = setInterval(function() {
                    var resultContentH = $("#left_Menu").height();
                    if (resultContentH > 0) {
                        $("#left_Menu").height(resultContentH);
                        setTimeout(function () {
                            clearInterval(intervalTime_right);
                            myScroll_right = new IScroll('#right_Menu', {
                                vScroll: true,
                                mouseWheel: true,
                                vScrollbar: false,
                                probeType: 2,
                                click: true
                            });
                            myScroll_right.refresh();
                        }, 100);
                    }
                } ,10);
			},
            getChonse: function(type) {
                if(this.dtype == type) {
                    return true;
                }
                this.dtype = type;
                sessionStorage.setItem('number',this.dtype);
                this.menuIndex = type;
            },
            filters: {

			},
            chooseSort(cid){
                let url = localStorage.apiDomain + 'public/index/index/classifylist/cid/' + cid;
                this.$http.get(url).then((response)=>{
                    this.pdata = response.data.info.list;
                    console.log(this.pdata);
                },(response)=>{
                    this.toastMessage = "网络开小差啦~";
                    this.toastShow = true;
                });
            },
            comfirmFun: function (cid) {

            },
            goCart: function(data) {
                var obj = {} , _self = this, cart = JSON.parse(sessionStorage.getItem("myCart"));
                obj = {
                    id:data.id,
                    name:data.title,
                    price:data.price,
                    shotcut:data.src,
                    deliverytime:data.deliverytime,
                    activestu:data.activestu,
                    peisongok:data.peisongok,
                    nums:this.buyNums,
                    store:this.proNums,
                    format:'',
                    formatName:'',
                };
                //获取当前时间
                var date = new Date(), hours = date.getHours(), minute = date.getMinutes(), seconds = date.getSeconds();
                var minuteOfDay =  hours * 60  + minute; //从0:00分开是到目前为止的分钟数
                var start = 0 * 60; //开始时间
                var end = 13 * 60;  //结束时间
                if(data.peisongok == 0 && data.deliverytime == 1) {
                    alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                    return false;
                }
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
                this.setCart(obj);
                obj = {};
                alert("加入购物车成功");
			}
        },
    }
</script>