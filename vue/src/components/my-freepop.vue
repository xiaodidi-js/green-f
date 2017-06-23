<template>
    <div class="masker" :class="{'show':show}"
         @click="hidePanel" @touchmove.stop.prevent @touchend.stop
         @touchstart.stop></div>
    <div class="panel" :class="{'show':show}" @touchmove.stop.prevent @touchend.stop @touchstart.stop>
        <div class="search_panel">
            <form class="search_form">
                <input type="text" class="search_txt" placeholder="搜索自提点" v-model="search" />
                <input type="button" class="search_btn"/>
            </form>
            <div class="alladdress">
                <span>地区选择:</span>
                <div class="sel-bg">
                    <div class="select-add" id="selectTitle" @click="onChonse()">全部</div>
                    <i class="iconfont icon-sanjiao icon-sanjiao" id="icon-sanjiao"></i>

                </div>
            </div>
        </div>
        <div class="con-box" id="content-box" v-on:touchmove="conMove">
            <div class="emline" v-show="showStatus">{{ showTips }}</div>
            <freepop-list v-for="item in tmp_address" :obj="item" :chose-id="chosen" :sum-money="money" ></freepop-list>
        </div>
        <div class="btn" v-if="showConfirm" @click="hidePanel">{{ confirmText }}</div>
    </div>

    <div class="popdown" v-show="popdown" @click="downpop"></div>
    <div class="option-list" id="left_Menu">
        <div class="scroll" id="scroller">
            <div>
                <div class="everaddress" @click="allChonse()">全部</div>
                <div class="down"  @click="downpop">完成</div>
            </div>
            <li class="list-li" v-for="item in options">
                <div style="background: #eee;text-indent:0.5em;">{{ item.name }}</div>
                <i class="list" style="display:block;width:100%;height:1px;background: #f2f2f2;"></i>
                <div class="double-list">
                    <ul>
                        <li class="select-li" v-for="items in item.sub" @click="onOnlyAddress(items.id)">{{ items.name }}</li>
                    </ul>
                </div>
            </li>
        </div>
    </div>
    <!-- toast显示框 -->
    <toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>
    <!-- loading加载框 -->
    <loading :show="loadingShow" :text="loadingMessage"></loading>

</template>

