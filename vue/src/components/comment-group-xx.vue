<style scoped>

    body{background: #fff;}

    .com-wrapper{
        width:100%;
        height:100%;
        background: #fff;
    }

    .closing-time{
        width:100%;
        height:40px;
        background: #e6e6e6;
        text-align:center;
        font-size:14px;
        line-height:40px;
        color:#666;
    }

    .card-box{
        width:100%;
        height:351px;
        background: #fff;
        border-bottom:#E6E6E6 solid 1px;
        min-height: 350px;
        margin: 50px 0px 40px;
    }

    .card-box .pro-mes{
        /* width: 100%; */
        padding: 5% 0%;
        border-bottom: #F2F2F2 1px solid;
        font-size: 0;
        margin: 0px 10px;
    }

    .card-box .pro-mes:last-child{
        border-bottom:none;
    }

    .card-box:last-child{
        border-bottom:none;
    }

    .card-box .pro-mes .shotcut,.card-box .pro-mes .words{
        display:inline-block;
        vertical-align:top;
        font-size:1.4rem;
    }

    .card-box .pro-mes .shotcut{
        width:22%;
        padding-top:22%;
        margin-right:3%;
        background-color:#DDD;
        background-size:cover;
        background-position:center;
        background-repeat:no-repeat;
        overflow:hidden;
    }

    .card-box .pro-mes .words{
        width:75%;
    }

    .card-box .pro-mes .words .name{
        width:100%;
        display:-webkit-box;
        -webkit-line-clamp:2;
        -webkit-box-orient:vertical;
        overflow:hidden;
    }

    .card-box .pro-mes .words .format{
        width:100%;
        white-space:nowrap;
        text-overflow:ellipsis;
        overflow:hidden;
        font-size:1.2rem;
        color:#ccc;
    }

    .card-box .pro-mes .words .money{
        font-size:1.4rem;
        color:#F9AD0C;
        text-align:left;
        margin-top:0.7rem;
        white-space:nowrap;
        text-overflow:ellipsis;
        overflow:hidden;
    }

    .card-box .pro-mes .words .unit{
        font-size:1.2rem;
    }

    .card-box .pro-mes .com-text{
        width:96%;
        height:8rem;
        font-size:1.4rem;
        line-height:1.8rem;
        color:#333;
        background-color:#F2F2F2;
        margin:1rem 0rem;
        padding:2%;
        border-radius:0.3rem;
    }

    .comment-message{
        clear: both;
        width:100%;
    }

    .comment-message ul li{
        width: 95%;
        height: 85px;
        border: 1px solid #f9ad0c;
        background: #fbe7bc;
        text-align: left;
        margin: 10px 7px 0px;
        border-radius: 5px;
    }

    .comment-message ul li p .todate{
        margin-right: 10px;
    }

    .comment-message ul li .item-info-msg{
        clear: both;
        font-size: 20px;
        text-indent: 0.5em;
        height: 20px;
        line-height: 15px;
    }

    .item-view-sure{clear: both;
        margin: 10px;
        position: relative;
        top: 10px;}

    .item-view-sure p{
        height:50px;
        border:1px solid #f2f2f2;
        background: #f2f2f2;
        line-height:50px;
        font-size:16px;
        padding:0px 10px;
        color:#808080;
        border-radius:5px;
    }

    /* rater start */
    .rater{
        width:100%;
    }

    .rater li{
        height:50px;
        float:left;
        width:33%;
    }
    .rater li img{
        margin:0px 26px;
    }
    /* rater end */

    .pro-main{
        margin:10px;
    }

    .pro-main .uploader .camere-down{
        float: left;
        margin: 7px 0.35rem;
        border: 1px solid #eee;
        /* padding: 12px 5px; */
        width: 21.5%;
        height: 66px;
    }



</style>

<template	>
    <div class="com-wrapper">
        <p class="closing-time">成交时间 2016-06-26 09:25:54</p>
        <div class="card-box" style="margin:0px;">
            <div class="pro-mes">
                <div class="shotcut">
                    <img :src="item.shotcut" style="width:100%;height:100%;" />
                </div><!-- v-lazy:background-image="item.shotcut" -->
                <div class="words">
                    <div class="name">车厘子水果色泽红艳光洁 玲珑珑如玛瑙宝....</div>
                </div>
            </div>
            <div class="pro-main">
                <ul class="uploader">
                    <li class="camere-down">
                        <img src="../images/img1.png" alt="" />
                    </li>
                    <li class="camere-down">
                        <img src="../images/img1.png" alt="" />
                    </li>
                    <li class="camere-down">
                        <img src="../images/img1.png" alt="" />
                    </li>
                </ul>
            </div>

            <div class="comment-message">
                <ul>
                    <li>
                        <p class="item-info">
                            <span style="margin: 6px 9px;display: block;float: left;">
                                <a href=""></a>
                                <a href=""></a>
                                <a href=""></a>
                                <a href=""></a>
                                <a href=""></a>
                                <img src="../images/true-comment.png" style="width:25px;height:25px;" alt="" />
                                <img src="../images/true-comment.png" style="width:25px;height:25px;" alt="" />
                                <img src="../images/true-comment.png" style="width:25px;height:25px;" alt="" />
                                <img src="../images/true-comment.png" style="width:25px;height:25px;" alt="" />
                                <img src="../images/true-comment.png" style="width:25px;height:25px;" alt="" />
                            </span>
                            <span>好评</span>
                            <span style="float:right;" class="todate">[2017-04-18]</span>
                        </p>
                        <p class="item-info-msg" style="text-align:left;">下次再会回来</p>
                    </li>
                </ul>
                <div class="item-view-sure">
                    <p>
                        <span style="float:left;">感谢你的肯定</span>
                        <span style="float:right;">[2016-07-11]</span>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- toast提示框 -->
    <toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>

    export default{
        components:{

        },
        props: {
            products: {

            }
        },
        data() {
            return {

            }
        }
    }
</script>