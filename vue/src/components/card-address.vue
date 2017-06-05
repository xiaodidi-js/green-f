<style scoped>
	.card-box{
		width: 92%;
		height: auto;
		padding: 4% 2%;
		border-bottom: #B3B3B3 solid 1px;
		margin: 10px auto 0;
	}

	#cardbox{display:none;}

	.card-box .half-div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		color:#333;
		width:50%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.my-icon-chosen:before{
		color:#f9ad0c;
	}

	.text-right{
		text-align:right;
	}

	.card-box .half-div .icon{
		display:inline-block;
		vertical-align:middle;
		width: 1.8rem;
		height: 1.8rem;
	}

	.card-box .half-div .icon.img{
		background-position:center;
		background-repeat:no-repeat;
		background-size:contain;
	}

	.card-box .half-div .icon.img.edit{
		background-image:url('../images/edit.png');
	}

	.card-box .half-div .icon.img.del{
		background-image:url('../images/del.png');
	}

	.card-box .half-div .icon.separator{
		width:0.1rem;
		height:1rem;
		background-color:#D2D2D2;
		margin:0.2rem 0.8rem;
	}

	.card-box .address{
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		width:100%;
		max-height:3.6rem;
		font-size:1.4rem;
		line-height:1.8rem;
		color:#808080;
		margin-top:0.6rem;
		margin-bottom:1.5rem;
		overflow:hidden;
	}



	.card-box .address.active {
		background: #81c429;
	}

	.comfire-chonse {
		width:80%;
		margin:23% 10% 10% 10%;
	}

	.add-address {
		width:80%;
		margin:5% 10% 30% 10%;
	}

	.address-comfirm {
		-webkit-appearance: none;
		-moz-appearance: none;
		-ms-appearance: none;
		-o-appearance: none;
		appearance: none;
		border:none;
	}

</style>

<style>
	.weui_icon_circle:before, .weui_icon_success:before{
		font-size:2.2rem !important;
		margin-right:0.3rem;
		margin-top:0rem;
	}

	.weui_icon_success:before{
		color:#fff;
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

	.weui_btn_dialog.primary{
		color:#81c429 !important;
	}

	/* addresses_table start */
	.addresses_table{
		width: 100%;
		height: 3.8rem;
		border-bottom: 1px solid #ccc;
		background: #efefef;
		box-shadow: 1px 1px 10px #efefef;
		position: fixed;
		top: 222px;
		z-index: 9;
		box-shadow: 0 2px 15px #ccc;
    }

	.addresses_table ul li span {
		display:block;

		line-height:3.8rem;
	}

    .addresses_table ul li{
		width:50%;
		text-align:center;
		font-size:14px;
		float:left;
		color:#333;

	}
    .addresses_table .sel-active{
        border-bottom:3px solid #3cc51f;
        position:absolute;
        top:49px;
        left:0px;
        width:50%;
    }

    .addresses_table ul .active{border-bottom:3px solid #81c429;}

    /* addresses_table end */

	#ziti{
		display:block;
	}

	#ziti .main_ziti{
		width:100%;
		margin:10px 0px;
		position: relative;
		top:50px;
	}

	#ziti .main_ziti .address{
		width:98%;
		height:auto;
		background:#FEFEFE;
		overflow:hidden;
		position:relative;
		margin:0 auto;
		margin-bottom:1.16rem;
	}

	#ziti .main_ziti .isActive {
		width:98%;
		height:auto;
		background:#81c429;
		overflow:hidden;
		position:relative;
		margin:0 auto;
		margin-bottom:1.16rem;
	}

	.isActive .address_list li {
		color:#fff;
	}

	.isActive .yuan .weui_icon_success:before {
		color:#fff;
	}

	.address_list li{
		font-size: 1.4rem;
		margin: 0rem 1.1rem;
		color: #4d4d4d;
		line-height: 25px;
		text-align: left;
		width: 100%;
	}
	.address_list li .left-title {
		/*width:23%;*/
		/*float:left;*/
	}

	.address_list li .right-title {
		/*width:58%;*/
		/*float:left;*/
	}

	.yuan {
		width: 2.2rem;
		height: 2.1rem;
		position: absolute;
		bottom: 38%;
		right: 1.387rem;
		line-height: 0.596rem;
		text-align: center;
	}

</style>

