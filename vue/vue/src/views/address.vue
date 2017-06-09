<style scoped>
.btn-wrapper{
	width:80%;
	margin:20% 10% 0% 10%;
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
	background-color:#F9AD0C !important;
	color:#fff !important;
}

.weui_btn_default:active{
	background-color:#DE9A08 !important;
}

.weui_btn_disabled.weui_btn_default{
	background-color:#F3C76A !important;
}

.weui_cell_ft{
	text-align:left !important;
}

.weui_cell_ft span{
	color:#A9A9A9;
}

.weui_cell_ft span.vux-popup-picker-value{
	color:#000;
}

.vux-popup-picker-header{
	color:#F9AD0C !important;
}
</style>

<template>
	<!-- 输入内容 -->
	<group title="">
		<x-input :show-clear=true placeholder="收货人姓名" type="text" :value.sync="aname"></x-input>
		<x-input :show-clear=true placeholder="手机号码" type="text" :value.sync="atel"></x-input>
		<x-input :show-clear=true placeholder="邮政编码" type="text" :value.sync="acode"></x-input>
		<address placeholder="省，市，区" title="" :list="addressData" :value.sync="aprovince"></address>
		<x-textarea :rows="3" placeholder="详细地址" :value.sync="address"></x-textarea>
	</group>
	<!-- 底部按钮 -->
	<div class="btn-wrapper">
		<x-button :text="btnText" :disabled="btnDis" @click="postData"></x-button>
	</div>
	<!-- 输入内容 -->

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
import Group from 'vux/src/components/group'
import XInput from 'vux/src/components/x-input'
import Address from 'vux/src/components/address'
import AddressChinaData from 'vux/src/components/address/list.json'
import XTextarea from 'vux/src/components/x-textarea'
import XButton from 'vux/src/components/x-button'
import Toast from 'vux/src/components/toast'
import value2name from 'filter/value2name'
import name2value from 'filter/name2value'
import { clearAll,myActiveTwo } from 'vxpath/actions'

export default{
	data() {
		return {
			toastMessage:'',
			toastShow:false,
			btnText:'保存',
			btnDis:false,
			addressData:AddressChinaData,
			aname:'',
			atel:'',
			acode:'',
			aprovince:[],
			address:''
		}
	},
	vuex: {
		actions: {
			clearAll,
            myActiveTwo
		}
	},
	components: {
		Group,
		XInput,
		Address,
		XButton,
		XTextarea,
		Toast
	},
	route: {

	},
	ready() {
		if(this.$route.name === 'address-edit') {
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
			this.$http.get(localStorage.apiDomain+'public/index/user/addressinfo/uid/'+ustore.id+'/token/'+ustore.token+'/aid/'+this.$route.params.aid).then((response)=>{
				if(response.data.status === 1) {
					this.aname = response.data.person;
					this.atel = response.data.tel;
					this.acode = response.data.code;
					if(response.data.area){
						this.aprovince = name2value(response.data.area,this.addressData).split(' ');
					}
					this.address = response.data.address;
				}else if(response.data.status === -1) {
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
		}
	},
	computed: {
		provinceName: function(){
			return value2name(this.aprovince,this.addressData);
		}
	},
	methods: {
		postData: function(){
			if(this.aname == '') {
				this.toastMessage = '请填写收货人姓名';
				this.toastShow = true;
				return false;
			} else if (this.atel == '') {
				this.toastMessage = '请填写收货人电话';
				this.toastShow = true;
				return false;
			} else if (this.acode == '') {
				this.toastMessage = '请填写邮政编码';
				this.toastShow = true;
				return false;
			} else if (this.provinceName == '') {
				this.toastMessage = '请选择收货省份地区';
				this.toastShow = true;
				return false;
			} else if (this.address == '') {
				this.toastMessage = '请填写详细收货地址';
				this.toastShow = true;
				return false;
			}
			let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
			ustore = JSON.parse(ustore);
            let self = this;
			if(this.$route.name === 'address-edit') {
				let pdata = {
				    uid:ustore.id,
					token:ustore.token,
					person:this.aname,
					tel:this.atel,
					code:this.acode,
					area:this.provinceName,
					address:this.address,
					id:this.$route.params.aid
				};
				this.$http.put(localStorage.apiDomain+'public/index/user/addressinfo',pdata).then((response)=>{
					if (response.data.status === 1) {
						this.toastMessage = response.data.info;
						this.toastShow = true;
						let context = this;
						setTimeout(function(){
							history.back();
						},600);
					} else if (response.data.status === -1) {
						this.toastMessage = response.data.info;
						this.toastShow = true;
						let context = this;
						setTimeout(function(){
							context.clearAll();
							sessionStorage.removeItem('userInfo');
							localStorage.removeItem('userInfo');
							context.$router.go({name:'login'});
						},800);
					} else {
						this.toastMessage = response.data.info;
						this.toastShow = true;
					}
				},(response)=>{
					this.toastMessage = '网络开小差了~';
					this.toastShow = true;
				});
			} else {
				let pdata = {
				    uid:ustore.id,
					token:ustore.token,
					person:this.aname,
					tel:this.atel,
					code:this.acode,
					area:this.provinceName,
					address:this.address
				};
				this.$http.post(localStorage.apiDomain + 'public/index/user/addressinfo',pdata).then((response)=>{
					if(response.data.status === 1) {
						this.toastMessage = response.data.info;
						this.toastShow = true;
						setTimeout(function(){
							self.myActiveTwo("active");
							history.back();
						},600);
					}else if(response.data.status === -1) {
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
			}
		}
	}
}

</script>