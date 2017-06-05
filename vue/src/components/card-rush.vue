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
        margin-bottom: 1.2rem;
	}

	.card-box .mes .progress-bar{
		width:70%;
		height:0.5rem;
		background: #fff;
		overflow:hidden;
		border:#81c429 solid 1px;
		border-radius:0.3rem;
		margin-bottom:0.5rem;
	}

	.card-box .mes .progress-bar .progress{
		width:50%;
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
        font-size: 2.9rem;
        color: #F9AD0C;
        position: relative;
        margin-top: 11px;
	}

	.card-box .mes .money .unit{
		font-size:1.4rem;
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
</style>

<template>
	<div class="wrapper" v-for="item in rushproducts">
		<div class="card-box" v-for="list in item.arr" v-link="{name:'detail',params:{pid:list.shopid}}">
			<div class="img" :style="{backgroundImage:'url('+list.shotcut+')'}"></div>
			<!-- 即将开始 -->
			<div class="mes" v-if="item.stime > item.servertime">
				<div class="name">{{ list.name }}</div>
				<div class="pre-desc">{{ item.stime | time }}准时开抢</div>
				<div class="money" v-for="money in list.saledata">
					<label class="unit">¥</label>{{ money.saleprice }}
				</div>
			</div>
			<!-- 正在抢购/抢购完毕 -->
			<div class="mes" v-else>
				<div class="name">{{ list.name }}</div>
				<div class="progress-bar">
					<div class="progress"></div>
				</div>
				<div class="desc">已抢购50%</div>
				<div class="money" v-for="money in list.saledata">
					<label class="unit">¥</label>{{ money.saleprice }}
					<a class="rush">马上抢</a>
				</div>
			</div>
		</div>
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
                timeline: []
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