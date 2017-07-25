<template>
	<template v-if="info.title">
		<div class="wrapper-ele" style="padding-bottom: 100px;" :class="{'nopadding':noPadding}" >
			<label class="title">{{ info.title }}</label>
			<div class="parent">
				<div class="ui-box" v-for="item in info.list">
					<div @click="goPage('detail', {pid:item.id})">
						<div class="img" v-if="item.store == 0">
							<div class="qing">已售罄</div>
							<!--<div v-lazy:background-image="item.src" class="lazyImg"></div>-->
							<img :src="item.src" alt="" style="width:100%;height:100%;" />
						</div>
						<div class="img" v-else>
							<!--<div v-lazy:background-image="item.src" class="lazyImg"></div>-->
							<img :src="item.src" alt="" style="width:100%;height:100%;" />
						</div>
						<div class="mes">
							<div class="name">{{ item.title }}</div>
						</div>
					</div>
					<div style="padding-bottom: 25px;margin: 0px 5px;">
						<div class="money">
							<label class="unit">¥</label>{{ item.price }}
						</div>
						<div class="scar" @click="addCart(item)">
							<img src="../images/shopcar_youlike.png" style="width:100%;height:100%;"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</template>
	<template v-else>
		<div class="wrapper-ele" :class="{'nopadding':noPadding}" >
			<template v-for="item in info.list">
				<div class="ui_box">
					<div @click="goPage('detail', {pid:item.id})">
						<div class="img" v-if="item.store == 0" v-bind:style="{backgroundImage:'url('+ item.src +')'}">
							<div class="qing">已售罄</div>
							<!--<div v-lazy:background-image="item.src" class="lazyImg"></div>-->
							<!--<img :src="item.src" alt="" style="width:100%;height:100%;" />-->
						</div>
						<div class="img" v-else v-bind:style="{backgroundImage:'url('+ item.src +')'}">
							<!--<div v-lazy:background-image="item.src" class="lazyImg"></div>-->
							<!--<div class="img" v-bind:style="{backgroundImage:'url('+ item.src +')'}"></div>-->
							<!--<img :src="item.src" alt="" style="width:100%;height:100%;" />-->
						</div>
						<div class="mes">
							<div class="name">{{ item.title }}</div>
						</div>
					</div>
					<div style="padding-bottom: 25px;margin: 10px 5px;">
						<div class="money">
							<label class="unit">¥</label>{{ item.price }}
					</div>
						<div class="scar" @click="addCart(item)">
							<img src="../images/shopcar_youlike.png" style="width:100%;height:100%;"/>
						</div>
					</div>
				</div>
			</template>
		</div>
	</template>
	<!-- 弹出提示框 -->
	<alert :show.sync="alertShow" title="" button-text="知道了">
		<p>加入购物车成功!</p>
	</alert>
</template>

<script>

    import { setCartStorage,clearAll } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'
    import axios from 'axios'
    import qs from 'qs'
    import Alert from 'vux/src/components/alert'

	export default{
        ready() {

		},
		props: {
			info: {
				type: Object,
				required: true
			},
			noPadding: {
				type: Boolean,
				default: false
			}
		},
        vuex: {
            actions: {
                setCart:setCartStorage,
                clearAll,
            }
        },
        components: {
            Alert,
		},
		data() {
			return {
                buyNums:1,
                proNums:1,
                alertShow: false,
			}
		},
		methods: {
            goPage(name,params) {
                this.$router.go({name:name,params:params});
			},
            addCart (data) {
                var obj = {} , cart = JSON.parse(localStorage.getItem("myCart")), self = this;
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
                            id: data.id,
                            name: data.title,
                            price: data.price,
                            shotcut: data.src,
                            deliverytime: data.deliverytime,
                            activestu: data.activestu,
                            peisongok: data.peisongok,
                            activeid:data.activeid,
                            activepay:data.activepay,
                            nums: this.buyNums,
                            store: this.proNums,
                            formatName: '',
                            format: '',
                        };
                        if(data.peisongok == 0 && data.deliverytime == 1) {
                            alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                            return false;
                        } else if(data.peisongok == 0 && data.deliverytime == 0) {
                            alert("抱歉，次日配送商品已截单。请到当日配送专区选购，谢谢合作！");
                            return false;
                        } else if(data.store == 0) {
                            alert("已售罄");
                            return false;
                        } else if (data.activeid == 1) {
                            alert("这是限时抢购商品！");
                            return false;
                        } else if (data.activestu == 2) {
                            alert("这是限时分享商品！");
                            return false;
                        }
                        if(cart != '') {
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
                        alert("加入购物车成功!");
                    });
				}
			},
		}
	}
