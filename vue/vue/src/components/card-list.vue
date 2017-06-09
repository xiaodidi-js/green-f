<style scoped>
	.fixed-tab{
		position:fixed;
		top:46px;
		left:0;
		width:100%;
		z-index:100;
	}

</style>

<template>
	<div class="sub-content">
		<div class="cla-message">
			<div class="main" v-for="item in list" v-link="{name:'cla-list',params:{cid:item.id}}">
				<div class="shotcut"><!--  v-lazy:background-image="" -->
					<img :src="item.shotcut" alt="" class="shotcut-img" />
				</div>
				<div class="shotcut-txt">
					<p>{{ item.name }}</p>
					<p style="color:#f9ad0c;">
						<i>￥</i>
						<span class="money">29.99</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import CardSquare from 'components/card-square'
import Separator from 'components/separator'

export default{
	data() {
		return {
			toastMessage:'',
			toastShow:false,
			column:'hot',
			data:{
				title: '',
				list: []
			},
			arrlist: []
		}
	},
	components: {
		CardSquare,
		Separator
	},
	route: {

	},
	ready() {
		this.getData('');
	},
	methods: {
		getData: function(sk) {
			let url = localStorage.apiDomain + 'public/index/index/classifylist/cid/' + this.$route.params.cid + '/action/' + this.column;
			if(sk.length > 0) {
				url += '/search/' + sk;
			}
			var _this = this;
			this.$http.get(url).then((response)=>{
                _this.arrlist = response.data.list;
				console.log(_this.arrlist);
			},(response)=>{
				this.toastMessage = "网络开小差啦~";
				this.toastShow = true;
			});
		},
		changeColumn: function(col){
			if(this.column===col){
				return false;
			}
			this.column = col;
			this.getData('');
		}
	},
	events: {
		goSearch: function(skey){
			this.getData(skey);
		}
	}
}

</script>