<template>
	<div class="addresses_table">
		<ul id="card">
			<li class="active">
				<span>自提点</span>
			</li>
			<li>
				<span>快递地址</span>
			</li>
		</ul>
	</div>

	<div id="content">
		<!-- 自提地址 -->
		<div id="ziti">
			<div class="main_ziti" id="Ele-chonse">
				<div class="address" :class="{'isActive':item.is_default === 1}" v-for="item in chosens">
					<ul class="address_list" style="width: 85%;" @click="isDefault($index,item.id)">
						<li>
							<span class="left-title">自提点：</span>
							<span class="right-title">{{ item.name }}</span>
						</li>
						<li>
							<span class="left-title">电话:</span>
							<span class="right-title">{{ item.tel }}</span>
						</li>
						<li>
							<span class="left-title">收货地址：</span>
							<span class="right-title">{{ item.address  }}</span>
						</li>
						<li>
							<span class="left-title">服务范围：</span>
							<span class="right-title">{{ item.address  }}</span>
						</li>
					</ul>
					<div class="yuan">
						<icon type="success" v-show="item.is_default === 1"></icon>
						<icon type="circle" v-show="item.is_default !== 1"></icon>
					</div>
				</div>
			</div>
			<div class="comfire-chonse">
				<x-button text="确认"></x-button>
			</div>
		</div>

		<!-- 快递地址 -->
		<div id="cardbox" style="display:none;position: relative;top: 60px;">
			<div class="card-box" v-for="item in addresses" style="background: #f2f2f2;box-shadow: none;border:none;">
				<div class="half-div" style="float: left;">{{ item.name }}</div>
				<div class="half-div text-right">{{ item.tel }}</div>
				<div class="address" style="background:none">{{ item.address }}</div>
				<div class="half-div" @click="setDefault($index,item.id)" style="float: left;">
					<icon type="success" class="my-icon-chosen" v-show="item.is_default === 1"></icon>
					<icon type="circle" class="my-icon" v-show="item.is_default !== 1"></icon>
					<i>默认地址</i>
            </div>
				<div class="half-div text-right">
					<div class="icon img edit" v-link="{name:'address-edit',params:{aid:item.id}}"></div>
					<div class="icon separator"></div>
					<div class="icon img del" @click="setDel(item.id)"></div>
				</div>
			</div>
			<!-- 底部按钮 -->
			<div class="add-address">
				<x-button text="新增地址" class="address-comfirm" v-link="{name:'address-add'}"></x-button>
			</div>
		</div>
	</div>
	<!-- 确定弹框 -->
	<confirm :show.sync="confirmShow" title="删除地址" confirm-text="确定" cancel-text="取消" @on-confirm="confirmDel" @on-cancel="cancelDel"><p style="text-align:center;">确定删除该地址吗？</p></confirm>
</template>


