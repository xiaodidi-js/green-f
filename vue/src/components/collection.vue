<style scoped>
	.col-wrapper,.card-wrapper{
		width:100%;
		height:auto;
		margin-top: 15px;
	}

	.notify-box{
		width:94%;
		height:auto;
		padding:3%;
		background-color:#81c429;
		font-size:0;
		position:fixed;
		top:22.2rem;
		left:0;
		z-index:100;
	}

	.notify-box div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		line-height:20px;
		color:#fff;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}
	.notify-box div.ntips{
		width:65%;
		margin-right:10%;
	}

	.notify-box div.btn{
		width:25%;
		text-align:right;
	}

	.col-wrapper .image{
		width:45%;
		padding-top:45%;
		margin:15% auto 5%;
		background-image:url('../images/collection.png');
		background-position:center;
		background-size:contain;
		background-repeat:no-repeat;
	}

	.col-wrapper .tips{
		font-size:1.8rem;
		color:#999;
		text-align:center;
	}
</style>

<style>

.weui_btn_default{
	font-family:'Microsoft YaHei';
	background-color:#F9AD0C !important;
	color:#fff !important;
}

.weui_btn_default:active{
	background-color:#DE9A08 !important;
}

.weui_btn_disabled.weui_btn_default{
	background-color:#F3C76A !important;
}

.weui_btn_dialog.primary{
	color:#F9AD0C !important;
}
</style>

<template>
	<div class="col-wrapper" v-if="collections.length > 0">
		<div class="notify-box">
			<div class="ntips" v-show="editMode === 1">请选择删除商品</div>
			<div class="ntips" v-else>当前共有{{ collections.length }}个收藏</div>
			<div class="btn">
				<a @click="changMode">{{ modeText }}</a>
			</div>
		</div>

		<separator :set-height="40" unit="px"></separator>

		<div class="card-wrapper">
			<collection-list
					v-for="item in collections"
					:mode="editMode"
					:cid="item.id"
					:pid="item.pid"
					:img="item.shotcut"
					:pname="item.name"
					:pprice="item.price"
					:pstore="item.store"
					:chosen.sync="choseArr">
			</collection-list>

			<x-button :text="btnText" :disabled="btnDis" style="width:80%;margin:2rem auto;" @click="setMulitpleDel" v-if="editMode === 1"></x-button>
		</div>
	</div>

	<div class="col-wrapper" v-else>
		<div class="notify-box">
			<div class="ntips">当前没有收藏商品</div>
		</div>
		<div class="image"></div>
		<p class="tips">亲，您的收藏夹空空如也~</p>
		<x-button text="逛一逛" style="width:40%;margin:2rem auto;" v-link="{name:'index'}"></x-button>
	</div>

	<!-- 确定弹框 -->
	<confirm :show.sync="confirmShow" title="删除收藏" confirm-text="确定" cancel-text="取消" @on-confirm="confirmDel" @on-cancel="cancelDel"><p style="text-align:center;">确定删除收藏商品吗？</p></confirm>
</template>

<script>
	import CollectionList from 'components/collection-list'
	import XButton from 'vux/src/components/x-button'
	import Confirm from 'vux/src/components/confirm'
	import Separator from './separator'
	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		components: {
			XButton,
			Confirm,
			Separator,
			CollectionList
		},
		props: {
			collections: {
				type: Array,
				default() {
					return []
				}
			}
		},
		data() {
			return {
				modeText:'编辑',
				btnDis:false,
				editMode:0,
				confirmShow:false,
				choseArr:[],
				delItem:0
			}
		},
		ready() {
			
		},
		methods: {
			changMode: function(){
				this.modeText = this.modeText === '编辑' ? '完成' : '编辑';
				this.editMode = this.editMode ? 0 : 1;
				if(this.editMode === 0){
					this.choseArr = [];
				}
			},
			setMulitpleDel: function(){
				if(this.editMode!==1){
					return false;
				}else if(this.choseArr.length<=0){
					return false;
				}
				this.confirmShow = true;
			},
			confirmDel: function(){
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				ustore = JSON.parse(ustore);
				let durl = '';
				if(this.delItem>0){
					durl = localStorage.apiDomain+'public/index/user/usercollection/uid/'+ustore.id+'/token/'+ustore.token+'/type/0/cid/'+this.delItem;
				}else{
					durl = localStorage.apiDomain+'public/index/user/usercollection/uid/'+ustore.id+'/token/'+ustore.token+'/type/1/cid/'+this.choseArr.join(',');
				}
				this.$http.delete(durl).then((response)=>{
					if(response.data.status===1){
						if(this.delItem>0){
							this.$dispatch('delData',this.delItem);
						}else{
							this.$dispatch('delData',this.choseArr);
							this.choseArr = [];
						}
						this.delItem = 0;
					}else if(response.data.status===-1){
						this.delItem = 0;
						this.$dispatch('showMes',response.data.info);
						let context = this;
						setTimeout(function(){
							context.clearAll();
							sessionStorage.removeItem('userInfo');
							localStorage.removeItem('userInfo');
							context.$router.go({name:'login'});
						},800);
					}else{
						this.delItem = 0;
						this.$dispatch('showMes',response.data.info);
					}
				},(response)=>{
					this.delItem = 0;
					this.$dispatch('showMes','网络开小差了~');
				});
			},
			cancelDel: function(){
				this.delItem = 0;
			}
		},
		computed: {
			btnText: function(){
				if(this.choseArr.length>0){
					return '删除('+this.choseArr.length+')';
				}else{
					return '删除';
				}
			}
		},
		events: {
			setDel: function(id){
				this.delItem = id;
				this.confirmShow = true;
			}
		}
	}
</script>