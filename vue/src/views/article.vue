<template>
	<div id="article-body">
		<div class="lyt-logo">
			<div class=""></div>
			<img src="../images/logo_lv.png" alt="" style="width:40px;height:40px;float:left;" />
			<span id="product">{{ list.title }}</span>
		</div>
		<div class="article-ready">
			<div class="readying" style="float:left;line-height:35px;">阅读量：<i id="visitor">{{ list.visitor }}</i></div>
			<div class="activity-data">{{ list.createtime | time }}</div>
		</div>
		<div id="article" class="article">
			<spinner class="my-spinner"></spinner>
		</div>
	</div>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	<!-- 回到顶部 -->
	<div class="goto"></div>

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
            $(".goto").click(function(){
                $("html,body").animate({
                    scrollTop:0
                },200);
            });
            this.$getData('/index/index/articledetail/cid/' + this.$route.params.cid).then((res)=>{
                if(res.status === 1) {
                    $("#article").html(res.content.content);
                    this.list = res.content;
                }else{
                    this.toastMessage = res.info;
                    this.toastShow = true;
                }
            },(res)=>{
                this.toastMessage = "网络开小差啦~";
                this.toastShow = true;
            });
		},
        filters: {
            time: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var years = d.getFullYear();
                var month = d.getMonth() + 1;
                var days = d.getDate();
                return years + "-" + month + "-" + days;
            }
        },
		methods: {

		}
	}
</script>

<style>

	.lyt-logo{
		/*width: 100%;*/
		clear: both;
		position: relative;
		height: 50px;
		line-height: 50px;
		color:#333;
		margin: 0px 5px;
		padding-top: 10px;
	}
	#article-body .readying {
		float:right;
		font-size:14px;
	}

	#article-body .activity-data {
		float:right;
		line-height:35px;
		margin-right:0px;
	}

	#article-body .article-ready {
		position: relative;
		height: 35px;
		margin: 0px 10px;
		font-size:14px;
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
		margin-top: 4.5rem;
		width: 100%;
		height: auto;
		background: #fff;
		clear: both;
	}

	div#article.article{
		width: 95%;
		height: auto;
		overflow: hidden;
		margin: 10px auto 0px;
		padding-bottom: 20px;
	}

	div#article.article img,div#article.article table,div#article.article embed,div#article.article object,div#article.article div,div#article.article p {
		max-width:100% !important;
		width:100%;
		font-size:14px;
		line-height: 30px;
		text-align:justify;
	}
</style>