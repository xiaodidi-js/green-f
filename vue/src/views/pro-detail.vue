
<style scoped>
	.my-swiper{
		width:100%;
		height:auto;
		overflow:hidden;
	}

	.ms-scroller{
		min-width:100%;
		height:auto;
		font-size:0;
		white-space:nowrap;
	}

	.ms-scroller>div.ms-item{
		display:inline-block;
		vertical-align:top;
		font-size:0;
		width:100%;
		height:auto;
		max-width:100%;
		overflow:hidden;
		background: #fff;
	}

	.pro-mes{
		width:96%;
		height:auto;
		padding:2%;
		background-color:#FFF;
		font-size:1.4rem;
	}

	.nowrap{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.pro-mes .title{
		font-size:14px;
		color:#333;
		width:100%;
		height:auto;
		margin-bottom:0.3rem;
		white-space:normal;
	}

	.pro-mes .desc{
		color:#81c429;
		margin-bottom:0.3rem;
		white-space:normal;
		font-size:14px;
	}

	.pro-mes .price{
		color:#F9AD0C;
		font-size:30px;
	}

	.pro-mes .price .unit{
		font-size:20px;
	}

	.pro-mes .price .old{
		font-size:1.2rem;
		color:#ccc;
		text-decoration:line-through;
	}

	.divider{
		width:97%;
		padding-left:3%;
		margin:1% 0% 2% 0%;
		border-bottom:#EFEFEF solid 1px;
	}

	/* 商品優惠 */
	.preferential {
		width:100%;
		height:4.5rem;
		line-height:4.5rem;
		background: #f2f2f2;
		clear:both;
		text-indent: 2rem;
	}

	.preferential ul li {
		color:#808080;
	}

	.preferential ul li .icon-tick {
		background: url("../images/chengnou.png") no-repeat;
		background-size: 83%;
		padding:0px 10px;
		position:relative;
		top:2px;

	}

	.preferential ul .free {
		width:40%;
		float:left;
		font-size:12px;
	}

	.preferential ul .deliver {
		width:60%;
		float:left;
		font-size:12px;
	}

	/* 商品優惠 */

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

	.service-bar{
		width:96%;
		/*padding:2%;*/
		background-color:#f2f2f2;
		font-size:0;
		border-bottom:#e8e8e8 solid 1px;
		height:38px;
		overflow:hidden;
	}

	.service-bar .words{
		font-size:12px;
		color:#000;
		display:inline-block;
		vertical-align:middle;
		width:92%;
	}

	.service-bar .arrow{
		display:inline-block;
		vertical-align:middle;
		width:2%;
		margin:0% 3%;
		height:100%;
	}

	.service-bar .words .service-span{
		width: 30%;
		height:38px;
		display:block;
		line-height:38px;
		float:left;
		padding-left: 8%;
	}

	.service-bar .arrow>img{
		width:100%;
		height:auto;
	}

	.my-icon:before{
		font-size:1.6rem;
		color:#f26c60;
		margin-right:0.3rem;
		line-height:1.6rem;
	}

	.comment-box{
		width:100%;
		margin:0% 0px 10%;
		height:auto;
		background-color:#fff;
	}

	.comment-bar{
		width:96%;
		padding:2%;
		font-size:0;
	}

	.comment-bar .com-title{
		font-size:1.4rem;
		color:#808080;
		display:inline-block;
		vertical-align:middle;
		width:92%;
	}

	.comment-bar .com-arrow{
		display:inline-block;
		vertical-align:middle;
		width:2%;
		margin:0% 3%;
		height:100%;
	}

	.comment-bar .com-arrow>img{
		width:100%;
		height:auto;
	}

	.comment-bar.guige{
		width:100%;
		padding:0;
	}

	.comment-bar.guige .com-title{
		width:92%;
	}

	.comment-bar.guige .com-arrow{
		width:7%;
		margin:0% 1% 0% 0%;
		text-align:right;
	}

	.com-line{
		width:96%;
		padding:2%;
		font-size:0;
		border-top:#EFEFEF solid 1px
	}

	.com-line>p.first{
		font-size:1.2rem;
		color:#808080;
		letter-spacing:0.1rem;
	}

	.com-line .cstar,.com-line .cname,.com-line .cdate{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
		color:#999999;
		width:100%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.com-line .cname,.com-line .cdate{
		/*margin-left:5%;*/
		/*text-align:center;*/
	}

	.com-line .cdate{
		text-align:right;
		float:right;
		width: 30%;
	}

	.com-line .content{
		width:100%;
		margin:2% 0%;
		font-size:1.4rem;
		color:#333;
		white-space:normal;
	}

	.com-line .format{
		width:100%;
		margin:2% 0% 0% 0%;
		font-size:1.2rem;
		color:#999999;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.tuijian-box{
		width: 96%;
		height: auto;
		padding: 0% 2% 3.5% 2%;
		padding-top: 5%;
		display: none;
		background: #fff;
		clear: both;
	}

	.tuijian-box .tj-scroller{
		white-space:nowrap;
		font-size:0;
		height:auto;
		padding:0rem;
		width:100%;
		float:left;
	}

	.pro-mes .main .line .rush{
		width:96%;
		border-radius:0.3rem;
		border:#f26c60 solid 0.1rem;
		margin:0rem auto 0.8rem auto;
		font-size:0;
		overflow:hidden;
	}

	.pro-mes .main .line .rush .rtit{
		display:inline-block;
		vertical-align:middle;
		font-size:1.6rem;
		color:#fff;
		width:15%;
		padding:2% 0%;
		text-align:center;
		background-color:#f26c60;
	}

	.pro-mes .main .line .rush .rcon{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		color:#fff;
		width:72%;
		margin-left:3%;
	}

	.pro-mes .main .line .rush .rcon>div{
		width:100%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.pro-mes .main .line .rush .rcon .rctit{
		color:#808080;
	}

	.pro-mes .main .line .rush .rcon .rccon{
		color:#f26c60;
	}

	.pro-mes .deliver{
		font-size:0;
		color:#ccc;
		margin-top:0.5rem;
		margin-bottom: 1.2rem;
	}

	.pro-mes .deliver .son{
		display:inline-block;
		font-size:1.2rem;
		vertical-align:middle;
		width:33.3%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		text-align:center;
	}

	.pro-mes .deliver .son:nth-child(1){
		text-align:left;
	}

	.pro-mes .deliver .son:nth-child(2){
		text-align:center;
	}

	/*.pro-mes .deliver .son:nth-child(3){*/
		/*text-align:right;*/
	/*}*/

	.fixed-tab{
		/*position:fixed;*/
		/*top:0;*/
		/*left:0;*/
		width:100%;
		z-index:90;
	}

	.com-line.allcom{
		font-size:1.4rem;
		color:#81c429;
		text-align:center;
	}

	.com-line.allcom:active{
		background-color:#f5f5f5;
	}

	.format-pop{
		width:100%;
		box-sizing:border-box;
		height:auto;
		background-color:#fff;
		padding:1rem;
		position:fixed;
		bottom:4.5rem;
		left:0;
		z-index:99;
		transform:scale(0);
		-webkit-transform:scale(0);
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

	.product_titile{
		width: 100%;
		height: 45px	;
		box-sizing: border-box;
		padding-left: 4%;
		padding-right: 4%;
		line-height: 39px;
		font-size: 12px;
		background: #fff;
		border-bottom: 1px solid #ccc;
	}

	.product_titile ul li{
		width: 33.33%;
		height: 100%;
		color: #4D4D4D;/*81C429*/
		text-align: center;
		float: left;
		line-height: 43px;
	}

	.product_titile ul .active{
		color: #81C429;
		border-bottom: 3px solid #81C429;
	}

	.product_details_picture{
		width: 100%;
		height: 554px;
		background: #fff;
		clear:both;
	}
	/*.product_details_picture img{*/
		/*width: 100%;*/
		/*height: 554px;*/
	/*}*/


	/* 分享 */
	.product_details_share{
		width: 100%;
		box-sizing: border-box;
		padding-left: 14%;
		margin-top: 15px;
		display:none;
	}
	.product_share_button{
		width: 83%;
		height: 40px;
		line-height: 40px;
		font-size: 14px;
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
		text-align: center;
		float: left;
		color:#81C429;
		font-size: 12px;
	}
	/* 分享 */


	/* 增加数量 */
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
		color:#999;
	}
	/* 增加数量 */

	.ms-item-class {
		clear: both;
		padding-bottom: 13px;
		font-size: 1.6rem;
		font-weight: 500;
		text-align:center;
		color:#333;
	}

	img {
		display:block;
	}

</style>

<style>
.ms-scroller>div.ms-item>div,.ms-scroller>div.ms-item table,.ms-scroller>div.ms-item img,.ms-scroller>div.ms-item embed,.ms-scroller>div.ms-item video{
		max-width:100% !important;
}
.dots-my-orange>a>.vux-icon-dot{
	background:#fff !important;
}
.dots-my-orange>a>.vux-icon-dot.active{
	background:#f9ad0c !important;
}
</style>

<template>
	<!-- 顶部选项 -->

	<!--<separator :set-height="44" unit="px"></separator>-->
	<div class="my-swiper"> <!-- @touchstart="tslistener($event)" @touchend="telistener($event)" -->
		<div id="scroller" class="ms-scroller" style="transform:translate3d(0px,0px,0px)">
			<div class="ms-item">
				<!-- 头部滚动图 -->
				<swiper :list="data.gallery" loop auto dots-position="center"
						:show-desc-mask="false"
						:aspect-ratio="480/480" dots-class="dots-my-orange" @touchstart.stop @touchend.stop></swiper>
				<!-- 产品信息 -->
				<div class="pro-mes">
					<div class="title">{{ data.name }}</div>
					<div class="desc">{{ data.description }}</div>
					<div class="price nowrap" >
						<div class="price nowrap" v-if="data.is_promote || !data.sale">
							<label class="unit">¥</label>
							<span style="font-size:40px;">{{ data.price }}</span>
							<div class="old">原价:¥ {{ data.starprice }}</div>
						</div>
						<div class="price nowrap" v-else>
							<label class="unit">¥</label> {{ data.price }}
						</div>
					</div>
					<div class="deliver">
						<div class="son">快递：{{ makeFreight }}</div>
                        <div class="son">销量：{{ data.virtual_sale }}</div>
                        <div class="son">库存：{{ data.store }}</div>
					</div>

					<!-- 分割线 -->
					<div class="divider"></div>

					<!-- 抢购时间 -->
					<seckill-floor v-show="seckillShow" :columns="gotimeline" end=""></seckill-floor>
					<!-- 抢购时间 -->

					<!--<div class="product_button">-->
						<!--<div class="product_button_num">数量：</div>-->
						<!--<div class="product_button_number">-->
							<!--<div class="product_button_cut":class="{'disabled':buyNums<=1}" @click="reduceNums">-</div>-->
							<!--<div class="product_button_text"><input type="number" id="num" class="input" :value="buyNums" readonly /></div>-->
							<!--<div class="product_button_add" :class="{'disabled':buyNums>=proNums}" @click="addNums">+</div>-->
						<!--</div>-->
					<!--</div>-->

				</div>

				<div class="preferential">
					<ul>
						<li class="free">
							<i class="icon-tick"></i>
							<span>满￥100包邮</span>
						</li>
						<li class="deliver">
							<i class="icon-tick"></i>
							<span>卖家承诺24小时内发货</span>
						</li>
					</ul>
				</div>

				<div class="product_titile">
					<ul id="card">
						<li class="active">图文详情</li>
						<li>客户评价</li>
						<li>推荐组合</li>
					</ul>
				</div>

				<!--<tab default-color="#333333" active-color="#F9AD0C" :line-width="2" class="fixed-tab">-->
					<!--<tab-item :selected="column === 0" @click="changeColumn(0)">基本信息</tab-item>-->
					<!--<tab-item :selected="column === 1" @click="changeColumn(1)">图文详情</tab-item>-->
					<!--<tab-item :selected="column === 2" @click="changeColumn(2)">品牌承诺</tab-item>-->
				<!--</tab>-->

				<div id="content">
					<!-- 图文详情 -->
					<div class="product_details">
						<div class="ms-item ms-item-class">
							<spinner class="my-spinner"></spinner>
						</div>
						<div class="product_details_share">
							<div class="product_share_button">立即分享抢购</div>
							<div class="product_share_world">
								<div class="product_share_line"></div>
								<div class="product_share_value">分享后即可抢购一次</div>
								<div class="product_share_line"></div>
							</div>
						</div>
					</div>
					<!-- 最新评价 -->
					<div class="comment-box" style="display:none;">
						<div class="comment-bar">
							<div class="com-title">最新评价</div>
							<div class="com-arrow"></div>
						</div>
						<div v-if="data.comments && data.comments.length > 0">
							<div class="com-line" v-for="cms in data.comments">
								<div class="cname">{{ cms.uname }}</div>
								<div class="cdate">{{ cms.createtime }}</div>
								<div class="content">
									{{ cms.content }}
								</div>
								<div class="format" v-if="cms.fname">
									{{ cms.fname }}
								</div>
								<div class="cstar">
									<rater :value="cms.stars" :margin="1" active-color="#F9AD0C" :font-size="16" :disabled="true"></rater>
								</div>
							</div>
							<div class="com-line allcom" v-link="{name:'comment-list',params:{pid:$route.params.pid}}">
								查看全部评价
                            </div>
						</div>
						<div v-else>
							<div class="com-line">
								<p class="first">赶快来抢沙发吧!</p>
							</div>
						</div>
					</div>
					<!-- 推荐产品 -->
					<div class="tuijian-box" style="display:none;" @touchstart.stop @touchend.stop v-show="data.commend">
						<div id="scbox" class="tj-scroller">
							<card-recommend :info="data.commend" :card-width="10"></card-recommend>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<separator :set-height="4.5"></separator>

	<!-- toast提示框 -->
	<toast :show.sync="stoastShow">{{ stoastMessage }}</toast>
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>

	<!-- 底部购买 -->
	<bottom-buy :bage="cartNums" :fixed="true" :collect="data.collect" :store="proNums"></bottom-buy>

	<!-- actionpanel -->
	<my-pop title="商家公告" :show.sync="showPanel" :show-confirm="true" confirm-text="完成" :service="data.notice"></my-pop>

	<div class="fpmasker" :class="{'show':formatPopShow}" @touchmove.stop.prevent @touchend.stop @touchstart.stop @click="hideFormatPop"></div>
	<div class="format-pop" :class="{'show':formatPopShow}" @touchmove.stop.prevent @touchend.stop @touchstart.stop>
		<div class="line">
			<div class="pimg" style="padding-top:0%;"> <!--  v-lazy:background-image="data.shotcut" -->
				<img :src="data.shotcut" style="width:100%;height:100%;" alt="">
			</div>
			<div class="pmes">
				<div class="price">¥{{data.price}}</div>
				<div>库存{{proNums}}件</div>
				<div class="dialog">{{ getGuigeName }}</div>
			</div>
		</div>
		<div class="close" @click="hideFormatPop">X</div>
		<div class="divider" style="margin-top:23%;"></div>
		<div class="line" v-for="(pindex,fmt) in data.format">
			<div class="title">{{ fmt.name }}</div>
			<div id="con" class="con" style="font-size:0;white-space:normal;">
				<guige :value="val.id" :text="val.name" v-for="(sindex,val) in fmt.value" @click="changeGuige(pindex,val.id,val.name)"></guige>
			</div>
			<div class="divider"></div>
		</div>
		<div class="line" style="padding-bottom:0.3rem;font-size:0;">
			<div class="title inline">购买数量</div>
			<div class="con inline">
				<div class="num-counter">
					<div class="btns" :class="{'disabled':buyNums <= 1}" @click="reduceNums">-</div>
					<input type="number" class="input" :value="buyNums" readonly />
					<div class="btns" :class="{'disabled':buyNums >= proNums}" @click="addNums">+</div>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
	import { cartNums } from 'vxpath/getters'
	import { setCartStorage } from 'vxpath/actions'
	import Swiper from 'vux/src/components/swiper'
	import SwiperItem from 'vux/src/components/swiper-item'
	import Tab from 'vux/src/components/tab/tab.vue'
	import TabItem from 'vux/src/components/tab/tab-item'
	import Icon from 'vux/src/components/icon'
	import MyPop from 'components/my-pop'
	import Rater from 'vux/src/components/rater'
	import CardRecommend from 'components/card-recommend'
	import TimerCountdown from 'components/timer-countdown'
	import Scroller from 'vux/src/components/scroller'
	import BottomBuy from 'components/bottom-buy'
	import Separator from 'components/separator'
	import Toast from 'vux/src/components/toast'
	import Guige from 'components/guige'
	import Spinner from'components/spinner'
	import WxJssdk from 'weixin-js-sdk'
	import SeckillFloor from 'components/seckill-floor'
    import axios from 'axios'
    import qs from 'qs'


	export default{
		vuex: {
			getters: {
				cartNums
			},
			actions: {
				setCart: setCartStorage
			}
		},
		data() {
			return {
				column:0,
				winWidth:0,
				minHeight:0,
				startX:0,
				startY:0,
				showPanel:false,
				proNums:1,
				buyNums:1,
				guige:[],
				guigeName:[],
				formatPopShow:false,
				toastMessage:'',
				toastShow:false,
				stoastMessage:'',
				stoastShow:false,
				data:[],
                toggle: true,
                gotimeline: [],
                seckillShow: false,
				local:localStorage.apiDomain,
			}
		},
		components: {
			Swiper,
			SwiperItem,
			Tab,
			TabItem,
			Icon,
			MyPop,
			Rater,
			CardRecommend,
			TimerCountdown,
			Scroller,
			BottomBuy,
			Separator,
			Toast,
			Guige,
			Spinner,
            SeckillFloor
		},
		route: {
			data(transition) {
				if(typeof this.data.id !== 'undefined' && this.data.id != transition.to.params.pid){
					location.reload();
				}
			}
		},
		ready() {
		    //选项卡
			this.siblingsDom();
			this.timeline();
			let getUrl = '',context = this;
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			if(ustore){
				getUrl = localStorage.apiDomain+'public/index/index/productdetail/uid/'+ustore.id+'/pid/'+this.$route.params.pid;
			}else{
				getUrl = localStorage.apiDomain+'public/index/index/productdetail/uid/0/pid/'+this.$route.params.pid;
			}
            var _self = this;
			this.$http.get(getUrl).then((response)=>{
				this.data = response.data;
                if(!this.data.format){
					this.proNums = this.data.store;
				}
                //判断是否活动商品
                if(_self.data.activeid == 0) {
                    _self.seckillShow = false
					console.log(_self.seckillShow);
				} else if(_self.data.activeid != 0) {
                    console.log(_self.seckillShow);
                    _self.seckillShow = true;
				}
                //判断是否分享商品
//                this.data.share != null ? _self.activestu = 2 : _self.activestu = 0;
                //微信分享
				this.$http.get(localStorage.apiDomain+'public/index/index/wxshare').then((response)=>{
					let getSession = response.data;
					let shareData = {
							title:this.data.name,
							desc:this.data.description,
							link:'http://'+window.location.host+'/index_prod.html#!/detail/' + this.data.id,
							imgUrl:this.data.shotcut
						};
					WxJssdk.config({
						debug:false,
						appId:getSession.appid,
						timestamp:getSession.timestamp,
						nonceStr:getSession.noncestr,
						signature:getSession.signature,
						jsApiList:[
							'onMenuShareTimeline',
				            'onMenuShareAppMessage',
				            'onMenuShareWeibo',
				            'onMenuShareQQ',
				            'onMenuShareQZone'
						]
					});
					WxJssdk.ready(()=>{
						WxJssdk.onMenuShareTimeline(shareData);
						WxJssdk.onMenuShareAppMessage(shareData);
						WxJssdk.onMenuShareWeibo(shareData);
						WxJssdk.onMenuShareQZone(shareData);
						WxJssdk.onMenuShareQQ(shareData);
					});

					// 分享朋友圈
					WxJssdk.onMenuShareTimeline({
                        title: this.data.name, // 分享标题
                        link:'http://'+window.location.host+'/index_prod.html#!/detail/'+this.data.id,
                        imgUrl: this.data.shotcut, // 分享图标
                        success: function () {
                            alert("成功!");
                            _self.$http.get(localStorage.apiDomain + 'public/index/index/addshare?uid=' + ustore.id + '&pid=' + _self.data.id + '&activeid=' + _self.data.activeid).then((response)=>{
                                console.log(response.data.msg);
                                console.log(response.data.msg);
                                $(".addCar").attr("disabled",true);
                            },(response)=>{
                                this.toastMessage = '网络开小差了~';
                                this.toastShow = true;
                            });
                        },
					});

					// 分享好友
					WxJssdk.onMenuShareAppMessage({
                        title: this.data.name, // 分享标题
                        link:'http://'+window.location.host+'/index_prod.html#!/detail/'+this.data.id,
                        imgUrl: this.data.shotcut, // 分享图标
                        success: function () {
                            alert("成功!");
                            _self.$http.get(localStorage.apiDomain + 'public/index/index/addshare?uid=' + ustore.id + '&pid=' + _self.data.id + '&activeid=' + _self.data.activeid).then((response)=>{
                                console.log(response.data.msg);
                                console.log(response.data.msg);
                                $(".addCar").attr("disabled",true);
                            },(response)=>{
                                this.toastMessage = '网络开小差了~';
                                this.toastShow = true;
                            });
                        },
					});

                    // 分享QQ
					WxJssdk.onMenuShareQQ({
                        title: this.data.name, // 分享标题
                        link:'http://'+window.location.host+'/index_prod.html#!/detail/'+this.data.id,
                        imgUrl: this.data.shotcut, // 分享图标
                        success: function () {
                            alert("成功!");
                            _self.$http.get(localStorage.apiDomain + 'public/index/index/addshare?uid=' + ustore.id + '&pid=' + _self.data.id + '&activeid=' + _self.data.activeid).then((response)=>{
                                console.log(response.data.msg);
                                console.log(response.data.msg);
                                $(".addCar").css("background","#eee").attr("disabled",true);
                            },(response)=>{
                                this.toastMessage = '网络开小差了~';
                                this.toastShow = true;
                            });
                        },
					});
					WxJssdk.error(function(res){
                        console.log(res.errMsg);
					});
				},(response)=>{
					console.log('get wx share failed.');
				});
				//微信分享
				this.$nextTick(()=>{
//                    this.winWidth = window.screen.width;
//                    this.minHeight = window.screen.height - (document.getElementsByClassName('vux-tab')[0].offsetHeight + document.getElementsByClassName('bottom-buy')[0].offsetHeight);
//                    document.getElementById('scroller').style.height = document.getElementsByClassName('ms-item')[0].offsetHeight<this.minHeight ? this.minHeight+'px' : document.getElementsByClassName('ms-item')[0].offsetHeight+'px';
//                    if(this.data.commend&&this.data.commend.length>0){
//                        let bis = document.getElementsByClassName('card-box');
//                        let bwid = 0;
//                        for(let item=0;item<bis.length;item++){
//                            bwid+=10.8;
//                        }
//                        document.getElementById('scbox').style.width = bwid ? (bwid-0.8) +'rem' : '100%';
//                        this.$refs.scroller.reset();
//                    }
                    var scaleBox = this.data.content;
                    var itemEle = document.getElementsByClassName('ms-item')[1];
					if(scaleBox === '') {
                        itemEle.innerHTML = "暂时没有详情图~~~";
                        itemEle.style.paddingTop = "10px";
                        itemEle.style.height = "150px";
                        itemEle.style.lineHeight = "150px";
					} else {
                        itemEle.innerHTML = scaleBox;
                        var chil = itemEle.children;
                        console.log(chil);
                        for(var i in chil) {
                            chil[i].style.display = "block";
						}
					}
//                    document.getElementsByClassName('ms-item')[2].innerHTML = this.data.detail;
				});
			},(response)=>{
				this.toastMessage = "网络开小差啦~";
				this.toastShow = true;
			});


		},
		computed: {
			makeFreight: function(){
				let fmoney = parseFloat(this.data.freight);
				if(isNaN(fmoney)){
					fmoney = 0;
				}
				return fmoney.toFixed(2);
			},
			getGuigeName: function(){
				if(this.guigeName <= 0) {
					return '请选择商品规格和数量';
				}
				return '已选择"'+ this.guigeName.join('-') +'"';
			}
		},
		methods: {
            judgefun:function () {
                var _self = this;
                var shoping = JSON.parse(sessionStorage.getItem("myCart"));
                if(this.data.peisongok == 0) {
                    alert("抱歉，菜品已截单，请到首页选购菜品，谢谢合作！");
                    _self.toastMessage = "";
                    _self.toastShow = false;
                    return false;
                }
                if(shoping != null) {
                    for(let i = 0; i < shoping.length; i++) {
                        if (shoping[i]["deliverytime"] != this.data.deliverytime) {
                            if (this.data.peisongok == 1 && this.data.deliverytime == 0) {
                                alert("亲！您选购的菜品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                _self.toastShow = true;
                                return false;
                            } else if (this.data.peisongok == 1 && this.data.deliverytime == 1) {
                                alert("亲！您选购的菜品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！！");
                                _self.toastShow = true;
                                return false;
                            }
                        }
                    }
                }
            },
            gofun: function() {
                var _self = this;
                var shoping = JSON.parse(sessionStorage.getItem("myCart"));
                if(shoping === null) {
                    return true;
                } else {
                    for(let i = 0; i < shoping.length; i++) {
                        if(shoping[i]["deliverytime"] != this.data.deliverytime) {
                            if(this.data.deliverytime == 0){
                                _self.toastMessage = "购物车有当日商品！";
                                _self.toastShow = true;
                                return false;
                            } else if (this.data.deliverytime == 1) {
                                _self.toastMessage = "购物车有次日商品！";
                                _self.toastShow = true;
                                return false;
                            }
                        }
                    }
                }
            },
            timeline: function() {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                var _this = this;
                this.$http.get(localStorage.apiDomain+'public/index/sale/SaleTimeSolt/uid').then((response) => {
                    if(response.data.status===1) {
                        this.gotimeline = response.data.SaleTimeSolt;
                        console.log(this.gotimeline);
                    } else if(response.data.status===-1) {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    } else {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            $id: function(id) {
                return document.getElementById(id);
            },
            siblings: function (dom,callback){
                var pdom = dom.parentElement;
                var tabArr = [].slice.call(pdom.children);
                tabArr.filter(function(obj){
                    if(obj!=dom)callback.call(obj);
                });
            },
            siblingsDom:function (){
                var cardDom = this.$id("card");
                var liDomes = cardDom.children;
                var len = liDomes.length;
                for(var i = 0; i < len; i++) {
                    //给对象缓存自有属性
                    liDomes[i].index = i;
                    var _this = this;
                    liDomes[i].onclick = function(){
                        this.className = "active";
                        //同辈元素互斥
                        _this.siblings(this,function(){
                            this.className = "";
                        });
                        //把对应的选项卡的内容显示出来
                        var tabDom = document.getElementById("content").children[this.index];
                        tabDom.style.display = "block";
                        //拿它的父亲对象
                        _this.siblings(tabDom,function(){
                            this.style.display = "none";
                        });
                    };
                }
            },
			tslistener: function(e){
				this.startX = e.changedTouches[0].pageX;
				this.startY = e.changedTouches[0].pageY;
			},
			telistener: function(e){
				if(Math.abs(e.changedTouches[0].pageX - this.startX) - Math.abs(e.changedTouches[0].pageY - this.startY) > 0){
					if(e.changedTouches[0].pageX - this.startX > 0 && this.column > 0 && e.changedTouches[0].pageX - this.startX > 50) {
						this.changeColumn(this.column-1);
					}else if(e.changedTouches[0].pageX - this.startX < 0 && this.column < 2 && e.changedTouches[0].pageX - this.startX < -50) {
						this.changeColumn(this.column+1);
					}
				}
			},
			changeColumn: function(col) {
				this.column = col;
				let iHeight = document.getElementsByClassName('ms-item')[col].offsetHeight < this.minHeight ? this.minHeight : document.getElementsByClassName('ms-item')[col].offsetHeight;
				let scroller = document.getElementById('scroller');
				scroller.style.height = iHeight+'px';
				scroller.style.transition = "-webkit-transform 300ms ease-out";
				scroller.style.webkitTransform = "translate3d(-" + this.column * this.winWidth + "px,0px,0px)";
				window.scrollTo(0, 0);
			},
			showPanelMes: function() {
				this.showPanel = true;
			},
			checkGuige: function() {
				if(this.guige.length !== this.data.format.length) {
					return false;
				} else {
					for(let gg = 0; gg < this.guige.length; gg++) {
						if(typeof this.guige[gg] === 'undefined' || this.guige[gg] == '') {
						    console.log(this.guige.length);
							return false;
						}
					}
					return true;
				}
			},
			changeGuige: function(index,id,name) {
				this.guige.$set(index,id);
				this.guigeName.$set(index,name);
				if(!this.checkGuige()) return;
				this.$http.get(localStorage.apiDomain+'public/index/index/propertyprice/pid/'+this.$route.params.pid+'/val/'+this.guige.join(',')).then((response)=>{
					if(response.data.status === 1) {
						if(this.data.is_promote) {
							this.data.promote_price = response.data.price;
						} else {
							this.data.price = response.data.price;
						}
						this.proNums = response.data.store;
						this.buyNums = 1;
					}else{
						this.toastMessage = response.data.info;
						this.toastShow = true;
					}
				},(response)=>{
					this.toastMessage = '商品信息获取失败';
					this.toastShow = true;
				});
			},
			addNums: function(){
			    if(this.data.activeid == 0) {
                    if(this.buyNums>=this.proNums){
                        return false;
                    }
                    this.buyNums++;
				} else if(this.data.activeid != 0) {
                    if(this.buyNums >= this.proNums){
                        return false;
                    }
                    console.log(parseInt(this.data.activepay));
                    if(parseInt(this.data.activepay) >= this.buyNums) {
                        this.buyNums++;
                        if(this.buyNums == parseInt(this.data.activepay)) {
							return;
						}
					}
                    this.buyNums = parseInt(this.data.activepay);
                    alert("超出限购范围");
				}
			},
			reduceNums: function() {
				if(this.buyNums <= 1) {
					return false;
				}
				this.buyNums--;
			},
			hideFormatPop: function(evt){
				evt.stopPropagation();
				this.formatPopShow = false;
			},
			showFormatPop: function(){
				this.formatPopShow = true;
			}
		},
		events: {
			showSonMes: function(mes) {
				if(typeof mes==='string'&&mes.length > 0) {
					this.toastMessage = mes;
					this.toastShow = true;
				}
			},
			buyNow: function() {
                if(!this.formatPopShow == true) {
                    this.formatPopShow = true;
                    console.log(this.data.activepay);
                    return false;
                }
                if(this.proNums <= 0) {
                    this.toastMessage = '商品暂时缺货';
                    this.toastShow = true;
                    return false;
                }else if(this.buyNums < 1) {
                    this.toastMessage = '购买数量不能小于1';
                    this.toastShow = true;
                    return false;
                }else if(this.buyNums > this.proNums) {
                    this.toastMessage = '购买数量超过库存数量';
                    this.toastShow = true;
                    return false;
                }
                let cartObj = {};
                let cartFormat = this.guige.length > 0 ? this.guige.join(',') : '';
                let cartFormatName = this.guige.length > 0 ? this.guigeName.join('-') : '';
                cartObj = {
                    id:this.$route.params.pid,
                    shotcut:this.data.shotcut,
                    name:this.data.name,
                    price:this.data.price,
                    deliverytime:this.data.deliverytime,
                    peisongok:this.data.peisongok,
                    format:cartFormat,
                    formatName:cartFormatName,
                    nums:this.buyNums,
                    store:this.proNums,
                    activestu:this.data.activestu
                };


                var _self = this;
                var shoping = JSON.parse(sessionStorage.getItem("myCart"));
                if(this.data.peisongok == 0) {
                    alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                    _self.toastMessage = "";
                    _self.toastShow = false;
                    this.$router.go({name: 'index'});
                    return false;
                }
                if(shoping != null) {
                    for(let i = 0; i < shoping.length; i++) {
                        if (shoping[i]["deliverytime"] != this.data.deliverytime) {
                            if (this.data.peisongok == 1 && this.data.deliverytime == 0) {
                                alert("亲！您选购的菜品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                this.$router.go({name: 'cart'});
                                return false;
                            } else if (this.data.peisongok == 1 && this.data.deliverytime == 1) {
                                alert("亲！您选购的菜品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！！");
                                this.$router.go({name: 'cart'});
                                return false;
                            }
                        }
                    }
                }
                this.setCart(cartObj);
                cartObj = {};
                cartFormat = null;
                this.formatPopShow = false;
                this.stoastMessage = '加入购物车成功';
                this.stoastShow = true;
                this.$router.go({name:'cart'});
			},
			addCart : function() {
                if(!this.formatPopShow == true) {
                    this.formatPopShow = true;
                    return false;
				}
                if(this.proNums <= 0) {
                    this.toastMessage = '商品暂时缺货';
                    this.toastShow = true;
                    return false;
                } else if (this.buyNums < 1) {
                    this.toastMessage = '购买数量不能小于1';
                    this.toastShow = true;
                    return false;
                } else if (this.buyNums > this.proNums) {
                    this.toastMessage = '购买数量超过库存数量';
                    this.toastShow = true;
                    return false;
                }
                let cartObj = {};
                let cartFormat = this.guige.length > 0 ? this.guige.join(',') : '';
                let cartFormatName = this.guige.length > 0 ? this.guigeName.join('-') : '';
                cartObj = {
                    id:this.$route.params.pid,
                    shotcut:this.data.shotcut,
                    name:this.data.name,
                    price:this.data.price,
                    deliverytime:this.data.deliverytime,
                    peisongok:this.data.peisongok,
                    format:cartFormat,
                    formatName:cartFormatName,
                    nums:this.buyNums,
                    store:this.proNums,
                    activestu:this.data.activestu,
                };
                var _self = this;
                var shoping = JSON.parse(sessionStorage.getItem("myCart"));
                if(this.data.peisongok == 0) {
                    alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                    _self.toastMessage = "";
                    _self.toastShow = false;
					sessionStorage.removeItem("myCart");
                    this.$router.go({name: 'index'});
                    return false;
                }
                if(shoping != null) {
                    for(let i = 0; i < shoping.length; i++) {
                        if (shoping[i]["deliverytime"] != _self.data.deliverytime) {
                            if (_self.data.peisongok == 1 && _self.data.deliverytime == 0) {
                                alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                this.$router.go({name: 'cart'});
                                return false;
                            } else if (_self.data.peisongok == 1 && _self.data.deliverytime == 1) {
                                alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！！");
                                this.$router.go({name: 'cart'});
                                return false;
                            }
                        }
                    }
                }
                this.setCart(cartObj);
                cartObj = {};
                cartFormat = null;
                this.formatPopShow = false;
                this.stoastMessage = '加入购物车成功';
                this.stoastShow = true;
            },
            filters: {
                time: function (value) {
                    let d = new Date(parseInt(value) * 1000);
                    var hours = d.getHours();
                    var minutes = d.getMinutes();
                    var seconds = d.getSeconds();
                    return (hours > 9 ? hours : '0' + hours) + ':' + (minutes > 9 ? minutes : '0' + minutes) + ":" + (seconds > 9 ? seconds : '0' + seconds)
                }
            }
		}
	}
</script>