<style scoped>
	body{
		background-color: #fff;
	}

	/* product_details start */
	.product_details{
		width: 100%;
		background-color: #fff;
		padding-bottom: 50px;
	}
	.product_details .product_details_img{
		width: 100%;
		height: 320px;
	}
	.product_details .product_details_img img{
		width: 100%;
		height: 100%;
	}
	.product_details  .product_details_world{
		width: 100%;
		box-sizing: border-box;
		padding-left:4.18% ;
	}
	.product_details_top{
		width: 100%;
		height: 29px;
		line-height: 29px;
		font-size: 13px;
		color: #333;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;;
	}
	.product_details_certer{
		width: 100%;
		height: 16px;
		font-size: 12px;
		line-height: 16px;
		color: #81C429;
	}
	.product_details_footer{
		width: 100%;
		height: 17px;
		margin-top: 11px;
		color: #F9AD0C;
	}
	.product_details_laster{
		width: 100%;
		height: 12px;
		font-size: 12px;
		color: #B3B3B3;
		margin-top: 10px;
	}
	.details_laster_postage{
		width: 33%;
		float: left;
	}
	.details_laster_sales{
		width: 33%;
		float: left;
	}
	.details_laster_stock{
		width: 33%;
		float: left;
	}
	.product_details_line{
		width: 98%;
		border-top:1px #CCCCCC solid;
		margin-top: 18px;
	}
	.product_button{
		width: 100%;
		height: 50px;
	}
	.product_button_num{
		width: 13.76%;
		height: 50px;
		line-height: 50px;
		font-size: 12px;
		text-align: center;
		color: #333;
		float: left;
	}
	.product_button_number{
		width: 31.89%;
		height: 24px;
		margin-top: 12px;
		float: left;
		border:1px #ccc solid;
	}
	.product_button_cut{
		width: 25%;
		height: 24px;
		float: left;
		line-height: 24px;
		text-align: center;
	}
	.product_button_text{
		width: 50%;
		height: 24px;
		float: left;
		text-align: center;
	}
	.product_button_add{
		width: 25%;
		height: 24px;
		float: left;
		text-align: center;
		line-height: 24px;
	}
	.product_button_text input{
		width: 96%;
		height: 24px;
		float: left;
		text-align: center;
		border-left: 0.5px #ccc solid;
		border-right:   0.5px #ccc solid;
	}
	.product_committed{
		width: 100%;
		height: 38px;
		background-color:#F2F2F2;
	}
	.product_committed_left,.product_committed_right{
		width: 45%;
		height: 38px;
		float: left;
		line-height: 38px;
		font-size: 12px;
		box-sizing: border-box;
		padding-left: 8%;
	}
	.product_committed_right{
		width: 55%;
		padding-left: 0;
	}
	.product_committed_left span:nth-of-type(1),.product_committed_right span:nth-of-type(1){
		width: 14px;
		height: 14px;
	}
	.product_committed_left span img,.product_committed_right span img{
		width: 14px;
		height: 14px;
	}
	.product_titile{
		width: 100%;
		height: 39px;
		box-sizing: border-box;
		padding-left: 4%;
		padding-right: 4%;
		line-height: 39px;
		font-size: 12px;
	}
	.product_graphic_details{
		width: 33.33%;
		height: 100%;
		color: #81C429;
		text-align: center;
		float: left;
	}
	.product_customer_reviews,.product_recommended_combination{
		width: 33.33%;
		height: 100%;
		color: #4D4D4D;
		text-align: center;
		float: left;
	}
	.product_details_picture{
		width: 100%;
		height: 554px;
	}
	.product_details_picture img{
		width: 100%;
		height: 554px;
	}
	.product_details_share{
		width: 100%;
		box-sizing: border-box;
		padding-left: 14%;
		margin-top: 15px; 
	}
	.product_share_button{
		width: 83%;
		height: 40px;
		line-height: 40px;
		font-size: 15px;
		color: #fff;
		text-align: center;
		background-color: #81C429;
		border-radius: 5px; 
	}
	.product_share_world{
		width: 100%;
		height: 31px;
		line-height: 31px;
	}
	.product_share_line{
		width: 10%;
		height: 1px;
		margin-top: 15px;
		border-top: 1px #81C429 solid;
		float: left;
	}
	.product_share_value{
		width: 65%;
		height: 31px;
		line-height: 31px;
		color: #81C429;
		text-align: center;
		float: left;
	}
    /* product_details end */


    /* product-button-fixed start */
    .product-button-fixed{
        width:100%;
        position:fixed;
        bottom:0px;
        left:0px;
        background: #343136;
        height:50px;
    }

    .product-button-fixed .product-button-h1{
        width:35%;
        height:40px;
        float:left;
        color:#fff;
    }

    .product-button-fixed .product-button-h1 p{
        width:50%;
        float:left;
        font-size:14px;
        text-align: center;
    }

    .product-button-fixed .product-button-h1 p i{
        display: block;
        position: relative;
        font-size: 25px;
        top: 3px;
    }

    .product-button-fixed .product-button-h2{
        width:65%;
        float:left;
    }

    .product-button-fixed .product-button-h2 .product-comfirm-btn{
        width:50%;
        float:left;
        line-height:50px;
        color:#fff;
        font-size:14px;
        text-align: center;
    }

    .product-button-fixed .product-button-h2 .now-pay{
        background: #81c429;
    }

    .product-button-fixed .product-button-h2 .add-cart{
        background: #f9ad0c;
    }

    /* product-button-fixed end */


