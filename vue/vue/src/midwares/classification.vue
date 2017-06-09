<style>

    .vux-header {
        position: fixed;
        top:0px;
        left:0px;
        width:100%;
        z-index:99;
    }

    /* ification-nav start */
    #wrapper{
        width: 100%;
        height: 4.1rem;
        background-color: #fff;
        position: fixed;
        top: 46px;
        left: 0px;
        z-index: 99;
        overflow:hidden;
        box-shadow: 0 5px 15px #ccc;

        -webkit-overflow-scrolling: touch;
        -moz-overflow-scrolling: touch;
        -ms-overflow-scrolling: touch;
        -o-overflow-scrolling: touch;
        overflow-scrolling: touch;
    }

    #wrapper #scroller {
        position: absolute;
        z-index: 1;
        -webkit-tap-highlight-color: rgba(0,0,0,0);
        width: 100%;
        -webkit-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-text-size-adjust: none;
        -ms-text-size-adjust: none;
        -o-text-size-adjust: none;
        text-size-adjust: none;
    }

    .ification-nav ul li{
        float:left;
        line-height:3.8rem;
        margin:0rem 0rem;
        width:20%;
        text-align:center;
        font-size:14px;
    }
    .ification-nav ul li .nav-list{
        width:100%;
        height:0.3rem;
        background: #81c429;
        position:relative;
        top:-1px;
        display:none;
    }

    .ification-nav ul .active{
        display:block;
        border-bottom:3px solid #81c429;
    }
    /* ification-nav end */


    /* ification-wrapper start */
    .ification-wrapper{
        width:100%;
        padding:0;
        margin-top:10px;
        font-size:0;
    }

    #content {
        width:100%;
        height:100%;
    }

    .orders-box{
        width: 90%;
        height: auto;
        margin: 0% 2% 2% 3%;
        background-color: #fff;
        display: block;
        font-size: 0;
        color: #333;
        box-shadow: 1px 1px 2px #e2e2e2;
        padding: 2%;
        border-radius: 0.6rem;
    }

    .orders-box .top-line,.orders-box .mid-line{
        border-bottom:#F2F2F2 solid 1px;
    }

    .orders-box .top-line,.orders-box .btm-line{
        height:auto;
        line-height:2.5rem;
    }

    .orders-box .top-line,.orders-box .mid-line,.orders-box .btm-line{
        width:100%;
        max-width:100%;
        font-size:0;
        overflow:hidden;
    }

    .orders-box .top-line div,.orders-box .btm-line div{
        display:inline-block;
        font-size:1.4rem;
        color:#4D4D4D;
        width:75%;
    }

    .orders-box .top-line div.date,.orders-box .btm-line div.money{
        white-space:nowrap;
        text-overflow:ellipsis;
        overflow:hidden;
        text-align:left;
    }

    .orders-box .btm-line div.money{
        width:100%;
        vertical-align:middle;
        padding-top:0.6rem;
    }

    .orders-box .btm-line div.button{
        width:100%;
        vertical-align:middle;
        padding-top:0.6rem;
    }

    .orders-box .manage-btn{
        display:inline-block;
        vertical-align:middle;
        font-size:1.4rem;
        color:#81c429;
        line-height:1.6rem;
        padding:0.5rem 0.6rem;
        border:#81c429 solid 1px;
        border-radius:0.3rem;
        margin-right:0.5rem;
        float:left;
    }

    .orders-box .btm-line div.money label{
        color:#F9AD0C;
    }

    .orders-box .top-line div.status,.orders-box .btm-line div.button{
        color:#81c429;
        white-space:nowrap;
        text-overflow:ellipsis;
        overflow:hidden;
        text-align:right;
    }

    .orders-box .top-line div.status{
        float:right;
        width:25%;
    }

    .orders-box .btm-line div.button{
        font-size:0;
    }

    .orders-box .mid-line .imgs{
        display:inline-block;
        vertical-align:middle;
        width:20%;
        padding-top:20%;
        margin:2% 1% 2% 0%;
        background-color:#eee;
        background-repeat:no-repeat;
        background-position:center;
        background-size:cover;
    }

    .orders-box .mid-line .imgs:last-child{
        margin-right:0%;
    }

    .orders-box .mid-line{
        position:relative;
    }

    .orders-box .mid-line .arrow{
        width:3.5%;
        height:100%;
        background-repeat:no-repeat;
        background-position:center;
        background-size:contain;
        background-image:url('../images/arrow.png');
        position:absolute;
        top:0rem;
        right:0.5rem;
    }
    /* ification-wrapper end */

</style>


<template>
    <!-- ification-nav start -->
    <div class="ification-nav" id="wrapper">
        <scroller v-ref:scroller lock-y :scrollbar-x="false" style="height: 100%;overflow:visible;">
            <div id="scroller">
                <ul id="card">
                    <li class="activeification-show" :class="{'active':dtype == 0}" @click="getData(0)">全部</li>
                    <li class="ification-show" :class="{'active':dtype == 1}" @click="getData(1)">待付款</li>
                    <li class="ification-show" :class="{'active':dtype == 2}" @click="getData(2)">待发货</li>
                    <li class="ification-show" :class="{'active':dtype == 3}" @click="getData(3)">待收货</li>
                    <li class="ification-show" :class="{'active':dtype == 4}" @click="getData(4)">评价</li>
                </ul>
            </div>
        </scroller>
    </div>

    <!-- ification-nav end -->
    <div class="content" id="content">
        <payment :orders="data"></payment>
    </div>

</template>

<script>
    import CardOrders from 'components/card-orders'
    import Separator from 'components/separator'
    import Toast from 'vux/src/components/toast'
    import Badge from 'vux/src/components/badge'
    import { clearAll } from 'vxpath/actions'
    import Swiper from 'vux/src/components/swiper'
    import SwiperItem from 'vux/src/components/swiper-item'
    import payment from 'components/order-payment'
    import Scroller from 'vux/src/components/scroller'

    export default{
        vuex: {
            actions: {
                clearAll
            }
        },
        components: {
            CardOrders,
            Separator,
            Toast,
            Badge,
            payment,
            Swiper,
            SwiperItem,
            Scroller
        },
        data() {
            return {
                toastShow: false,
                toastMessage: '',
                dtype:-1,
                count:{
                    unpay: 0,
                    unsend: 0,
                    unreceive: 0,
                    uncomment: 0,
                    service: 0
                },
                data:[],
                btnStatus:false,
                confirmShow:false,
                confirmTitle:'',
                confirmText:'',
            }
        },
        route: {

        },
        ready() {
            this.getData(0);
        },
        methods: {
            getData: function(type = 0) {
                if(this.dtype == type) {
                    return true;
                }
                this.dtype = type;
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.$http.get(localStorage.apiDomain+'public/index/user/orderselection/uid/'+ustore.id+'/token/'+ustore.token+'/type/'+type).then((response)=> {
                    if(response.data.status === 1) {
                        document.body.scrollTop = 0;
                        this.count = response.data.count;
                        this.data = response.data.list;
                    }else if(response.data.status===-1){
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    }else{
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            }
        }
    }
</script>