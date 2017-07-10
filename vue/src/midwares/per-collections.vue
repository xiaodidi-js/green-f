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
            data(transition) {

            }
        },
		watch: {
			$route(to) {
				if(to.name === 'per-collections') {
                    this.getData();
				}
			}
		},
		ready() {
		    this.getData();
		},
		methods: {
		    getData() {
                this.$getData('/index/user/usercollection/uid/' + this.$ustore.id + '/token/' + this.$ustore.token).then((res)=>{
                    if(res.status === 1) {
                        this.data = res.list;
                    }else if(res.status===-1){
                        this.toastMessage = res.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    }else{
                        this.toastMessage = res.info;
                        this.toastShow = true;
                    }
                },(res)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
			}
		},
		events: {
			showMes: function(mes){
				if(typeof mes === 'string' && mes.length > 0) {
					this.toastMessage = mes;
					this.toastShow = true;
				}
			},
			delData: function(id) {
				if(typeof id === 'number') {
					for(let pl = 0;pl < this.data.length; pl++) {
						if(id == this.data[pl].id) {
							this.data.splice(pl,1);
							break;
						}
					}
				} else if (typeof id === 'object') {
					for(let pa = 0; pa < id.length; pa++) {
						for(let pl = 0; pl < this.data.length; pl++) {
							if(id[pa] == this.data[pl].id) {
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