<template>
    <div class="toast-fixed" v-show="showele"></div>
    <div class="toast" v-show="showele">
        <div class="toast-message">
            <span>{{ messages }}</span>
        </div>
        <div class="toas-bottom" @click="doSomething()">OK</div>
    </div>
</template>

<script>
    export default {
        props: {
            messages: {
                type: String,
                default: '',
            },
            showele: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                toastMessage: '',
                toastShow: false,
            }
        },
        ready() {
            var eleW = $(".toast").width(), eleH = $(".toast").height();
            var winLeft = $(document).width(), winTop = $(document).height();
            var l = (winLeft - eleW) / 2;
            var t = (winTop - eleH) / 2;
            $(".toast").css({
                left: l + "px",
            });
        },
        methods: {
            doSomething() {
                this.showele = false;
            }
        },
        computed: {

        },
    }
</script>

<style type="text/css">
    /* .toast strat */
    .toast-fixed {
        width:100%;
        height:100%;
        background: rgba(0,0,0,0.2);
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 999;
    }

    .toast {
        position: absolute;
        top: 120px;
        left: 0px;
        width: 250px;
        height: auto;
        text-align: center;
        font-size: 14px;
        color: #4b8bf4;
        z-index: 9999;
        background: #fff;
        border-radius: 5px;
        max-width: 250px;
    }

    .toast .toast-message {
        width: 100%;
        height: 6.5rem;
        line-height: 6.5rem;
        border-radius: 5px 5px 0px 0px;
    }

    .toast .toas-bottom {
        color: #4b8bf4;
        height: 3.5rem;
        line-height: 3.5rem;
        width: 100%;
        border-top: 1px solid #eee;
    }

    .toast .toas-bottom:active {
        background: #4b8bf4;
        color: #fff;
        border-radius: 0px 0px 5px 5px;
    }

    /* .toast end */
</style>