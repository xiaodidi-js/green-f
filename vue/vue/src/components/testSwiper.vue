<style scoped>
	
</style>

<template>
	<swiper :list="gallery" loop auto dots-position="center"
			:show-desc-mask="false"
			:aspect-ratio="480/480" dots-class="dots-my-orange" @touchstart.stop @touchend.stop></swiper>

	<button @click="replaceData">replace</button>
</template>

<script>
	import Swiper from 'vux/src/components/swiper'
	import SwiperItem from 'vux/src/components/swiper-item'

	export default{
		components: {
			Swiper,
			SwiperItem
		},
		data() {
			return {
				gallery:[
					{url:"http://www.baidu.com",img:"http://qgshop.b0.upaiyun.com/2016/11/19/08/51/08/upload_5c9462e857fe02a61f646f4780982d2f.jpg"},
					{url:"javascript:",img:"http://qgshop.b0.upaiyun.com/2016/11/19/08/51/09/upload_9410a7ed11a3bb4df232940e4a70d909.jpg"},
					{url:"javascript:",img:"http://qgshop.b0.upaiyun.com/2016/11/19/09/50/54/upload_0ecb4b46d3b998be77536bc012ade862.jpg"}
				],
				rdata:[
					{url:"http://www.baidu.com",img:"http://qgshop.b0.upaiyun.com/2016/11/16/03/24/55/upload_5c9462e857fe02a61f646f4780982d2f.jpg"},
					{url:"javascript:",img:"http://qgshop.b0.upaiyun.com/2016/11/16/03/24/55/upload_9410a7ed11a3bb4df232940e4a70d909.jpg"},
					{url:"javascript:",img:"http://qgshop.b0.upaiyun.com/2016/11/16/03/24/56/upload_5c9462e857fe02a61f646f4780982d2f.jpg"},
					{url:"javascript:",img:"http://qgshop.b0.upaiyun.com/2016/11/16/03/24/56/upload_9410a7ed11a3bb4df232940e4a70d909.jpg"},
					{url:"javascript:",img:"http://qgshop.b0.upaiyun.com/2016/11/16/03/24/56/upload_5c9462e857fe02a61f646f4780982d2f.jpg"}
				]
			}
		},
		methods: {
			replaceData() {
				this.gallery = this.rdata;
			}
		}
	}
</script>