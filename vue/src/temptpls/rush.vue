<style scoped>

</style>

<template>
	<!-- 头部 -->
	<x-header style="background-color:#343136;" :left-options="{showBack:true,backText:''}">限时抢购</x-header>
	<!-- 限时抢购 -->
	<tap-card></tap-card>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
import XHeader from 'vux/src/components/x-header'
import TapCard from 'components/tap-card'
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
		XHeader,
		TapCard,
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
		
	}
}

</script>