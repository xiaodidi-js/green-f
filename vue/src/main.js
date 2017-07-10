/**
 * Created by samhong on 16/6/20.
 */
import Vue from 'vue';
import VueLazy from 'vue-lazyload';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import App from 'components/app.vue';
import Routers from './router';
import Env from './config/env';
import WxJssdk from 'weixin-js-sdk'
import { fetchGet, fetchPost, fetchPut, fetchDelete,ustore } from './libs/util.js'

import 'vux/src/styles/close.less';

Vue.use(VueLazy,{
	preLoad:1.2,
	error:'dist/assets/error.png',
	loading:'dist/assets/loading.svg',
	attempt:2
});

Vue.use(VueResource);
Vue.use(VueRouter);

Vue.prototype.$getData = fetchGet;
Vue.prototype.$postData = fetchPost;
Vue.prototype.$putData = fetchPut;
Vue.prototype.$deleteData = fetchDelete;
Vue.prototype.$ustore = ustore;

// 开启debug模式
Vue.config.debug = true;
//设置请求域名

localStorage.setItem('apiDomain', 'http://green-f.cn/');
/* http://newshop.com/ */

// 路由配置
let router = new VueRouter({
    // 是否开启History模式的路由,默认开发环境开启,生产环境不开启。如果生产环境的服务端没有进行相关配置,请慎用
    history: Env != 'production',
    // history: true,
    saveScrollPosition: true,
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition
        } else {
            return { x: 0, y: 0 }
        }
    }
});

router.map(Routers);

router.beforeEach((transition) => {

    //  解决支付路径问题
    // let { href, protocol, host, search, hash } = window.location;
    // const pathname = '/'; // 解决支付路径问题添加的前缀，替换成你的
    // search = search || '?';
    // hash = hash || '#!/';
    // let newHref = `${protocol}//${host}${pathname}${search}${hash}`;
    // if (newHref !== href) {
    //     window.location.replace(newHref);
    // }
    if(Env == 'production') {
        //微信openid检测
        if(!sessionStorage.getItem('openid')) {
            let query = transition.to.query;
            let since = sessionStorage.setItem('since',query.sinceid); //自提点关注检测
            location.reload();
            if(localStorage.getItem('openid')){
                let leopid = localStorage.getItem('openid');
                sessionStorage.setItem('openid',leopid);
                return true;
            }else{
                if(typeof query.opid !== 'undefined' && query.opid != '') {
                    localStorage.setItem('openid',query.opid);
                } else {
                    location.href = localStorage.getItem('apiDomain') + 'public/index/home/index?back=' + encodeURI(transition.to.path);
                    return true;
                }
            }
        }
    }

    //登录检测
    if(typeof(transition.to.login) !== 'undefined' && transition.to.login === true) {
        let ustore = localStorage.getItem('userInfo') || sessionStorage.getItem('userInfo');
        if(ustore===null) {
            transition.redirect({name:'login'});
        } else {
            transition.next();
        }
    }else if(['login','register','find'].indexOf(transition.to.name) >= 0) {
        let ustore = localStorage.getItem('userInfo') || sessionStorage.getItem('userInfo');
        if(ustore !== null) {
            transition.abort();
        }else{
            transition.next();
        }
    }else{
        transition.next();
    }
    window.scrollTo(0, 0);

    //  窗体滚动事件
    $(window).scroll(function() {
        if($(window).scrollTop() >= 350) {
            $(".goto").fadeIn(500);
        } else {
            $(".goto").stop(true,true).fadeOut(500);
        }
    });
});

router.afterEach((transition) => {
    //获取微信分享配置
    if(transition.to.name != 'detail') {
        Vue.http.get(localStorage.apiDomain+'public/index/index/wxshare').then((response)=>{
            let getSession = response.data;
            let shareData = {
                title:getSession.title,
                desc:getSession.desc,
                link:'http://'+window.location.host+'/index.html',
                imgUrl:getSession.imgurl
            };
            WxJssdk.config({
                debug:false,
                appId:getSession.appid,
                timestamp:getSession.timestamp,
                nonceStr:getSession.noncestr,
                signature:getSession.signature,
                jsApiList:[
                    'onMenuShareTimeline',
                    'onMenuShareAppMessage',
                    'onMenuShareWeibo',
                    'onMenuShareQQ',
                    'onMenuShareQZone'
                ]
            });
            WxJssdk.ready(()=>{
                WxJssdk.onMenuShareTimeline(shareData);
                WxJssdk.onMenuShareAppMessage(shareData);
                WxJssdk.onMenuShareWeibo(shareData);
                WxJssdk.onMenuShareQZone(shareData);
                WxJssdk.onMenuShareQQ(shareData);
            });
            WxJssdk.error(function(res){
                console.log(res.errMsg);
            });
        },(response)=>{
            console.log('get wx share failed.');
        });
    }
});

router.redirect({
    '*': '/index'
});

router.start(App, '#app');