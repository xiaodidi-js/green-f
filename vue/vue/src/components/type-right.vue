<style scoped>
	.wrapper{
		width:100%;
		padding:0rem 0rem 1rem 0rem;
		font-size:0;
	}

	.wrapper.nopadding{
		padding-bottom:0rem;
	}

	.title{
		display:block;
		margin:0.5rem 0rem 1rem 0rem;
		font-size:1.4rem;
		color:#F9AD0C;
		font-weight:normal;
		letter-spacing:1px;
		border-left:#F9AD0C solid 5px;
		padding-left:0.8rem;
	}

	.card-box{
		width:49%;
		height:auto;
		margin-bottom:2%;
		margin-right:2%;
		background-color:#fff;
		display:inline-block;
		font-size:1.6rem;
		color:#333;
		box-shadow:1px 1px 2px #e2e2e2;
	}

	.card-box:nth-child(even){
		margin-right:0%;
	}

	.card-box:nth-last-child(2),.card-box:last-child{
		margin-bottom:0%;
	}

	.parent{
		width:100%;
		height:auto;
		margin:0;
		padding:0;
	}

	.img{
		width:100%;
		padding-top:100%;
		background-position:center;
		background-size:cover;
		background-repeat:no-repeat;
		background-color:#e4e4e4;
	}

	.mes{
		padding:0.7rem 0.5rem;
	}

	.mes .name{
		font-size:1.4rem;
		color:#333;
		line-height:1.8rem;
		max-height:3.6rem;
		overflow:hidden;
		text-overflow:ellipsis;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		font-weight:600;
	}

	.mes .money{
		font-size:1.6rem;
		color:#F9AD0C;
	}

	.mes .money .unit{
		font-size:1.2rem;
		margin-right:0.2rem;
	}
</style>

<template>
	<!--<div class="wrapper" v-if="info.title">-->
		<!--<label class="title">{{ info.title }}</label>-->
		<!--<div class="parent">-->
			<!--<div class="card-box" v-link="{name:'detail',params:{pid:item.id}}" v-for="item in info.list">-->
				<!--<div class="img" v-lazy:background-image="item.src"></div>-->
				<!--<div class="mes">-->
					<!--<div class="name">-->
						<!--{{ item.title }}-->
					<!--</div>-->
					<!--<div class="money">-->
						<!--<label class="unit">¥</label>{{ item.price }}-->
					<!--</div>-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->
	<!--</div>-->
	<div class="wrapper" :class="{'nopadding':noPadding}">
		<div class="card-box" v-for="item in arrsomething"> <!--  v-link="{name:'detail',params:{pid:item.id}}" -->
			{{ item }}
			<div class="img" v-lazy:background-image="item.src"></div>
			<div class="mes">
				<div class="name">
					{{ item.title }}
				</div>
				<div class="money">
					<label class="unit">¥</label>{{ item.price }}
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props: {
			info: {
				type: Object,
				required: true
			},
			noPadding: {
				type: Boolean,
				default: false
			},
			arrsomething: []
		},
		data() {
			return {

			}
		},
		ready() {

		},
		methods: {
            getData: function(sk){
                let url = localStorage.apiDomain +
                    'public/index/index/classifylist/cid/' +
                    this.$route.params.cid+'/action/' +
                    this.column;
                if(sk.length>0){
                    url += '/search/'+sk;
                }
                var _this = this;
                this.$http.get(url).then((response)=>{
                    _this.arrsomething = response.data.list;
                    console.log(response.data.list);
                },(response)=>{
                    this.toastMessage = "网络开小差啦~";
                    this.toastShow = true;
                });
            }
		}
	}
</script>