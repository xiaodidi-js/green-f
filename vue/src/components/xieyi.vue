<template>
    <div class="xieyi-content">
        <div class="xieyi-desc">
            <strong class="xieyi-title">{{ title }}</strong>
            <p class="description">{{ content }}</p>
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
                title: '',
                content: ''
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
                    this.title = res.info.data;
                    this.content = res.info.data;
                    var str = this.title.substring(0,9);
                    this.title = str;
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