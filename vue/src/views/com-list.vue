<style scoped>
	.com-wrapper{
		width:94%;
		min-height:100%;
		padding:3%;
		margin-top: 45px;
		background-color:#fff;
	}

	.com-wrapper .com-box{
		width:96%;
		padding:2%;
		border-bottom:#EFEFEF solid 1px;
		font-size:0;
	}

	.com-wrapper .com-box .head,.com-wrapper .com-box .name,.com-wrapper .com-box .date{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		color:#999999;
	}

	.com-wrapper .com-box .head{
		width:12%;
		padding-top:12%;
		border-radius:50%;
		background-color:#ccc;
		background-position:center;
		background-repeat:no-repeat;
		background-size:cover;
		margin-right:5%;
	}

	.com-wrapper .com-box .name{
		width:41%;
		margin-right:2%;
		text-align:left;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.com-wrapper .com-box .date{
		width:40%;
		text-align:right;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.com-wrapper .com-box .content{
		width:100%;
		height:auto;
		font-size:1.4rem;
		color:#999999;
		margin-bottom:2%;
	}

	.com-wrapper .com-box .img-area{
		width:100%;
		height:auto;
		font-size:0;
		text-align:center;
		margin-bottom:2%;
	}

	.com-wrapper .com-box .img-area .image{
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

	.com-wrapper .com-box .img-area .image:last-child{
		margin-right:0%;
	}

	.com-wrapper .com-box .img-area .image.unupload:active{
		background-size:30%;
		background-color:#F9F9F9;
	}

	.com-wrapper .com-box .img-area .image.upload{
		background-size:cover;
	}

	.com-wrapper .com-box .bubble{
		width:100%;
		margin-top:0.5rem;
		position:relative;
	}

	.com-wrapper .com-box .bubble:last-child{
		margin-bottom:0.5rem;
	}

	.com-wrapper .com-box .bubble .arrow{
		width:0;
		height:0;
		border-top:transparent solid 5px;
		border-bottom:transparent solid 5px;
		border-left:#f2f2f2 solid 5px;
		position:absolute;
		top:0.6rem;
		right:-0.4rem;
	}

	.com-wrapper .com-box .bubble.my .marrow{
		width:0;
		height:0;
		border-top:transparent solid 5px;
		border-bottom:transparent solid 5px;
		border-right:#f9ad0c solid 5px;
		position:absolute;
		top:0.6rem;
		left:-0.4rem;
	}

	.com-wrapper .com-box .bubble .sp-content{
		width:96%;
		padding:2%;
		border-radius:0.2rem;
		background-color:#f2f2f2;
		font-size:1.4rem;
		color:#999999;
		word-break:break-all;
	}

	.com-wrapper .com-box .bubble.my .sp-content{
		background-color:#f9ad0c;
		color:#ffffff;
	}

	.fixed-tab{
		position:fixed;
		top:46px;
		left:0;
		width:100%;
		z-index:100;
	}

	.com-wrapper .ncimg{
		width:15%;
		height:auto;
		vertical-align:middle;
	}

	.com-wrapper .nocoms{
		display:inline-block;
		vertical-align:middle;
		font-size:1.8rem;
		color:#d6d6d6;
	}
</style>

<template>
	<!-- 顶部选项 -->
	<tab default-color="#333333" active-color="#F9AD0C" :line-width="2" class="fixed-tab">
		<tab-item :selected="column === 0" @click="changeColumn(0)">全部({{ data.all }})</tab-item>
		<tab-item :selected="column === 1" @click="changeColumn(1)">好评({{ data.good }})</tab-item>
		<tab-item :selected="column === 2" @click="changeColumn(2)">中评({{ data.common }})</tab-item>
		<tab-item :selected="column === 3" @click="changeColumn(3)">差评({{ data.bad }})</tab-item>
	</tab>

	<separator :set-height="44" unit="px"></separator>

	<!-- 评论列表 -->
	<div class="com-wrapper" v-if="data.list.length>0">
		<div class="com-box" v-for="item in data.list">
			<div class="head"> <!-- v-lazy:background-image="item.shotcut" -->
				<img :src="item.shotcu" style="width:100%;height:100%;"/>
			</div>
			<div class="name">{{ item.uname }}</div>
			<div class="date">{{ item.createtime }}</div>
			<rater :value="item.stars" :margin="5" active-color="#F9AD0C" :font-size="18" :disabled="true" style="width:100%;margin:2% 0%;"></rater>
			<div class="content">
				{{ item.content }}
			</div>
			<pic-shower :imgs="item.imgs" v-if="item.imgs && item.imgs.length > 0"></pic-shower>
			<div class="bubble" v-for="sub in item.subs">
				<div class="arrow"></div>
				<div class="sp-content">{{ sub }}</div>
			</div>
			<!-- <div class="bubble my">
				<div class="marrow"></div>
				<div class="sp-content">很满意,下次还会再来!</div>
			</div> -->
		</div>
	</div>
	<div class="com-wrapper" style="text-align:center;padding-top:5rem;" v-else>
		<img class="ncimg" src="../images/nocoms.png" />
		<label class="nocoms">
			暂时没有评价哦
		</label>
	</div>

	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
	import Tab from 'vux/src/components/tab/tab.vue'
	import TabItem from 'vux/src/components/tab/tab-item'
	import MyPop from 'components/my-pop'
	import Rater from 'vux/src/components/rater'
	import Separator from 'components/separator'
	import PicShower from 'components/pic-shower'
	import Toast from 'vux/src/components/toast'
	import { clearAll } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				clearAll
			}
		},
		components: {
			Tab,
			TabItem,
			MyPop,
			Rater,
			Separator,
			PicShower,
			Toast
		},
		route: {
			
		},
		data() {
			return {
				toastMessage:'',
				toastShow:false,
				column:0,
				data:{
					all:0,
					good:0,
					common:0,
					bad:0,
					list:[]
				},
				list: {
				    uimg:'',
				}
			}
		},
		ready(){
			this.getData();

			var head = JSON.parse(localStorage.getItem("userHeader"));
			for(var i in head) {
                console.log(head[i].headimgurl);
			}
		},
		methods: {
			changeColumn: function(col){
				this.column = col;
				this.getData();
			},
			getData: function(){
				this.$http.get(localStorage.apiDomain+'public/index/index/commentlist/pid/'+this.$route.params.pid+'/type/'+this.column).then((response)=>{
					if(response.data.status===1){
						this.data = response.data;
						console.log(this.data.list);
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
			}
		}
	}
</script>