	<style scoped>
.btn-wrapper{
	width:80%;
	margin:10% 10% 0% 10%;
}

.btn-wrapper .link-box{
	width:100%;
	position:relative;
	margin-top:0.8rem;
	font-size:1.4rem;
	color:#B3B3B3;
	
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

.tabmain{position:relative;}
.tabmain .user_icon{position: absolute;
	left: 20px;
	top: 2px;
	font-size: 26px;
	color: #eee;}

.tabmain .weui_input{margin-left:3.3rem;width:87%;}

</style>

<template>
	<!-- 输入内容 -->
	<group title="">
		<div class="tabmain">
			<i class="iconfont user_icon icon-yonghu"></i>
			<x-input :show-clear=true placeholder="手机号码" type="text" :value.sync="data.uname" class="login-ipt"></x-input>
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
		<x-button :text="btnText" :disabled="btnDis" @click="postData"></x-button>
		<div class="link-box">
			<a class="left" v-link="{name:'find'}">找回密码</a>
			<a class="right" v-link="{name:'register'}">免费注册</a>
		</div>
	</div>
	<!-- 输入内容 -->
	<!-- loading提示框 -->
	<loading :show="loadingShow" text="正在登录..."></loading>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
import Group from 'vux/src/components/group'
import XInput from 'vux/src/components/x-input'
import BottomCheck from 'components/bottom-check'
import XButton from 'vux/src/components/x-button'
import Toast from 'vux/src/components/toast'
import Loading from 'vux/src/components/loading'

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
		Loading
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
				this.toastMessage = '请填写登录账号和密码';
				this.toastShow = true;
				return false;
			} else {
			    if(this.data.auto === false) {
			        setInterval(function(){
                        self.btnText = '请选择是否下次自动登录';
                        self.toastShow = true;
					},1000);
				} else if(this.data.auto === true) {
                    self.toastShow = false;
				}
				this.btnText = '正在登录...';
				this.btnDis = true;
				this.loadingShow = true;
				this.$http.get(localStorage.apiDomain+'public/index/login/useraction/uname/'+this.un+'/upwd/'+this.up).then((response)=>{
					if(response.data.status === 1) {
						let obj = {id:response.data.id,token:response.data.token,time:response.data.time};
						sessionStorage.removeItem('userInfo');
						localStorage.removeItem('userInfo');
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
					}else{
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