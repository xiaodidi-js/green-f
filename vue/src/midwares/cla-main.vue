<style scoped>
	.sub-content{height:87%;}
</style>

<template>
	<div class="sub-content">
		<!-- 分类列表 -->
		<card-types :types="data"></card-types>
		<!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	</div>
</template>

<script>
import CardTypes from 'components/card-types'
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
			CardTypes,
			Toast
		},
		route: {

		},
		ready() {
			this.$http.get(localStorage.apiDomain + 'public/index/index/columns').then((response)=>{
				localStorage.setItem("classify",JSON.stringify(response.data.classify));
				this.data = JSON.parse(localStorage.getItem("classify"));
			},(response)=>{
				this.toastMessage = "网络开小差啦~";
				this.toastShow = true;
			})
		}
	}

</script>