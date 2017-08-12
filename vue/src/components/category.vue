<template>
    <header id="header">
        <span class="left" onclick="javascript:window.history.back(-1);"></span>
        <input type="text" placeholder="京东自营生鲜 全品类满139减30！">
        <span class="right"></span>
    </header>
    <div style="height:45px;"></div>

    <div id="contents">
        <aside id="categories">
            <ul>
                <li><span class="current">热门推荐</span></li>
                <li><span>潮流女装</span></li>
                <li><span>品牌男装</span></li>
                <li><span>个护化妆</span></li>
                <li><span>家用电器</span></li>
                <li><span>电脑办公</span></li>
                <li><span>手机数码</span></li>
                <li><span>母婴童装</span></li>
                <li><span>图书</span></li>
                <li><span>家居家纺</span></li>
                <li><span>居家生活</span></li>
                <li><span>家具建材</span></li>
                <li><span>食品生鲜</span></li>
                <li><span>酒水饮料</span></li>
                <li><span>运动户外</span></li>
                <li><span>鞋靴箱包</span></li>
                <li><span>奢品礼品</span></li>
                <li><span>钟表珠宝</span></li>
                <li><span>玩具乐器</span></li>
                <li><span>内衣配饰</span></li>
                <li><span>汽车用品</span></li>
                <li><span>音像制品</span></li>
                <li><span>医药保健</span></li>
                <li><span>计生情趣</span></li>
                <li><span>京东金融</span></li>
                <li><span>生活旅行</span></li>
                <li><span>宠物农资</span></li>
                <li><span></span></li>
            </ul>
        </aside>
        <aside id="detail">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </aside>
    </div>
</template>


<script>
    export default {
        data() {
            return {

            }
        },
        ready() {
            $("#detail div").html($("#categories ul li:eq(0) span").html());


            $("aside#categories ul li").bind("click", function () {
                $("aside#categories ul li span").removeClass("current");

                $(this).children("span").addClass("current");

                // console.log($(this).index() * 47);

                $(this).parents("#categories").animate({"scrollTop": $(this).index() * 47}, 400);

                $("#contents").animate({"scrollTop": 0}, 0);

                $("#detail div").html($(this).find("span").html());

            });
        },
        methods: {}
    }
</script>

<style>
    * {
        margin: 0;
        padding: 0;
    }

    ul {
        list-style: none;
    }

    html, body {
        height: 100%;
    }

    body {
        font-family: "Microsoft YaHei";
    }

    ::-webkit-scrollbar {
        display: none;
    }

    #header {
        z-index: 99;
        position: fixed;
        top: 0;
        width: 100%;
        height: 44px;
        border-bottom: 1px solid #ccc;
        background: linear-gradient(#fff, #efefef);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    #header span {
        margin: 0 10px;
    }

    #header .left {
        height: 20px;
        width: 20px;
        background: url("../img/jd-sprites.png") -21px 0;
        background-size: 200px 200px;
    }

    #header .right {
        height: 20px;
        width: 20px;
        background: url("../img/jd-sprites.png") -60px 0;
        background-size: 200px 200px;
    }

    #header input {
        height: 30px;
        border: 1px solid #bbbbbb;
        border-radius: 4px;
        flex-grow: 1;
        text-indent: 20px;
    }

    #categories {
        width: 76px;
        height: 100%;
        overflow-y: auto;
        position: fixed;
        left: 0;
        z-index: 99;
        background-color: #fff;
    }

    #categories ul li {
        height: 46px;
        width: 75px;
        border-bottom: 1px solid #ddd;
        border-right: 1px solid #dddddd;
    }

    #categories ul li span {
        display: block;
        text-align: center;
        line-height: 46px;
        font-size: 12px;
    }

    .current {
        color: #d00 !important;
    }

    #contents {
        display: flex;
        height: 100%;
        overflow-y: auto;
    }

    #contents #detail {
        margin: 10px 10px 10px 86px;
        flex-grow: 1;
        height: 3000px;
    }

    #contents #detail {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    #contents #detail div {
        flex-grow: 1;
        margin: 10px 0;
        text-align: center;
        background-color: #efefef;
        width: 100%;
        font-size: 30px;
    }
</style>