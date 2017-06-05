/**
 * Created by aresn on 16/8/22.
 */
const routers = {
    '/index': {
        name:'index',
    	header:false,
    	footer:true,
    	title:'绿秧田商城',
    	position:1,
        saveScrollPosition: true,
        scrollBehavior (to, from, savedPosition) {
            if (to.hash) {
                return {
                    selector: to.hash
                }
            }
        },
        component (resolve) {
            require(['./views/index.vue'], resolve);
        },
        subRoutes: {
            '/': {
                name:'index-default',
                header:false,
                footer:true,
                title:'',
                position:1,
                saveScrollPosition: true,
                component (resolve) {
                    require(['./midwares/index-main.vue'], resolve);
                }
            },
            '/column/:cid': {
                name:'index-column',
                header:false,
                footer:true,
                title:'',
                position:1,
                saveScrollPosition: true,
                component (resolve) {
                    require(['./midwares/index-column.vue'], resolve);
                }
            }
        }
    },
    '/classify': {
        name:'classify',
        header:false,
        footer:true,
        title:'商品分类',
        position:2,
        saveScrollPosition: true,
        component (resolve) {
            require(['./views/classify.vue'], resolve);
        },
        subRoutes: {
            '/': {
                name:'cla-default',
                header:true,
                footer:true,
                title:'商品分类',
                position:2,
                component (resolve) {
                    require(['./midwares/cla-main.vue'], resolve);
                }
            },
            '/list/:cid': {
                name:'cla-list',
                header:false,
                footer:true,
                title:'',
                position:2,
                component (resolve) {
                    require(['./midwares/cla-list.vue'], resolve);
                }
            }
        }
    },
    '/cart': {
        name:'cart',
        header:true,
        footer:true,
        title:'购物车',
        position:0,
        login:true,
        component (resolve) {
            require(['./views/cart.vue'], resolve);
        }
    },
    '/personal': {
        name:'personal',
        header:false,
        footer:true,
        title:'个人中心',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/personal.vue'], resolve);
        },
        subRoutes: {
            '/': {
                name:'per-default',
                header:false,
                footer:true,
                title:'',
                position:4,
                login:true,
                component (resolve) {
                    require(['./midwares/per-orders.vue'], resolve);
                }
            },
            '/orders': {
                name:'per-orders',
                header:false,
                footer:true,
                title:'',
                position:4,
                login:true,
                component (resolve) {
                    require(['./midwares/per-orders.vue'], resolve);
                }
            },
            '/coupons': {
                name:'per-coupons',
                header:false,
                footer:true,
                title:'',
                position:4,
                login:true,
                component (resolve) {
                    require(['./midwares/per-coupons.vue'], resolve);
                }
            },
            '/collections': {
                name:'per-collections',
                header:false,
                footer:true,
                title:'',
                position:4,
                login:true,
                component (resolve) {
                    require(['./midwares/per-collections.vue'], resolve);
                }
            },
            '/addresses': {
                name:'per-addresses',
                header:false,
                footer:true,
                title:'',
                position:4,
                login:true,
                component (resolve) {
                    require(['./midwares/per-addresses.vue'], resolve);
                }
            },
            '/settings': {
                name:'per-settings',
                header:false,
                footer:true,
                title:'',
                position:4,
                login:true,
                component (resolve) {
                    require(['./midwares/per-settings.vue'], resolve);
                }
            }
        }
    },
    '/article/:cid': {
        name:'article',
        header:true,
        footer:false,
        title:'精选编辑',
        position:1,
        component (resolve) {
            require(['./views/article.vue'], resolve);
        }
    },
    '/rush': {
        name:'rush',
        header:true,
        footer:false,
        title:'限时抢购',
        position:1,
        component (resolve) {
            require(['./views/rush.vue'], resolve);
        }
    },
    '/detail/:pid': {
        name:'detail',
        header:false,
        footer:false,
        title:'订单详情',
        position:1,
        component (resolve) {
            require(['./views/pro-detail.vue'], resolve);
        } 
    },
    '/comment/list/:pid': {
        name:'comment-list',
        header:true,
        footer:false,
        title:'商品评价',
        position:1,
        component (resolve) {
            require(['./views/com-list.vue'], resolve);
        } 
    },
    '/comment_submit/:oid': {
        name:'comment-submit',
        header:false,
        footer:false,
        title:'提交评论',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/com-submit.vue'], resolve);
        } 
    },
    '/comment/detail/:oid': {
        name:'comment-detail',
        header:true,
        footer:false,
        title:'评价详情',
        position:1,
        component (resolve) {
            require(['./views/com-detail.vue'], resolve);
        } 
    },
    '/service/:oid': {
        name:'service',
        header:true,
        footer:false,
        title:'售后服务',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/service.vue'], resolve);
        } 
    },
    '/service_apply/:oid': {
        name:'service-apply',
        header:true,
        footer:false,
        title:'售后申请',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/service-apply.vue'], resolve);
        } 
    },
    '/submit': {
        name:'submit',
        header:true,
        footer:false,
        title:'订单结算',
        position:3,
        login:true,
        component (resolve) {
            require(['./views/submit.vue'], resolve);
        } 
    },
    '/order/detail/:oid': {
        name:'order-detail',
        header:true,
        footer:false,
        title:'订单详情',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/ord-detail.vue'], resolve);
        } 
    },
    '/express': {
        name:'express',
        header:true,
        footer:false,
        title:'物流信息',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/express.vue'], resolve);
        } 
    },
    '/address/add': {
        name:'address-add',
        header:true,
        footer:false,
        title:'添加地址',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/address.vue'], resolve);
        } 
    },
    '/address/edit/:aid': {
        name:'address-edit',
        header:true,
        footer:false,
        title:'编辑地址',
        position:4,
        login:true,
        component (resolve) {
            require(['./views/address.vue'], resolve);
        } 
    },
    '/login': {
        name:'login',
        header:true,
        footer:false,
        title:'账号',
        position:0,
        component (resolve) {
            require(['./views/login.vue'], resolve);
        }
    },
    '/register': {
        name:'register',
        header:true,
        footer:false,
        title:'注册',
        position:0,
        component (resolve) {
            require(['./views/register.vue'], resolve);
        }
    },
    '/find': {
        name:'find',
        header:true,
        footer:false,
        title:'找回密码',
        position:0,
        component (resolve) {
            require(['./views/find.vue'], resolve);
        }
    },
    '/tgallery': {
        component (resolve) {
            require(['./components/testSwiper.vue'], resolve);
        }
    },
    '/activity': {
        name:'activity',
        header:true,
        footer:true,
        title:'活动',
        position:3,
        component (resolve) {
            require(['./components/activity.vue'], resolve);
        }
    },
    '/activity-event': {
        name:'activity-event',
        header:true,
        footer:true,
        title:'活动详情',
        position:0,
        component (resolve) {
            require(['./components/activity-event.vue'], resolve);
        }
    },
    '/integral': {
        name:'integral',
        header:true,
        footer:false,
        title:'我的积分',
        component (resolve) {
            require(['./components/integral.vue'], resolve);
        }
    },//全部订单
    '/order-all': {
        name:'orderAll',
        header:false,
        footer:true,
        title:'全部订单',
        component (resolve) {
            require(['./components/order-all.vue'], resolve);
        }
    },
    '/order-deliver': {
        name:'orderdeliver',
        header:false,
        footer:true,
        title:'待收货',
        component (resolve) {
            require(['./components/order-deliver.vue'], resolve);
        }
    },
    '/order-receipt': {
        name:'orderreceipt',
        header:false,
        footer:true,
        title:'待收货',
        component (resolve) {
            require(['./components/order-receipt.vue'], resolve);
        }
    },
    '/order-evaluate': {
        name:'orderevaluate',
        header:false,
        footer:true,
        title:'待评价',
        component (resolve) {
            require(['./components/order-evaluate.vue'], resolve);
        }
    },
    'coupon-list': {
        name:'couponlist',
        header:false,
        footer:false,
        title:'优惠劵',
        component (resolve) {
            require(['./components/coupon-list.vue'], resolve);
        }
    },
    'comment-group': {
        name:'commentgroup',
        header:false,
        footer:false,
        title:'商品评论',
        component (resolve) {
            require(['./components/comment-group.vue'], resolve);
        }
    },
    'seckill-floor': {
        name:'seckillfloor',
        header:false,
        footer:false,
        title:'活动抢购',
        component (resolve) {
            require(['./components/seckill-floor.vue'], resolve);
        }
    },
    'buying': {
        name:'buying',
        header:false,
        footer:true,
        title:'限时抢购',
        component (resolve) {
            require(['./midwares/buying.vue'], resolve);
        }
    },
    'buying-like': {
        name:'buyinglike',
        header:false,
        footer:false,
        title:'绿秧田',
        component (resolve) {
            require(['./components/buying-like.vue'], resolve);
        }
    },
    'address': {
        name:'address',
        header:false,
        footer:false,
        title:'地址',
        component (resolve) {
            require(['./components/address.vue'], resolve);
        }
    },
    'order-success': {
        name:'ordersuccess',
        header:false,
        footer:false,
        title:'订单支付成功',
        component (resolve) {
            require(['./components/order-success.vue'], resolve);
        }
    },
    'order-fail': {
        name:'orderfail',
        header:false,
        footer:false,
        title:'订单支付失败',
        component (resolve) {
            require(['./components/order-fail.vue'], resolve);
        }
    },
    'my-freepop': {
        name:'myfreepop',
        header:false,
        footer:false,
        title:'自提点',
        component (resolve) {
            require(['./components/my-freepop.vue'], resolve);
        }
    },
    'freepop-list': {
        name:'freepoplist',
        header:false,
        footer:false,
        title:'自提点',
        component (resolve) {
            require(['./components/freepop-list.vue'], resolve);
        }
    },
    'card-types': {
        name:'cardtypes',
        header:true,
        footer:true,
        title:'下单',
        component (resolve) {
            require(['./components/card-types.vue'], resolve);
        }
    },
    'card-square': {
        name:'cardsquare',
        header:false,
        footer:false,
        title:'下单',
        component (resolve) {
            require(['./components/card-square.vue'], resolve);
        }
    },
    'card-list': {
        name:'card-list',
        header:false,
        footer:false,
        title:'下单',
        component (resolve) {
            require(['./components/card-list.vue'], resolve);
        }
    },
    'search': {
        name:'search',
        header:true,
        footer:true,
        title:'搜索',
        component (resolve) {
            require(['./components/search.vue'], resolve);
        }
    },
    'tap-card': {
        name:'tap-card',
        header:false,
        footer:true,
        title:'抢购',
        component (resolve) {
            require(['./components/tap-card.vue'], resolve);
        }
    },
    'banners': {
        name:'banners',
        header:false,
        footer:false,
        title:'banners',
        component (resolve) {
            require(['./components/banners.vue'], resolve);
        }
    },
    'sao': {
        name:'sao',
        header:false,
        footer:true,
        title:'扫一扫关注',
        component (resolve) {
            require(['./components/sao.vue'], resolve);
        }
    },
    'format-pop': {
        name:'formatpop',
        header:false,
        footer:false,
        title:'选择规格',
        component (resolve) {
            require(['./components/format-pop.vue'], resolve);
        }
    },
    'balance-price': {
        name:'balance-price',
        header:false,
        footer:false,
        title:'选择规格',
        component (resolve) {
            require(['./components/balance-price.vue'], resolve);
        }
    },
    '/order-type': {
        name:'order-type',
        header:true,
        footer:true,
        title:'订单分类',
        component (resolve) {
            require(['./midwares/order-type.vue'], resolve);
        }
    },
    '/order-payment': {
        name:'order-payment',
        header:true,
        footer:true,
        title:'订单分类',
        component (resolve) {
            require(['./components/order-payment.vue'], resolve);
        }
    }
};
export default routers;