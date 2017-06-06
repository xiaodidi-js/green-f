/**
 * Created by samhong on 16/6/20.
 */
import Vue from 'vue';
// import VueLazy from 'vue-lazyload';
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import App from 'components/app.vue';
import Routers from './router';
import Env from './config/env';
import WxJssdk from 'weixin-js-sdk'
import fetchGet from './libs/util.js'
import fetchPost from './libs/util.js'



// Vue.use(VueLazy,{
// 	preLoad:1.2,
// 	error:'dist/assets/error.png',
// 	loading:'dist/assets/loading.svg',
// 	attempt:3
// });

Vue.use(VueResource);
Vue.use(VueRouter);

// 开启debug模式
Vue.config.debug = true;
//设置请求域名
localStorage.setItem('apiDomain','http://green-f.cn/'); /* http://newshop.com/ */

// 路由配置
let router = new VueRouter({
    // 是否开启History模式的路由,默认开发环境开启,生产环境不开启。如果生产环境的服务端没有进行相关配置,请慎用
    history: Env != 'production',
    scrollBehavior (to, from, savedPosition) {
        if (savedPosition) {
        	console.log(savedPosition);
            return savedPosition
        } else {
            console.log(x + "-" + y);
            return { x: 0, y: 0 }
        }
    }
});

router.map(fetchPost);
router.map(fetchGet);
router.map(Routers);

router.beforeEach((transition) => {

	if(Env == 'production') {
		//微信openid检测
		if(!sessionStorage.getItem('openid')){
			let query = transition.to.query;
			if(typeof query.opid !== 'undefined' && query.opid != '') {
                sessionStorage.setItem('openid',query.opid);
			} else {
				location.href = localStorage.getItem('apiDomain')+'public/index/home/index?back=' + encodeURI(transition.to.path);
				return true;
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
	}else if(['login','register','find'].indexOf(transition.to.name)>=0) {
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
});

router.afterEach((transition) => {
	//获取微信分享配置
	if(transition.to.name!='detail'){
		Vue.http.get(localStorage.apiDomain+'public/index/index/wxshare').then((response)=>{
			let getSession = response.data;
			let shareData = {
					title:getSession.title,
					desc:getSession.desc,
					link:'http://'+window.location.host+'/index_prod.html',
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