<style scoped>
	
</style>

<template>
	<div class="sub-content">
		<card-address :addresses="data"></card-address>
	</div>

	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>
</template>

<script>
	import Toast from 'vux/src/components/toast'
	import CardAddress from 'components/card-address'
	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		components: {
			CardAddress,
			Toast
		},
		data() {
			return {
				toastShow: false,
				toastMessage: '',
				data: []
			}
		},
		route: {

		},
		ready() {
			this.$getData('/index/user/addresslist/uid/' + this.$ustore.id + '/token/' + this.$ustore.token).then((res)=>{
				if(res.status === 1) {
					this.data = res.list;
				}else if(res.status === -1) {
					this.toastMessage = res.info;
					this.toastShow = true;
					let context = this;
					setTimeout(function(){
						context.clearAll();
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
						context.$router.go({name:'login'});
					},800);
				}
			},(res)=>{
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
			})
		},
		events: {
			showMes: function(mes){
				if(typeof mes==='string' && mes.length > 0) {
					this.toastMessage = mes;
					this.toastShow = true;
				}
			}
		}
	}
</script>