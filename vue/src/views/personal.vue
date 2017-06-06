<style scoped>
	.container{
		width:100%;
		height:auto;
	}

	.white-bg{
		background-color:#fff;
	}	

	.container .top-message{
		width:90%;
		height:16.5rem;
		padding:1rem 5%;
		position:fixed;
		top:0;
		left:0;
		z-index:100;
	}

	.container .top-message .shotcut{
		width:10rem;
		height:10rem;
		border:#efefef solid 1px;
		border-radius:5rem;
		margin:auto;
		overflow:hidden;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		background-color:#efefef;
		text-align:center;
	}

	.container .top-message .shotcut>span{
		width:0;
		height:100%;
		display:inline-block;
		vertical-align:middle;
	}

	.container .top-message .shotcut>img{
		width:30%;
		height:auto;
		vertical-align:middle;
	}

	.container .top-message .nickname{
		margin:0.5rem auto 0.3rem auto;
		width:80%;
		font-size:16px;
		color:#666;
		text-align:center;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		color:#666;
	}

	.container .top-message .score{
		margin:auto;
		width:50%;
		font-size:1.4rem;
		color:#fff;
		line-height: 30px;
		text-align:left;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		background: url("../images/qiandao.png") no-repeat #81c429;
		background-size: 23px 23px;
		background-position: 5px 2px;
		border-radius: 5px;
		text-indent: 2.5em;
		margin: 7px auto;
		text-align: center;
	}

	.container .mid-card{
		width:100%;
		height:2.2rem;
		padding:1.5rem 0rem 0.8rem 0rem;
		text-align:center;
		font-size:0;
		position:fixed;
		top:17.7rem;
		left:0;
		z-index:100;
	}

	.container .mid-card .tap-logo{
		display:inline-block;
		width:2rem;
		height:2.2rem;
		margin-right:11%;
		background-size:contain;
		background-repeat:no-repeat;
		background-position:center;
		vertical-align:middle;
		position:relative;
	}

	.container .mid-card .tap-logo .arrow{
		position:absolute;
		width:0rem;
		height:0rem;
		bottom:-0.8rem;
		left:0.5rem;
	}

	.container .mid-card .tap-logo .arrow.actived{
		border-top:transparent solid 0.5rem;
		border-left:transparent solid 0.5rem;
		border-right:transparent solid 0.5rem;
		border-bottom:#efefef solid 0.5rem;
	}

	.container .mid-card .tap-logo.coupons .arrow.actived{
		border-top:transparent solid 0.5rem;
		border-left:transparent solid 0.5rem;
		border-right:transparent solid 0.5rem;
		border-bottom:#81c429 solid 0.5rem;
	}

	.container .mid-card .tap-logo.collections .arrow.actived{
		border-top:transparent solid 0.5rem;
		border-left:transparent solid 0.5rem;
		border-right:transparent solid 0.5rem;
		border-bottom:#81c429 solid 0.5rem;
	}

	.container .mid-card .tap-logo.orders{
		background-image:url('../images/orders.png');
	}

	.container .mid-card .tap-logo.coupons{
		background-image:url('../images/coupons.png');
	}

	.container .mid-card .tap-logo.collections{
		background-image:url('../images/collections.png');
	}

	.container .mid-card .tap-logo.addresses{
		background-image:url('../images/addresses.png');
	}

	.container .mid-card .tap-logo.settings{
		background-image:url('../images/settings.png');
	}

	.container .mid-card .tap-logo:last-child{
		margin-right:0%;
	}
</style>

<template>
	<div class="container">
		<div class="top-message white-bg">
			<div class="shotcut" :style="{backgroundImage:'url('+ headerIcon.headimgurl +')'}">
				<span v-show="upsta"></span>
				<img src="../images/loading.svg" v-show="upsta">
			</div>
			<div class="nickname">{{ headerIcon.nickname }}</div>
			<div class="score" v-link="{name:'integral'}">
				<span>签到积分:</span>
				<span>{{ number }}</span>
			</div>
			<input type="file" id="himg" @click="fileClick" @change="getImage" accept="image/jpeg,image/png,image/gif" style="display:none;" />
		</div>
		<div class="mid-card white-bg">
			<div class="tap-logo orders" v-link="{name:'per-orders'}">
				<div class="arrow" :class="{'actived':$route.name === 'per-orders' || $route.name==='per-default'}"></div>
			</div>
			<div class="tap-logo coupons" v-link="{name:'per-coupons'}">
				<div class="arrow" :class="{'actived':$route.name === 'per-coupons'}"></div>
			</div>
			<div class="tap-logo collections" v-link="{name:'per-collections'}">
				<div class="arrow" :class="{'actived':$route.name === 'per-collections'}"></div>
			</div>
			<div class="tap-logo addresses" v-link="{name:'per-addresses'}">
				<div class="arrow" :class="{'actived':$route.name === 'per-addresses'}"></div>
			</div>
			<div class="tap-logo settings" v-link="{name:'per-settings'}">
				<div class="arrow" :class="{'actived':$route.name === 'per-settings'}"></div>
			</div>
		</div>
		<separator :set-height="21"></separator>
		<router-view></router-view>
		<toast :show.sync="toastShow" type="text">{{ toastMessage}}</toast>
	</div>