<script type="text/javascript">

	import Icon from 'vux/src/components/icon'
	import XButton from 'vux/src/components/x-button'
	import Confirm from 'vux/src/components/confirm'
	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		computed: {

		},
		components: {
			Icon,
			XButton,
			Confirm
		},
        computed : {

		},
		props: {
			addresses: {
				type: Array,
				default() {
					return []
				}
			}
		},
		data() {
			return {
				confirmShow:false,
				delItem:0,
                issel:0,
                order_list: [],
                chosens: [],
                radio: '1',
                isActive: false,
                address: true
			}
		},
		ready() {
			this.siblingsDom();
			this.chosenfun();
//			var act = $("#card").find("li").eq(0).attr('class');
//			if(act == 'active') {
//				$("#card").find("li").eq(0).removeClass("active");
//			} else {
//                $("#card").find("li").eq(1).addClass(this.$store.state.text);
//			}
//			console.log(act);
//			console.log(this.$store.state.text);
		},
		methods: {
			isActiveFun: function() {
				var ele = document.getElementById("Ele-chonse");
				var eleAddress = ele.children;
				var _this = this;
				for(let i = 0; i < eleAddress.length; i++) {
					eleAddress[i].index = i;
					eleAddress[i].onclick = function(){
						this.className = "isActive";
						//同辈元素互斥
						_this.siblings(this,function(){
							this.className = "address";
						});
					};
				}
			},
		    //自提点
			chosenfun: function() {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.getType = this.$parent.deliverType;
                var _this = this;
                this.$http.get(localStorage.apiDomain+'public/index/user/addresschosen/uid/' + ustore.id + '/token/' + ustore.token + '/type/' + this.getType).then((response)=>{
                    if(response.data.status === 1) {
                        console.log(response.data);
                        this.showStatus = false;
                        this.showTips = '加载中...';
                        this.chosens = response.data.list;
                        for(let i = 0; i < this.chosens.length; i++) {
							this.chosens[i].index = i;
                            if(this.chosens[i].is_default == 1) {
								_this.isActiveFun();
							}
						}
                    }else if(response.data.status=== -1) {
                        this.$parent.toastMessage = response.data.info;
                        this.$parent.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    }else{
                        this.address = [];
                        this.chosen = 0;
                        this.showTips = '暂无添加地址';
                        this.showStatus = true;
                    }
                },(response)=>{
                    this.$parent.toastMessage = '网络开小差了~';
                    this.$parent.toastShow = true;
                });
			},
            //自提点选择
            setChosen: function(obj){
                if(typeof obj==='object'){
                    let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                    ustore = JSON.parse(ustore);
                    let pids = '';
                    if(this.$parent.cartIds.length>0){
                        pids = this.$parent.cartIds.join(',');
                    }
                    let pdata = {uid:ustore.id,token:ustore.token,type:this.$parent.deliverType,ids:pids,area:obj.area};
                    this.$http.post(localStorage.apiDomain+'public/index/user/addresschosen',pdata).then((response)=>{
                        if(response.data.status === 1) {
                            this.chosen = obj.id;
                            this.$parent.data.address = obj;
                            this.$parent.freight = response.data.freight;
                        }else if(response.data.status === -1) {
                            this.$parent.toastMessage = response.data.info;
                            this.$parent.toastShow = true;
                            let context = this;
                            setTimeout(function(){
                                context.clearAll();
                                sessionStorage.removeItem('userInfo');
                                localStorage.removeItem('userInfo');
                                context.$router.go({name:'login'});
                            },800);
                        }else{
                            this.$parent.toastMessage = response.data.info;
                            this.$parent.toastShow = true;
                        }
                    },(response)=>{
                        this.$parent.toastMessage = '网络开小差了~';
                        this.$parent.toastShow = true;
                    });
                }
            },
            $id: function(id) {
                return document.getElementById(id);
            },
            siblings: function (dom,callback){
                var pdom = dom.parentElement;
                var tabArr = [].slice.call(pdom.children);
                tabArr.filter(function(obj){
                    if(obj!=dom)callback.call(obj);
                });
            },
            siblingsDom:function (){
                var cardDom = this.$id("card");
                var liDomes = cardDom.children;
                var len = liDomes.length;
                for(var i = 0; i < len; i++) {
                    //给对象缓存自有属性
                    liDomes[i].index = i;
                    var _this = this;
                    liDomes[i].onclick = function(){
                        this.className = "active";
                        //同辈元素互斥
                        _this.siblings(this,function(){
                            this.className = "";
                        });
                        //把对应的选项卡的内容显示出来
                        var tabDom = document.getElementById("content").children[this.index];
                        tabDom.style.display = "block";
                        //拿它的父亲对象
                        _this.siblings(tabDom,function(){
                            this.style.display = "none";
                        });
                    };
                }
            },
            isDefault: function(index,id) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                let pdata = {uid:ustore.id,token:ustore.token,state:0,addressid:id};
                var _this = this;
                this.$http.put(localStorage.apiDomain+'public/index/Usercenter/addressmoren',pdata).then((response) => {
                    if(response.data.status === 1) {
                        console.log(response.data);
                        for(let i = 0;i < this.chosens.length; i++) {
                            if(i != index && this.chosens[i].is_default != 0) {
                                this.chosens[i].is_default = 0;
                            }
                        }
                        _this.isActiveFun();
                        this.chosens[index].is_default = 1;
                    }else if(response.data.status === -1) {
                        this.$dispatch('showMes',response.data.info);
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    }else{
                        this.$dispatch('showMes',response.data.info);
                    }
                },(response)=>{
                    this.$dispatch('showMes','网络开小差了~');
                });
            },
			setDefault: function(index,id){
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				ustore = JSON.parse(ustore);
				let pdata = {uid:ustore.id,token:ustore.token,aid:id};
				this.$http.put(localStorage.apiDomain+'public/index/user/addresslist',pdata).then((response) => {
					if(response.data.status===1) {
                        console.log(response.data);
						for(let i = 0;i < this.addresses.length; i++) {
							if(i != index && this.addresses[i].is_default != 0) this.addresses[i].is_default = 0;
						}
						this.addresses[index].is_default = 1;
					}else if(response.data.status===-1) {
						this.$dispatch('showMes',response.data.info);
						let context = this;
						setTimeout(function(){
							context.clearAll();
							sessionStorage.removeItem('userInfo');
							localStorage.removeItem('userInfo');
							context.$router.go({name:'login'});
						},800);
					}else{
						this.$dispatch('showMes',response.data.info);
					}
				},(response)=>{
					this.$dispatch('showMes','网络开小差了~');
				});
			},
            changeActive: function(evt){
                evt.preventDefault();
                evt.stopPropagation();
                this.$dispatch('setChosen',this.obj);
            },
			setDel: function(id){
				this.delItem = id;
				this.confirmShow = true;
			},
			confirmDel: function(){
				if(!this.delItem){
					return false;
				}
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				ustore = JSON.parse(ustore);
				let add = localStorage.apiDomain+'public/index/user/addressinfo/uid/'+ustore.id+'/token/'+ustore.token+'/aid/'+this.delItem;
				this.$http.delete(add).then((response)=>{
					if(response.data.status===1){
						for(let add=0;add<this.addresses.length;add++){
							if(this.addresses[add].id===this.delItem){
								this.addresses.splice(add,1);
								break;
							}
						}
					}else if(response.data.status===-1){
						this.$dispatch('showMes',response.data.info);
						let context = this;
						setTimeout(function(){
							context.clearAll();
							sessionStorage.removeItem('userInfo');
							localStorage.removeItem('userInfo');
							context.$router.go({name:'login'});
						},800);
					}else{
						this.$dispatch('showMes',response.data.info);
                        console.log("Yes...");
					}
					this.delItem = 0;
				},(response)=>{
					this.delItem = 0;
					this.$dispatch('showMes','网络开小差了~');
				});
			},
			cancelDel: function(){
				this.delItem = 0;
			}
		}
	}
</script>