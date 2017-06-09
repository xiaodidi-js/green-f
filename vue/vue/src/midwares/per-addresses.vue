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
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			this.$http.get(localStorage.apiDomain+'public/index/user/addresslist/uid/'+ustore.id+'/token/'+ustore.token).then((response)=>{
				if(response.data.status===1){
					this.data = response.data.list;
				}else if(response.data.status===-1){
					this.toastMessage = response.data.info;
					this.toastShow = true;
					let context = this;
					setTimeout(function(){
						context.clearAll();
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
						context.$router.go({name:'login'});
					},800);
				}
			},(response)=>{
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
			})
		},
		events: {
			showMes: function(mes){
				if(typeof mes==='string'&&mes.length > 0) {
					this.toastMessage = mes;
					this.toastShow = true;
				}
			}
		}
	}
</script>