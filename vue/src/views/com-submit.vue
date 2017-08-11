<style scoped>
	.nowrap{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.htimer{
		width:100%;
		padding:0.5rem 0rem;
		font-size:1.4rem;
		color:#808080;
		text-align:center;
		background-color:#F2F2F2;
	}

	.fixbtn{
		position:fixed;
		bottom:0;
		left:0;
		border-radius:0;
		margin:0;
	}
</style>

<style>
.weui_btn_default{
	background-color:#F9AD0C !important;
	color:#fff !important;
}

.weui_btn_default:active{
	background-color:#DE9A08 !important;
}

.weui_btn_disabled.weui_btn_default{
	background-color:#F3C76A !important;
}
</style>

<template>
	<!-- 头部时间 -->
	<div class="htimer nowrap">成交时间:{{ data.createtime }}</div>
	<!-- 评价组件 -->
	<comment-group :products.sync="data.list"></comment-group>
	<!-- 底部按钮 -->
	<x-button text="发表评价" :disabled="btnDis" class="fixbtn" @click="submitComment" style="line-height: 2.777;z-index:100;"></x-button>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	<!-- loading加载框 -->
	<loading :show="loadingShow" :text="loadingMessage"></loading>
</template>

<script>
import CommentGroup from 'components/comment-group'
import XButton from 'vux/src/components/x-button'
import Toast from 'vux/src/components/toast'
import Loading from 'vux/src/components/loading'
import { clearAll } from 'vxpath/actions'

export default{
	vuex: {
		actions: {
			clearAll
		}
	},
	data() {
		return {
			loadingShow:false,
			loadingMessage:'',
			toastMessage:'',
			toastShow:false,
			btnDis:false,
			data:{
				createtime: '',
				list: []
			}
		}
	},
	components: {
		CommentGroup,
		XButton,
		Toast,
		Loading
	},
	route: {
		data(transition) {
			if(typeof transition.to.params.oid === 'undefined' || !transition.to.params.oid) {
				transition.abort();
				transition.go({name:'index'});
			}
		}
	},
	ready() {
		this.$getData('/index/user/productscommention/uid/' + this.$ustore.id + '/token/' + this.$ustore.token+'/oid/' + this.$route.params.oid).then((res)=>{
            let context = this;
			if(res.status === 1) {
				this.data.createtime = res.createtime;
				this.data.uyhost = res.uyhost;
				this.data.list = res.list;
			}else if(res.status===-1){
				this.toastMessage = res.info;
				this.toastShow = true;
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
		},(res) => {
			this.toastMessage = '网络开小差了~';
			this.toastShow = true;
		});
	},
	methods: {
		submitComment: function(){
			if(this.data.list.length<=0){
				this.toastMessage = '提交数据为空';
				this.toastShow = true;
				return false;
			}
			for(let litem = 0; litem < this.data.list.length;litem++) {
				if(this.data.list[litem].stars <= 0) {
					this.toastMessage = '还有未完成的评分';
					this.toastShow = true;
					return false;
				} else if(this.data.list[litem].content == '') {
					this.toastMessage = '还有未填写的评论';
					this.toastShow = true;
					return false;
				}
			}
			this.btnDis = true;
			this.loadingMessage = '正在提交';
			this.toastShow = true;
			let pdata = {
			    uid: this.$ustore.id,
				token: this.$ustore.token,
				oid: this.$route.params.oid,
				'comments': JSON.stringify(this.data.list)
			};
			this.$postData('/index/user/productscommention',pdata).then((response)=>{
				this.loadingShow = false;
				this.toastMessage = response.info;
				this.toastShow = true;
				if(response.status===1){
					let context = this;
					setTimeout(function(){
						context.$router.replace({name:'order-detail',params:{oid:context.$route.params.oid}});
					},800);
				}else if(response.status === -1) {
					let context = this;
					setTimeout(function(){
						context.clearAll();
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
						context.$router.go({name:'login'});
					},800);
				}else{
					this.btnDis = false;
				}
			},(response)=>{
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
				this.btnDis = false;
			});
		}
	}
}

</script>