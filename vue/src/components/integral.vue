<template>
    <div class="integral-head">
        <p style="color:#4d4d4d;" class="integral-title">签到积分</p>
        <div class="integral-head-h1">
            <p style="width:67px;margin:0px auto;">
                <img src="../images/jifen.png" style="width:67px;height:67px;" />
            </p>
            <i class="integral-number">{{ number }}</i>
        </div>
        <x-button type="primary" class="sign public-bgcolor" @click="qiandao()">点我签到</x-button>
        <p class="integral-h5">小积分大用途，通过每日签到和订单评价获取更多积分</p>
    </div>
    <div class="integral-tab">
        <ul id="card">
            <li class="actives" @click="main('orders')">全部积分</li>
            <li @click="main('qiandao')">签到积分</li>
            <li @click="main('orders')">消费积分</li>
        </ul>
    </div>
    <div class="integral-body" id="content">
        <div><!-- 所有积分 -->
            <arr :list="allList"></arr>
        </div>
        <div><!-- 签到积分 -->
            <qiandao :list="allList"></qiandao>
        </div>
        <div><!-- 消费积分 -->
            <orders :list="allList"></orders>
        </div>
    </div>
</template>

<script>
    import {formatDate} from '../filters/date.js';
    import axios from 'axios'
    import qs from 'qs'
    import orders from 'components/integral-tmpl'
    import qiandao from 'components/integral-qiandao'
    import arr from 'components/integral-arr'
    import XButton from 'vux/src/components/x-button'
    import Tab from 'vux/src/components/tab/tab.vue'
    import TabItem from 'vux/src/components/tab/tab-item'

    export default{
        vuex: {
            actions: {

            }
        },
        components: {
            orders,
            qiandao,
            arr,
            XButton,
            Tab,
            TabItem,
        },
        data() {
            return {
                integral: [],
                list: [],
                allList: [],
                orderList: [],
                qiandaoList: [],
                number: 0,
                qiandaoOK: '点我签到',
                dtype: '',
            }
        },
        route: {

        },
        computed : {

        },
        ready() {
            this.siblingsDom();
            this.qiandaoOK;
            this.main();
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
            main: function(type) {
                if(this.dtype == type && this.allList) {
                    return true;
                }
                this.dtype = type;
                this.$getData('/index/Usercenter/integral/uid/' + this.$ustore.id + '/token/' + this.$ustore.token).then((res) => {
                    this.allList = res.list;
                    this.number = res.zongfen;
                });
            },
            qiandao: function() {
                this.$getData('/index/usercenter/qiandao/uid/' + this.$ustore.id + '/token/' + this.$ustore.token).then((res) => {
                    if(res.status == 0) {
                        this.list = res.list;
                        alert("今天已签到了哦!");
                    } else if(res.status == 1) {
                        alert("签到成功！");
                        location.reload();
                    }
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
                        this.className = "actives";
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

<style lang="less">

    @import '../styles/theme.less';

    /* integral-head start */

    .integral-head {
        font-size:16px;
        width:100%;
        background: #fff;
        padding: 10px 0px;
    }

    .integral-head .integral-head-h1 {
        width:100%;
        margin:10px auto;
    }

    .integral-head .integral-title {
        font-size:16px;
        text-indent:1em;
        padding-top:10px;
    }

    .integral-head .integral-number {
        font-size: 57px;
        color: #81c429;
        font-family: 'PingFang';
        text-align: center;
        display: block;
        text-overflow: ellipsis;
        overflow: hidden;
        width: 100%;
        height: 74px;
    }
    .integral-head .integral-h5{
        color:#999;
        text-align:center;
        margin:0px 10px;
        font-size: 14px;
    }
    .integral-head .sign {
        margin: 10px auto;
        font-size: 1.4rem;
        display: block;
        width: 15rem;
        height: 3.5rem;
        line-height: 2.5rem;
        border: 1px solid #81c429;
        /*background: #81c429;*/
        color: #fff;
        border-radius: 5px;
    }
    /* integral-head end */

    /* integral-tab start */
    .integral-tab {
        width:100%;
        background: #81c429;
        height:50px;
        border-top:5px solid #f2f2f2;
    }

    .integral-tab ul li {
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

    .integral-tab ul .actives {
        width:33%;
        height:47px;
        border-bottom: 3px solid #f9cc3d;
    }


    .integral-body {
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
        width:50%;
        float:left;
        font-size:14.5px;
        margin-top: 5px;
    }

    .integral-body .body-list ul li .all-date p {
        height:25px;
        line-height: 25px;
        text-align:left;
        /*padding:10px 0px;*/
    }

    .integral-body .body-list ul li .add-number {
        font-size: 25px;
        float: right;
        color: #81c429;
        width: 43%;
        overflow: hidden;
        line-height: 61px;
        text-align: right;
        text-overflow: ellipsis;
    }

    #sign {
        display:none;
    }

    #consumption {
        display:none;
    }
    /* integral-body end */

</style>