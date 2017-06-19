<style type="text/css">
    body{background: #fff;}
    .content_ciri{width:100%;margin-top:5px;}

    .ciri_banner{width:100%;height:9.9rem;}
    .content_main{display: flex;flex-wrap:wrap;
        box-sizing:border-box;padding-right:1%;
    }
    .box{width:24%;height:8.3rem;background:#F0F0F0;
        margin-left:1%;border-radius:2px;
        margin-top:3px;position:relative;
    }
    img{width:100%;height:100%;}
    .index-text{position:absolute;bottom:5px;width:100%;text-align:center;color:#808080;}
</style>

<template>
    <!-- 次日送达 -->
    <div class="content_ciri">
        <img src="../images/banner_peisong.png" class="ciri_banner">
        <div class="content_main">
            <div class="box" v-for='item in 12'>
                <img src="../images/content_ciri.png">
                <p class="index-text">蔬菜豆菇</p>
            </div>
        </div>
    </div>
    <!-- 次日送达 -->
</template>