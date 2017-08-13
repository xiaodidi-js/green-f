<template>
	<!-- 输入内容 -->
	<div class="input-wrapper">
		<div class="list">
			<label>手机号码</label>
			<input type="text" placeholder="请输入您的手机号码" readonly :value="data.tel" style="color:#999;" />
		</div>
		<div class="list">
			<label>昵称</label>
			<input type="text" placeholder="请输入您的昵称" v-model="data.name"  style="color:#999;"/>
		</div>
		<div class="list">
			<label>性别</label>
			<select v-model="data.sex" style="color:#999;">
				<option v-for="so in sexOpts" :value="so.key" :selected="data.sex === so.key">{{ so.value }}</option>
			</select>
		</div>
		<div class="list">
			<label>出生日期</label>
			<input type="text" placeholder="请输入您的出生日期" readonly value="{{ data.birthday }}" @click="getDate" style="color:#999;"/>
		</div>
		<!-- 日历组件 -->
		<calendar v-ref:calendar :value.sync="data.birthday" title="" :weeks-list="['日','一','二','三','四','五','六']"></calendar>
		<div class="list" @click="changePwd">
			<label>密码修改</label>
			<div class="arrow"></div>
		</div>
		<div id="pwd" class="list pwd" style="display:none;">
			<input type="password" placeholder="请输入旧密码" v-model="data.opwd" height="5.5rem" />
			<input type="password" placeholder="请输入新密码" v-model="data.npwd" />
			<input type="password" placeholder="请确认新密码" v-model="data.cpwd" />
		</div>
	</div>

	<!-- 底部按钮 -->
	<div class="btn-wrapper">
		<x-button type="primary" :text="btnText" id="confirm" :disabled="btnDis" @click="postData"></x-button>
		<x-button style="color: #fff;" type="primary" text="退出登录" style="background-color:transparent !important;color:#81c429 !important;border:1px solid #81c429;margin-top:10px;" @click="showExit"></x-button>
	</div>

	<!-- 确定弹框 -->
	<confirm :show.sync="confirmShow" title="退出登录" confirm-text="确定" cancel-text="取消" @on-confirm="exitLogin">
		<p style="text-align:center;">确定退出当前账号吗？</p>
	</confirm>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
import XButton from 'vux/src/components/x-button'
import Calendar from 'vux/src/components/calendar'
import Toast from 'vux/src/components/toast'
import Confirm from 'vux/src/components/confirm'
import { clearAll } from 'vxpath/actions'

