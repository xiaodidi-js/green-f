<style>

    .shop-content{
        width:100%;
    }

    .shop-content .shop-content-buy .horizontal-view{
        width:100%;
        height:226px;
    }

    .shop-content .shop-content-buy .view-image{
        width:100%;
        height:165px;
    }

    .shop-content .shop-content-buy .vertical-view{
        width:100%;
        height:45px;
        line-height:45px;
        border-bottom:1px solid #ccc;
    }

    .shop-content .shop-content-buy .vertical-view .todaynew{
        font-size:16px;
    }


    .shop-content .shop-content-buy .vertical-view .move{
        font-size:14px;
        color:#999;
    }

    .shop-content .shop-content-buy .vertical-view span{
        font-family: "Microsoft YaHei";
    }

    .shop-content .shop-content-buy ul{
        widht:100%;
        height:auto;
    }

    .shop-content .shop-content-buy ul li{
        width:33%;
        height:240px;
        float:left;
        margin: 5px 0px 0px 1px;
        position:relative;
        background: #fff;
    }

    .shop-content .shop-content-buy ul li .icon-xinpin{
        position: absolute;
        top: 0px;
        left: 0px;
        width: 51px;
        height: 36px;
        background: url(../images/img4.png) no-repeat;
        background-size: 70%;
        color: #fff;
        text-align:center;
        font-size:14px;
        text-indent:-1em;
        line-height: 38px;
    }


    .shop-content .shop-content-buy ul li p{
        color:#333;
        font-size:14px;
        height:35px;
        overflow:hidden;
        text-overflow: ellipsis;
        padding:0px 3px;
    }

    .shop-content .shop-content-buy ul li .order-p-money{
        color:#F9AD0C;
        width:64%;
        float:left;
        line-height:35px;
    }

    .shop-content .shop-content-buy ul li .cart-buy{
        width:25px;
        height:25px;
        background: url('../images/gouwuche.png') no-repeat;
        background-size: 100%;
        float:right;
        margin-top:3px;
    }

    .shop-content .shop-content-buy ul li .order-p-money span{
        font-size:20px;
    }

</style>


<template>
    <div class="shop-content">
        <div class="shop-content-buy">
            <div class="horizontal-view">
                <img src="../images/banner_xinpin.png" alt="" style="width:100%;height:226px;"/>
            </div>
            <div class="vertical-view">
                <span class="todaynew" style="xxfloat:left;margin-left:10px;">每日新品</span>
                <span class="move" style="float:right;margin-right:10px;">查看更多     &gt;</span>
            </div>
            <ul>
                <li>
                    <div class="icon-xinpin">新品</div>
                    <div class="shop-img-body">
                        <img src="../images/img1.png" alt="" class="view-image" />
                    </div>
                    <p>车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝</p>
                    <p class="order-p-money">￥<span>19.00</span></p>
                    <p class="cart-buy"></p>
                </li>
                <li>
                    <div class="icon-xinpin">新品</div>
                    <div class="shop-img-body">
                        <img src="../images/img1.png" alt="" class="view-image" />
                    </div>
                    <p>车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝</p>
                    <p class="order-p-money">￥<span>19.00</span></p>
                    <p class="cart-buy"></p>
                </li>
                <li>
                    <div class="icon-xinpin">新品</div>
                    <div class="shop-img-body">
                        <img src="../images/img1.png" alt="" class="view-image" />
                    </div>
                    <p>车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝</p>
                    <p class="order-p-money">￥<span>19.00</span></p>
                    <p class="cart-buy"></p>
                </li>
            </ul>
        </div>
    </div>
</template>

