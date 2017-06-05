<style>

	.wrapper{
		width:100%;
		font-size:0;
	}

	.wrapper.nopadding{
		padding-bottom: 0;
	}

	.wrapper .title{
		display:block;
		margin:0.5rem 0rem 1rem 0rem;
		font-size:1.4rem;
		color:#F9AD0C;
		font-weight:normal;
		letter-spacing:1px;
		border-left:#F9AD0C solid 5px;
		padding-left:0.8rem;
	}

	.wrapper .ui_box {
		width: 48%;
		height: auto;
		background-color: #fff;
		display: inline-block;
		font-size: 1.6rem;
		margin: 4px 2.9px;
		color: #333;
		box-shadow: 1px 1px 2px #e2e2e2;
	}

	.wrapper .ui_box:nth-child(even){
		margin-right:0%;
	}

	.wrapper .ui_box:nth-last-child(2),.wrapper .ui_box:last-child{
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

	.wrapper .ui_box .mes{
		padding:0.7rem 0.5rem;

	}

	.wrapper .ui_box .mes .name{
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

	.wrapper .ui_box .money{
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

	.wrapper .ui_box .scar {
		width: 2.5rem;
		/* height: 3rem; */
		float: right;
	}

</style>

<template>
	<div class="wrapper" style="padding:50px 0px 20px;">
		<template v-for="item in arr">
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
					<div class="scar" @click="addCartShop(item.id)">
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
				listArr: [],
                activestu:0,
                buyNums:1,
                proNums:1,
			}
		},
		ready() {
			this.keyCodefun();
			sessionStorage.setItem("arr",this.arr);
			console.log(sessionStorage.getItem("arr"));
			console.log(this.listArr);
		},
		computed: {

		},
		methods: {
            addCartShop (id){
                //购物车缓存
                var cart = JSON.parse(sessionStorage.getItem("myCart")) , obj = {} , _self = this;
                if(cart != '') {
                    console.log(1);
                    for(var y in cart) {
                        if (cart[y]["deliverytime"] != _self.arr[y].deliverytime) {
                            if (_self.arr[y].deliverytime == 0) {
                                alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                return false;
                            } else if (_self.arr[y].deliverytime == 1) {
                                alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                return false;
                            }
                        }
                    }
                }
                for(var i in this.arr) {
                    obj = {
                        id:id,
                        name:this.arr[i].name,
                        price:this.arr[i].price,
                        shotcut:this.arr[i].shotcut,
                        deliverytime:this.arr[i].deliverytime,
                        nums:this.buyNums,
                        store:this.proNums,
                        activestu:this.activestu,
                        format:'',
                        formatName:'',
					}
				}
				this.setCart(obj);
                alert("加入购物车成功!");
			},
            keyCodefun: function (event) {
                var _this = this;
                var e = event || window.event;
                if(e && e.keyCode == 13) {
                    _this.goSearch();
                }
            },
            goSearch: function() {
				this.searchKey = this.searchKey.replace(/(^\s*)|(\s*$)/g,'');
				if(this.searchKey === "") {
                    this.toastMessage = "请输入关键字...";
                    this.toastShow = true;
				}
				if(this.searchKey.length <= 0) {
					return false;
				}
				this.$dispatch('goSearch',this.searchKey);
			}
		}
	}
</script>