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

    .search_panel .alladdress .sel-bg .option-list {
        z-index: 999;
        width: 125%;
        height: auto;
        background: #fff;
        position: absolute;
        border: 1px solid #ccc;
        /* border-top: none; */
        left: -1px;
        top: 30px;
    }

    .search_panel .alladdress .sel-bg .option-list .list-li {
        /*height:35px;*/
        line-height: 35px;
        font-size: 14px;
        /*border-bottom:1px solid #f2f2f2;*/
        position: relative;
    }

    .search_panel .alladdress .sel-bg .option-list .list-li .double-list {
        /*position:absolute;*/
        /*left:10rem;*/
        /*top:0rem;*/
        width: 10rem;
    }

    .search_panel .alladdress .sel-bg .option-list .list-li .double-list ul li {
        width: 105%;
        height: 3.5rem;
        display: block;
        margin-left: 2rem;
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

    .search_panel .alladdress .sel-bg .option-list .everaddress {
        clear:both;
        height:3.5rem;
        width:100%;
        font-size:1.4rem;
        line-height:3.5rem;
    }

    /* search_panel end */

    .masker {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 0%;
        z-index: 1000;
        background-color: transparent;
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

<template>
    <div class="masker" :class="{'show':show}" @click="hidePanel" @touchmove.stop.prevent @touchend.stop
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
                    <ul class="option-list" v-show="isChonse">
                        <div class="everaddress" @click="allChonse()">全部</div>
                        <li class="list-li" v-for="item in options">
                            <div style="">{{ item.name }}</div>
                            <i class="list" style="display:block;width:15rem;height:1px;background: #f2f2f2;"></i>
                            <div class="double-list">
                                <ul>
                                    <li class="select-li"
                                        v-for="items in item.sub"
                                        @click="onOnlyAddress(items.id)">
                                        {{ items.name }}
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <!--<select class="sel-bg">-->
                        <!--<option @click="onChonse()">全部</option>-->
                        <!--<optgroup label="{{ item.name }}" v-for="item in options">-->
                            <!--<option v-for="items in item.sub" @click="onOnlyAddress(items.id)">{{ items.name }}</option>-->
                        <!--</optgroup>-->
                    <!--</select>-->
                </div>
            </div>
        </div>
        <div class="con-box" id="content-box" v-on:touchmove="conMove">
            <div class="emline" v-show="showStatus">{{ showTips }}</div>
            <freepop-list :money="money" v-for="item in tmp_address" :obj="item" :chose-id="chosen" :showPop="showGive"></freepop-list>
        </div>
        <div class="btn" v-if="showConfirm" @click="hidePanel">{{ confirmText }}</div>
    </div>

    <!-- toast显示框 -->
    <toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>

    <!-- loading加载框 -->
    <loading :show="loadingShow" :text="loadingMessage"></loading>

</template>

<script>
    import FreepopList from 'components/freepop-list'
    import {clearAll} from 'vxpath/actions'
    import Toast from 'vux/src/components/toast'
    import Loading from 'vux/src/components/loading'

    export default{
        vuex: {
            actions: {
                clearAll
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
                type: String,
                default: ''
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
                showGive: false,
            }
        },
        ready() {
            this.selList();
        },
        methods: {
            fun: function () {
                var self = this;
                var data = self.tmp_address.filter(function (item) {
                    return item.address.indexOf(self.search) !== -1
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
                        _this.tansform('icon-sanjiao', 'rotate(0deg)');
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
                    this.show = false;
                    this.ischonse = false;
                }
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
                        console.log(response.data);
                        if (response.data.status === 1) {
                            this.chosen = obj.id;
                            this.$parent.data.address = obj;
                            this.$parent.data.tmp_address = obj;
//                            this.$parent.data.data = obj;
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
                this.fun()
            },
            show: function (nval, oval) {
                if ((nval === true && this.address.length <= 0) || (nval === true && this.$parent.deliverType != '' && this.$parent.deliverType != this.getType)) {
                    let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                    ustore = JSON.parse(ustore);
                    this.getType = this.$parent.deliverType;
                    this.$http.get(localStorage.apiDomain + 'public/index/user/addresschosen/uid/' + ustore.id + '/token/' + ustore.token + '/type/' + this.getType).then((response) => {
                        console.log(response.data);
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
//                console.log(1);
//                var self = this;
//                if (this.searchKey) {
//                    var arr = []
//                    for (var i in this.address) {
//                        var obj = this.address[i]
//                        if (obj['key'].indexOf(this.searchKey) !== -1) {
//                            arr.push(obj)
//                        }
//                    }
//                    this.tmp_address = this.address;
//                    this.data = arr
//                    console.log(this.address);
//                } else {
//                    this.data = this.address
//                }


            }
        }
    }
</script>