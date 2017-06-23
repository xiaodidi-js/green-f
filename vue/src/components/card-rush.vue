<template>
	<div class="wrapper" v-for="item in rushproducts">
		<template v-for="list in item.arr">
			<div class="card-box" v-link="{name:'detail',params:{pid:list.shopid}}" v-if="item.nowsale == 0">
				<div class="img" v-lazy:background-image="list.shotcut"></div>
				<!-- 即将开始 -->
				<div class="mes">
					<div class="name">{{ list.name }}</div>
					<div class="pre-desc">{{ item.stime | time }}准时开抢</div>
					<div class="money" v-for="money in list.saledata">
						<label class="unit">¥</label>{{ money.saleprice }}
					</div>
				</div>
			</div>
			<div class="card-box" v-link="{name:'detail',params:{pid:list.shopid}}" v-else>
				<div class="img" :style="{backgroundImage:'url('+ list.shotcut +')'}"></div>
				<!-- 正在抢购/抢购完毕 -->
				<div class="mes">
					<div class="name">{{ list.name }}</div>
					<progress class="progress-bar" max="100" value="30"></progress>
					<div class="desc">已抢购{{ number }}%</div>
					<div class="money" v-for="money in list.saledata">
						<label class="unit">¥</label>{{ money.saleprice }}
						<a class="rush">马上抢</a>
					</div>
				</div>
			</div>
		</template>
	</div>
</template>

<script>
	export default{
		props: {
			rushproducts: {
				type: Array,
				default() {
					return []
				}
			}
		},
		data() {
			return {
                timeline: [],
				showbar: '',
				number: 0
			}
		},
        filters: {
            time: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var years = d.getFullYear();
                var moneths = d.getMonth();
                var dates = d.getDate();
                var hours = d.getHours();
                var minutes = d.getMinutes();
                var seconds = d.getSeconds();
                return (hours > 9 ? hours : '0' + hours) + '-' + (minutes > 9 ? minutes : '0' + minutes)
            }
        },
        methods: {

        },
        ready() {

        },
	}
</script>

<style scoped>
	.wrapper{
		width:100%;
		padding:0rem 0rem 1rem 0rem;
		font-size:0;
	}

	.card-box{
		width:96%;
		height:auto;
		margin:0% 0% 2% 0%;
		background-color:#fff;
		display:block;
		font-size:0;
		color:#333;
		box-shadow:1px 1px 2px #e2e2e2;
		padding:2%;
	}

	.card-box:last-child{
		margin-bottom:0%;
	}

	.card-box .img{
		display:inline-block;
		vertical-align:middle;
		width:35%;
		padding-top:35%;
		margin-right:2%;
		background-color:#eee;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
	}

	.card-box .mes{
		display:inline-block;
		vertical-align:top;
		width:63%;
		font-size:1.4rem;
	}

	.card-box .mes .name{
		color: #4D4D4D;
		line-height: 1.6rem;
		height: 3.2rem;
		max-height: 4.2rem;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		font-weight: normal;
	}

	.card-box .mes .progress-bar{
		width: 100%;
		height: 1rem;
		background: #fff;
		overflow: hidden;
		border-radius: 0.3rem;
		margin-top: 0.5rem;
	}

	.card-box .mes .progress-bar .progress{
		width:0%;
		height:100%;
		background: #81c429;
	}

	.card-box .mes .desc,.card-box .mes .pre-desc{
		width:70%;
		font-size:1.2rem;
		color:#999999;
		margin-top:0.5rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.card-box .mes .pre-desc{
		color:#FF7486;
	}

	.card-box .mes .money{
		font-size: 2.6rem;
		color: #F9AD0C;
		position: relative;
	}

	.card-box .mes .money .unit{
		font-size:1.9rem;
		margin-right:0.3rem
	}

	.card-box .mes .money .rush{
		position:absolute;
		bottom:0;
		right:0;
		width:6.2rem;
		height:2.7rem;
		font-size:1.2rem;
		line-height: 2.7rem;
		color:#fff;
		background: #81c429;
		border-radius:0.3rem;
		text-align:center;
	}

	.card-box .mes .money .rush:active{
		background:#DE9A08;
	}

	.card-box .mes .money .rush.disabled{
		background:#F3C76A;
	}


	progress::-moz-progress-bar { background: #0064B4; }
	progress::-webkit-progress-bar { background: #eee; }
	progress::-webkit-progress-value  { background: #81c429; }

</style>