<script>
    import FreepopList from 'components/freepop-list'
    import {clearAll,myGift,mySong, commitData, mystu } from 'vxpath/actions'
    import Toast from 'vux/src/components/toast'
    import Loading from 'vux/src/components/loading'
    import axios from 'axios'
    import qs from 'qs'

    export default{
        vuex: {
            actions: {
                clearAll,
                myGift,
                mySong,
                commitData,
                mystu,
            }
        },
        components: {
            FreepopList,
            Toast,
            Loading
        },
        props: {
            show: {
                type: Boolean,
                required: true,
                twoWay: true
            },
            title: {
                type: String,
                default: ''
            },
            showConfirm: Boolean,
            confirmText: {
                type: String,
                default: '确定'
            },
            chosen: {
                type: Number,
                required: true,
                default: 0,
                twoWay: true
            },
            money: {
                type: [String,Number],
                default: 0,
            },
            pop: {
                type: Boolean,
                default: true,
            },
            lists: {
                type: [Object,Array],
                default: [],
            }
        },
        data() {
            return {
                showStatus: true,
                showTips: '加载中...',
                getType: '',
                address: [],
                toastMessage: '',
                toastShow: false,
                isChonse: false,
                options: [],
                search: '',
                tmp_address: [],
                data: [],
                popdown: false,
            }
        },
        ready() {
            this.selList();
            this.onToureEle();
            console.log(123123);
        },
        created() {

        },
        methods: {
            onToureEle () {
                try {
                    var times = null , myScroll_left;
                    times = setInterval(function() {
                        var resultContentH = $("#left_Menu").height();
                        if (resultContentH > 0) {
                            $("#left_Menu").height(resultContentH);
                            setTimeout(function () {
                                clearInterval(times);
                                myScroll_left = new IScroll('#left_Menu', {
                                    vScroll: true,
                                    mouseWheel: true,
                                    vScrollbar: false,
                                    probeType: 2,
                                    click: true
                                });
                                myScroll_left.refresh();
                            }, 100);
                        }
                    } ,100);
                } catch (e) {}
            },
            downpop () {
                $(".option-list").show().animate({
                    "bottom":"-250px"
                },100);
                this.popdown = false;
                this.tansform('icon-sanjiao', 'rotate(0deg)');
                this.isChonse = false;
            },
            fun: function () {
                var self = this;
                var data = self.tmp_address.filter(function (item) {
                    return item.name.indexOf(self.search) !== -1
                });
                this.tmp_address = data;
            },
            touchout: function () {
                if (this.isChonse) {
                    this.tansform('icon-sanjiao', 'rotate(0deg)');
                    this.isChonse = false;
                }
            },
            onOnlyAddress: function (id) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                var _this = this;
                this.$http.get(localStorage.apiDomain + 'public/index/Usercenter/myaddress/uid/' + ustore.id + '/token/' + ustore.token + '/state/0/sinceid/' + id).then((response) => {
                    if (response.data.status === 1) {
                        var tmp = this.address.filter(function (item) {
                            return item.pid == id;
                        });
                        this.tmp_address = tmp;
                        this.data = tmp;
                        $(".double-list ul li").click(function() {
                            var values = $(this).text();
                            $(".select-add").text(values);
                        });
                        this.isChonse = false;
                        _this.tansform('icon-sanjiao','rotate(0deg)');
                    } else if (response.data.status === -1) {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function () {
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name: 'login'});
                        }, 800);
                    } else {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                }, (response) => {
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            tansform: function (id, angle) {
                var icon = document.getElementById(id);
                icon.style.transform = angle;
                icon.style.transition = '0.5s';
                return icon;
            },
            allChonse: function() {
                if (!this.isChonse) {
                    this.isChonse = true;
                    this.tansform('icon-sanjiao', 'rotate(180deg)');
                } else {
                    this.tansform('icon-sanjiao', 'rotate(0deg)');
                    this.isChonse = false;
                }
                this.tmp_address = this.address;
                var values = $(".everaddress").text();
                $(".select-add").text(values);
                this.isChonse = false;
            },
            onChonse: function () {
                var content = this;
                this.popdown = true;
                $(".option-list").show().animate({
                    "bottom":"0px"
                },100);
                if (!this.isChonse) {
                    this.isChonse = true;
                    this.tansform('icon-sanjiao', 'rotate(180deg)');
                } else {
                    this.tansform('icon-sanjiao', 'rotate(0deg)');
                    this.isChonse = false;
                }
            },
            hidePanel: function () {
                if (!this.chosen) {
                    this.toastMessage = '请选择自提地点~~~~';
                    this.toastShow = true;
                } else {
                    this.oneGift(this.chosen,this.money);
                    this.show = false;
                    this.ischonse = false;
                }
            },
            oneGift: function (id,money) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                var content = this;
                axios({
                    method: 'post',
                    url: localStorage.apiDomain + 'public/index/user/manjiusong',
                    data: qs.stringify({
                        uid:ustore.id,
                        token:ustore.token,
                        sinceid:id,
                        money:money
                    })
                }).then((response) => {
                    if(response.data.status == 1) {
                        content.openpop = true;
                        content.showGive = true;
                        this.lists = response.data.maxmoney;
                        for(var i in this.lists) {
                            this.mySong('请选择满'+ this.lists[i].maxmoney +'元赠品');
                            console.log(this.lists[i].maxmoney);
                        }
                        this.commitData({target: 'giftList', data: response.data.maxmoney});
                        this.commitData({target: 'giftstu', data: 1});
                        this.commitData({target: 'visibleEle', data: true});
                    } else if(response.data.status == 0) {
                        this.commitData({target: 'visibleEle', data: false});
                        axios({
                            method: 'post',
                            url: localStorage.apiDomain + 'public/index/user/shoudan',
                            data: qs.stringify({
                                uid:ustore.id,
                                token:ustore.token,
                                sinceid:this.chosen,
                                money:this.money
                            })
                        }).then((response) => {
                            if(response.data.status == 1) {
                                this.commitData({target: 'visibleEle', data: true});
                                this.mySong('请选择首单用户赠品');
                                content.showGive = true;
                                this.myGift(this.lists);
                                this.lists = response.data.shoduan_data;
                                this.commitData({target: 'giftList', data: response.data.shoudan_data})
                                this.commitData({target: 'giftstu', data: 2});
                            } else if(response.data.status === 0) {
                                this.commitData({target: 'visibleEle', data: false});
                            }
                        });
                    }
                });
            },
            conMove: function (evt) {
                evt.stopPropagation();
            },
            selList: function (id) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                let pdata = {uid: ustore.id, token: ustore.token, addressid: id};
                this.$http.put(localStorage.apiDomain + 'public/index/Usercenter/since', pdata).then((response) => {
                    if (response.data.status === 1) {
                        this.showStatus = false;
                        this.showTips = '加载中...';
                        this.options = response.data.list;
                    } else if (response.data.status === -1) {
                        this.$dispatch('showMes', response.data.info);
                        let context = this;
                        setTimeout(function () {
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name: 'login'});
                        }, 800);
                    } else {
                        this.$dispatch('showMes', response.data.info);
                    }
                }, (response) => {
                    this.$dispatch('showMes', '网络开小差了~');
                });
            }
        },
        events: {
            setChosen: function (obj) {
                if (typeof obj === 'object') {
                    let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                    ustore = JSON.parse(ustore);
                    let pids = '';
                    if (this.$parent.cartIds.length > 0) {
                        pids = this.$parent.cartIds.join(',');
                    }
                    let pdata = {
                        uid: ustore.id,
                        token: ustore.token,
                        type: this.$parent.deliverType,
                        ids: pids,
                        area: obj.area
                    };
                    this.$http.post(localStorage.apiDomain + 'public/index/user/addresschosen', pdata).then((response) => {
                        if (response.data.status === 1) {
                            this.chosen = obj.id;
                            this.$parent.data.address = obj;
                            this.$parent.data.tmp_address = obj;
                            this.$parent.freight = response.data.freight;
                        } else if (response.data.status === -1) {
                            this.$parent.toastMessage = response.data.info;
                            this.$parent.toastShow = true;
                            let context = this;
                            setTimeout(function () {
                                context.clearAll();
                                sessionStorage.removeItem('userInfo');
                                localStorage.removeItem('userInfo');
                                context.$router.go({name: 'login'});
                            }, 800);
                        } else {
                            this.$parent.toastMessage = response.data.info;
                            this.$parent.toastShow = true;
                        }
                    }, (response) => {
                        this.$parent.toastMessage = '网络开小差了~';
                        this.$parent.toastShow = true;
                    });
                }
            }
        },
        watch: {
            search () {
                if(this.search == '') {
                    this.tmp_address = this.address;
                } else {
                    this.fun()
                }
            },
            show: function (nval, oval) {
                if ((nval === true && this.address.length <= 0) || (nval === true && this.$parent.deliverType != '' && this.$parent.deliverType != this.getType)) {
                    let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                    ustore = JSON.parse(ustore);
                    this.getType = this.$parent.deliverType;
                    this.$http.get(localStorage.apiDomain + 'public/index/user/addresschosen/uid/' + ustore.id + '/token/' + ustore.token + '/type/' + this.getType).then((response) => {
                        if (response.data.status === 1) {
                            this.showStatus = false;
                            this.showTips = '加载中...';
                            this.address = response.data.list;
                            this.tmp_address = response.data.list;
//                            this.data = response.data.list;
                        } else if (response.data.status === -1) {
                            this.$parent.toastMessage = response.data.info;
                            this.$parent.toastShow = true;
                            let context = this;
                            setTimeout(function () {
                                context.clearAll();
                                sessionStorage.removeItem('userInfo');
                                localStorage.removeItem('userInfo');
                                context.$router.go({name: 'login'});
                            }, 800);
                        } else {
                            this.address = [];
                            this.chosen = 0;
                            this.showTips = '暂无添加地址';
                            this.showStatus = true;
                        }
                    }, (response) => {
                        this.$parent.toastMessage = '网络开小差了~';
                        this.$parent.toastShow = true;
                    });
                }
            }
        },
        computed: {
            data:function(){

            }
        }
    }
