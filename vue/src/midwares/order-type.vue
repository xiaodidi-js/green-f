<template>
    <div class="classif">
        <div class="list licon fixed justify">
            <div class="tap-type" :class="{'active':dtype == 0}" @click="getViewData(0)">
                <div class="icon unpay icon-ui icon-ui-fukuan"></div>
                <div class="title">全部</div>
            </div>
            <div class="tap-type" :class="{'active':dtype == 1}" @click="getViewData(1)">
                <div class="title">待付款</div>
            </div>
            <div class="tap-type" :class="{'active':dtype == 2}" @click="getViewData(2)">
                <div class="title">待发货</div>
            </div>
            <div class="tap-type" :class="{'active':dtype == 3}" @click="getViewData(3)">
                <div class="title">待收货</div>
            </div>
            <div class="tap-type" :class="{'active':dtype == 4}" @click="getViewData(4)">
                <div class="title">评价</div>
            </div>
        </div>
    </div>
    <div class="payment">
        <payment :orders="data"></payment>
    </div>
    <div class="payment" style="width:40%;height:20%;margin:150px auto;" v-if="data == '' ">
        <img src="../images/cart.png" style="width:100%;height: 100%" alt="" />
        <p class="nothing-order">暂时没有商品</p>
    </div>
</template>

<script>

    import payment from 'components/order-payment'
    import Tab from 'vux/src/components/tab/tab.vue'
    import TabItem from 'vux/src/components/tab/tab-item'

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
            TabItem
        },
        data() {
            return {
                dtype: -1,
                data: [],
            }
        },
        ready() {
            this.getViewData(0);
        },
        methods: {
            getViewData: function(type) {
                if(this.dtype == type && this.data){
                    return true;
                }
                this.dtype = type;
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.$getData('/index/user/orderselection/uid/'+ustore.id+'/token/'+ustore.token+'/type/' + type).then((res) => {
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

    .classif .list .active {
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