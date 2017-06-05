<!-- 全部订单 开始  -->

<style>

</style>


<template>
    <!-- ification-wrapper start -->
    <div class="ification-wrapper" id="orderall">
        <div class="orders-box" v-for="item in allorder">
            <div class="top-line">
                <div class="order">订单号：{{ item.ordernumber }}</div>
                <div class="status">{{ item.state }}</div>
            </div>
            <div class="mid-line">
                <div class="imgs"></div>
                <div class="arrow"></div>
            </div>
            <div class="btm-line">
                <div class="money">
                    总金额：
                    <label>￥{{ item.total }}</label>
                </div>
                <div class="button">
                    <a class="manage-btn">取消订单</a>
                    <a class="manage-btn" v-link="{name:'order-detail',params:{oid:item.id}}" >去付款</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ification-wrapper end -->
</template>

<script>

    export default{
        vuex: {
            actions: {

            }
        },
        props: {

        },
        components: {

        },
        data() {
            return {
                allorder:[
                    {
                        "ordernumber":170204008002011,
                        "state":"待发货",
                        "orderimages":"http://jcx.quguonet.com/upload/2017-04/13/banner3.jpg",
                        "total":"50.0",
                    },
                    {
                        "ordernumber":111212124545121,
                        "state":"待付款",
                        "orderimages":"http://jcx.quguonet.com/upload/2017-04/13/banner3.jpg",
                        "total":"660.0",
                    }
                ]
            }
        },
        ready() {
            this.all();
        },
        methods: {
            all: function () {

            }
        }
    }
</script>

<!-- 全部订单 结束 -->