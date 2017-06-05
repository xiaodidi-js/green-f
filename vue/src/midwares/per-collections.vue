	<style scoped>
	
</style>

<template>
	<div class="sub-content">
		<collection :collections="data"></collection>
	</div>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
	import Toast from 'vux/src/components/toast'
	import Collection from 'components/collection'
	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		components: {
			Collection,
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
			this.$http.get(localStorage.apiDomain+'public/index/user/usercollection/uid/'+ustore.id+'/token/'+ustore.token).then((response)=>{
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
				}else{
					this.toastMessage = response.data.info;
					this.toastShow = true;
				}
			},(response)=>{
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
			});
		},
		events: {
			showMes: function(mes){
				if(typeof mes==='string'&&mes.length>0){
					this.toastMessage = mes;
					this.toastShow = true;
				}
			},
			delData: function(id){
				if(typeof id==='number'){
					for(let pl=0;pl<this.data.length;pl++){
						if(id==this.data[pl].id){
							this.data.splice(pl,1);
							break;
						}
					}
				}else if(typeof id==='object'){
					for(let pa=0;pa<id.length;pa++){
						for(let pl=0;pl<this.data.length;pl++){
							if(id[pa]==this.data[pl].id){
								this.data.splice(pl,1);
								break;
							}
						}
					}
				}
			}
		}
	}
</script>