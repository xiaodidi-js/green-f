<!-- 抢购页面 -->

<style type="text/css">

    .snapped{
        width:100%;
        height:66px;
    }

    .snapped .head-ul{
        width:100%;
        height:50px;
        background: #4D4D4D;
        z-index: 10;
    }

    .snapped .head-ul li{
        width:20%;
        height:50px;
        float:left;
        text-align:center;
        color:#fff;
        font-size:14px;
        position:relative;
    }

    .snapped .head-ul .active{
        background: #F9AD0C;
    }

    .snapped .head-ul .active .bg-sj{
        /*position: absolute;*/
        /*bottom: -12px;*/
        /*left: 23px;*/
        background: url(../images/img2.png) no-repeat;
        background-size: 18px 10px;
        padding: 6px 10px;
        margin: 0px auto;
    }

    .snapped ul li .state{
        margin-top:3px ;
        line-height:15px;
    }

    .snapped ul li .gotime{
        margin-top:10px;
    }

    .snapped-title{
        /*text-indent:1em;*/
    }

    .snapped-h1{
        width:100%;
        height:60px;
        line-height: 60px;
        color:#333;
        background: #F2F2F2;
        position: relative;
        z-index:-1;
        font-size: 14px;
    }

    .snapped-h1 .snapped-list{
        width: 5px;
        height: 19px;
        background: #81C429;
        position: absolute;
        top: 21px;
        left: 6px;
    }

    .snapped-order{
        width:100%;
    }

    .snapped-order li{
        height:14rem;
        width:100%;
        clear:both;
        background: #fff;
        margin: 5px 0px;
    }

    .snapped-order li .snapped-main{
        width: 97%;
        height: 140px;
        padding: 10px 0;
    }

    .snapped-order li .snapped-image{
        /*background: url('../images/banner_chelizi.png') no-repeat;*/
        /*background-size: 100%;*/
        width:38%;
        height:120px;
    }

    .snapped-order li .snapped-image img{
        width:38%;
        float:left;
        height:120px;
    }

    .snapped-order li .description{
        float:left;
        color:#4D4D4D;
        width:58%;
        font-size:14px;
        margin: 0rem 0rem 0rem 1rem;;
        height: 100%;
        position:relative;
    }

    .snapped-order li .description .desc-h1{
        line-height: 20px;
        text-align:left;
    }

    .snapped-order li .description .do-money{
        float: left;
        width: 96%;
        position: absolute;
        bottom: 4px;
        text-align: left;
    }

    .snapped-order li .description .now-buying{
        border: 1px solid #81c429;
        background: #81c429;
        padding: 0.5rem 1.5rem;
        float: right;
        border-radius: 5px;
        color: #fff;
        margin:8px 0px 0px 5px;
    }

    .snapped-order li .description .thisdate{
        font-size:12px;color:#81C429;
        display:none;
    }

    .snapped-order li .description .thisdate .progress{
        width:150px;
        height:5px;
        border:1px solid #81c429;
        background: #fff;
        border-radius:5px;
        display:block;
        margin: 10px 0px 0px;
        position:relative;
    }

    .snapped-order li .description .thisdate .already {
        float:left;
    }

    .snapped-order li .description .thisdate .progress .go-progress{
        position:absolute;
        left:0px;
        top:0px;
        width:10%;
        height:5px;
        background: #81c429;
    }

    .snapped .snapped-header{
        width:100%;
        position: fixed;
        text-align:center;
        top: 0px;
        clear:both;
        left: 0px;
        z-index: 99;
    }

</style>

<template>
    <div class="snapped">
        <div class="snapped-header">
            <ul class="head-ul" id="card">
                <li class="active">
                    <p class="state gotime">00:00</p>
                    <p class="state">已结束</p>
                    <p class="" style="display:none;">即将开抢</p>
                    <i class="bg-sj"></i>
                </li>
                <li>
                    <p class="state gotime">10:00</p>
                    <p class="state">已结束</p>
                    <p class="" style="display:none;">即将开抢</p>
                    <i class="bg-sj"></i>
                </li>
                <li>
                    <p class="state gotime">12:00</p>
                    <p class="state">即将开抢</p>
                    <p class="" style="display:none;">已结束</p>
                    <i class="bg-sj"></i>
                </li>
                <li>
                    <p class="state gotime">14:00</p>
                    <p class="state">已结束</p>
                    <p class="" style="display:none;">即将开抢</p>
                    <i class="bg-sj"></i>
                </li>
                <li>
                    <p class="state gotime">20:00</p>
                    <p class="state">即将开抢</p>
                    <p class="" style="display:none;">已结束</p>
                    <i class="bg-sj"></i>
                </li>
            </ul>
            <div class="snapped-h1">
                <p class="snapped-list"></p>
                <p style="float:left;margin-left:15px;" class="snapped-title">限时限量 疯狂抢购</p>
                <p style="float:right;margin-right:15px;">
                    距离本场开始 03:50:51
                </p>
            </div>
        </div>

        <div id="content" style="margin-top: 115px;">
            <!-- 00:00点 -->
            <div class="buyinga">
                <ul class="snapped-order">
                    <li v-for="item in buydata">
                        <div class="snapped-main">
                            <div class="snapped-image" style="float:left;">
                                <img v-bind:src="item.pic" alt="" style="width:100%;height:122px;" />
                            </div>
                            <div class="description">
                                <p class="desc-h1" style="margin:0px;">{{ item.buytitle }}</p>
                                <p class="thisdate">
                                    <span class="progress">
                                        <i class="go-progress"></i>
                                    </span>
                                    <span class="already">
                                        已抢购
                                        <i>70</i>%
                                    </span>
                                </p>
                                <p style="float:left;color:#81c429;">
                                    <span>
                                        <i id="houre">12</i>:
                                        <i id="minute">00</i>
                                        {{ item.status }}
                                    </span>
                                </p>
                                <p style="color:#F9AD0C;" class="do-money">
                                    ￥ <span style="font-size: 28px;">{{ item.money }}</span>
                                    <button class="now-buying">马上抢</button>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</template>

