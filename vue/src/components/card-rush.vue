<template>
	<div class="wrapper" style="padding-bottom: 6rem;" v-for="item in products">
		<template v-if="item.next !== null">
			<div class="words">
				<label class="title">限时限量 疯狂抢购</label>
				<label class="timer">
					<timer-countdown :time="item.next - item.servertime" desc="下场开始还有" end="" v-show="nowthat"></timer-countdown>
				</label>
			</div>
		</template>
		<template v-else>
			<div class="words">
				<!--<label class="title">限时限量 疯狂抢购</label>-->
				<label class="timer"></label>
			</div>
		</template>
		<template v-for="list in item.arr">
			<div class="card-box" v-link="{name:'detail',params:{pid:list.shopid}}">
				<div class="img" style="padding-top: 35%;" :style="{backgroundImage:'url('+ list.shotcut +')'}"></div>
				<!-- 正在抢购/抢购完毕 -->
				<div class="mes" v-if="item.nowsale == 1">
					<template v-for="money in list.saledata">
						<div class="name">{{ list.name }}</div>
						<progress class="progress-bar" max="100" :value="100 - money.salenub"></progress>
						<div class="desc">已抢购{{ 100 - money.salenub }}%</div>
						<div class="money">
							<div style="float:left;">
								<label class="unit">¥</label>
								<span>{{ money.saleprice }}</span>
							</div>
							<x-button type="primary" class="rush">马上抢</x-button>
						</div>
					</template>
				</div>
				<!--即将开始 -->
				<div class="mes" v-else>
					<div class="name">{{ list.name }}</div>
					<div class="pre-desc">{{ item.stime | time }}准时开抢</div>
					<div class="money" v-for="money in list.saledata">
						<label class="unit">¥</label>{{ money.saleprice }}
					</div>
				</div>
			</div>
		</template>
	</div>
</template>

<script>

    import XButton from 'vux/src/components/x-button'
    import TimerCountdown from 'components/timer-countdown'

	export default{
		props: {
			products: {
				type: Array,
				default() {
					return []
				}
			},
            nowthat: {
			    type: Boolean,
				default: true,
			}
		},
        ready() {
			console.log(this.products);
        },
        components: {
            XButton,
            TimerCountdown,
		},
		data() {
			return {
                timeline: [],
				showbar: '',
                number: 0,		//已抢购
                times: null,	//时间
			}
		},
        filters: {
            time: function (value) {
                var d = new Date(parseInt(value) * 1000),
					years = d.getFullYear(),
					moneths = d.getMonth(),
					dates = d.getDate(),
					hours = d.getHours(),
					minutes = d.getMinutes(),
					seconds = d.getSeconds();
                return (hours > 9 ? hours : '0' + hours) + '-' + (minutes > 9 ? minutes : '0' + minutes)
            }
        },
        methods: {

        }
	}
</script>

<style>

	.wrapper{
		width:100%;
		padding-bottom: 8rem;
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
		position: relative;
		padding-top: 10%;
	}

	.card-box .mes .name{
		color: #4D4D4D;
		line-height: 1.6rem;
		height: 3.2rem;
		overflow: hidden;
		text-overflow: ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 2;
		-webkit-box-orient: vertical;
		font-weight: normal;
		position: absolute;
		top: 0px;
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
		font-size:1.6rem;
		color:#333;
		margin-top:0.5rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.card-box .mes .pre-desc{
		color:#FF7486;
	}

	.card-box .mes .money {
		font-size: 2.6rem;
		color: #F9AD0C;
		position: relative;
		width: 100%;
		height: auto;
	}

	.card-box .mes .money .salenub-div {
		font-size: 12px;
		float:left;
		margin: 16px 0px 0px 10px;
	}

	.card-box .mes .money .unit{
		font-size:1.9rem;
		margin-right:0.3rem
	}

	.card-box .mes .money .rush{
		width: 7.2rem;
		height: 2.7rem;
		font-size: 1.2rem;
		line-height: 2.7rem;
		color: #fff;
		border-radius: 0.3rem;
		text-align: center;
		display: block;
		float: right;
		margin-top: 8px;
	}

	.card-box .mes .money .rush.disabled{
		background:#F3C76A;
	}

	progress::-moz-progress-bar { background: #0064B4; }
	progress::-webkit-progress-bar { background: #eee; }
	progress::-webkit-progress-value  { background: #81c429; }

	.words{
		width:100%;
		height:auto;
		padding:0% 0% 2% 0%;
		font-size:0;
		background-color:#efefef;
	}
	.words .title{
		display:inline-block;
		vertical-align:middle;
		width:45%;
		font-size:1.4rem;
		color:#333;
		letter-spacing:1px;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		margin:0.5rem 0rem 0.5rem 0rem;
		border-left:#81c429 solid 5px;
		padding-left:2%;
	}
	.words .timer{
		display:inline-block;
		vertical-align:middle;
		width:50%;
		margin:0.5rem 0rem 0.5rem 0rem;
		text-align:right;
	}

</style>