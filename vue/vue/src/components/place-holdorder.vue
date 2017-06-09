<template>
    <div class="place-shop" id="host">
        <ul>
            <li>
                <div class="mark">
                    <div>
                        <img src="../images/content_linnan.png" alt="" style="width:100%;height:160px;" />
                    </div>
                    <p class="mark-content-view">车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝</p>
                    <p class="order-p-money">
                        ￥<span>19.00</span>
                    </p>
                    <p class="icon-cart"></p>
                </div>
            </li>
        </ul>
    </div>
</template>

<script type="text/javascript">

    import neworder from 'components/place-neworder'

    export default{
        props: {
            columns: {

            }
        },
        data() {
            return {

            }
        },
        ready() {

        },
        methods: {

        },//模板
        components: {
            neworder,
        },
        computed: {

        },
        watch: {

        }
    }
</script>