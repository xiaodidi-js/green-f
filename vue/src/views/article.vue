<style>
	div#article.article{
		width:100%;
		height:auto;
		overflow:hidden;
	}

	div#article.article img,div#article.article table,div#article.article embed,div#article.article object,div#article.article div,div#article.article p{
		max-width:100% !important;
	}
</style>

<template>
	<div id="article" class="article">
		<spinner class="my-spinner"></spinner>
	</div>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
	import Spinner from'components/spinner'
	import Toast from 'vux/src/components/toast'

	export default{
		components: {
			Spinner,
			Toast
		},
		data() {
			return {
				toastShow:false,
				toastMessage:''
			}
		},
		ready() {
			this.$http.get(localStorage.apiDomain+'public/index/index/articledetail/cid/'+this.$route.params.cid).then((response)=>{
				if(response.data.status===1){
					document.getElementById('article').innerHTML = response.data.content.content;
				}else{
					this.toastMessage = response.data.info;
					this.toastShow = true;
				}
			},(response)=>{
				this.toastMessage = "网络开小差啦~";
				this.toastShow = true;
			});
		}
	}
</script>