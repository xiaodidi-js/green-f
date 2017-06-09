<!-- 待评价 开始 -->


<template>
    <!-- ification-wrapper start -->
    <div class="ification-wrapper" id="evaluate">
        <div class="orders-box">
            <div class="top-line">
                <div class="order">订单号：170204008002011</div>
                <div class="status">交易完成</div>
            </div>
            <div class="mid-line" v-link="{name:'commentgroup'}">
                <div class="imgs"></div>
                <div class="arrow"></div>
            </div>
            <div class="btm-line">
                <div class="money">
                    总金额：
                    <label>￥999.9</label>
                </div>
                <div class="button">
                    <a href="" class="manage-btn">删除订单</a>
                    <a href="" class="manage-btn">申请售后</a>
                    <a href="" class="manage-btn">客户评价</a>
                </div>
            </div>
        </div>
    </div>
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

            }
        },
        methods: {

        }
    }
</script>

<!-- 待评价 结束 -->