</template>

<script>
	import Toast from 'vux/src/components/toast'
	import Separator from 'components/separator'
	import { clearAll,myActive } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll,
                myActive
			}
		},
		components: {
			Separator,
			Toast
		},
		data() {
			return {
				toastShow:false,
				toastMessage:'',
				upsta:0,
				uimg:'',
				uname:'',
				uscore:0,
				headerIcon: '',
				number: 0,
			}
		},
		ready() {
		    this.main();
            this.weixinHeader();
		    //记录索引
            this.myActive(1);
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			this.$http.get(localStorage.apiDomain+'public/index/user/userinfo/uid/'+ustore.id+'/token/'+ustore.token).then((response)=>{
				if(response.data.status===1){
					this.uname = response.data.uname;
					this.uscore = response.data.score;
					if(response.data.shotcut!==null){
						this.uimg = response.data.shotcut;
					}
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
			main: function() {
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				ustore = JSON.parse(ustore);
				this.$http.get(localStorage.apiDomain+'public/index/Usercenter/integral/uid/' + ustore.id + '/token/' + ustore.token).then((response)=>{
                    this.number = response.data.zongfen;
					console.log(response.data.list);
				},(response)=>{
					this.toastMessage = '网络开小差了~';
					this.toastShow = true;
				});
			},
		    weixinHeader: function () {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                let openid = sessionStorage.getItem("openid");
                this.$http.get(localStorage.apiDomain + 'public/index/index/get_weixin?openid=' + openid).then((response)=>{  /* 'os0CqxBBANhLuBLTsViL3C0zDlNs' */
					this.headerIcon = response.data.msg.weixindata;
                    console.log(this.headerIcon);
                    var header = JSON.stringify(this.headerIcon);
                    localStorage.setItem("userHeader",header);
                },(response)=>{
                    this.toastMessage = "网络开小差啦~";
                    this.toastShow = true;
                    this.upsta = 0;
                });
            },
			addShotcut: function(){
				if(this.upsta){
					return false;
				}
				document.getElementById('himg').click();
			},
			fileClick: function(evt){
				evt.stopPropagation();
			},
			getImage: function(){
				let file = document.getElementById('himg');
				if(typeof file.files[0]==='undefined'){
					return false;
				}
				this.upsta = 1;
				if(this.handleFiles(file.files[0])===false){
					this.upsta = 0;
					file.value = '';
					return false;
				}
			},
			handleFiles: function(file){
				if(!this.checkImg(file.type)){
					this.toastMessage = '上传文件类型不是图片';
					this.toastShow = true;
					return false;
				}
				this.getUpInfo(file);
			},
			checkImg: function(getType=''){
				if(getType==='' || typeof getType !== 'string'){
					return false;
				}
				let exts = ['jpg','jpeg','gif','png'];
				let tarr = getType.split('/')[1];
				return exts.indexOf(tarr)>=0 ? true : false;
			},
			getUpInfo: function(file){
				if(typeof file === 'undefined' || file === null){
					return false;
				}
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				ustore = JSON.parse(ustore);
				this.$http.put(localStorage.apiDomain+'/public/index/user/makeInfoForUpyun',{'allow-file-type':'jpg,jpeg,gif,png','ext-param':'himg,'+ustore.id+',1','ftype':file.type}).then((response)=>{
					let resdata = response.data;
					if(resdata.status === 1) {
						this.uploadImgToUpyun(resdata.domain,resdata.url,file,resdata.policy,resdata.signature,resdata.notify,resdata.param,resdata.thumb);
					} else {
						this.toastMessage = resdata.info;
						this.toastShow = true;
						this.upsta = 0;
					}
				},(response)=>{
					this.toastMessage = "网络开小差啦~";
					this.toastShow = true;
					this.upsta = 0;
				});
			},
			uploadImgToUpyun: function(domain,url,file,policy,signature,notify,param,thumb='') {
				let formData = new FormData();
				formData.append('file',file);
				formData.append('policy',policy);
				formData.append('signature',signature);
				formData.append('notify-url',notify);
				formData.append('ext-param',param);
				formData.append('x-gmkerl-thumb',thumb);
				let context = this;
				this.$http.post(url,formData).then((response)=>{
					let upurl = domain + JSON.parse(response.data).url;
					context.upsta = 0;
					context.uimg = upurl;
				},(response)=>{
					this.toastMessage = "网络开小差啦~";
					this.toastShow = true;
					this.upsta = 0;
				});
			}
		}
	}
</script>