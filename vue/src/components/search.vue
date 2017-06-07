<style>

	.wrapper-search{
		width:100%;
		font-size:0;
		margin-bottom:25px;
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

	.ui_box .img{
		width:100%;
		height:16rem;
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
		width: 2.5rem;
		float: right;
	}

</style>

<template>
	<div class="wrapper-search" style="padding:50px 0px 20px;">
		<template v-for="item in list">
			<div class="ui_box">
				<div v-link="{name:'detail',params:{pid:item.id}}">
					<div class="img"> <!--  v-lazy:background-image="item.src" -->
						<img :src="item.shotcut" style="width:100%;height:100%;" />
					</div>
					<div class="mes">
						<div class="name">
							{{ item.name }}
					</div>
					</div>
				</div>
				<div style="margin:0px 10px 10px;height: 20px;">
					<div class="money">
						<label class="unit">¥</label>{{ item.price }}
					</div>
					<div class="scar" @click="addCartShop(item)">
						<img src="../images/shopcar_youlike.png" style="width:100%;height:100%;"/>
					</div>
				</div>
			</div>
		</template>
	</div>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>

    import Toast from 'vux/src/components/toast'
    import { myActive,setCartStorage } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'

	export default{
		components: {
			Toast,
		},
        vuex: {
            actions: {
                myActive,
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
			}
		},
		ready() {

		},
		computed: {

		},
		methods: {
            addCartShop (data){
                //购物车缓存
                var date = new Date(), hours = date.getHours(), minute = date.getMinutes(), seconds = date.getSeconds();
                var minuteOfDay =  hours * 60  + minute; //从0:00分开是到目前为止的分钟数
                var start = 0 * 60; //开始时间
                var end = 20 * 60;  //结束时间
                if(data.peisongok == 0 && data.deliverytime == 1) {
                    alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                    return false;
                }
                if(cart != '') {
                    for(var y in cart) {
                        if (cart[y]["deliverytime"] != data.deliverytime) {
                            if (_self.list[y].deliverytime == 0) {
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
                    store:this.proNums,
                    format:'',
                    formatName:'',
                }
				this.setCart(obj);
                alert("加入购物车成功!");
			}
		}
	}
</script>