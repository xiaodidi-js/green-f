<style type="text/css">
	/* buying-time start */
	.buying-time{
		width: 99%;
		height: 75px;
		margin: 5px auto 0;
		border: 1px solid #f26c60;
		border-radius: 5px;
		display: block;
	}

	.buying-time .buying-time-title{
		width: 50px;
		background: #f26c60;
		height: 100%;
		text-align: center;
		line-height: 30px;
		font-size: 16px;
		border-radius: 5px 0px 0px 5px;
		position: relative;
		right: 1px;
		float:left;
	}

	.buying-time .buying-time-title span{
		width:100%;
		display:block;
		color:#fff;
		line-height: 30px;
		position: relative;
		top: 8px;
	}

	.buying-time .buying-time-body{
		float:left;
		font-size:16px;
		margin: 9px 22.5px	;
		line-height:30px;
	}

	.buying-time .buying-time-body span{
		display:block;
	}

	/* buying-time end */
</style>

<template>
	<!-- 抢购时间 -->
	<div class="buying-time" v-if="nowsale == 1">
		<p class="buying-time-title">
			<span>抢</span>
			<span>购</span>
		</p>
		<p class="buying-time-body">
			<span style="color:#808080;">距离抢购结束还剩：</span>
			<span style="color:#f26c60;" id="timeline">
				<i id="times_hour">{{ timeRes.hour }}</i> 小时
				<i id="times_minute">{{ timeRes.minute}}</i> 分
				<i id="second">{{ timeRes.second}}</i>秒
			</span>
		</p>
	</div>
	<div class="buying-time" style="display:none;" v-else=""></div>
	<!-- 抢购时间 -->
</template>

<script>
    export default{
        props: {
            kind: {
                type: Number,
                default: 0
            },
            time: {
                type: Number,
                default: 0,
                twoWay: true
            },
            desc: {
                type: String,
                default: ''
            },
            end: {
                type: String,
                default: ''
            },
            unith: {
                type: String,
                default: ':'
            },
            unitm: {
                type: String,
                default: ':'
            },
            units: {
                type: String,
                default: ''
            },
            columns: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                timer:null,
                status:1
            }
        },
        methods: {
            "setTime": function(){
                let _self = this;
                this.columns = setInterval(function(){
                    _self.time --;
                },1000);
            }
        },
        ready() {
            if(this.kind===1){
                this.unith = "小时";
                this.unitm = "分";
                this.units = "秒";
            }
            if(this.time){
                this.setTime();
            }else{
                this.status = 0;
            }
            let _self = this;
            this.$watch('columns',function(newVal,oldVal) {
                for(var i = 0;i < newVal.length; i++) {
                    if(newVal[i].nowsale == 1 && newVal[i].etime > 0) {
                        console.log(newVal[i].etim);
                        _self.time = newVal[i].etime;
                        _self.nowsale = 1;
                    }
                    console.log(newVal[i]);
                }
            });

        },
        computed: {
            "timeRes": function() {
                let timeObj = {"hour":"00","minute":"00","second":"00"};
                let tmpTime = this.time;
                let htimes = 0,mtimes = 0;
                //计算小时数
                if(tmpTime >= 3600) {
                    htimes = parseInt(tmpTime / 3600);
                    timeObj.hour = htimes.toString();
                    if(htimes < 10){
                        timeObj.hour = "0"+timeObj.hour;
                    }
                    tmpTime = tmpTime - 3600 * htimes;
                }
                //计算分钟数
                if(tmpTime >= 60) {
                    mtimes = parseInt(tmpTime / 60);
                    timeObj.minute = mtimes.toString();
                    if(mtimes < 10) {
                        timeObj.minute = "0"+timeObj.minute;
                    }
                    tmpTime = tmpTime - 60 * mtimes;
                }
                //计算秒数
                if(tmpTime >= 0) {
                    timeObj.second = tmpTime.toString();
                    if(tmpTime < 10) {
                        timeObj.second = "0"+timeObj.second;
                    }
                }
                return timeObj;
            }
        },
        watch: {
            time: function(nval,oval) {
                if(oval == ''){
                    this.setTime();
                }else if(nval <= 0){
                    this.nowsale = 0;
                    clearInterval(this.timer);
                }
            }
        }
    }
</script>