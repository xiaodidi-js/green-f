<template>
	<div class="wrapper">
		<!-- 导航栏 -->
		<router-view keep-alive></router-view>
        <!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
		<!-- loading加载框 -->
		<loading :show="loadingShow" :text="loadingMessage"></loading>
	</div>
</template>
<script>

import Toast from 'vux/src/components/toast'
import Loading from 'vux/src/components/loading'

export default{
	data() {
		return {
			data:{

			},
		}
	},
    components: {
        Toast,
        Loading
    },
	route: {
		
	},
	ready() {

	},
    methods: {

	},
	events: {

	}
}

</script>

<style type="text/css">

	#app{
		position: relative;
	}

	.wrapper{
		width:100%;
		height:auto;
	}
	.container{
		width:100%;
		height:3.6rem;
		overflow:hidden;
	}

	.box{
		white-space:nowrap;
		font-size:0;
		height:3.6rem;
		padding:0rem;
		width:100%;
		float:left;
	}

	.box-item:last-child{
		border:none;
	}

	.box-item{
		display:inline-block;
		font-size:1.4rem;
		vertical-align:middle;
		text-align:center;
		line-height:2rem;
		margin-top:0.8rem;
		margin-bottom:0.6rem;
		padding:0rem 1.5rem;
		border-right:#EFEFEF solid 1px;
		width:auto;
		position:relative;
	}

	.box-item .line{
		width:100%;
		max-width:100%;
		height:0.2rem;
		position:absolute;
		bottom:-0.8rem;
		left:0rem;
		background-color:#fff;
	}

	.box-item.active{
		color:#f9ad0c;
	}

	.box-item.active .line{
		background-color:#f9ad0c;
	}

	.box-item .tag{
		font-size:0.8rem;
		line-height:1.2rem;
		letter-spacing:.1rem;
		color:#ff7486;
		position:absolute;
		top:-0.8rem;
		right:0.35rem;
		padding:0;
		margin:0;
	}

	.dots-my>a>.vux-icon-dot{
		background:#fff !important;
	}
	.dots-my>a>.vux-icon-dot.active{
		background:#333 !important;
	}

	.weui_toast_text .weui_toast_content {
		font-size:14px;
	}

</style>