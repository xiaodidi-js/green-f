<template>
    <div class="order-search">
        <div class="logo" style="background: none;width:50px;float:left;">
            <img src="../images/logo_lv.png" alt="" style="width:40px;height:40px;margin: 5px 15px;" />
        </div>
        <div class="search" style="width:66%;position:relative;left:12px;">
            <input type="text" placeholder="请输入您要搜索的商品" v-model="searchKey" @keydown="breakSearch()" />
            <a href="javascript:void(0)" class="order-search-btn" style="display:block;" @click="goSearch()">搜索</a>
            <!--<x-button text="搜索" class="order-search-btn" style="display:block;" @click="goSearch()"></x-button>-->
            <!--<input type="button" class="order-search-btn" @click="goSearch()" value="搜索" />-->
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
    import axios from 'axios'
    import qs from 'qs'
    import XButton from 'vux/src/components/x-button'

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
            XButton
        },
        route: {

        },
        ready() {
            this.ban();
            this.breakSearch();
        },
        methods: {
            ban() {
                this.$getData('/index/index/mainInfo').then((res) => {
                    this.banners = res.banners;
                });
            },
            //按钮回车事件
            breakSearch (event) {
                var e = window.event || event;
                if(e && e.keyCode == 13) {
                    this.goSearch();
                }
            },
            goSearch() {
                this.$getData('/index/index/searchshop?shopname=' + this.searchKey).then((res) => {
                    if(res.status == 1) {
                        this.$router.go({
                            name:'search',
                            params:{
                                arr:this.mySearch(res.info.data)
                            }
                        });
                    } else if (res.status == 0) {
                        alert(res.info);
                        this.searchKey = '';
                    }
                });
            },
            goPage() {
                this.myActive(5);
                this.$router.go({name: 'per-orders'})
            },
        },
        events: {

        }
    }
</script>

<style lang="less">

    @import '../styles/theme.less';

    .order-search{
        width:100%;
        height:50px;
        background-color: @header-default-bg-color;
        position: fixed;
        top:0px;
        left:0px;
        z-index: 99;
    }

    .order-search .search{
        font-size: 14px;
        width: 70%;
        height: 40px;
        margin: 0px auto;
        position: relative;
        top: 5px;
        background: url("../images/search-1.png") no-repeat #fff left;
        background-size: 20px 20px;
        background-position-x: 6px;
    }

    .order-search .search input[type='text']{
        margin: 5px 0px 0px 29px;
        height: 30px;
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
        line-height: 40px;
        width: 18%;
        height: 40px;
        color: #81c429;
        background: #f7f7f7;
        font-size: 14px;
        text-align: center;
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
