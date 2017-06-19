<style type="text/css">
    .saobg {
        width:100%;
        height:100%;
        background: #fff;
    }
    .sao {
        width: 30rem;
        height: 30rem;
        position: fixed;
        top: 75px;
        right: 0px;
        left: 0px;
        text-align: center;
        font-size: 24px;
        margin: 0px auto;
    }
</style>

<template>
    <div class="saobg">
        <div class="sao" id="saosao">
            <img src="http://green-f.cn/public/static/lvyangtian/logo.jpg" alt="" style="width:100%;height:100%;" />
            <span>长按关注我们！</span>
            <br />
            <span style="color:#c40000">即可享受完整的购物体验！</span>
        </div>
    </div>
</template>

<script>
    export default{
        props: {
            types: {
                type: Array,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                data: [],
                item: [],
                myScroll: '',
                dtype: null,
                guige:[],
            }
        },
        ready() {

        },
        components: {
        },
        methods: {
            $id: function(id) {
                return document.getElementById(id);
            }
        },
    }
</script>