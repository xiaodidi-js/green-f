<template>
	<!-- 输入内容 -->
	<group style="margin-top: 46px;">
		<x-input :show-clear="true" placeholder="请输入您的手机号码" type="tel" :value.sync="data.tel"></x-input>
		<x-input :show-clear="false" placeholder="请输入验证码" type="number" class="weui_vcode" :value.sync="data.ucode">
			<x-button slot="right" type="primary" :text="codeText" :disabled="codeDis" @click="getCode"></x-button>
		</x-input>
		<x-input :show-clear="true" placeholder="请输入账号密码" type="password" :value.sync="data.npwd"></x-input>
		<x-input :show-clear="true" placeholder="请再次输入密码" type="password" :value.sync="data.cpwd"></x-input>
	</group>
	<!-- 底部选择 -->
	<!--<div>-->
	<!--<icon type="success" class="my-icon-chosen" v-show="item.is_default === 1"></icon>-->
	<!--<icon type="circle" class="my-icon" v-show="item.is_default !== 1"></icon>-->
	<!--</div>-->
	<div class="eleChonse">
		<bottom-check style="width:43%;float:left;" title="我已阅读并同意" :status.sync="data.check"></bottom-check>
		<a href="javascript:void(0);" v-link="{name: 'xieyi'}" class="xieyi">绿秧田商城服务协议</a>
	</div>
	<!-- 底部按钮 -->
	<div class="btn-wrapper" style="width:90%;margin:0px 5%;">
		<x-button type="primary" :text="btnText" :disabled="btnDis" @click="postData"></x-button>
	</div>
	<!-- 输入内容 -->
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
    import Group from 'vux/src/components/group'
    import XInput from 'vux/src/components/x-input'
    import BottomCheck from 'components/bottom-check'
    import XButton from 'vux/src/components/x-button'
    import Toast from 'vux/src/components/toast'
    export default{
        data() {
            return {
                toastMessage:'',
                toastShow:false,
                codeText:'获取验证码',
                codeDis:false,
                btnText:'免费注册',
                btnDis:false,
                data:{
                    tel:'',
                    ucode:'',
                    npwd:'',
                    cpwd:'',
                    check:true,
                    xieyi: '',
                },
            }
        },
        components: {
            Group,
            XInput,
            BottomCheck,
            XButton,
            Toast,
        },
        route: {

        },
        ready() {
			this.xiayi();
        },
        methods: {
            xiayi: function() {
                this.$getData('/index/index/xieyi').then((res)=>{
                    this.data.xieyi = res.info.data;
                    var str = this.data.xieyi.substring(0,9);
                    this.data.xieyi = str;
                },(res)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                    this.codeDis = false;
                });
			},
            getCode: function(){
                if(this.codeDis){
                    return false;
                }else if(this.data.tel==''){
                    this.toastMessage = '请输入您的手机号码';
                    this.toastShow = true;
                    return false;
                }
                let second = 120,context = this,timer = null;
                this.codeDis = true;
                var options = {tel:this.data.tel};
                this.$postData('/index/login/getCodeBySms',options).then((res)=>{
                    this.toastMessage = res.info;
                    this.toastShow = true;
                    if (res.status === 1) {
                        this.codeText = second+'s';
                        timer = setInterval(function() {
                            if(second > 0) {
                                second--;
                                context.codeText = second + 's';
                            }else{
                                context.codeText = '获取验证码';
                                context.codeDis = false;
                                clearInterval(timer);
                            }
                        },1000);
                    } else {
                        this.codeDis = false;
                    }
                },(res)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                    this.codeDis = false;
                });
            },
            checkBefore: function() {
                let telReg = /^[\d]{9,11}$/;
                let pwdReg = /^[\w@\+\?\.\*-\_\#\^]{6,30}$/;
                switch (true) {
					case this.data.tel.length <= 0:
                        this.toastMessage = '请输入您的手机号码';
                        this.toastShow = true;
                        return false;
                    case !telReg.test(this.data.tel):
                        this.toastMessage = '手机号码格式不正确';
                        this.toastShow = true;
                        return false;
					case this.data.ucode.length != 5:
                        this.toastMessage = '请输入五位验证码';
                        this.toastShow = true;
                        return false;
					case this.unpwd.length <= 0:
                        this.toastMessage = '请输入账号密码';
                        this.toastShow = true;
                        return false;
					case !pwdReg.test(this.unpwd):
                        this.toastMessage = '账号密码格式不正确';
                        this.toastShow = true;
                        return false;
					case this.ucpwd.length <= 0:
                        this.toastMessage = '请输入确认密码';
                        this.toastShow = true;
                        return false;
					case this.unpwd!==this.ucpwd:
                        this.toastMessage = '两次密码不一致';
                        this.toastShow = true;
                        return false;
					case !this.data.check:
                        this.toastMessage = '请先仔细阅读使用协议';
                        this.toastShow = true;
                        return false;
				}
                return true;
            },
            postData: function() {
                if(this.btnDis) {
                    return false;
                }else if(!this.checkBefore()) {
                    return false;
                }
                this.btnDis = true;
                this.btnText = '正在提交...';
                let pdata = {utel:this.data.tel,upwd:this.unpwd,cpwd:this.ucpwd,code:this.data.ucode};
                this.$postData('/index/login/useraction',pdata).then((res) => {
                    switch (true) {
						case res.status === 1:
                            let getData = res;
                            if(getData.id && getData.token && getData.time) {
                                let storeData = {id:getData.id,token:getData.token,time:getData.time};
                                storeData = JSON.stringify(storeData);
                                sessionStorage.removeItem('userInfo');
                                localStorage.setItem('userInfo',storeData);
                                location.reload();
                            }
                            this.toastMessage = getData.info;
                            this.toastShow = true;
                            let context = this;
                            setTimeout(function(){
                                context.btnDis = false;
                                context.btnText = '免费注册';
                                context.$router.replace('index');
                            },800);
						case typeof res.info !== 'undefined':
                            this.toastMessage = res.info;
                            this.toastShow = true;
                            this.btnDis = false;
                            this.btnText = '免费注册';
					}
                },(res)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                    this.btnDis = false;
                    this.btnText = '免费注册';
                });
            }
        },
        computed: {
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
	/* eleChonse start */
	.eleChonse {
		width: 100%;
		position: relative;
		height: 5rem;
		top: 10px;
	}

	.eleChonse .wrapper {
		margin: 0px 15px;
		padding: 0px 1rem;
	}

	.eleChonse .xieyi {
		position: absolute;
		top: 0px;
		left: 150px;
	}
	/* eleChonse end */
	.btn-wrapper {
		width: 80%;
		margin: 5% 10% 0%;
	}
	.btn-wrapper .link-box{
		width:100%;
		position:relative;
		margin-top:0.8rem;
		font-size:1.2rem;
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
		font-family:'Microsoft YaHei';
		background-color:#F9AD0C !important;
		color:#fff !important;
	}
	.weui_btn_default:active{
		background-color:#DE9A08 !important;
	}
	.weui_btn_disabled.weui_btn_default,.weui_cell_ft .weui_btn_disabled.weui_btn_primary{
		background-color:#F3C76A !important;
	}

	.weui_cell_ft .weui_btn_primary {
		height:3.4rem;
		margin:0.5rem 0rem;
		background-color:#F9AD0C !important;
		font-size:1.4rem;
		color:#fff;
		line-height:2.4rem;
		font-family:'Microsoft YaHei';
		padding-top:0.5rem;
		padding-bottom:0.5rem;
		color:#fff;
		margin-left:auto;
		margin-right:auto;
		margin-right:0.5rem;
	}
	.weui_cell_ft .weui_btn_primary:active{
		background-color:#DE9A08 !important;
		color:#fff;
	}
	.weui_cell{
		font-size:14px;
	}
	.wbox label {
		padding-left: 10px;
		line-height: 2.1rem;
	}

	.xieyi {
		float: right;
		display: block;
		line-height: 2rem;
		font-size: 15px;
		color: #81c429;
		margin: 0px 15px;
	}
</style>