<style>
    .shopcar_youlike{
        width: 100%;
        height: auto;
        box-sizing:border-box;
        padding:0px 1%;
        padding-bottom: 65px;
    }
    .youlike_title{
        width: 100%;
        height: 4rem;
        line-height: 4rem;
        font-size: 1.6rem;
        color: #4D4D4D;
        margin-bottom: 0.9rem;
    }

    .youlike_title .list-icon {
        display:block;
        width: 0.5rem;
        height:2.3rem;
        margin-top:8px;
        float:left;
        margin-right:10px;
        background: #81c429;
    }

    .youlike_list {
        width: 100%;
    }

    .youlike_list ul li{
        display: block;
        width: 32.5%;
        float: left;
        height: 100%;
        background-color: #fff;
        margin-bottom: 0.7rem;
    }
    .youlike_list ul li:nth-of-type(1),
    .youlike_list ul li:nth-of-type(2){
        margin-right:0.39rem;
    }
    .list_pirture {
        position:relative;
    }
    .list_pirture img{
        width: 100%;
        height: 10.556rem;
    }

    .list_pirture .qing {
        position:absolute;
        top:0px;
        left:0px;
        width:100%;
        height:100%;
        background: rgba(0,0,0,0.5);
        text-align:center;
        font-size:24px;
        line-height: 110px;
        color:#fff;
    }

    .list_value{
        width: 100%;
        height: 30px;
        line-height: 14px;
        margin-top: 0.2rem;
        box-sizing: border-box;
        padding: 0px 5px;
        font-size: 12px;
        color: #333;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        text-align:left;
    }
    .list_footer {
        width: 65%;
        height:2.806rem;
        box-sizing:border-box;
        padding:0px 5px;
        float:left;
    }
    .footer_money {
        width: 50%;
        height: 2.806rem;
        font-size: 16px;
        color: #F9B21C;
        line-height: 3.22rem;
        float: left;
    }
    .footer_shopcar{
        width: 25%;
        height: 1.806rem;
        float: right;
        text-align:right;
    }
    .footer_shopcar{
        margin-top: 5px;
    }
    .footer_shopcar img{
        width: 2.3rem;
        height: 1.7rem;
    }
    @media screen and (max-width: 320px){
        .list_value{margin-top:0.1rem;}
    }
</style>


<template>
    <!-- <猜你喜欢> -->
    <div class="shopcar_youlike">
        <div class="youlike_title">
            <i class="list-icon"></i>
            <span>猜你喜欢</span>
        </div>
        <div class="youlike_list">
            <ul>
                <li v-for="item in likedata">
                    <div v-link="{name:'detail',params:{pid:item.id}}">
                        <div class="list_pirture" v-if="item.store == 0">
                            <div class="qing">已售罄</div>
                            <img :src="item.shotcut" />
                        </div>
                        <div class="list_pirture" v-else>
                            <img :src="item.shotcut"/>
                        </div>
                        <div class="list_value">{{ item.name }}</div>
                        <div class="list_footer">
                            <div class="footer_money">￥{{ item.price }}</div>
                        </div>
                    </div>
                    <div class="footer_shopcar" @click="addCarts(item)">
                        <img src="../images/shopcar_youlike.png"/>
                    </div>
                </li>
                <div style="clear:both;"></div>
            </ul>
        </div>
    </div>
    <!-- <猜你喜欢> -->

    <!-- toast显示框 -->
    <toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>

</template>

<script>

    import Scroller from 'vux/src/components/scroller'
    import { setCartStorage } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'
    import Toast from 'vux/src/components/toast'
    import axios from 'axios'
    import qs from 'qs'

    export default{
        vuex: {
            getters: {
                cartNums
            },
            actions: {
                setCart: setCartStorage
            }
        },
        props: {
            info: {
                type: Array,
                default() {
                    return []
                }
            },
            cardWidth: {
                type: Number,
                default: 0
            },
            likedata: [],
        },
        components: {
            Scroller,
            Toast,
        },
        data() {
            return {
                toastMessage: '',
                toastShow: false,
                showQiag: false,
                proNums:1,
                buyNums:1,
                activestu:0,
                ids: 0,
            }
        },
        ready() {
            this.listShop();
        },
        methods: {
            listShop: function () {
                var _this = this;
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.$http.get(localStorage.apiDomain + 'public/index/user/cainixihuan/uid/' + ustore.id + '/token/' + ustore.token).then((response)=>{
                    this.likedata = response.data.tuijian_shop;
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            addCarts: function (data) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                var obj = {} , cart = JSON.parse(sessionStorage.getItem("myCart")) , self = this;
                if(ustore == null) {
                    alert("没有登录，请先登录！");
                    setTimeout(function () {
                        self.$router.go({name: 'login'});
                    }, 800);
                    return false;
                } else if(ustore != null) {
                    axios({
                        method: 'get',
                        url: localStorage.apiDomain + 'public/index/index/productdetail/uid/' + ustore.id + '/pid/' + data.id,
                    }).then((response) => {
                        obj = {
                            id:data.id,
                            name:data.name,
                            price:data.price,
                            shotcut:data.shotcut,
                            deliverytime:data.deliverytime,
                            peisongok:data.peisongok,
                            activestu:data.activestu,
                            nums:this.buyNums,
                            store:this.proNums = response.data.store,
                            format:'',
                            formatName:'',
                        };
                        if(data.peisongok == 0 && data.deliverytime == 1) {
                            alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                            return false;
                        } else if(data.store == 0) {
                            alert("已售罄");
                            return false;
                        } else if (data.activeid > 0) {
                            alert("这是限时抢购商品！");
                            return false;
                        }
                        if(cart != '') {
                            for(var y in cart) {
                                if (cart[y]["deliverytime"] != data.deliverytime) {
                                    if (data.deliverytime == 0) {
                                        alert("亲！您选购的商品为次日配送商品，购物车里存在当日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！");
                                        return false;
                                    } else if (data.deliverytime == 1) {
                                        alert("亲！您选购的商品为当日配送商品，购物车里存在次日配送商品！所以在配送时间上不一致，请先结付或者删除购物车的菜品，再进行选购结付既可；谢谢您的配合！！");
                                        return false;
                                    }
                                }
                            }
                        }
                        self.setCart(obj);
                        obj = {};
                        alert("成功加入购物车!");
                        this.$router.go({name : "cart"});
                    });
                }
            }
        }
    }
</script>