<template>
	<template v-for="item in info">
		<div v-for="list in item.data" v-if="list.data !== '' ">
			<div class="card-box" style="box-shadow: none;">
				<div v-link="{name:'detail',params:{pid:list.id}}">
					<div class="pict" v-if="list.store == 0">
						<div class="qing">已售罄</div>
						<div class="img" v-bind:style="{backgroundImage:'url('+ list.shotcut +')'}"></div>
					</div>
					<div class="pict" v-else>
						<div class="img" v-bind:style="{backgroundImage:'url('+ list.shotcut +')'}"></div>
					</div>
					<div class="mes">
						<div class="name">{{ list.name }}</div>
					</div>
				</div>
				<div class="money">
					<label class="unit">¥</label>
					<label>{{ list.price }}</label>
				</div>
				<div class="icon_shopcar" @click="addCart(list)"></div>
			</div>
			<div class="card-box" style="box-shadow: none;">
				<div class="shopnull">暂没有推荐商品</div>
			</div>
		</div>
	</template>
	<div class="nothings" v-else>
		<span>—————&nbsp;&nbsp;暂时没有推荐商品&nbsp;&nbsp;—————</span>
	</div>
</template>

<script>

    import axios from 'axios'
    import qs from 'qs'
    import { setCartStorage } from 'vxpath/actions'

	export default{
        vuex: {
            actions: {
                setCart: setCartStorage,
            }
        },
		props: {
			info: {
				type: Object,
				default() {
					return []
				}
			},
			cardWidth: {
				type: Number,
				default: 0
			}
		},
		data() {
			return {
				list: [],
                buyNums: 1,
                proNums: 1,
			}
		},
		ready () {

		},
        computed () {

		},
		methods: {
			addCart(data) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
				var obj = {}, content = this , cart = sessionStorage.getItem("myCart");
                axios({
                    method: 'get',
                    url: localStorage.apiDomain + 'public/index/index/productdetail/uid/' + ustore.id + '/pid/' + data.id,
                }).then((response) => {
                    obj = {
                        id:data.id,
                        name:data.name,
                        price:data.price,
                        shotcut:data.shotcut,
                        deliverytime:data.deliverytime,
                        peisongok:data.peisongok,
                        activestu:data.activestu,
                        nums:this.buyNums,
                        store:this.proNums = response.data.store,
                        format:'',
                        formatName:'',
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
                    } else if (data.activeid > 0) {
                        alert("这是限时抢购商品！");
                        return false;
                    }
                    if(cart != '') {
                        for(var y in cart) {
                            if (cart[y]["deliverytime"] != data.deliverytime) {
                                if (data.deliverytime == 0) {
                                    alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                    return false;
                                } else if (data.deliverytime == 1) {
                                    alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！！");
                                    return false;
                                }
                            }
                        }
                    }
                    this.setCart(obj);
                    obj = {};
                    alert("成功加入购物车!");
                });
			}
		}
	}
</script>

<style scoped>

	.nothings {
		height: 60px;
		line-height: 45px;
		text-align: center;
		font-size: 14px;
		color: #808080;
	}

	.card-box{
		width:31.1%;
		height:auto;
		margin:0rem 0rem 1rem 0.5rem;
		background-color:#fff;
		display:inline-block;
		font-size:1.6rem;
		color:#333;
		float:left;
		/*box-shadow:1px 1px 2px #e2e2e2;*/
	}

	.card-box:nth-of-type(1) {
		margin-right:0.39rem;
	}

	.card-box .shopnull {
		text-align:center;
		width:100%;
		height:360px;
		font-size:16px;
	}

	.card-box:last-child{
		margin-right:0%;
	}

	.card-box .img{
		width:100%;
		padding-top:90%;
		background-position:center;
		background-size:cover;
		background-color:#e4e4e4;
	}

	.icon_shopcar img{
		width:100%;
		height:100%;
		background-size:100%;
	}

	.mes{
		padding: 5% 0%;
	}

	.mes .name{
		font-size:1.4rem;
		color:#333;
		line-height:1.6rem;
		max-height:3.2rem;
		height:3.2rem;
		overflow:hidden;
		text-overflow:ellipsis;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		white-space:normal;
	}

	.card-box  .money{
		font-size:1.8rem;
		color:#F9AD0C;
		float:left;
	}

	.card-box  .money .unit{
		font-size:1.2rem;
		margin-right:0.2rem;
	}

	.icon_shopcar{
		width: 30%;
		height: 2.5rem;
		line-height: 2.806rem;
		float: right;
		text-align: right;
		background: url('../images/gouwuche.png') no-repeat;
		background-size: 95%;
	}

	.pict {
		position: relative;
	}

	.pict .qing {
		position: absolute;
		top: 0px;
		left: 0px;
		width:100%;
		height:100%;
		text-align: center;
		line-height: 9rem;
		font-size:16px;
		color:#fff;
		background: rgba(0,0,0,0.5);
	}

</style>