export default{
	vuex: {
		actions: {
			clearAll
		}
	},
	components: {
		XButton,
		Calendar,
		Toast,
		Confirm
	},
	data() {
		return {
			confirmShow:false,
			toastMessage:'',
			toastShow:false,
			btnText:'确认修改',
			btnDis:false,
			sexOpts:[{key:"0",value:"男"},{key:"1",value:"女"}],
			data:{
				tel:'',
				name:'',
				sex:0,
				birthday:"TODAY",
				opwd:'',
				npwd:'',
				cpwd:'',
			},
            colorVal: ''
		}
	},
	methods: {
        chonseColor () {
			$(".color-list").css({"display" : "block"});
		},
        thatColor () {
            var links = document.createElement("link");
            links.rel = 'stylesheet';
            links.type = 'text/css';
            links.href = '../src/styles/red.css';

            var header = document.getElementsByTagName("head")[0];
            header.appendChild(links);
		},
		changePwd: function(event){
			let pwd = document.getElementById("pwd");
			if(pwd.style.display==="none"){
				pwd.style.display = "block";
			}else{
				pwd.style.display = "none";
			}
		},
		getDate: function(){
			let children = this.$refs.calendar.$children;
			children[0].$emit("click");
		},
		showExit: function(){
			this.confirmShow = true;
		},
		exitLogin: function() {
			this.clearAll();
            localStorage.removeItem('userInfo');
			sessionStorage.removeItem('userInfo');
			localStorage.removeItem('openid');
			sessionStorage.removeItem('openid');
			this.$router.go({name:'index'});
		},
		checkBefore: function() {
			let telReg = /^[\d]{9,11}$/;
			let pwdReg = /^[\w@\+\?\.\*-\_\#\^]{6,30}$/;
			if(this.data.tel.length <= 0) {
				this.toastMessage = '请输入您的手机号码';
				this.toastShow = true;
				return false;
			}else if(!telReg.test(this.data.tel)) {
				this.toastMessage = '手机号码格式不正确';
				this.toastShow = true;
				return false;
			}else if(this.data.name.length <= 0) {
				this.toastMessage = '请输入您的昵称';
				this.toastShow = true;
				return false;
			}else if(this.uopwd.length > 0 && this.unpwd.length <= 0) {
				this.toastMessage = '请输入新密码';
				this.toastShow = true;
				return false;
			}else if(this.uopwd.length > 0 && this.unpwd.length > 0 && !pwdReg.test(this.unpwd)) {
				this.toastMessage = '新密码格式不正确';
				this.toastShow = true;
				return false;
			}else if(this.uopwd.length > 0 && this.unpwd.length > 0 && this.ucpwd.length <= 0) {
				this.toastMessage = '请输入确认密码';
				this.toastShow = true;
				return false;
			}else if(this.uopwd.length > 0 && this.unpwd.length > 0 && this.unpwd !== this.ucpwd) {
				this.toastMessage = '两次密码不一致';
				this.toastShow = true;
				return false;
			}
			return true;
		},
		postData: function() {
			if(this.btnDis) {
				return false;
			} else if(!this.checkBefore()) {
				return false;
			}
			this.btnDis = true;
			this.btnText = '正在提交...';
			let pdata = {
			    id: this.$ustore.id,
				token: this.$ustore.token,
				utel: this.data.tel,
				uname: this.data.name,
				opwd: this.uopwd,
				upwd: this.unpwd,
				cpwd: this.ucpwd,
				sex: this.data.sex,
				birthday: this.data.birthday
			};
			this.$putData('/index/login/useredit',pdata).then((res)=>{
				if (res.status===1) {
					let getData = res;
					if(getData.id && getData.token && getData.time) {
						let storeData = {
						    id:getData.id,
							token:getData.token,
							time:getData.time
						};
						storeData = JSON.stringify(storeData);
						sessionStorage.getItem('userInfo') === null ? localStorage.setItem('userInfo',storeData) : sessionStorage.setItem('userInfo',storeData);
					}
					this.toastMessage = getData.info;
					this.toastShow = true;
					this.data.opwd = '';
					this.data.npwd = '';
					this.data.cpwd = '';
					this.btnDis = false;
					this.btnText = '确认修改';
				} else {
					if(typeof res.info !== 'undefined'){
						this.toastMessage = res.info;
						this.toastShow = true;
					}
					this.btnDis = false;
					this.btnText = '确认修改';
				}
			},(res)=>{
				this.toastMessage = '网络开小差了~';
				this.toastShow = true;
				this.btnDis = false;
				this.btnText = '确认修改';
			});
		}
	},
	ready() {
		this.$getData('/index/login/useredit/uid/' + this.$ustore.id).then((res)=>{
			if(res.status===1){
				this.data.tel = res.utel;
				localStorage.setItem('tel',this.data.tel);



				this.data.name = res.uname;
				this.data.sex = res.sex;
				if(res.birthday !== '' && res.birthday!=='0000-00-00'){
					this.data.birthday = res.birthday;
				}
			}else{
				this.toastMessage = res.info;
				this.toastShow = true;
			}
		},(res)=>{
			this.toastMessage = '网络开小差了~';
			this.toastShow = true;
		})
	},
	computed: {
		uopwd: function() {
			return this.data.opwd.replace(/(^\s*)|(\s*$)/,'');
		},
		unpwd: function() {
			return this.data.npwd.replace(/(^\s*)|(\s*$)/,'');
		},
		ucpwd: function() {
			return this.data.cpwd.replace(/(^\s*)|(\s*$)/,'');
		}
	}
}
</script>

<style scoped>
	.input-wrapper{
		width:90%;
		height:auto;
		margin:auto;
		padding:8% 0% 0% 0%;
	}

	.btn-wrapper{
		width:90%;
		margin:8% 5% 10% 5%;
	}

	.input-wrapper .list{
		width: 100%;
		height: auto;
		margin: 0rem 0rem 0.8rem 0rem;
		font-size: 0;
		padding: 0rem 0rem 0.5rem 0rem;
		line-height: 2.5rem;
		position: relative;
		/* border-bottom: 1px solid #ccc; */
	}

	.input-wrapper .list .that-style {
		float: right;
		width: 3.3rem;
		height: 3.3rem;
		background: #81c429;
		border: 1px solid #81c429;
	}

	.input-wrapper .list .color-list {
		width: 111px;
		height: 111px;
		position: absolute;
		top: -39px;
		right: 33px;
		z-index: 1000;
		background: #fff;
		display: none;
	}

	.input-wrapper .list .color-list li {
		width: 33px;
		height: 33px;
		float: left;
		background: #55a532;
		margin: 2px;
	}

	.input-wrapper .list:last-child{
		margin-bottom:0rem;
	}

	.input-wrapper .list label,.input-wrapper .list input,.input-wrapper .list select{
		display:inline-block;
		font-size:1.6rem;
	}

	.input-wrapper .list label{
		width:25%;
	}

	.input-wrapper .list .chonseColor{
		width: 15%;
		height: 25px;
		float: right;
		position: relative;
		top: 3px;
		border: 3px solid #ccc;
		border-radius: 5px;
		appearance:none;
		-o-appearance:none;
		-ms-appearance:none;
		-moz-appearance:none;
		-webkit-appearance:none;
	}

	.input-wrapper .list input,.input-wrapper .list select{
		width:75%;
		height:2.5rem;
		text-align:right;
		background-color:transparent;
	}

	.input-wrapper .list select{
		border:none;
		text-align:right;
		appearance:none;
		-webkit-appearance:none;
		-moz-appearance:none;
		direction:rtl;
	}

	.input-wrapper .list .arrow{
		width:2.5%;
		height:100%;
		position:absolute;
		top:0rem;
		right:0rem;
		background-image:url('../images/arrow.png');
		background-size:contain;
		background-repeat:no-repeat;
		background-position:center;
	}

	.input-wrapper .list.pwd{
		text-align:center;
	}

	.input-wrapper .list.pwd input{
		width: 100%;
		height: 4.5rem;
		text-align: left;
		background-color: transparent;
		margin-bottom: 0.8rem;
		border-bottom: 1px solid #ccc;
		font-size: 14px;
	}

</style>

<style>
	.weui_cells{
		margin-top:0 !important;
	}

	.weui_btn_default{
		background-color:#F9AD0C !important;
		color:#fff !important;
		border-radius:0.2rem;
	}

	.weui_btn_default:active{
		background-color:#DE9A08 !important;
	}

	.weui_btn_disabled.weui_btn_default{
		background-color:#F3C76A !important;
	}

	a.calendar-title{
		font-size:1.8rem;
		margin:0.5rem 0rem;
	}

	table thead tr th{
		font-size:1.4rem;
		font-weight:600;
	}

	div.input-wrapper .weui_cell.vux-tap-active{
		display:none;
	}
</style>