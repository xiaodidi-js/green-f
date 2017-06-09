<style type="text/css">
    /* integral-head start */
    .integral-head{
        font-size:16px;
        width:100%;
        background: #fff;
        padding: 10px 0px;
    }

    .integral-head .integral-head-h1{
        width:100%;
        margin:10px auto;
    }

    .integral-head .integral-title{
        font-size:16px;
        text-indent:1em;
        padding-top:10px;
    }

    .integral-head .integral-number{
        font-size: 57px;
        color: #81c429;
        font-family: 'PingFang';
        text-align: center;
        display: block;
    }

    .integral-head .integral-h5{
        color:#999;
        text-align:center;
        margin:0px 10px;
        font-size: 14px;
    }

    .integral-head .sign {
        margin:10px auto;
        display: block;
        width: 10rem;
        height: 3rem;
        border:1px solid #81c429;
        background: #81c429;
        color:#fff;
        border-radius:5px;
    }

    /* integral-head end */

    /* integral-tab start */
    .integral-tab{
        width:100%;
        background: #81c429;
        height:50px;
        border-top:5px solid #f2f2f2;
    }

    .integral-tab ul li{
        font-size: 14px;
        float: left;
        width: 33%;
        height:55px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        display: block;
        text-align: center;
        line-height: 50px;
        position:relative;
        color:#fff;
    }

    .integral-tab ul .active {
        width:33%;
        height:47px;
        border-bottom: 3px solid #f9cc3d;
    }

    /*.integral-tab ul li .list {*/
        /*width:50%;*/
        /*height:3px;*/
        /*background: #f9cc3d;*/
        /*position:absolute;*/
        /*left:28px;*/
        /*bottom:0px;*/
    /*}*/

    /* integral-tab end */

    /* integral-body start */
    .integral-body{
        width:100%;
    }

    .integral-body .body-list{
        margin:10px 10px 0;
    }

    .integral-body .body-list ul li{
        height: 60px;
        border-bottom: 1px solid #CACACA;
        color: #4d4d4d;
        width: 100%;
    }

    .integral-body .body-list ul li .all-date{
        width:60%;
        float:left;
        font-size:14.5px;
        margin-top: 5px;
    }

    .integral-body .body-list ul li .all-date p{
        height:25px;
        line-height: 25px;
        text-align:left;
        /*padding:10px 0px;*/
    }

    .integral-body .body-list ul li .add-number{
        font-size: 28px;
        float:right;
        color:#81c429;
        margin-top: 8px;
    }

    #sign{
        display:none;
    }

    #consumption{
        display:none;
    }

    /* integral-body end */

</style>

<template>
    <div class="integral-head">
        <p style="color:#4d4d4d;" class="integral-title">签到积分</p>
        <div class="integral-head-h1">
            <p style="width:67px;margin:0px auto;">
                <img src="../images/jifen.png" style="width:67px;height:67px;" />
            </p>
            <i class="integral-number">{{ number }}</i>
        </div>
        <button class="sign" @click="qiandaoFun()">点我签到</button>
        <p class="integral-h5">小积分大用途，通过每日签到和订单评价获取更多积分</p>
    </div>
    <div class="integral-tab">
        <ul id="card">
            <li class="active" @click="Allmain()">全部积分</li>
            <li @click="main()">签到积分</li>
            <li @click="Allmain()">消费积分</li>
        </ul>
    </div>

    <div class="integral-body" id="content">
        <!-- 全部积分 -->
        <template v-for="item in allList">
            <div class="body-list">
                <ul>
                    <li>
                        <div class="all-date">
                            <p>签到</p>
                            <p>{{ item.createtime | time }}</p>
                        </div>
                        <div class="add-number">+{{ item.amount }}</div>
                    </li>
                </ul>
            </div>
        </template>
    </div>

</template>

<script>

    import {formatDate} from '../filters/date.js';


    export default{
        vuex: {
            actions: {

            }
        },
        components: {

        },
        data() {
            return {
                integral: [],
                list: [],
                allList: [],
                orderList: [],
                qiandaoList: [],
                number: 0,
            }
        },
        route: {

        },
        ready() {
            this.siblingsDom();
            this.main();
            this.Allmain();
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
                return (years) + '-' + (moneths + 1 > 9 ? moneths + 1 : '0' + (moneths + 1)) + '-' + (dates > 9 ? dates : '0' + dates) + ' ' + hours + ':' + minutes + ':' + seconds;
            }
        },
        methods: {
            Allmain () {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.$http.get(localStorage.apiDomain+'public/index/Usercenter/integral/uid/' + ustore.id + '/token/' + ustore.token).then((response)=>{
                    this.allList = response.data.list;
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            main: function() {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.$http.get(localStorage.apiDomain+'public/index/Usercenter/integral/uid/' + ustore.id + '/token/' + ustore.token).then((response)=>{
                    this.allList = response.data.list;
                    this.orderList = response.data.list;
                    this.number = response.data.zongfen;
                    console.log(response.data);
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            qiandaoFun: function() {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.$http.get(localStorage.apiDomain+'public/index/usercenter/qiandao/uid/' + ustore.id + '/token/' + ustore.token).then((response)=>{
                    this.list = response.data.list;
                    if(response.data.status == 0) {
                        alert("今天已签到了哦!");
                    } else if(response.data.status == 1) {
                        this.$router.go({name: 'integral'});
                        alert("签到成功！");
                    }
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
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

            }
        }
    }
</script>