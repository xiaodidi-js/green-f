<template>
    <!-- 轮播图 -->
    <!--<template v-for="item in testarr">-->
        <!--<template v-if="item.type == 4">-->
            <!--<swiper :list="item.arr" url="item.url" loop dots-position="center" :show-desc-mask="false"-->
                    <!--:aspect-ratio="650/1242" auto dots-class="dots-my" style="width: 100%;margin-top:50px;">-->
            <!--</swiper>-->
        <!--</template>-->
    <!--</template>-->
    <swiper :list="banners"
            :show-desc-mask="false"
            :aspect-ratio="650/1242"
            loop dots-position="center"
            auto dots-class="dots-my"
            style="width: 100%;margin-top:50px;">
    </swiper>
</template>

<script>

        import Swiper from 'vux/src/components/swiper'
    import Scroller from 'vux/src/components/scroller'
    import Toast from 'vux/src/components/toast'

    export default{
        props: {
            testarr:[]
        },
        data() {
            return {
                banners: [],
            }
        },
        components: {
            Swiper,
            Scroller,
        },
        route: {

        },
        ready() {
            this.ban();
        },
        methods: {
            ban: function () {
                this.$http.get(localStorage.apiDomain + 'public/index/index/mainInfo').then((response)=>{
                    this.banners = response.data.banners;
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            }
        },
        events: {

        }
    }

</script>