</style>

<template>
	<!-- product_details start -->
	<div class="product_details">
		<!-- 轮播图 开始 -->
		<div class="product_details_img">
			<img src="../images/aaa_detail.png"/>
		</div>
		<!-- 轮播图 结束 -->
		<div class="product_details_world">
			<div class="product_details_top">车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝....</div>
			<div class="product_details_certer">征服你的味蕾，带来时刻的好心情！</div>
			<div class="product_details_footer">
				<span style="font-size:12px;">￥</span>
				<span style="font-size:17px;">19.00</span>
			</div>
			<div class="product_details_laster">
				<div class="details_laster_postage ">快递:0.00</div>
				<div class="details_laster_sales ">销量：1888</div>
				<div class="details_laster_stock ">库存：52</div>
			</div>
			<div class="product_details_line"></div>
		</div>
		<div class="product_button">
			<div class="product_button_num">数量：</div>
			<div class="product_button_number">

				<div class="product_button_cut">-</div>
				<div class="product_button_text"><input type="text" value="1" /></div>
				<div class="product_button_add">+</div>

			</div>
		</div>
		<div class="product_committed">
			<div class="product_committed_left">
				<span><img src="../images/chengnou.png"/></span>
				<span>满100包邮</span>
			</div>
			<div class="product_committed_right">
				<span><img src="../images/chengnou.png"/></span>
				<span>卖家承诺24小时内发货</span>
			</div> 
		</div>
		<div class="product_titile">
			<div class="product_graphic_details">图文详情</div>
			<div class="product_customer_reviews">客户评价</div>
			<div class="product_recommended_combination">推荐组合</div>
		</div>
		<div class="product_details_picture"><img src="../images/product_tuwen.png"/></div>


		<!-- product_details_share start -->
		<!--<div class="product_details_share">-->
			<!--<div class="product_share_button">立即分享抢购</div>-->
			<!--<div class="product_share_world">-->
				<!--<div class="product_share_line"></div>-->
				<!--<div class="product_share_value">分享后即可抢购一次</div>-->
				<!--<div class="product_share_line"></div>-->
			<!--</div>-->
		<!--</div>-->
		<!-- product_details_share end -->



	</div>
	<!-- product_details end -->

    <div class="product-button-fixed">
        <div class="product-button-h1">
            <p>
                <i class="iconfont">&#xe70a;</i>
                <span>收藏</span>
            </p>
            <p>
                <i class="iconfont">&#xe603;</i>
                <span>购物车</span>
            </p>
        </div>
        <div class="product-button-h2">
            <a class="now-pay product-comfirm-btn">立即购买</a>
            <a class="add-cart product-comfirm-btn">加入购物车</a>
        </div>
    </div>

</template>

<script>

	export default{
		components: {
		},
		props: {
			bgcolor: {
				type: String,
				default: ''
			},
			fixed: {
				type: Boolean,
				default: false
			},
			top: {
				type: Number,
				default: 0
			},
			unit: {
				type: String,
				default: 'rem'
			}
		},
		ready() {

		},
		data() {
			return {
				searchKey:''
			}
		},
		methods: {

			"goBack": function(){
				window.history.back();
			},
			"goSearch": function(){
				this.searchKey = this.searchKey.replace(/(^\s*)|(\s*$)/g,'');
				if(this.searchKey.length<=0){
					return false;
				}
				this.$dispatch('goSearch',this.searchKey);
			}
		}
	}
</script>