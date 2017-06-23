<template>
    <!-- 轮播图 -->
    <!--<template v-for="item in testarr">-->
        <!--<template v-if="item.type == 4">-->
            <!--<swiper :list="item.arr" url="item.url" loop dots-position="center" :show-desc-mask="false"-->
                    <!--:aspect-ratio="650/1242" auto dots-class="dots-my" style="width: 100%;margin-top:50px;">-->
            <!--</swiper>-->
        <!--</template>-->
    <!--</template>-->
    <div class="order-search"  style="background: #81c429;">
        <div class="logo" style="background: none;width:50px;float:left;">
            <img src="../images/logo_lv.png" alt="" style="width:40px;height:40px;margin: 5px 15px;" />
        </div>
        <div class="search" style="width:65%;position:relative;left:12px;">
            <input type="text" placeholder="请输入您要搜索的商品" v-model="searchKey" @keydown="breakSearch()" />
            <input type="button" class="order-search-btn" @click="goSearch()" value="搜索" />
        </div>
        <div class="customer">
            <a href="javascript:void(0)" class="txt-service" @click="goPage"></a>
        </div>
    </div>
    <swiper :list="banners" :show-desc-mask="false" :aspect-ratio="650/1242" dots-position="center"
            auto dots-class="dots-my" style="width: 100%;clear:both;top:50px;"></swiper>
</template>

<script>

    import Swiper from 'vux/src/components/swiper'
    import Scroller from 'vux/src/components/scroller'
    import Toast from 'vux/src/components/toast'
    import { myActive,mySearch,commitData } from 'vxpath/actions'

    export default{
        props: {
            testarr:[]
        },
        vuex: {
            actions: {
                myActive,
                mySearch,
                commitData,
            }
        },
        data() {
            return {
                banners: [],
                searchKey: '',
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
            this.breakSearch();
        },
        methods: {
            ban: function () {
                this.$http.get(localStorage.apiDomain + 'public/index/index/mainInfo').then((response)=>{
                    this.banners = response.data.banners;
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            //按钮回车事件
            breakSearch (event) {
                var e = window.event || event;
                if(e && e.keyCode == 13) {
                    this.goSearch();
                }
            },
            goSearch () {
                var _self = this;
                this.$http.get(localStorage.apiDomain + 'public/index/index/searchshop?shopname=' + this.searchKey).then((response)=>{
                    if(response.data.status == 1) {
                        this.$router.go({
                            name:'search',
                            params:{
                                arr:this.mySearch(response.data.info.data)
                            }
                        });
                    } else if(response.data.status == 0) {
                        alert(response.data.info);
                        this.searchKey = '';
                    }

                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            goPage () {
                this.myActive(5);
                this.$router.go({name: 'per-orders'})
            },
        },
        events: {

        }
    }

</script>

<style>
    .order-search{
        width:100%;
        height:50px;
        background: #343136;
        position: fixed;
        top:0px;
        left:0px;
        z-index: 99;
    }

    .order-search .search{
        font-size: 14px;width: 70%;
        height: 35px;margin: 0px auto;
        position: relative;top: 8px;
        background: url("../images/search-1.png") no-repeat #fff left;
        background-size: 20px 20px;
        background-position-x: 6px;
    }

    .order-search .search input[type='text']{
        margin: 5px 0px 0px 29px;
        height: 25px;
        border: none;
        width: 67%;
    }

    .order-search .customer {
        float:right;
        position: absolute;
        top:5px;
        text-align:center;
        width:14%;
        right:0px;
        color:#fff;
    }


    .order-search .customer .icon-kefu {
        font-size: 21px;
    }

    .order-search .customer .txt-service {
        display:block;
        width: 2.8rem;
        height: 3.7rem;
        background: url('../images/logo_kefu.png') no-repeat;
        background-size:100%;
        position: absolute;
        top: 0px;
        left: 10px;
    }

    .order-search-btn{
        position: absolute;
        right: 0px;
        top: 0px;
        line-height: 35px;
        width: 18%;
        height: 35px;
        color: #81c429;
        background: #f7f7f7;
        font-size: 14px;
        -webkit-appearance: none;
        -moz-appearance: none;
        -ms-appearance: none;
        -o-appearance: none;
        appearance: none;
    }

    .order-search-btn:active {
        background: #3cc51f;
        color:#fff;
    }

    /* search start */
    .search{
        background: #81c429;
        width:100%;
        height:66px;
    }
    .search .logo{
        width:56px;
        height:54px;
        float:left;
        padding: 5px 5px 5px 10px;
    }
    /* search end */
</style>