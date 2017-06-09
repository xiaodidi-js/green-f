<style scoped>
	
</style>

<template>
	<div class="sub-content">
		<card-coupon></card-coupon>
	</div>

	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>
</template>

<script>
	import CardCoupon from 'components/card-coupon'
	import Toast from 'vux/src/components/toast'

	export default{
		components: {
			CardCoupon,
			Toast
		},
		data() {
			return {
				toastMessage:'',
				toastShow:false,
				data: []
			}
		},
		route: {

		},
		ready() {
			
		},
		events: {
			showMes: function(mes){
				if(typeof mes==='string'&&mes.length>0){
					this.toastMessage = mes;
					this.toastShow = true;
				}
			}
		}
	}
</script>