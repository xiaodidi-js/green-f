<style scoped>

</style>

<template>
	<!-- 购物车 -->
	<cart></cart>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
import Cart from 'components/cart'
import Toast from 'vux/src/components/toast'

export default{
	data() {
		return {
			toastMessage:'',
			toastShow:false
		}
	},
	components: {
		Cart,
		Toast
	},
	route: {
		
	},
	ready() {
		
	},
	events: {
		showMes: function(mes){
			if(typeof mes === 'string' && mes.length > 0) {
				this.toastMessage = mes;
				this.toastShow = true;
			}
		}
	}
}

</script>