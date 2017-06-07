	<style scoped>
	.wrapper{
		/*padding:4% 3%;*/
		height:300px;
		font-size:0;
		overflow:hidden;
	}

	.bg-color {
		background: #f5f9ea;
		padding-bottom: 10px;
	}

	.card-box{
		display:inline-block;
		width:31%;
		min-height:10px;
		background-color:#fff;
		box-shadow:1px 1px 2px #e2e2e2;
		vertical-align:middle;
		font-size:1.6rem;
		border-radius:0.1rem;
		text-align:center;
		margin-top: 10px;
	}
	.card-box:last-child{
		margin-right:0%;
	}
	.card-box .title{
		font-size:1.5rem;
		padding:0.2rem 0.5rem 0rem 0.5rem;
	}
	.card-box:first-child>.title{
		color:#E74F7B;
		line-height: 22px;
	}

	.card-box:nth-child(even)>.title{
		color:#F46769;
		line-height: 22px;
	}
	.card-box:last-child>.title{
		color:#FFA103;
		line-height: 22px;
	}
	.money{
		color:#f9ad0c;
		font-size: 24px;
		line-height: 24px;
	}

	.card-box .time{
		font-size:1.4rem;
		line-height:2.2rem;
		height:2.2rem;
		padding:0.2rem 0.3rem 0.2rem 0.3rem;
		text-align:center;
	}
	.card-box .time>label.number{
		color:#fff;
		background-color:#343136;
		border-radius:0.3rem;
		padding:0.1rem 0.2rem;
	}
	.card-box .time>label.dotted{
		color:#343136;
		font-weight:bold;
	}
	.card-box .time>label.none{
		color:#999;
	}
	.card-box .desc{
		font-size:1.2rem;
		color:#999;
		line-height:1.3rem;
		height:2.4rem;
		overflow:hidden;
		text-overflow:ellipsis;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		padding:0rem 0.5rem 0.2rem 0.5rem;
	}
	.card-box .img{
		width: 89%;
		padding-top: 90%;
		background-color: #eee;
		border-radius: 0.2rem;
		margin: 0.5rem 0rem 0.5rem 0.5rem;
		background-repeat: no-repeat;
		background-position: center;
		background-size: cover;
		overflow: hidden;
	}
	.buy{
		width:100%;
		line-height: 40px;
		position:relative;
		font-size:14px;
		background: #fff;
	}
	.myp{
		width:91px;
		margin:0 auto;
		font-size:14px;
		color:#81c429;
		text-align:center;
		line-height: 25px;
	}

	.timer{width:22rem;margin:0 auto;overflow:hidden;height:3.64rem;margin:5px auto;display:flex;}

	.timer_p{font-size: 14px;color:#999999;padding-right:0;padding-right:8px;line-height: 40px;}

	.box {
		width: 3.64rem;
		height: 3.64rem;
		background: #373439;
		border-radius: 2px;
		color: #fff;
		line-height: 0.64rem;
		text-align: center;
	}

	.box span {line-height:3.74rem;}

	.timer_dian {
		padding:0 3px;
		font-size:18px;
		line-height:3.64rem;
	}
	.watch_more {
		position: absolute;
		right: 1.5rem;
		top: 2.6rem;
		color: #b3b3b3;
		font-size: 13px;
	}

	.buy {
		width: 100%;
		line-height: 40px;
		position: relative;
		font-size: 14px;
		background: #fff;
		padding: 5px 0px;
	}

	.content {
		width: 100%;
		height: 100%;
		background: #f5f9ea;
		clear: both;
	}
	.content .box-list {
		width: 32%;
		height: auto;
		background: #fff;
		float: left;
		text-align: center;
		margin: 5px 2.1px;
	}
	.content .box-list .main-title {
		color:#ff1d25;
		font-size:1.6rem;
		line-height: 3.0rem;
		height:3.0rem;
		display:block;
		width:100%;
	}

	.content .box-list .main-price {
		color:#f9ad0c;
		display:block;
		height:2.5rem;
		line-height: 2.5rem;
		width:100%;
	}

	.content .box-list .main-des {
		font-size:1.3rem;
		color:#999;
		height:4.0rem;
		line-height: 1.9rem;
		display: block;
		margin:0px auto;
		word-wrap:break-word;
		overflow: hidden;
		width: 100%;
		text-overflow: ellipsis;
	}

</style>
<template>
	<div v-show="showele">
		<div class="buy">
			<p class="myp">限时抢购</p>
			<div class="timer">
				<p class="timer_p">距结束</p>
				<div class="box"><span style="font-size: 1.4rem;">{{ timeRes.hour }}</span></div>
				<p class="timer_dian">:</p>
				<div class="box"><span style="font-size: 1.4rem;">{{ timeRes.minute }}</span></div>
				<p class="timer_dian">:</p>
				<div class="box"><span style="font-size: 1.4rem;">{{ timeRes.second }}</span></div>
				<div class="time">
					<label class="dotted" v-if="status == 0">抢购进行中!</label>
					<label class="none" v-if="status < 0">抢购已结束</label>
				</div>
			</div>
			<div class="watch_more" v-link="{name:'tap-card'}">
				<span>查看更多 &gt; </span>
			</div>
		</div>

		<div class="content">
			<template  v-for="item in columns">
				<template v-if="item.nowsale == 1">
					<div class="box-list" v-for="list in item.arr" v-link="{name:'detail',params:{pid:list.shopid}}">
						<p class="main-title">秒杀价</p>
						<template v-for="mon in list.saledata">
							<p class="main-price">
								<i style="font-size: 1.2rem;">￥</i>
								<i style="font-size: 2.3rem;">{{ mon.saleprice }}</i>
							</p>
						</template>
						<div class="main-des">{{ list.name }}</div>
						<div style="width:90%;margin:7px auto;">
							<img :src="list.shotcut" style="width:100%;height:100%;" />
						</div>
					</div>
				</template>
			</template>
		</div>
	</div>
</template>
<script>

    export default{
        props: {
            columns: {
                type: Array,
                default() {
                    return []
                }
            },
            time: {
                type: Number,
                default: 0,
                twoWay: true
            }
        },
        data() {
            return {
                time:'',
                timer:null,
                status:1,
                showele: false
            }
        },
        components: {

		},
        ready() {
            let _self = this;
            this.$watch('columns',function(newVal) {
                for(var i = 0;i < newVal.length; i++) {
                    var mytime = newVal[i].etime - newVal[i].servertime;
                    console.log(mytime);
                    if(newVal[i].nowsale == 1 && newVal[i].etime > 0) {
                        this.showele = true;
                        _self.time = mytime;
                        _self.nowsale = 1;
                    }
                }
            });
        },
        methods: {
            setTime:function() {
                let _self = this;
                this.timer = setInterval(function(){
                    _self.time--;
                    if(_self.time == 0) {
                        _self.showele = false;
                        _self.$router.go({name:'index'});
					}
                },1000);
            }
        },
        computed: {
            timeRes: function() {
                let timeObj = {"hour" : "00","minute" : "00","second" : "00"};
                let tmpTime = this.time;
                let htimes = 0,mtimes = 0;
                //计算小时数
                if(tmpTime >= 3600) {
                    htimes = parseInt(tmpTime / 3600);
                    timeObj.hour = htimes.toString();
                    if(htimes < 10) {
                        timeObj.hour = "0" + timeObj.hour;
                    }
                    tmpTime = tmpTime - 3600 * htimes;
                }
                //计算分钟数
                if(tmpTime >= 60) {
                    mtimes = parseInt(tmpTime / 60);
                    timeObj.minute = mtimes.toString();
                    if(mtimes < 10) {
                        timeObj.minute = "0" + timeObj.minute;
                    }
                    tmpTime = tmpTime - 60 * mtimes;
                }
                //计算秒数
                if(tmpTime >= 0) {
                    timeObj.second = tmpTime.toString();
                    if(tmpTime < 10) {
                        timeObj.second = "0" + timeObj.second;
                    }
                }
                return timeObj;
            }
        },
        watch: {
            time:function(nval,oval) {
                if (oval == '') {
                    this.setTime();
                } else if (nval <= 0) {
                    this.nowsale = 0;
                    clearInterval(this.timer);
                }
            }
        }
    }
</script>