<style scoped>
    @import '../styles/common.css';

    .vux-header {
        position: fixed;
        width: 100%;
        top:0px;
        left:0px;
        padding: 3px 0;
        box-sizing: border-box;
        background-color: #35495e;
        z-index: 10;
    }

</style>
<template>
    <div>
        <!-- 头部 -->
        <x-header :fixed="true" color="#343136" :left-options="{showBack:true,backText:''}" v-show="$route.header">{{ $route.title }}</x-header>
        <!-- 顶部间距 -->
        <!--<separator :set-height="46" unit="px" v-show="$route.header"></separator>-->

        <router-view></router-view>

        <!-- 底部间距 -->
        <separator v-show="$route.footer"></separator>
        <!-- 底部选项卡 -->
        <bottom v-show="$route.footer"></bottom>
    </div>
</template>
<script>
    import store from 'vxpath/store'
    import XHeader from 'vux/src/components/x-header'
    import Bottom from './bottom'
    import Separator from './separator'

    export default {
        store,
        components: {
            XHeader,
            Bottom,
            Separator
        },
        vuex: {
           
        },
        data () {
            return {}
        },
        route: {
            
        },
        ready () {
           
        },
        beforeDestroy () {

        },
        methods: {

        }
    }
</script>
