<template>
    <div class="changePay" v-show="showele">
        <div class="prompt">请在15分钟内完成付款,晚了就给人抢了</div>
        <div class="countdown">
            <span>剩余支付时间</span>
            <span>{{ timeRes.hour}} : {{ timeRes.minute }} : {{ timeRes.second }}</span>
        </div>
    </div>
</template>

<script>
    export default{
        props: {
            arr: {
                type: Array,
                default() {
                    return
                }
            },
            time: {
                type: Number,
                default: 0,
                twoWay: true
            },
            showele: {
                type: Boolean,
                default : false,
            },
            time: {
                type: Number,
                default: 0,
                twoWay: true
            },
            end: {
                type: String,
                default: ''
            },
            kind: {
                type: Number,
                default: 0
            },
        },
        data() {
            return {
                timer:null,
                status:1
            }
        },
        components: {

        },
        ready() {

            if(this.time){
                this.setTime();
            }else{
                this.status = 0;
            }
        },
        methods: {
            "setTime": function() {
                try {
                    let _self = this;
                    this.timer = setInterval(function(){
                        _self.time--;
                        if(_self.time == 0) {
                            _self.showele = false;
                            _self.$dispatch('overtime');
                            _self.$router.go({name:'index'});
                            clearInterval(_self.timer);
                        }
                    },1000);
                } catch (e) {}
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
            time: function(nval,oval) {
                if(oval == ''){
                    this.setTime();
                }else if(nval <= 0){
                    this.status = 0;
                    clearInterval(this.timer);
                }
            }
        }
    }
</script>

<style>
    .bal-wrapper .changePay {
        width: 100%;
        height: 8rem;
        background: #fff;
        margin: 10px 0px;
        text-align: center;
    }

    .bal-wrapper .changePay .prompt {
        color: #333;
        width: 100%;
        height: 48px;
        line-height: 60px;
        text-align: center;
        font-size: 14px;
    }

    .bal-wrapper .changePay .countdown {
        color: #81c429;
        font-size:14px;
    }
</style>