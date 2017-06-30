<template>
	<!-- 输入内容 -->
	<group title="" style="margin-top: 46px;">
		<div class="tabmain">
			<i class="iconfont user_icon icon-yonghu"></i>
			<x-input :show-clear=true placeholder="手机号码" type="number" :value.sync="data.uname" class="login-ipt"></x-input>
		</div>
		<div class="tabmain">
			<i class="iconfont user_icon icon-mima"></i>
			<x-input :show-clear=true placeholder="账号密码" type="password" :value.sync="data.pwd" class="login-ipt"></x-input>
		</div>
	</group>
	<!-- 底部选择 -->
	<bottom-check title="下次自动登录（公众场所请慎用）" desc="" :status.sync="data.auto"></bottom-check>
	<!-- 底部按钮 -->
	<div class="btn-wrapper">
		<x-button :text="btnText" :disabled="btnDis" style="line-height:47px;" @click="postData"></x-button>
		<div class="link-box">
			<a class="left" v-link="{name:'find'}">找回密码</a>
			<a class="right" v-link="{name:'register'}">免费注册</a>
		</div>
	</div>
	<!-- 输入内容 -->
	<!-- loading提示框 -->
	<loading :show="loadingShow" text="正在登录..."></loading>
	<!-- toast提示框 -->
	<!--<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>-->
	<!--<toast-msg :messages="toastMessage" :showele="toastShow"></toast-msg>-->
</template>

<script>
import Group from 'vux/src/components/group'
import XInput from 'vux/src/components/x-input'
import BottomCheck from 'components/bottom-check'
import XButton from 'vux/src/components/x-button'
import Toast from 'vux/src/components/toast'
import Loading from 'vux/src/components/loading'
import toastMsg from 'components/toast-msg'

export default{
	data() {
		return {
			loadingShow:false,
			toastMessage:'',
			toastShow:false,
			btnText:'登录',
			btnDis:false,
			data:{
				uname:'',
				pwd:'',
				auto:false
			}
		}
	},
	components: {
		Group,
		XInput,
		BottomCheck,
		XButton,
		Toast,
		Loading,
        toastMsg
	},
	route: {

	},
	ready() {
        this.data.auto = true;
	},
	methods: {
		checkBefore: function(){
			if(this.un.length <= 0 || this.up.length <= 0) {
				return false;
			}
			return true;
		},
		postData: function(){
		    var self = this;
			if(this.checkBefore() === false){
				alert('请填写登录账号和密码');
				return false;
			} else {
			    if(this.data.auto === false) {
                    alert('请选择是否下次自动登录');
				} else if(this.data.auto === true) {
                    self.toastShow = false;
				}
				this.btnText = '正在登录...';
				this.btnDis = true;
				this.loadingShow = true;
				this.$http.get(localStorage.apiDomain + 'public/index/login/useraction/uname/' + this.un + '/upwd/' + this.up).then((response)=>{
					if(response.data.status === 1) {
						let obj = {id:response.data.id,token:response.data.token,time:response.data.time};
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
						localStorage.removeItem('openid');
						sessionStorage.removeItem('openid');
						if(this.data.auto){
							localStorage.setItem('userInfo',JSON.stringify(obj));
						}else{
							sessionStorage.setItem('userInfo',JSON.stringify(obj));
						}
						this.loadingShow = false;
						this.toastMessage = response.data.info;
						this.toastShow = true;
						let context = this;
						setTimeout(function(){
							context.data.uname = '';
							context.data.pwd = '';
							context.data.auto = false;
							context.btnText = '登录';
							context.btnDis = false;
							context.$router.replace('index');
						},800);
					} else if (response.data.status === 0) {
						alert(response.data.info);
                        self.loadingShow = false;
                        self.btnText = '登录';
                        self.btnDis = false;
					} else {
						this.loadingShow = false;
						this.toastMessage = response.data.info;
						this.toastShow = true;
						this.btnText = '登录';
						this.btnDis = false;
					}
				},(response)=>{
					this.loadingShow = false;
					this.toastMessage = '网络开小差了~';
					this.toastShow = true;
					this.btnText = '登录';
					this.btnDis = false;
				});
			}
		}
	},
	computed: {
		un: function(){
			return this.data.uname.replace(/(^\s*)|(\s*$)/g,'');
		},
		up: function(){
			return this.data.pwd.replace(/(^\s*)|(\s*$)/g,'');
		}
	}
}

</script>

<style scoped>

	.msg-head {
		width:100%;
		height:4.6rem;
		color: #fff;
		line-height: 4.6rem;
		text-align: center;
		background: #35495e;
		display:block;
	}

	.msg-head .msg-back {
		width: 10%;
		font-size: 16px;
		margin-left: 1rem;
		height: 100%;
		float: left;
	}

	.msg-head .msg-back:before {
		content: "";
		position: absolute;
		display: block;
		top: 16px;
		left: 18px;
		width: 12px;
		height: 12px;
		border: 1px solid #ccc;
		border-width: 1px 0 0 1px;
		margin-left: 3px;
		margin-top: 1px;
		transform: rotate(315deg);
		-o-transform: rotate(315deg);
		-ms-transform: rotate(315deg);
		-moz-transform: rotate(315deg);
		-webkit-transform: rotate(315deg);
	}

	.msg-head .msg-title {
		font-size: 16px;
		width: 92%;
	}

	.btn-wrapper{
		width: 92%;
		margin: 5% auto 10%;
	}

	.btn-wrapper .link-box{
		width: 100%;
		position: relative;
		margin-top: 1.8rem;
		font-size: 1.4rem;
		color: #B3B3B3;
	}

	.btn-wrapper .link-box a{
		color:#B3B3B3;
	}

	.btn-wrapper .link-box .left{
		position:absolute;
		left:0;
		top:0;
	}

	.btn-wrapper .link-box .right{
		position:absolute;
		right:0;
		top:0;
	}
</style>

<style>
	.weui_cells{
		margin-top:0 !important;
	}

	.weui_btn_default{
		background-color:#81c429 !important;
		color:#fff !important;
	}

	.weui_btn_default:active{
		background-color:#DE9A08 !important;
	}

	.weui_btn_disabled.weui_btn_default{
		background-color:#F3C76A !important;
	}

	.weui_cell {
		padding: 15px;
	}

	.tabmain {
		position:relative;
	}

	.tabmain .user_icon {
		position: absolute;
		left: 20px;
		top: 6px;
		font-size: 26px;
		color: #eee;}

	.tabmain .weui_input{margin-left:3.3rem;width:87%;}

</style>