<style scoped>
    .counter{

    }

</style>
<template>
    <span class="counter" v-if="status === 1">
        {{ desc }}
        {{ timeRes.hour}}
        {{ unith }}
        {{ timeRes.minute}}
        {{ unitm }}
        {{ timeRes.second}}
        {{ units }}
    </span>
    <span class="counter" v-else>{{ end }}</span>
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
                this.timer = setInterval(function(){
                    _self.time --;
                },1000);
            }
        },
        ready() {
            if(this.kind === 1) {
                this.unith = "小时";
                this.unitm = "分";
                this.units = "秒";
            }
            if(this.time){
                this.setTime();
            }else{
                this.status = 0;
            }
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
                    this.status = 0;
                    clearInterval(this.timer);
                }
            }
        }
    }
</script>