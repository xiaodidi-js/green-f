<style scoped>
#app{
	position: relative;
}
.container{
	background-color:#fff;
	width:100%;
	height:4rem;
	overflow:hidden;
}
.box{
	white-space:nowrap;
	font-size:0;
	height:2rem;
	padding:1rem 0rem;
	width:auto;
	float:left;
}
.box-item:last-child{
	border:none;
}
.box-item{
	display:inline-block;
	font-size:1.4rem;
	vertical-align:middle;
	text-align:center;
	line-height:2rem;
	padding:0rem 1.5rem;
	border-right:#EFEFEF solid 1px;
}
</style>

<style>
.dots-my>a>.vux-icon-dot{
	background:#fff !important;
}
.dots-my>a>.vux-icon-dot.active{
	background:#333 !important;
}
</style>
<template>
	<!-- 轮播图 -->
	<swiper :list="data.banners" loop dots-position="center" :show-desc-mask="false" :aspect-ratio="650/1242" auto dots-class="dots-my"></swiper>
	<!-- 导航栏 -->
	<div class="container">
		<scroller lock-y :scrollbar-x="false">
			<div class="box">
				<div class="box-item" v-for="col in data.columns">{{ col.name }}</div>
			</div>
		</scroller>
	</div>
	<!-- 栏目选项卡 -->
	<card-column :columns="data.maincolumns"></card-column>
	<!-- 热销产品排行榜 -->
	<card-rectangle :hotproducts="data.hotproducts"></card-rectangle>
	<!-- 精选文章列表 -->
	<card-image :articles="data.articles"></card-image>

	<!-- 底部间距 -->
	<bottom-separator></bottom-separator>
	<!-- 底部选项卡 -->
	<bottom></bottom>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>

import Swiper from 'vux/src/components/swiper'
import Scroller from 'vux/src/components/scroller'
import CardColumn from 'components/card-column'
import CardRectangle from 'components/card-rectangle'
import CardImage from 'components/card-image'
import Bottom from 'components/bottom'
import BottomSeparator from 'components/bottom-separator'
import Toast from 'vux/src/components/toast'

export default{
	data() {
		return {
			toastMessage:'',
			toastShow:false,
			data:[]
		}
	},
	components: {
		Swiper,
		Scroller,
		CardColumn,
		CardRectangle,
		CardImage,
		Bottom,
		BottomSeparator,
		Toast
	},
	route: {
		data(transition) {
			this.$http.get('src/data/index.json').then((response)=>{
				transition.next({
					data: response.data
				})
				//console.log(this.data.imgmessage);
			},(response)=>{
				this.toastMessage = "网络开小差啦~";
				this.toastShow = true;
			})
		}
	},
	ready() {
		/*this.$nextTick(()=>{
			this.$refs.scroller.reset()
		})*/
	}
}

</script>