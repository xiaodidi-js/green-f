<style scoped>
	.nowrap{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.com-wrapper{
		width:100%;
		height:100%;
		background-color:#FFF;
	}

	.htimer{
		width:100%;
		padding:0.5rem 0rem;
		font-size:1.4rem;
		color:#808080;
		text-align:center;
		background-color:#F2F2F2;
	}

	.card-box{
		width:97%;
		height:auto;
		padding:0% 0% 0% 3%;
		border-bottom:#E6E6E6 dashed 1px;
	}

	.card-box .pro-mes{
		width:97%;
		padding:3% 3% 3% 0%;
		border-bottom:#F2F2F2 1px solid;
		font-size:0;
	}

	.card-box:last-child{
		border-bottom:none;
	}

	.card-box .pro-mes .shotcut,.card-box .pro-mes .words{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
	}

	.card-box .pro-mes .shotcut{
		width:22%;
		padding-top:22%;
		margin-right:3%;
		background-color:#DDD;
		background-size:cover;
		background-position:center;
		background-repeat:no-repeat;
		overflow:hidden;
	}

	.card-box .pro-mes .words{
		width:75%;
	}

	.card-box .pro-mes .words .name{
		width:100%;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		overflow:hidden;
	}

	.card-box .pro-mes .words .money{
		font-size:1.4rem;
		color:#F9AD0C;
		text-align:left;
		margin-top:0.7rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.card-box .pro-mes .words .unit{
		font-size:1.2rem;
	}

	.card-box .pro-mes .com-text{
		width:96%;
		height:10.8rem;
		font-size:1.4rem;
		line-height:1.8rem;
		color:#333;
		background-color:#F2F2F2;
		margin:0rem 0rem 1rem 0rem;
		padding:2%;
		border-radius:0.3rem;
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
	<div class="com-wrapper" style="margin-top: 46px;">
		<!-- 头部时间 -->
		<div class="htimer nowrap">成交时间:{{ data.createtime }}</div>
		<!-- 评价详情 -->
		<div class="card-box">
			<div class="pro-mes">
				<div class="shotcut" :style="{backgroundImage:'url('+data.shotcut+')'}"></div>
				<div class="words">
					<div class="name">{{ data.name }}<label v-if="data.count>1">等多件商品</label></div>
					<div class="money">
						<label class="unit">¥</label>
						{{ data.price }}
					</div>
				</div>
			</div>
			<div class="pro-mes">
				<textarea class="com-text" placeholder="请输入申请售后的原因" v-model="data.content"></textarea>
				<pic-uploader :imgs.sync="data.imgs" :toast-show.sync="toastShow" :toast-message.sync="toastMessage"></pic-uploader>
			</div>
		</div>
	</div>

	<!-- 底部按钮 -->
	<x-button text="提交申请" :disabled="btnDis" style="position:fixed;bottom:0;left:0;border-radius:0;margin:0;" @click="submit"></x-button>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>

	<!-- loading加载框 -->
	<loading :show="loadingShow" :text="loadingMessage"></loading>
</template>

<script>
import XButton from 'vux/src/components/x-button'
import Toast from 'vux/src/components/toast'
import PicUploader from 'components/pic-uploader'
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
				shotcut: '',
				name: '',
				price: '',
				imgs: [
					{url:'',state:0,active:1},
					{url:'',state:0,active:0},
					{url:'',state:0,active:0},
					{url:'',state:0,active:0}
				],
				content: '',
				count: 0
			}
		}
	},
	components: {
		XButton,
		Toast,
		PicUploader,
		Loading
	},
	route: {
		
	},
	ready() {
		let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
		ustore = JSON.parse(ustore);
		this.$http.get(localStorage.apiDomain+'public/index/user/afterservice/uid/'+ustore.id+'/token/'+ustore.token+'/oid/'+this.$route.params.oid).then((response)=>{
			if(response.data.status===1){
				this.data.createtime = response.data.createtime;
				this.data.shotcut = response.data.shotcut;
				this.data.name = response.data.name;
				this.data.price = response.data.price;
				this.data.count = response.data.count; 
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
	methods: {
		submit: function(){
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			let pdata = {uid:ustore.id,token:ustore.token,oid:this.$route.params.oid,content:this.data.content,imgs:JSON.stringify(this.data.imgs)};
			this.btnDis = true;
			this.loadingMessage = '正在提交';
			this.loadingShow = true;
			this.$http.post(localStorage.apiDomain+'public/index/user/afterservice',pdata).then((response)=>{
				this.loadingShow = false;
				this.btnDis = false;
				this.toastMessage = response.data.info;
				this.toastShow = true;
				if(response.data.status===1){
					let context = this;
					setTimeout(function(){
						context.$router.replace({name:'service',params:{oid:context.$route.params.oid}});
					},800);
				}else if(response.data.status===-1){
					let context = this;
					setTimeout(function(){
						context.clearAll();
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
						context.$router.go({name:'login'});
					},800);
				}
			},(response)=>{
				this.loadingShow = false;
				this.btnDis = false;
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
			});
		}
	}
}

</script>