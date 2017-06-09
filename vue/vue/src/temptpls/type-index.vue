<style scoped>
#app{
	position: relative;
}

.container{
	background-color:#fff;
	width:100%;
	height:3.6rem;
	overflow:hidden;
}

.box{
	white-space:nowrap;
	font-size:0;
	height:3.6rem;
	padding:0rem;
	width:100%;
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
	margin-top:0.8rem;
	margin-bottom:0.6rem;
	padding:0rem 1.5rem;
	border-right:#EFEFEF solid 1px;
	width:auto;
	position:relative;
}

.box-item .line{
	width:100%;
	max-width:100%;
	height:0.2rem;
	position:absolute;
	bottom:-0.8rem;
	left:0rem;
	background-color:#fff;
}

.box-item.active{
	color:#f9ad0c;
}

.box-item.active .line{
	background-color:#f9ad0c;
}

.box-item .tag{
	font-size:0.8rem;
	line-height:1.2rem;
	letter-spacing:.1rem;
	color:#ff7486;
	position:absolute;
	top:-0.8rem;
	right:0.35rem;
	padding:0;
	margin:0;
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
		<scroller v-ref:scroller lock-y :scrollbar-x="false">
			<div id="scbox" class="box">
				<div class="box-item" :class="{'active':$index===1}" v-for="col in data.columns">
					{{ col.name }}
					<label class="tag" v-if="col.tag !== ''">{{ col.tag }}</label>
					<div class="line"></div>
				</div>
			</div>
		</scroller>
	</div>
	<!-- 栏目图片 -->
	<col-image :img-mes="data.imgmessage"></col-image>
	<!-- 产品列表 -->
	<card-square :info="data.grouplist"></card-square>
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
import ColImage from 'components/col-image'
import CardSquare from 'components/card-square'
import Bottom from 'components/bottom'
import BottomSeparator from 'components/bottom-separator'
import Toast from 'vux/src/components/toast'

export default{
	data() {
		return {
			toastMessage:'',
			toastShow:false,
			data:{}
		}
	},
	components: {
		Swiper,
		Scroller,
		ColImage,
		CardSquare,
		Bottom,
		BottomSeparator,
		Toast
	},
	route: {
		data(transition) {
			this.$http.get('src/data/type-index.json').then((response)=>{
				transition.next({
					data: response.data
				});
				this.$nextTick(()=>{
					let bis = document.getElementsByClassName('box-item');
					let bwid = 0;
					for(let item=0;item<bis.length;item++){
						bwid+=bis[item].offsetWidth;
					}
					document.getElementById('scbox').style.width = bwid ? bwid +'px' : '100%';
					this.$refs.scroller.reset();
				});
			},(response)=>{
				this.toastMessage = "网络开小差啦~";
				this.toastShow = true;
			})
		}
	},
	ready() {

	}
}

</script>