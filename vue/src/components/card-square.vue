<style scoped>
	.wrapper{
		width:100%;
		padding:0rem 0rem 1rem 0rem;
		font-size:0;
		margin-bottom:25px;
		overflow: hidden;
	}

	.wrapper.nopadding{
		padding-bottom: 0;
	}

	.wrapper-top {
		margin-top: 166px;
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
		width: 47%;
		height: auto;
		background-color: #fff;
		display: block;
		float:left;
		font-size: 1.6rem;
		margin: 4px 5.5px;
		color: #333;
		box-shadow: 1px 1px 2px #e2e2e2;
	}

	.wrapper .ui_box:nth-child(even){
		margin-right:0%;
	}

	.wrapper .ui_box:nth-last-child(2),.wrapper .ui_box:last-child{
		margin-bottom:0%;
	}

	.parent{
		width:100%;
		height:auto;
		margin:0;
		padding:0;
	}

	.img{
		width:100%;
		background-position:center;
		background-size:cover;
		background-repeat:no-repeat;
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

<template>
	<template v-if="info.title">
		<div class="wrapper" style="padding-bottom: 100px;" :class="{'nopadding':noPadding}" >
			<label class="title">{{ info.title }}</label>
			<div class="parent">
				<div class="ui-box" v-for="item in info.list">
					<div v-link="{name:'detail',params:{pid:item.id}}">
						<div class="img" v-if="item.src == ''"></div>
						<div class="img" v-else>
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
						<div class="scar" @click="addCart(item.id)">
							<img src="../images/shopcar_youlike.png" style="width:100%;height:100%;"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</template>
	<template v-else>
		<div class="wrapper" :class="{'nopadding':noPadding}" >
			<div class="ui_box" v-for="item in info.list">
				<div v-link="{name:'detail',params:{pid:item.id}}">
					<div class="img" v-if="item.src == ''"></div>
					<div class="img" v-else>
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
					<div class="scar" @click="addCart(item.id)">
						<img src="../images/shopcar_youlike.png" style="width:100%;height:100%;"/>
					</div>
				</div>
			</div>
		</div>
	</template>

	<!--<div class="wrapper" style="padding-bottom: 70px;" :class="{'nopadding':noPadding}">-->
		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--本地四季豆 500g/份-->
				<!--</div>-->
			<!--</div>-->
			<!--<div style="padding-bottom: 25px;margin: 0px 5px;">-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
					<!--</div>-->
				<!--<div class="scar">-->
					<!--<img src="../images/shopcar_youlike.png" style="width:100%;height:100%;"/>-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->
	<!--</div>-->


</template>

<script>

    import { setCartStorage } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'

	export default{
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
                setCart:setCartStorage
            }
        },
		data() {
			return {
                buyNums:1,
                proNums:1,
			}
		},
		methods: {
            addCart (id) {
                var obj = {};
                //购物车缓存
                var cart = JSON.parse(sessionStorage.getItem("myCart")), _self = this;
                for(var i in this.info.list) {
                    if(this.info.list[i].peisongok == 0) {
                        alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                        return false;
                    }
                    if(cart != '') {
                        for(var y in cart) {
                            if (cart[y]["deliverytime"] != _self.info.list[i].deliverytime) {
                                if (_self.info.list[i].deliverytime == 0) {
                                    alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                    return false;
                                } else if (_self.info.list[i].deliverytime == 1) {
                                    alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                    return false;
                                }
                            }
                        }
                    }
                    if (id == this.info.list[i].id) {
                        obj = {
                            id: id,
                            name: this.info.list[i].title,
                            price: this.info.list[i].price,
                            shotcut: this.info.list[i].src,
                            deliverytime: this.info.list[i].deliverytime,
                            activestu: this.info.list[i].activestu,
                            peisongok: this.info.list[i].peisongok,
                            nums: this.buyNums,
                            store: this.proNums,
                            formatName: '',
                            format: '',
                        };
                    }
				}
				this.setCart(obj);
                alert("加入购物车成功！");
			},
		}
	}
</script>