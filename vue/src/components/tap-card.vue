<style scoped>
	.tc-wrapper{
		width:100%;
		height:100%;
	}
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
	.hcon{
		width:100%;
		max-width:100%;
		height:5.4rem;
		overflow:hidden;
	}
	.tc-header{
		width:100%;
		height:4.4rem;
		background-color:#4D4D4D;
		position:relative;
		z-index:5;
		position: fixed;
		top:0px;
		left:0px;
		z-index:10;
	}
	.tc-tap{
		width:100%;
		height:5.4rem;
		position:absolute;
		font-size:0;
		top:0;
		white-space:nowrap;
	}
	.tc-tap-card{
		width:20%;
		height:3.2rem;
		padding:0.6rem 0rem;
		font-size:1.4rem;
		color:#fff;
		display:inline-block;
		vertical-align:top;
		text-align:center;
		position:relative;
	}
	.tc-tap-card.selected{
		background-color:#F9AD0C;
	}
	.tc-tap-card .time{
		display:block;
		width:100%;
		line-height:1.6rem;
		white-space:nowrap;
		overflow:hidden;
		text-overflow:ellipsis;
	}
	.tc-tap-card .status{
		display:block;
		width:100%;
		line-height:1.6rem;
		white-space:nowrap;
		overflow:hidden;
		text-overflow:ellipsis;
	}
	.tc-tap-card .btm{
		position:absolute;
		left:3.05rem;
		bottom:-1rem;
		width:0;
		height:0;
	}
	.tc-tap-card.selected .btm{
		position:absolute;
		left:3.05rem;
		bottom:-1rem;
		width:0;
		height:0;
		border-top:0.5rem solid #F9AD0C;
		border-left:0.5rem solid transparent;
		border-right:0.5rem solid transparent;
		border-bottom:0.5rem solid transparent;
	}
	.tc-wrapper .vux-slider{
		overflow:visible !important;
	}
</style>
<style>
	.tc-wrapper .vux-slider.my-vux-swiper > .vux-swiper{
		overflow:visible !important;
	}
	.words .timer .counter{
		font-size:1.4rem;
		color:#333;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}
</style>
<template>
	<div class="tc-wrapper">
		<!-- 头部选项卡 -->
		<div class="hcon">
			<div id="header" class="tc-header">
				<div id="tapper" class="tc-tap">
					<div class="tc-tap-card" v-for="item in gotimeline" @click="clickChange($index)" v-bind:class="[$index==index ? 'selected' : '']">
						<div v-if="item.nowsale == 1">
							<div class="time">{{ item.stime | time }}</div>
							<div class="status">进行中</div>
							<div class="btm"></div>
						</div>
                        <div v-if="item.nowsale == 0">
                            <div class="time">{{ item.stime | time }}</div>
                            <div class="status">即将开抢</div>
                            <div class="btm"></div>
                        </div>
						<div v-if="item.nowsale == 2">
							<div class="time">{{ item.stime | time }}</div>
							<div class="status">已结束</div>
							<div class="btm"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- 底部切换swiper -->
		<template v-for="item in gotimeline">
			<!-- 顶部标题 -->
			<div class="words">
				<label class="title">限时限量 疯狂抢购</label>
				<label class="timer">
					<!--<timer-countdown :time="item.etime - item.servertime" desc="下场开始还有" end="" keep-alive></timer-countdown>-->
				</label>
			</div>
			<!-- 外层scroller -->
			<!-- 产品列表 -->
			<card-rush :rushproducts="gotimeline" v-if="item.nowsale == 0 || item.nowsale == 1 || item.nowsale == 2"></card-rush>
		</template>
	</div>
</template>
<script>
    import Swiper from 'vux/src/components/swiper'
    import SwiperItem from 'vux/src/components/swiper-item'
    import TimerCountdown from 'components/timer-countdown'
    import Scroller from 'vux/src/components/scroller'
    import CardRush from 'components/card-rush'
    import { clearAll } from 'vxpath/actions'

    export default{
        components: {
            Swiper,
            SwiperItem,
            Scroller,
            CardRush,
            TimerCountdown,
        },
        vuex: {
            actions: {
                clearAll
            }
        },
        data() {
            return {
                index: 0,
                data: [],
                gotimeline: [],
            }
        },
        props: {
            endTime: {
                type: String,
                default: ''
            },
            endText: {
                type: String,
                default: '已结束'
            },
            callback: {
                type: Function,
                default: ''
            }
        },
        filters: {
            time: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var hours = d.getHours();
                var minutes = d.getMinutes();
                return (hours > 9 ? hours : '0' + hours) + ':' + (minutes > 9 ? minutes : '0' + minutes)
            },
            timeline: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var hours = d.getHours();
                var minutes = d.getMinutes();
                var seconds = d.getSeconds();
                return (hours > 9 ? hours : '0' + hours) + ':' + (minutes > 9 ? minutes : '0' + minutes) + ":" + (seconds > 9 ? seconds : '0' + seconds)
            }
        },
        methods: {
            clickChange: function(num) {
                this.index = num;
            },
            changeTapCard: function() {
//                let tapper = document.getElementById("tapper");
//                let card = document.getElementsByClassName("tc-tap-card");
//                card = card[0].offsetWidth;
//                let hwidth = document.getElementById("header").offsetWidth;
//                hwidth = hwidth / 2;
//                let distance = this.index * card + card / 2;
//                tapper.style.transition = "-webkit-transform 300ms ease-out";
//                if(distance > hwidth) {
//                    tapper.style.webkitTransform = "translate3d(-" + (distance-hwidth) + "px,0px,0px)";
//                }else{
//                    tapper.style.webkitTransform = "translate3d(" + (hwidth-distance) + "px,0px,0px)";
//                }
            },
            timeline: function() {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                var _this = this;
                this.$http.get(localStorage.apiDomain+'public/index/sale/SaleTimeSolt/uid').then((response) => {
                    if(response.data.status===1) {
                        this.gotimeline = response.data.SaleTimeSolt;
                        console.log(this.gotimeline);
                    } else if(response.data.status===-1) {
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
			}
        },
        ready() {
			this.timeline();
        },
        watch: {
            "index": function(nval,oval){
                this.changeTapCard();
            }
        }
    }
</script>