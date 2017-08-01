<template>
    <div class="xieyi-content">
        <div class="xieyi-desc">
            <strong class="xieyi-title">{{ xieyiTitle }}</strong>
            <p class="description">
                广州绿秧田食品有限公司（以下简称“绿秧田”）热衷于为广大群众提供绿色、安全、健康、美味食品而生的公司。
绿秧田公司的目标——用心做好绿色、安全、环保，便利、快捷食品。
主营业务包括：食品配送、冷链配送、零售、批发、送货上门等。
公司寄语：本公司很愿意和大家成为一份子，公司需要你们的支持和努力。没有人一开始就全懂，公司愿意大力培养和支持肯努力、肯进步的人才。愿意坚持、苦苦努力却得不到机会的，快来加入我们吧。在这里，我们共（jian）同（chi）努（bu）力（xie），造就一支精英团队！
            </p>
        </div>
    </div>
    <toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>

    import Toast from 'vux/src/components/toast'

    export default {
        data() {
            return {
                toastShow: false,
                toastMessage: '',
                xieyiTitle: ''
            }
        },
        ready() {
            this.xiayi();
        },
        components: {
            Toast,
        },
        methods: {
            xiayi: function() {
                this.$getData('/index/index/xieyi').then((res)=>{
                    this.xieyiTitle = res;
                    var str = this.xieyiTitle.substring(0,9);
                    this.xieyiTitle = str;
                },(res)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            }
        }
    }
</script>

<style type="text/css">
    /* xieyi-content start */
    .xieyi-content {
        padding-top: 65px;
        width:100%;
        height: 100%;
        background: #fff;
    }

    .xieyi-content .xieyi-title {
        font-size: 20px;
        text-align: center;
        color: #81c429;
        display: block;
    }

    .xieyi-content .xieyi-desc {
        padding: 0px 1.5rem;
        line-height: 3rem;
        font-size: 1.6rem;
    }

    .xieyi-content .xieyi-desc .description {
        text-indent: 2em;
        margin-top: 1rem;
        color: #B3B3B3;
    }
    /* xieyi-content end */
</style>