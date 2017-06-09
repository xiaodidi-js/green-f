
<style type="text/css">

    *{margin:0px;padding:0px;}
    ul li{list-style:none;}


    .order-search{width:100%;height:50px;background: #343136;
        position: relative;}

    .order-search .callback{
        width:25px;
        height:25px;
        float:left;
        background: url("../images/arrow_left.png") no-repeat;
        background-size: 15px 25px;
        margin:12px 15px;
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
        width: 66%;
    }

    .order-search-btn{
        position: absolute;
        right: 0px;
        top: 0px;
        line-height: 40px;
        width: 15%;
        height: 35px;
        color: #fff;
        border: none;
        background: rgba(255,255,255,0.2);
        font-size: 14px;
    }


    .order-banner{
        width:100%;
        height:325px;
        clear:both;
    }

    /* order-table start */
    .order-table{
        width:100%;
        height:45px;
        clear:both;
        background: #fff;
    }

    li{
        width:33%;
        float:left;
        text-align:center;
        line-height:45px;
        font-size: 14px;
    }

    .order-table ul .active{
        border-bottom: 3px solid #81C429;
    }

    .order-table ul li .wrap-list{
        width:30%;
        height:2px;
        background: #81C429;
        margin:0px auto;
    }

    /* order-table end */

    .order-content{
        width:100%;
        clear:both;
        margin-top: 10px;
    }

    .order-content .place-shop{
        width:100%;
    }

    .order-content ul li{
        width: 46%;
        height: 260px;
        float: left;
        margin: 0px 6px 10px;
        background: #fff;
    }



    .order-content ul li .mark{
        height:260px;
        margin: 0px 6px 55px;
    }

    .order-content ul li .mark-content-view{
        color: #333;
        font-size: 14px;
        height: 35px;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0px 3px;
        line-height: 17px;
        text-align: left;
    }

    .order-content ul li .order-p-money{
        color:#F9AD0C;
        width:60%;
        float:left;
    }

    .order-content ul li .icon-cart{
        float:right;
        width:28px;
        height:28px;
        background: url("../images/gouwuche.png") no-repeat right;
        background-size: 28px 25px;
        position: relative;
        top: 8px;
        right: 2px;
    }

    .order-content ul li .order-p-money span{
        font-size:20px;
    }

</style>
<template style="background: #F2F2F2;">
    <!-- order-search start -->
    <div class="order-search">
        <div class="callback"></div>
        <div class="search">
            <input type="text" class="" placeholder="请输入您要搜索的商品"/>
        </div>
        <input type="button" class="order-search-btn" value="搜索" style=""/>
    </div>
    <!-- order-search end -->

    <!-- order-banner start -->
    <div class="order-banner">
        <img src="../images/banner_xiadan.png" alt="" style="width:100%;height:325px;" />
    </div>
    <!-- order-banner end -->

    <!-- order-table start -->
    <div class="order-table">
        <ul id="card">
            <li class="active">新品</li>
            <li>热卖</li>
            <li>价格</li>
        </ul>
    </div>
    <!-- order-table end -->

    <div class="order-content" id="content">
        <neworder></neworder>
        <holdorder style="display:none;"></holdorder>
        <priceorder style="display:none;"></priceorder>
    </div>

</template>
<script type="text/javascript">

    import neworder from 'components/place-neworder'
    import holdorder from 'components/place-holdorder'
    import priceorder from 'components/place-price'

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
            this.siblingsDom();
        },
        methods: {
            $id: function(id){
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

                        var list = document.getElementsByClassName("wrap-list");
                        //console.log(list);

                        this.className = "active";
                        for(var j = 0, len = list.length; j < len; j++) {
                            list[j].index = j;
                            //console.log(list[j].index);
                        }
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
            }
        },//模板
        components: {
            neworder,
            holdorder,
            priceorder,
        },
        computed: {

        },
        watch: {

        }
    }
</script>