</script>

<style scoped>

    /* search_panel start */
    .search_panel {
        width: 100%;
    }

    .search_panel .search_form {
        border: 1px solid #f2f2f2;
        background: #fff;
        color: #4d4d4d;
        width: 93%;
        margin: 0px 10px;
        height: 4rem;
        font-size: 14px;
        text-indent: 1em;
        position: relative;
        top: 10px;
        z-index: 100;
    }

    .search_panel .search_form .search_txt {
        width: 93%;
        height: 3rem;
        background: url("../images/search-1.png") no-repeat right;
        background-size: 23px 23px;
        margin-top: 4px;
        font-size: 14px;
    }

    .search_panel .alladdress {
        width: 20rem;
        margin: 35px auto 0px;
        padding-bottom: 60px;
    }

    .search_panel .alladdress span {
        font-size: 14px;
        float: left;
        line-height: 32px;
    }

    .search_panel .alladdress .sel-bg {
        width: 12rem;
        height: 3rem;
        text-indent: 0.5em;
        border: 1px solid #ccc;
        float: left;
        margin-left: 5px;
        position: relative;
        background: #fff;
        outline: none;
    }

    .search_panel .alladdress .sel-bg .icon-sanjiao {
        position: absolute;
        right: 5px;
        top: 7px;
        color: #ccc;
    }

    .popdown {
        width:100%;
        height:100%;
        position: fixed;
        top:0px;
        left:0px;
        z-index: 6666;
        background: rgba(0,0,0,0.1);
    }

    .option-list {
        z-index: 7777;
        width: 100%;
        height: 250px;
        background: #fff;
        position: fixed;
        border: 1px solid #ccc;
        left: -1px;
        bottom: -250px;
        overflow-y: auto;
        display: block;
        -webkit-overflow-scrolling: touch;
        -moz-overflow-scrolling: touch;
        -ms-overflow-scrolling: touch;
        -o-overflow-scrolling: touch;
        overflow-scrolling: touch;
    }

    .option-list .list-li {
        line-height: 4.5rem;
        font-size: 14px;
        position: relative;
        clear: both;
    }

    .option-list .list-li .double-list {
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .option-list .list-li .double-list ul li {
        width: 105%;
        height: 4.5rem;
        display: block;
        text-indent: 2em;
        text-indent:2em;
    }

    .option-list .list-li .double-list ul li:active {
        background: #81c429;
        color:#fff;
    }

    .search_panel .alladdress .sel-bg .select-add {
        width: 9.5rem;
        border: none;
        height: 30px;
        background-size: 10px 10px;
        outline: none;
        text-align: center;
        line-height: 3rem;
        font-size: 14px;
    }

    .option-list .everaddress {
        clear:both;
        height:4.5rem;
        width:80%;
        float:left;
        font-size:1.4rem;
        line-height:4.5rem;
        text-indent:0.5em;
    }

    .option-list .everaddress:active {
        background: #81c429;
        color:#fff;
    }

    .option-list .down {
        width: 20%;
        float: right;
        line-height: 4.5rem;
        text-align: center;
        font-size: 1.4rem;
    }

    .option-list .down:active {
        background: #81c429;
        color:#fff;
    }

    /* search_panel end */

    .masker {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 0%;
        z-index: 1000;
        background: transparent;
    }

    .masker.show {
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: block;
        transition: background .6s;
        -webkit-transition: background .6s;
    }

    .panel {
        position: fixed;
        left: 0;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 5000;
        transform: translateY(100%);
        -webkit-transform: translateY(100%);
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        -webkit-transition: -webkit-transform .3s;
        transition: transform .3s, -webkit-transform .3s;
        background: #f2f2f2;
    }

    .panel.show {
        transform: translate(0);
        -webkit-transform: translate(0);
    }

    .panel .con-box {
        width: 94%;
        padding: 0% 3% 0% 3%;
        /* max-height: 20rem; */
        /* overflow-x: hidden; */
        height: 68%;
        /* overflow-y: scroll; */
        -webkit-overflow-scrolling: touch;
        margin-top: 65px;
        overflow-y: auto;
        margin-bottom: 52px;
    }

    .panel .title {
        width: 100%;
        font-size: 1.6rem;
        color: #333;
        letter-spacing: 0.2rem;
        text-align: center;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        padding-bottom: 5%;
        background-color: #fff;
        padding-top: 5%;
    }

    .panel .btn {
        width: 94%;
        padding: 3% 0%;
        background-color: #81c429;
        text-align: center;
        font-size: 1.6rem;
        color: #fff;
        letter-spacing: 0.2rem;
        position: absolute;
        bottom: 0px;
        margin: 10px;
    }

    .my-icon:before {
        font-size: 1.6rem;
        color: #cccccc;
    }

    .my-icon-chosen:before {
        font-size: 1.6rem;
        color: #f9ad0c;
    }

    .nowrap {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .emline {
        width: 100%;
        font-size: 1.4rem;
        color: #ccc;
        text-align: center;
    }

</style>