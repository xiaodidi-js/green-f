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

import Swiper from 'vux/src/components/swiper'
import Scroller from 'vux/src/components/scroller'
import Toast from 'vux/src/components/toast'
import Loading from 'vux/src/components/loading'

export default{
	data() {
		return {
			toastMessage:'',
            loadingMessage:'',
			toastShow:false,
			data:{
				banners:[],
				columns:[],
                title: '',
                list: []
			},
			banners: [],
            searchKey: '',
		}
	},
    components: {
        Swiper,
        Scroller,
        Toast,
        Loading
    },
	route: {
		
	},
	ready() {
		var _this = this;
		//回车搜索
        document.onkeydown = function(event) {
            var e = event || window.event || arguments.callee.caller.arguments[0];
            if(e && e.keyCode == 13) {
                _this.getData('');
			}
		};
        this.getData('');
	},
    methods: {
        getData: function(sk) {
            let url = localStorage.apiDomain+'/public/index/index/classifylist/cid/'+this.$route.params.cid+'/action/'+this.column;
            if(sk.length > 0) url += '/search/'+sk;
            this.$http.get(url).then((response) => {
                this.data.list = response.data.list;
            },(response)=>{
                this.toastMessage = "网络开小差啦~";
                this.toastShow = true;
            });
        },
        changeColumn: function(col){
            if(this.column===col){
                return false;
            }
            this.column = col;
            this.getData('');
        }
	},
	events: {
		goSearch: function(skey){
			this.getData(skey);
		}
	}
}

</script>