<script type="text/javascript">


    export default{
        props: {
            columns: {

            }
        },
        data() {
            return {
                time:'',
                timer:null,
                status:1,
                buydata: [
                    {
                        "pic" : "../images/banner_chelizi.png",
                        "buytitle" : "车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝....",
                        "status" : "准备开抢",
                        "money" : "35.1"
                    },
                    {
                        "pic" : "../images/banner_chelizi.png",
                        "buytitle" : "车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝....",
                        "status" : "准备开抢",
                        "money" : "48.58"
                    },
                    {
                        "pic" : "../images/banner_chelizi.png",
                        "buytitle" : "车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝....",
                        "status" : "准备开抢",
                        "money" : "8.88"
                    }
                ]
            }
        },
        ready() {
            let _self = this;
            this.$watch('columns',function(newVal,oldVal){
                for(var i=0;i<newVal.length;i++){
                    if(newVal[i].type == 1 && newVal[i].time > 0){
                        _self.time = newVal[i].time;
                        _self.status = 1;
                    }
                }
            });
//            this._centerDom("snapped-image",1242,1242);
//            this._centerDom("snapped-main",51,144);

            this.siblingsDom();

        },
        methods: {
            $id: function(id) {
                return document.getElementById(id);
            },
            siblings: function (dom,callback){
                var pdom = dom.parentElement;
                var tabArr = [].slice.call(pdom.children);
                tabArr.filter(function(obj){
                    if(obj!=dom)callback.call(obj);
                });
            },
            siblingsDom:function (){
                var cardDom = this.$id("card");
                var liDomes = cardDom.children;
                var len = liDomes.length;
                for(var i = 0; i < len; i++) {
                    //给对象缓存自有属性
                    liDomes[i].index = i;
                    var _this = this;
                    liDomes[i].onclick = function(){
                        this.className = "active";
                        //同辈元素互斥
                        _this.siblings(this,function(){
                            this.className = "";
                        });
                        //把对应的选项卡的内容显示出来
                        var tabDom = document.getElementById("content").children[this.index];
                        tabDom.style.display = "block";
                        //拿它的父亲对象
                        _this.siblings(tabDom,function(){
                            this.style.display = "none";
                        });
                    };
                }
            },
            _centerDom: function(ClassDom,width,height) {
                var dom = document.getElementsByClassName(ClassDom);
                for(var i = 0,len =  dom.length; i < len; i++) {
                    var eleWin = dom[i].offsetWidth;
                    console.log(eleWin);
                    var confirmWin = eleWin * width / height + "px";
                    dom[i].style.height = confirmWin;
                }
            },
            "setTime":function() {
                let _self = this;
                this.timer = setInterval(function(){
                    _self.time --;
                },1000);
            }
        },
        components: {

        },
        computed: {
            "timeRes": function(){
                let timeObj = {"hour":"00","minute":"00","second":"00"};
                let tmpTime = this.time;
                let htimes = 0,mtimes = 0;
                //计算小时数
                if(tmpTime >= 3600){
                    htimes = parseInt(tmpTime/3600);
                    timeObj.hour = htimes.toString();
                    if(htimes < 10){
                        timeObj.hour = "0"+timeObj.hour;
                    }
                    tmpTime = tmpTime - 3600 * htimes;
                }
                //计算分钟数
                if(tmpTime >= 60){
                    mtimes = parseInt(tmpTime/60);
                    timeObj.minute = mtimes.toString();
                    if(mtimes < 10){
                        timeObj.minute = "0"+timeObj.minute;
                    }
                    tmpTime = tmpTime - 60 * mtimes;
                }
                //计算秒数
                if(tmpTime >= 0){
                    timeObj.second = tmpTime.toString();
                    if(tmpTime < 10){
                        timeObj.second = "0"+timeObj.second;
                    }
                }
                return timeObj;
            }
        },
        watch: {
            "time":function(nval,oval){
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
