<style scoped>
	
</style>

<template>
	<div class="sub-content">
		<!-- 栏目图片 -->
		<col-image :img-mes="data.imgmessage"></col-image>
		<!-- 产品列表 -->
		<card-square :info="data.grouplist"></card-square>
		<!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	</div>
</template>

<script>
	import ColImage from 'components/col-image'
	import CardSquare from 'components/card-square'
	import Toast from 'vux/src/components/toast'

	export default{
		components: {
			ColImage,
			CardSquare,
			Toast
		},
		data() {
			return {
				toastMessage:'',
				toastShow:false,
				data: {
					imgmessage: {
						src: '',
						name: ''
					},
					grouplist: {
						title: '',
						list: []
					}
				}
			}
		},
		route: {
			data(transition) {
				this.$getData('/index/index/columninfo/id/' + this.$route.params.cid).then((res)=>{
					transition.next({
						data: res
					});
				},(res)=>{
					this.toastMessage = '网络开小差了~';
					this.toastShow = true;
				});
			}
		},
		ready() {
			
		}
	}
</script>