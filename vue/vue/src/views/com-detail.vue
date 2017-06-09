<style scoped>
	.nowrap{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.com-wrapper{
		width:100%;
		min-height:100%;
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
		padding:0% 0% 5% 3%;
		border-bottom:#E6E6E6 dashed 1px;
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

	.card-box .pro-mes .words .format{
		width:100%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		font-size:1.2rem;
		color:#ccc;
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
	
	.card-box .pro-mes .com-box{
		width:96%;
		padding:2%;
		border-radius:0.3rem;
		background-color:#F2F2F2;
		font-size:0;
		margin-bottom:0.7rem;
	}

	.card-box .pro-mes .com-box:last-child{
		margin-bottom:0rem;
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

	.card-box .pro-mes .com-box.admin{
		font-size:1.4rem;
		color:#808080;
		position:relative;
		word-break:break-all;
	}

	.card-box .pro-mes .com-box.admin .arrow{
		position:absolute;
		left:1rem;
		top:-0.5rem;
		width: 0;
	    height: 0;
	    border-left: 0.5rem solid transparent;
	    border-right: 0.5rem solid transparent;
	    border-bottom: 0.5rem solid #F2F2F2;
	}

	.card-box .pro-mes .com-box.my-com .my-content{
		width:100%;
		height:auto;
		font-size:1.4rem;
		color:#333;
		margin-top:0.5rem;
		word-break:break-all;
	}

</style>

<template>
	<div class="com-wrapper" style="margin-top:46px;">
		<!-- 头部时间 -->
		<div class="htimer nowrap">成交时间:{{ data.createtime }}</div>
		<!-- 评价详情 -->
		<div class="card-box" v-for="item in data.list">
			<div class="pro-mes">
				<div class="shotcut"> <!--  v-lazy:background-image="item.shotcut" -->
					<img :src="item.shotcut" style="width:100%;height:100%" />
				</div>
				<div class="words">
					<div class="name">{{ item.name }}</div>
					<div class="format">{{ item.fname }}</div>
					<div class="money">
						<label class="unit">¥</label>
						{{ item.price }}
					</div>
				</div>
			</div>
			<div class="pro-mes" style="border-bottom:none;" v-if="item.imgs&&item.imgs.length>0">
				<pic-shower :imgs="item.imgs"></pic-shower>
			</div>
			<div class="pro-mes">
				<div class="com-box my-com">
					<div class="boxes left nowrap">
						<rater :value="item.stars" :font-size="18" :margin="1" :disabled="true"></rater>
						<label v-if="item.stars > 4">好评</label>
						<label v-if="item.stars > 1 && item.stars <= 4">中评</label>
						<label v-if="item.stars < 2">差评</label>
					</div>
					<div class="boxes nowrap right">[{{ item.createtime }}]</div>
					<div class="my-content">
						{{ item.content }}
					</div>
				</div>
				<div class="com-box admin" v-for="sub in item.subs">
					<div class="arrow"></div>
					{{ sub.content }}
				</div>
			</div>
		</div>
	</div>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>
import Rater from 'vux/src/components/rater'
import PicShower from 'components/pic-shower'
import Toast from 'vux/src/components/toast'
import { clearAll } from 'vxpath/actions'

export default{
	vuex: {
		actions: {
			clearAll
		}
	},
	data() {
		return {
			toastMessage:'',
			toastShow:false,
			data:{
				createtime: '',
				list: []
			}
		}
	},
	components: {
		Rater,
		PicShower,
		Toast
	},
	route: {
		
	},
	ready() {
		let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
		ustore = JSON.parse(ustore);
		this.$http.get(localStorage.apiDomain+'public/index/user/commentdetail/uid/'+ustore.id+'/token/'+ustore.token+'/oid/'+this.$route.params.oid).then((response)=>{
			if(response.data.status === 1) {
				this.data.createtime = response.data.createtime;
				this.data.list = response.data.list;
				console.log(this.data.createtime);
                console.log(response.data.list);
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

</script>