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
		background-color:#fff;
	}

	.card-box .pro-mes{
		width:97%;
		padding:3% 3% 3% 0%;
		border-bottom:#F2F2F2 1px solid;
		font-size:0;
	}

	.card-box .pro-mes:last-child{
		border-bottom:none;
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

	.card-box .pro-mes .img-area{
		width:100%;
		height:auto;
		font-size:0;
		text-align:center;
	}

	.card-box .pro-mes .img-area .image{
		display:inline-block;
		vertical-align:middle;
		width:22%;
		padding-top:22%;
		margin-right:3%;
		border:#D6D5D5 solid 1px;
		background-image:url('../images/camera.png');
		background-position:center;
		background-size:40%;
		background-repeat:no-repeat;
		overflow:hidden;
	}

	.card-box .pro-mes .img-area .image:last-child{
		margin-right:0%;
	}

	.card-box .pro-mes .img-area .image.unupload:active{
		background-size:30%;
		background-color:#F9F9F9;
	}

	.card-box .pro-mes .img-area .image.upload{
		background-size:cover;
	}

	.card-box .pro-mes .com-box{
		width:96%;
		padding:2%;
		border-radius:0.3rem;
		background-color:#F2F2F2;
		font-size:0;
		margin-bottom:0.7rem;
		border:#B3B3B3 solid 1px;
	}

	.card-box .pro-mes .com-box .boxes{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
		color:#808080;
		line-height:1.8rem;
	}

	.card-box .pro-mes .com-box .boxes.left{
		width:65%;
		margin-right:2%;
		text-align:left;
	}

	.card-box .pro-mes .com-box .boxes.right{
		width:33%;
		text-align:right;
	}

	.card-box .pro-mes .com-box.my-com{
		border:#F9AD0C solid 1px;
		background-color:#FBE7BC;
	}

	.card-box .pro-mes .com-box .my-content{
		width:100%;
		height:auto;
		font-size:1.4rem;
		color:#333;
		margin-top:0.5rem;
		word-break:break-all;
	}

	.card-box .pro-mes .waitting{
		width:100%;
		font-size:1.4rem;
		color:#808080;
		text-align:center;
		padding:1rem 0rem;
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
	<!-- 评价详情 -->
	<div class="com-wrapper">
		<!-- 头部时间 -->
		<div class="htimer nowrap">成交时间:{{ data.createtime }}</div>
		<!-- 售后详情 -->
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
				<div class="com-box my-com" style="margin-bottom:0rem;">
					<div class="boxes left nowrap">申请原因</div>
					<div class="boxes nowrap right">[{{ data.message.createtime }}]</div>
					<div class="my-content">
						{{ data.message.content }}
					</div>
				</div>
				<div style="margin-top:0.7rem;" v-if="data.message.imgs&&data.message.imgs.length>0">
					<pic-shower :imgs="data.message.imgs"></pic-shower>
				</div>
			</div>
			<div class="pro-mes" v-if="data.message.status==0">
				<div class="waitting">
					申请审核中...
				</div>
			</div>
			<div class="pro-mes" v-if="data.message.status>=1&&data.message.subs&&data.message.subs.length>0">
				<div v-for="mitem in data.message.subs">
					<div class="com-box" v-if="mitem.uid>0">
						<div class="boxes left nowrap">后台回复</div>
						<div class="boxes nowrap right">[{{ mitem.createtime }}]</div>
						<div class="my-content">
							{{ mitem.content }}
						</div>
					</div>
					<div class="com-box my-com" v-else>
						<div class="boxes left nowrap">用户回复</div>
						<div class="boxes nowrap right">[{{ mitem.createtime }}]</div>
						<div class="my-content">
							{{ mitem.content }}
						</div>
					</div>
				</div>
			</div>
			<div class="pro-mes" v-if="data.message.status==2">
				<div class="waitting">
					处理完毕
				</div>
			</div>
			<separator v-show="data.message.status==1"></separator>
		</div>
	</div>

	<!-- 发送评论 -->
	<bottom-send :fixed="true" :disbtn="sendBtn" :text.sync="sendText" v-show="data.message.status==1"></bottom-send>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
import Toast from 'vux/src/components/toast'
import PicShower from 'components/pic-shower'
import Separator from 'components/separator'
import BottomSend from 'components/bottom-send'

export default{
	data() {
		return {
			toastMessage:'',
			toastShow:false,
			sendBtn:false,
			sendText:'',
			data:{
				createtime: '',
				shotcut: '',
				name: '',
				price: '',
				count: 0,
				message: {} 
			}
		}
	},
	components: {
		Toast,
		PicShower,
		Separator,
		BottomSend
	},
	route: {
		
	},
	ready() {
		let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
		ustore = JSON.parse(ustore);
		this.$http.get(localStorage.apiDomain+'public/index/user/afterservice/uid/'+ustore.id+'/token/'+ustore.token+'/oid/'+this.$route.params.oid+'/message/1').then((response)=>{
			if(response.data.status===1){
				this.data.createtime = response.data.createtime;
				this.data.shotcut = response.data.shotcut;
				this.data.name = response.data.name;
				this.data.price = response.data.price;
				this.data.count = response.data.count;
				this.data.message = response.data.message;
				this.$nextTick(function(){
					document.body.scrollTop = document.body.scrollHeight;
				});
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
		sendMes: function(mes){
			if(typeof mes!='string'||mes==''){
				this.toastMessage = '发送内容不能为空';
				this.toastShow = true;
				return false;
			}
			this.sendBtn = true;
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			let pdata = {uid:ustore.id,token:ustore.token,oid:this.$route.params.oid,top:this.data.message.id,content:mes};
			this.$http.put(localStorage.apiDomain+'public/index/user/afterservice',pdata).then((response)=>{
				this.sendBtn = false;
				if(response.data.status===1){
					this.data.message.subs.push({id:response.data.id,uid:response.data.uid,content:response.data.content,createtime:response.data.createtime});
					this.sendBtn = false;
					this.sendText = '';
					this.$nextTick(function(){
						document.body.scrollTop = document.body.scrollHeight;
					});
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
				this.sendBtn = false;
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
			});
		}
	}
}

</script>