</script>
<style type="text/css">
	.wrapper-ele{
		height: 100%;
		overflow: hidden;
		padding: 5px 4px 3rem;
	}

	.wrapper-ele.nopadding{
		padding-bottom: 3rem;
		height: 100%;
		overflow: hidden;
	}

	.wrapper-top {
		margin-top: 166px;
	}

	.wrapper-ele .title{
		display:block;
		margin:0.5rem 0rem 1rem 0rem;
		font-size:1.4rem;
		color:#F9AD0C;
		font-weight:normal;
		letter-spacing:1px;
		border-left:#F9AD0C solid 5px;
		padding-left:0.8rem;
	}

	.wrapper-ele .ui_box {
		width: 49.2%;
		/* height: auto; */
		background-color: #fff;
		display: block;
		float: left;
		font-size: 1.6rem;
		overflow: hidden;
		margin-right: 5px;
		margin-top: 5px;
		color: #333;
		box-shadow: 1px 1px 2px #e2e2e2;
	}

	/*@media screen and (max-width: 600px) {*/
		/*.wrapper .ui_box {*/
			/*width: 146px;*/
			/*height: 230px;*/
		/*}*/
	/*}*/

	/*@media screen and (max-width: 414px) {*/
		/*.wrapper .ui_box {*/
			/*width: 203px;*/
			/*height: 290px;*/
		/*}*/
	/*}*/

	/*@media screen and (max-width: 412px) {*/
		/*.wrapper .ui_box {*/
			/*width: 202px;*/
			/*height: 285px;*/
		/*}*/
	/*}*/

	/*@media screen and (max-width: 384px) {*/
		/*.wrapper .ui_box {*/
			/*width: 188px;*/
			/*height: 270px;*/
		/*}*/
	/*}*/

	/*@media screen and (max-width: 375px) {*/
		/*.wrapper .ui_box {*/
			/*width: 183px;*/
			/*height: 265px;*/
		/*}*/
	/*}*/

	/*@media screen and (max-width: 360px) {*/
		/*.wrapper .ui_box {*/
			/*width: 176px;*/
			/*height: 260px;*/
		/*}*/
	/*}*/

	/*@media screen and (max-width: 320px) {*/
		/*.wrapper .ui_box {*/
			/*width: 156px;*/
			/*height: 240px;*/
		/*}*/
	/*}*/

	.wrapper-ele .ui_box:nth-child(even){
		margin-right: 0%;
	}

	.wrapper-ele .ui_box:nth-last-child(2),.wrapper .ui_box:last-child{
		margin-bottom: 0%;
	}

	.parent{
		width:100%;
		height:auto;
		margin:0;
		padding:0;
	}

	.wrapper-ele .ui_box .img{
		width: 100%;
		position: relative;
		height: auto;
		padding-top: 100%;
		background-size: cover;
		background-position:center;
	}

	.wrapper-ele .ui_box .img .lazyImg {
		width:100%;
		padding-top:100%;
	}

	.wrapper-ele .ui_box .img .qing {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		font-size: 26px;
		line-height: 200px;
		color: #fff;
		text-align: center;
		z-index: 1;
		background: rgba(0,0,0,0.5);
	}

	.wrapper-ele .ui_box .mes{
		padding:0.7rem 0.5rem;
	}

	.wrapper-ele .ui_box .mes .name{
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
		font-weight:600;
	}

	.ui_box .money{
		font-size: 1.8rem;
		color: #F9AD0C;
		float: left;
		width: 5rem;
	}

	.ui_box .scar {
		float:right;
		width:2.5rem;
		height:2.1rem;
	}

	.ui_box .money .unit{
		font-size:1.2rem;
		margin-right:0.2rem;
	}
</style>