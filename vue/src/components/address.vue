<!-- 收货地址 -->

<style>

    /* search_panel start */
    .search_panel{
        width:100%;
        height: 65px;
    }
    .search_panel .search_form{
        border: 1px solid #CACACA;
        background: #fff;
        color: #4d4d4d;
        width: 93%;
        margin: 0px 10px;
        height: 4rem;
        font-size: 14px;
        text-indent: 1em;
        position: relative;
        top: 10px;

    }
    .search_panel .search_form .search_txt{
        width: 93%;
        height: 3rem;
        background: url("../images/search-1.png") no-repeat right;
        background-size: 23px 23px;
        margin-top: 4px;
    }

    .sel-address{
        width:20rem;
        margin:20px auto;
        padding-bottom:33px;
        clear: both;
    }

    .sel-address span{
        font-size:14px;
        float:left;
        line-height:32px;
    }

    .sel-address .sel-bg{
        width:10rem;
        height:3rem;
        text-indent:0.5em;
        border:1px solid #7E7E7E;
        float:left;
        margin-left:5px;
    }

    .sel-address .sel-bg .select-add{
        width:9rem;
        border:none;
        height:30px;
        background: url("../images/xia.png") no-repeat right;
        background-size: 10px 10px;
    }

    /* search_panel end */

    /* addresses_table start */
    .ui-address{width:100%;height:5rem;border-bottom:1px solid #ccc;position: relative;}
    .ui-address ul li{width:50%;text-align:center;font-size:21px;line-height:50px;float:left;color:#333;}
    .ui-address ul .active{
        border-bottom:3px solid #3cc51f;
        width:50%;
    }
    /* addresses_table end */


    .add-list{width:100%;height:100%;clear:both;padding-top: 10px;}
    .add-list ul li{width: 96%;
        height: 115px;
        background: #fff;
        text-align: left;
        line-height: 25px;
        color: #4d4d4d;
        margin: 5px 6px;
        position:relative;
    }

    .icon-choice{
        position:absolute;
        top:35px;
        right:0px;
    }

    .add-list ul li .li-text{text-indent: 1em;
        line-height: 25px;
        margin-top: 3px;}

    /* determine start */
    .btn-sure{
        width:90%;
        margin:20px auto;
        clear:both;
        height:40px;
    }
    .ui-button{width:90%;height:40px;background:#81c429;
        border:1px solid #81c429;
        font-size:14px;
        color:#fff;
        display:block;
        position:fixed;
        clear:both;
        border-radius: 5px;
    }

    .add-address{
        bottom: 60px;
        background: #ccc;
        /*border:1px solid #ccc;*/
    }

    .determine{
        bottom: 10px;
    }

    /* determine end */


    /* receipt start */
    .receipt{
        width:100%;
        margin:0px auto 70px;
        clear:both;
    }

    .receipt ul .receipt-li {
        width:100%;
        text-align:left;
        position:relative;
        margin:10px auto;
        display:block;
        background: #fff;
    }



    .receipt ul .receipt-li .receipt-text{
        line-height: 30px;
        width: 85%;
        height: 30px;
        text-indent: 1em;
        padding-top: 10px;
    }

    .receipt ul .receipt-li .receipt-add{
        width: 82%;
        height: 60px;
        margin: 0px 15px 5px;
        text-indent: 0rem;
    }

    /* receipt end */

</style>

<template>

    <div class="search_panel">
        <form class="search_form">
            <input type="text" class="search_txt" placeholder="搜索自提点" />
            <input type="button" class="search_btn"/>
        </form>
    </div>

    <div class="ui-address">
        <ul id="card">
            <li class="active">自提地点</li>
            <li>
                <span>收货地址</span>
                <div class="sel-active"></div>
            </li>
        </ul>
    </div>

    <div id="content">
        <div class="add-list">
            <div class="sel-address">
                <span>地区选择:</span>
                <div class="sel-bg" style="">
                    <select class="select-add">
                        <option>全部</option>
                    </select>
                </div>
            </div>
            <ul id="container">
                <li>
                    <p class="li-text">自提点：大良新宁路60号时代大厦14层</p>
                    <p class="li-text">电话:15044443333</p>
                    <p class="li-text">收货地址：大良凤山中路12号</p>
                    <p class="li-text">服务范围：凤岭名都</p>
                    <div class="icon-choice">
                        <icon type="success"></icon>
                        <icon type="circle"></icon>
                    </div>
                </li>
            </ul>

            <!-- btn-sure start -->
            <div class="btn-sure">
                <button class="ui-button determine">确定</button>
            </div>
            <!-- btn-sure end -->

        </div>

        <div class="receipt" style="display:none;">
            <ul>
                <li class="receipt-li">
                    <p class="receipt-text">
                        <span style="float:left;">张三</span>
                        <span style="float:right;">15622229999</span>
                    </p>
                    <p class="receipt-text receipt-add" style="">广东省佛山市顺德区大良街道新宁路银景苑四座</p>
                    <div class="icon-choice">
                        <icon type="success"></icon>
                        <icon type="circle"></icon>
                    </div>
                </li>
            </ul>

            <!-- btn-sure start -->
            <div class="btn-sure">

                <button class="ui-button add-address">增加收货地址</button>

                <button class="ui-button determine">确定</button>
            </div>
            <!-- btn-sure end -->

        </div>
    </div>



</template>


<script>
    import Icon from 'vux/src/components/icon'
    import CoupopList from 'components/coupop-list'
    import { clearAll } from 'vxpath/actions'

    export default{
        vuex: {
            actions: {
                clearAll
            }
        },
        components: {
            Icon,
            CoupopList
        },
        props: {
            show: {
                type:Boolean,
                required:true,
                twoWay:true
            },
            title: {
                type: String,
                default: ''
            },
            showConfirm: Boolean,
            confirmText: {
                type: String,
                default: '确定'
            },
            price: {
                type: [String,Number],
                default: 0
            },
            chosen: {
                type: Number,
                required: true,
                default: 0,
                twoWay: true
            }
        },
        data() {
            return {
                showStatus: true,
                showTips: '加载中...',
                coupon: []
            }
        },
        ready() {
            this.siblingsDom();
        },
        computed: {
            getPrice: function(){
                let fee = this.price;
                if(typeof fee==='string'){
                    fee = parseFloat(fee);
                }
                return fee.toFixed(2);
            }
        },
        methods: {
            $id: function(id) {
                return document.getElementById(id);
            },
            siblings: function (dom,callback){
                var pdom = dom.parentElement;
                var tabArr = [].slice.call(pdom.children);
                tabArr.filter(function(obj){
                    if(obj!=dom)callback.call(obj);
                });
            },
            siblingsDom:function (){
                var cardDom = this.$id("card");
                var liDomes = cardDom.children;
                var len = liDomes.length;
                for(var i = 0; i < len; i++) {
                    //给对象缓存自有属性
                    liDomes[i].index = i;
                    var _this = this;
                    liDomes[i].onclick = function(){
                        this.className = "active";
                        //同辈元素互斥
                        _this.siblings(this,function(){
                            this.className = "";
                        });
                        //把对应的选项卡的内容显示出来
                        var tabDom = document.getElementById("content").children[this.index];
                        tabDom.style.display = "block";
                        //拿它的父亲对象
                        _this.siblings(tabDom,function(){
                            this.style.display = "none";
                        });
                    };
                }
            },
            hidePanel: function(){
                this.show = false;
            },
            conMove: function(evt){
                evt.stopPropagation();
            }
        },
        events: {
            setChosen: function(obj){
                if(typeof obj==='object'){
                    this.chosen = obj.id;
                    this.$parent.couponObj = obj;
                }
            }
        },
        watch: {
//			show: function(nval,oval){
//				if(nval===true&&this.coupon.length<=0){
//					let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
//					ustore = JSON.parse(ustore);
//					this.$http.get(localStorage.apiDomain+'public/index/user/couponlist/uid/'+ustore.id+'/token/'+ustore.token+'/price/'+this.getPrice).then((response)=>{
//						if(response.data.status===1){
//							if(response.data.coupon.length<=0){
//								this.showTips = '暂无可用优惠券';
//							}else{
//								this.showStatus = false;
//								this.showTips = '加载中...';
//								this.coupon = response.data.coupon;
//							}
//						}else if(response.data.status===-1){
//							this.$parent.toastMessage = response.data.info;
//							this.$parent.toastShow = true;
//							let context = this;
//							setTimeout(function(){
//								context.clearAll();
//								sessionStorage.removeItem('userInfo');
//								localStorage.removeItem('userInfo');
//								context.$router.go({name:'login'});
//							},800);
//						}else{
//							this.showTips = '暂无可用优惠券';
//						}
//					},(response)=>{
//						this.$parent.toastMessage = '网络开小差了~';
//						this.$parent.toastShow = true;
//					});
//				}
//			}
        }
    }
</script>