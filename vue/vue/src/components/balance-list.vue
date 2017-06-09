<style scoped>
	.bl-wrapper{
		width:100%;
		background-color:#fff;
	}

	.bl-wrapper .line{
		width: 95%;
		width: 95%;
		margin: 10px 5px 0px;
		background-color: #fff;
		border-bottom: #f2f2f2 solid 1px;
		font-size: 0;
		padding: 10px 5px;
	}

	.bl-wrapper .line-bottom{
		border-bottom: none;
		font-size: 1.4rem;
		color: #808080;
		text-align: right;
		letter-spacing: 0.1rem;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
		background: #fff;
		padding: 2% 4% 2% 0%;
		line-height: 3rem;
	}

	.bl-wrapper .line-bottom .todaybtn {
		width:8rem;
		height:3rem;
		border:none;
		color:#fff;
		background: #81c429;
		margin:0px 0.5rem;
	}

	.bl-wrapper .line.bottom>label{
		color:#f9ad0c;
	}

	.bl-wrapper .line .img,.bl-wrapper .line .con{
		display:inline-block;
		vertical-align:top;
	}

	.bl-wrapper .line .img{
		width:25%;
		background-size:cover;
		background-position:center;
		background-repeat:no-repeat;
		background-color:#efefef;
	}

	.bl-wrapper .line .con{
		width:73%;
		font-size:0;
		line-height:1.6rem;
	}

	.bl-wrapper .line .con>div{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
	}

	.bl-wrapper .line .con>div.left{
		width:75%;
		margin-left:3%;
		margin-right:3%;
		
		text-align:left;
	}

	.bl-wrapper .line .con>div.left .name{
		color:#333;
		color: #333;
		text-overflow: ellipsis;
		overfloW: hidden;
		width: 100%;
		height: 4rem;
		line-height: 20px;
		text-align: justify;
	}

	.bl-wrapper .line .con>div.left .format{
		padding:0.2rem 0rem;
		font-size:1.2rem;
		color:#ccc;
	}

	.bl-wrapper .line .con>div.right{
		width:19%;
		text-align:right;
	}

	.bl-wrapper .line .con>div.right .price{
		color:#f9ad0c;
	}

	.bl-wrapper .line .con>div.right .num{
		color:#808080;
		position: relative;
		top: 5px;
	}

	.bl-wrapper .line.top{
		color:#333;
	}

	.bl-wrapper .line.top .icon,.bl-wrapper .line.top .wtit{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
	}

	.bl-wrapper .line.top .icon{
		width: 8%;
		margin-right: 2%;
		text-align: center;
		position: relative;
		top: 3px;
	}

	.bl-wrapper .line.top .icon>img{
		width:80%;
		height:auto;
	}

	.bl-wrapper .line.top .wtit{
		width:90%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		letter-spacing:0.1rem;
	}

	.bl-wrapper .line.top .wtit>label{
		color:#808080;
	}

	/* getShop start */
	.getShop {
		width:100%;
		height:100%;
		background: #fff;
		margin:10px 0px;
		font-size:1.4rem;
	}

	.getShop .getShopTime {
		border-bottom: 1px solid #f2f2f2;
		height:4.5rem;
		line-height:4.5rem;
	}

	.getShop .getShopTime {
		width:95%;
		margin:0px auto;
		padding-top:5px;
	}

	.radio-time {
		border:1px solid #ccc;
		padding:5px;
	}

	.getShop .getInformation {
		width:80%;
		text-align:center;
		margin: 10px auto;
		background: #fff;
	}

	.my-icon:before{
		color:#ccc;
	}

	.my-icon-chosen:before{
		color:#f9ad0c;
	}

	/* getShop end */


</style>

<template>

	<div class="bl-wrapper">
		<div class="line top" v-if="showTop">
			<div class="icon">
				<img src="../images/coupon.png" />
			</div>
			<div class="wtit">
				购买清单
				<label>（共{{ amount }}件商品）</label>
			</div>
		</div>
		<div class="line" v-for="item in list" v-link="{name:'detail',params:{pid:item.id}}">
			<div class="img"> <!--  v-lazy:background-image="item.shotcut" -->
				<img :src="item.shotcut" style="width:100%;height:100%;" />
			</div>
			<div class="con">
				<div class="left">
					<div class="name">{{ item.name }}</div>
					<div class="format">{{ item.formatName }}</div>
				</div>
				<div class="right">
					<div class="price">¥{{ item.price }}</div>
					<div class="num">x{{ item.nums }}</div>
				</div>
			</div>
		</div>
		<div class="line-bottom" v-if="showBtm">
			<div style="display:block;float:right;">共{{ amount }}件商品合计：<label style="color:#f9ad0c;">¥{{ sum }}</label></div>
		</div>
	</div>


</template>

<script>

    import Scroller from 'vux/src/components/scroller'
    import Icon from 'vux/src/components/icon'

	export default{
		props: {
			list: {
				type: Array,
				default() {
					return []
				}
			},
            gift: {
			    type: Array,
				default() {
			        return []
				}
			},
			showTop: {
				type: Boolean,
				default: false
			},
			showBtm: {
				type: Boolean,
				default: true
			},
            dispaly: {
			    type: Boolean,
                default: false,
			}
		},
		data() {
			return {
				amount:0,
                showValA: false,
                showValB: false,
				shonse:0,
                listGift: [],
				vieible: false,
			}
		},
		ready() {

		    for(let i in this.list) {
				if(this.list[i].activity != -1 && this.list[i].activity != 0) {
					this.vieible = true;
				}

                if(this.list[i].activity == 0) {
                    this.vieible = true;
                } else {
				    this.vieible = false;
				}

			}

			$(function() {
			    $(".todaybtn").mouseover(function() {
			        $(this).css({
						background: "#f9ad0c",
                        transition: "0.5s"
					});
				}).mouseout(function() {
                    $(this).css({
                        background: "#81c429",
						transition: "0.5s"
                    });
				});
			});
		},
        components: {
            Scroller,
            Icon
		},
		computed: {
			amount: function(){
				return this.list.length;
			},
			sum: function() {
				let sum = 0;
				if(this.amount > 0) {
					for(let ll = 0;ll < this.list.length; ll++) {
						sum += this.list[ll].price * this.list[ll].nums;
					}
				}
				return sum.toFixed(2);
			}
		},
		methods: {
		    ids: function() {

			},
		}
	}
</script>