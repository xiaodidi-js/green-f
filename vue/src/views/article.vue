

<template>
	<div id="article-body">
		<div id="article" class="article">
			<spinner class="my-spinner"></spinner>
		</div>
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
				toastMessage:'',
				list:[]
			}
		},
		ready() {
            this.$http.get(localStorage.apiDomain+'public/index/index/articledetail/cid/'+this.$route.params.cid).then((response)=>{
                if(response.data.status === 1) {
                    document.getElementById('article').innerHTML = response.data.content.content;
                    this.list = response.data.content;
                    console.log(this.list);
                }else{
                    this.toastMessage = response.data.info;
                    this.toastShow = true;
                }
            },(response)=>{
                this.toastMessage = "网络开小差啦~";
                this.toastShow = true;
            });
		},
		methods: {

		}
	}
</script>

<style>

	.lyt-logo{
		width: 100%;
		clear: both;
		position: relative;
		height: 50px;
		line-height: 50px;
	}
	.lyt-logo .readying {
		float:right;
	}

	.lyt-logo span {
		font-size: 16px;
		color: #3cc51f;
		line-height: 50px;
		padding-left: 15px;
		display: block;
		width: 56%;
		height: 40px;
		float: left;
		text-overflow: ellipsis;
		overflow: hidden;
	}

	#article-body {
		width: 100%;
		height: 100%;
		background: #fff;
	}

	div#article.article{
		width: 95%;
		height: auto;
		overflow: hidden;
		margin: 55px auto 20px;
	}

	div#article.article img,div#article.article table,div#article.article embed,div#article.article object,div#article.article div,div#article.article p {
		max-width:100% !important;
		width:100%;
		font-size:16px;
		line-height: 30px;
		text-align:justify;
	}
</style>