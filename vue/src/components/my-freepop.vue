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
            <div class="alladdress" v-show="chonse">
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
        <!-- 底部按钮 -->
        <div class="addButton commentButton" v-link="{name:'address-add'}">新增地址</div>
        <div class="commentButton" style="float:right;" v-if="showConfirm" @click="hidePanel">{{ confirmText }}</div>
    </div>

    <!-- 弹出选择层 -->
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
    import XButton from 'vux/src/components/x-button'

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
            Loading,
            XButton
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
            },
            chonse: {
                type: Boolean,
                default: true,
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
                    "bottom":"-253px"
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
                this.$getData('/index/Usercenter/myaddress/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/state/0/sinceid/' + id).then((res)  => {
                    if (res.status === 1) {
                        var tmp = this.address.filter(function (item) {
                            return item.pid == id;
                        });
                        content.tmp_address = tmp;
                        content.data = tmp;
                        $(".double-list ul li").click(function() {
                            var values = $(this).text();
                            $(".select-add").text(values);
                        });
                        content.isChonse = false;
                        content.tansform('icon-sanjiao','rotate(0deg)');
                    } else if (res.status === -1) {
                        content.toastMessage = response.data.info;
                        content.toastShow = true;
                        setTimeout(function () {
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name: 'login'});
                        }, 800);
                    } else {
                        this.toastMessage = res.info;
                        this.toastShow = true;
                    }
                },(res) => {
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
                var options = {
                    uid: this.$ustore.id,
                    token: this.$ustore.token,
                    sinceid:id,
                    money:money
                };
                this.$postData('/index/user/manjiusong',options).then((res) => {
                    if(res.status == 1) {
                        this.openpop = true;
                        this.showGive = true;
                        this.lists = res.maxmoney;
                        for(var i in this.lists) {
                            this.mySong('请选择满'+ this.lists[i].maxmoney +'元赠品');
                        }
                        this.commitData({target: 'giftList', data: res.maxmoney});
                        this.commitData({target: 'giftstu', data: 1});
                        this.commitData({target: 'visibleEle', data: true});
                    } else if(res.status == 0) {
                        this.commitData({target: 'visibleEle', data: false});
                        var jsons = {
                            uid: this.$ustore.id,
                            token: this.$ustore.token,
                            sinceid:this.chosen,
                            money:this.money
                        };
                        this.$postData('/index/user/shoudan',jsons).then((res) => {
                            if(res.status == 1) {
                                this.commitData({target: 'visibleEle', data: true});
                                this.mySong('请选择首单用户赠品');
                                this.showGive = true;
                                this.myGift(this.lists);
                                this.lists = res.shoduan_data;
                                this.commitData({target: 'giftList', data: res.shoudan_data});
                                this.commitData({target: 'giftstu', data: 2});
                            } else if(res.status === 0) {
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
                let pdata = {uid: this.$ustore.id, token: this.$ustore.token, addressid: id};
                this.$putData('/index/Usercenter/since', pdata).then((res) => {
                    if (res.status === 1) {
                        this.showStatus = false;
                        this.showTips = '加载中...';
                        this.options = res.list;
                    } else if (res.status === -1) {
                        this.$dispatch('showMes', res.info);
                        let context = this;
                        setTimeout(function () {
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name: 'login'});
                        }, 800);
                    } else {
                        this.$dispatch('showMes', res.info);
                    }
                }, (res) => {
                    this.$dispatch('showMes', '网络开小差了~');
                });
            }
        },
        events: {
            setChosen: function (obj) {
                let pids = '', pdata = {};
                if (typeof obj === 'object') {
                    if (this.$parent.cartIds.length > 0) {
                        pids = this.$parent.cartIds.join(',');
                    }
                    pdata = {
                        uid: this.$ustore.id,
                        token: this.$ustore.token,
                        type: this.$parent.deliverType,
                        ids: pids,
                        area: obj.area,
                        is_default: obj.is_default
                    };
                    this.$postData('/index/user/addresschosen', pdata).then((res) => {
                        if (res.status === 1) {
                            if(obj.is_default != 0) {
                                obj.is_default = 0;
                            }
                            obj.is_default = 1;
                            this.chosen = obj.id;
                            this.$parent.data.address = obj;
                            this.$parent.data.tmp_address = obj;
                            this.$parent.freight = response.data.freight;
                            /* 设置默认 */
                            let odata = {uid: this.$ustore.id,token: this.$ustore.token,state:0,addressid:obj.id};
                            this.$putData('/index/Usercenter/addressmoren',odata).then((res) => {
                                if(res.status === 1) {
                                    if(obj.is_default != 0) {
                                        obj.is_default = 0;
                                    }
                                    obj.is_default = 1;
                                }
                            },(res)=>{
                                this.$dispatch('showMes','网络开小差了~');
                            });
                        } else if (res.status === -1) {
                            this.$parent.toastMessage = res.info;
                            this.$parent.toastShow = true;
                            let context = this;
                            setTimeout(function () {
                                context.clearAll();
                                sessionStorage.removeItem('userInfo');
                                localStorage.removeItem('userInfo');
                                context.$router.go({name: 'login'});
                            }, 800);
                        } else {
                            this.$parent.toastMessage = res.info;
                            this.$parent.toastShow = true;
                        }
                    }, (res) => {
                        this.$parent.toastMessage = '网络开小差了~';
                        this.$parent.toastShow = true;
                    });
                }
            }
        },
        watch: {
            '$route'(to) {
                location.reload();
            },
            search () {
                if(this.search == '') {
                    this.tmp_address = this.address;
                } else {
                    this.fun()
                }
            },
            show: function (nval, oval) {
                if ((nval === true && this.address.length <= 0) || (nval === true && this.$parent.deliverType != '' && this.$parent.deliverType != this.getType)) {
                    this.getType = this.$parent.deliverType;
                    this.$getData('/index/user/addresschosen/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/type/' + this.getType).then((res) => {
                        if (res.status === 1) {
                            this.showStatus = false;
                            this.showTips = '加载中...';
                            this.address = res.list;
                            this.tmp_address = res.list;
//                            this.data = response.data.list;
                        } else if (res.status === -1) {
                            this.$parent.toastMessage = res.info;
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
                    }, (res) => {
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
        margin: 24px auto 0px;
        padding-bottom: 35px;
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
        bottom: -253px;
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
        height: 70%;
        overflow-scrolling: touch;
        -webkit-overflow-scrolling: touch;
        -o-overflow-scrolling: touch;
        -ms-overflow-scrolling: touch;
        margin-top: 53px;
        overflow-y: auto;
        margin-bottom: 52px;
    }

    .add-address {
        margin-top:100px;
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
        width: 45%;
        padding: 0%;
        background-color: #81c429;
        text-align: center;
        font-size: 1.6rem;
        color: #fff;
        letter-spacing: 0.2rem;
        position: absolute;
        bottom: 0px;
        margin: 10px;
    }

    .panel .commentButton {
        width: 45%;
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

    .panel .addButton {
        width: 45%;
        right: 0px;
        padding: 3% 0px;
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