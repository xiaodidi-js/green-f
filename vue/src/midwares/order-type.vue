<template>
    <div class="classif">
        <tab default-color="#333" active-color="#81c429">

            <tab-item :class="{'actives':dtype === 0}" :selected="dtype === 0" @click="getViewData(0)">
                <div class="icon unpay icon-ui icon-ui-fukuan"></div>
                <div class="title">全部</div>
            </tab-item>

            <tab-item :class="{'actives':dtype === 1}" :selected="dtype === 1" @click="getViewData(1)">
                <div class="icon unpay icon-ui icon-ui-fukuan"></div>
                <div class="title">待付款</div>
            </tab-item>

            <tab-item :class="{'actives':dtype === 2}" :selected="dtype === 2" @click="getViewData(2)">
                <div class="icon unpay icon-ui icon-ui-fukuan"></div>
                <div class="title">待发货</div>
            </tab-item>

            <tab-item :class="{'actives':dtype === 3}" :selected="dtype === 3" @click="getViewData(3)">
                <div class="icon unpay icon-ui icon-ui-fukuan"></div>
                <div class="title">待收货</div>
            </tab-item>

            <tab-item :class="{'actives':dtype === 4}" :selected="dtype === 4" @click="getViewData(4)">
                <div class="icon unpay icon-ui icon-ui-fukuan"></div>
                <div class="title">评价</div>
            </tab-item>

            <!--<div class="list licon fixed justify" style="width:100%;">-->
                <!--<div class="tap-type" :class="{'actives':dtype == 0}" @click="getViewData(0)">-->
                    <!--<div class="icon unpay icon-ui icon-ui-fukuan"></div>-->
                    <!--<div class="title">全部</div>-->
                <!--</div>-->
                <!--<div class="tap-type" :class="{'actives':dtype == 1}" @click="getViewData(1)">-->
                    <!--<div class="title">待付款</div>-->
                <!--</div>-->
                <!--<div class="tap-type" :class="{'actives':dtype == 2}" @click="getViewData(2)">-->
                    <!--<div class="title">待发货</div>-->
                <!--</div>-->
                <!--<div class="tap-type" :class="{'actives':dtype == 3}" @click="getViewData(3)">-->
                    <!--<div class="title">待收货</div>-->
                <!--</div>-->
                <!--<div class="tap-type" :class="{'actives':dtype == 4}" @click="getViewData(4)">-->
                    <!--<div class="title">评价</div>-->
                <!--</div>-->
            <!--</div>-->

        </tab>

    </div>
    <div class="payment">
        <payment :orders="data"></payment>
    </div>
    <div class="payment" style="width:40%;height:20%;margin:150px auto;" v-if="data == '' ">
        <img src="../images/cart.png" style="width:100%;height: 100%" alt="" />
        <p class="nothing-order">暂时没有商品</p>
    </div>
    <!-- 回到顶部 -->
    <div class="goto"></div>

    <!-- loading加载框 -->
    <loading :show="loadingShow" :text="loadingMessage"></loading>

</template>

<script>

    import payment from 'components/order-payment'
    import Tab from 'vux/src/components/tab/tab.vue'
    import TabItem from 'vux/src/components/tab/tab-item'
    import Loading from 'vux/src/components/loading'

    export default{
        vuex: {
            actions: {

            }
        },
        props: {

        },
        components: {
            payment,
            Tab,
            TabItem,
            Loading,
        },
        data() {
            return {
                dtype: -1,
                data: [],
                loadingShow: false,
                loadingMessage: '',
            }
        },
        ready() {
            this.getViewData(0);
            $(".goto").click(function(){
                $("html,body").animate({
                    scrollTop:0
                },200);
            });
            $(".group ,.actives").css({"color":"#81c429"});
        },
        watch: {
            $route(to) {
                if (to.name === 'order-type') {
                    this.getViewData(0);
                    $(".group ,.actives").css({"color": "#81c429"});
                }
            }
        },
        methods: {
            getViewData: function(type) {
                if(this.dtype == type && this.data){
                    return true;
                }
                if(this.$ustore.id == null) {
                    alert("没有登录，请先登录！");
                    setInterval(function() {
                        this.$router.go({ name : 'login'});
                    },500);
                } else {
                    this.dtype = type;
                    sessionStorage.setItem('mydtype',this.dtype);
                    this.loadingMessage = '请稍候...';
                    this.loadingShow = true;
                    this.$getData('/index/user/orderselection/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/type/' + type).then((res) => {
                        this.loadingShow = false;
                        if(res.status === 1) {
                            this.data = res.list;
                        }else if(res.status.status === -1){
                            this.toastMessage = res.info;
                            this.toastShow = true;
                            let context = this;
                            setTimeout(function(){
                                context.clearAll();
                                sessionStorage.removeItem('userInfo');
                                localStorage.removeItem('userInfo');
                                context.$router.go({name:'login'});
                            },800);
                        }else{
                            this.toastMessage = res.info;
                            this.toastShow = true;
                        }
                    },(res)=>{
                        this.toastMessage = "网络开小差啦~";
                        this.toastShow = true;
                    });
                }
            }
        }
    }
</script>

<style type="text/css">
    .classif {
        width: 100%;
        height: 4.5rem;
        background: #fff;
        font-size: 14px;
        margin-top: 46px;
        z-index: 99;
    }

    .classif .list .tap-type {
        float: left;
        width: 20%;
        height: 100%;
        line-height: 4.2rem;
        text-align: center;
    }

    .classif .list .actives {
        color: #333;
        border-bottom:3px solid #81c429;
    }

    .nothing-order {
        font-size: 16px;
        color: rgb(204,204,204);
        text-align: center;
        line-height: 3.5rem;
        font-weight: bold;
    }

</style>