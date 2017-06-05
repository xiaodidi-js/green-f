<style type="text/css">
    .classif {
        width:100%;
        height:4rem;
        background: #fff;
        font-size:14px;
        margin-top:46px;
        z-index: 99;
    }

    .classif .list .tap-type {
        float: left;
        width: 20%;
        height: 100%;
        line-height: 3.7rem;
        text-align: center;
    }

    .classif .list .active {
        border-bottom:3px solid #81c429;
    }

</style>

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

    <!--<tab default-color="#333" active-color="#81c429" :line-width="5" class="fixed-tab" style="top:46px;position:fixed;left:0px;width:100%;">-->
        <!--<tab-item :selected="{'active':dtype == 0}" @click="getViewData(0)">全部</tab-item>-->
        <!--<tab-item :selected="{'active':dtype == 1}" @click="getViewData(1)">待付款</tab-item>-->
        <!--<tab-item :selected="{'active':dtype == 2}" @click="getViewData(2)">待发货</tab-item>-->
        <!--<tab-item :selected="{'active':dtype == 3}" @click="getViewData(3)">待收货</tab-item>-->
        <!--<tab-item :selected="{'active':dtype == 4}" @click="getViewData(4)">评价</tab-item>-->
    <!--</tab>-->

    <payment :orders="data"></payment>

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
                this.$http.get(localStorage.apiDomain + 'public/index/user/orderselection/uid/'+ustore.id+'/token/'+ustore.token+'/type/'+type).then((response)=>{
                    if(response.data.status===1){
                        this.data = response.data.list;
                        console.log(this.data);
                    }else if(response.data.status === -1){
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    }else{
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            }
        }
    }
</script>