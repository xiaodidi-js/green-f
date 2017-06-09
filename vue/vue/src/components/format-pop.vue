<style type="text/css">
    .fpmasker{
        position:fixed;
        top:0;
        left:0;
        width:0%;
        height:0%;
        z-index:98;
        background-color:transparent;
    }

    .fpmasker.show{
        width:100%;
        height:100%;
        background-color:rgba(0,0,0,0.6);
        display:block;
        transition:background .5s;
        -webkit-transition:background .5s;
    }

    .format-pop{
        width:100%;
        box-sizing:border-box;
        height:auto;
        background-color:#fff;
        padding:1rem;
        position:fixed;
        bottom:4.5rem;
        left:0;
        z-index:99;
        transform:scale(0);
        -webkit-transform:scale(0);
    }

    .format-pop.show{
        transform:scale(1);
        -webkit-transform:scale(1);
        transition:transform .3s;
        -webkit-transition:transform .3s;
    }

    .format-pop .line .pimg{
        box-sizing:border-box;
        width:25%;
        padding-top:25%;
        border:#fff solid 0.3rem;
        border-radius:0.3rem;
        background-color:#efefef;
        background-position:center;
        background-size:cover;
        background-repeat:no-repeat;
        position:absolute;
        top:-5%;
    }

    .format-pop .line .pmes{
        box-sizing:border-box;
        width:65%;
        height:auto;
        position:absolute;
        top:0;
        left:30%;
        margin-top:3%;
    }

    .format-pop .line .pmes div{
        font-size:1.4rem;
        color:#808080;
    }

    .format-pop .line .pmes div.price{
        color:#F26C60;
    }

    .format-pop .close{
        width:1.8rem;
        height:1.8rem;
        border-radius:0.9rem;
        background:rgba(130,130,130,0.2);
        color:#fff;
        line-height:1.8rem;
        font-size:1.2rem;
        text-align:center;
        position:absolute;
        top:1rem;
        right:1rem;
    }

    .format-pop .line .title{
        font-size:1.4rem;
        color:#666;
        margin:0.68rem 0rem;
    }

    .format-pop .line .title.inline{
        display:inline-block;
        width:30%;
        vertical-align:middle;
        font-size:1.4rem;
    }

    .format-pop .line .con.inline{
        display:inline-block;
        width:70%;
        vertical-align:middle;
    }

    .format-pop .line .con.inline .num-counter{
        text-align:right;
    }

</style>


<template>
    <div class="pop">
        <div class="fpmasker" :class="{'show':formatPopShow}" @touchmove.stop.prevent @touchend.stop @touchstart.stop @click="hideFormatPop"></div>
        <div class="format-pop" :class="{'show':formatPopShow}" @touchmove.stop.prevent @touchend.stop @touchstart.stop>
            <div class="line">
                <div class="pimg" v-lazy:background-image="data.shotcut"></div>
                <div class="pmes">
                    <div class="price" v-if="data.is_promote">¥{{data.promote_price}}</div>
                    <div class="price" v-else>¥{{data.price}}</div>
                    <div>库存{{proNums}}件</div>
                    <div class="dialog">{{ getGuigeName }}</div>
                </div>
            </div>
            <div class="close" @click="hideFormatPop">X</div>
            <div class="divider" style="margin-top:23%;"></div>
            <div class="line" v-for="(pindex,fmt) in data.format">
                <div class="title">{{ fmt.name }}</div>
                <div id="con" class="con" style="font-size:0;white-space:normal;">
                    <guige :value="val.id" :text="val.name" v-for="(sindex,val) in fmt.value" @click="changeGuige(pindex,val.id,val.name)"></guige>
                </div>
                <div class="divider"></div>
            </div>
            <div class="line" style="padding-bottom:0.3rem;font-size:0;">
                <div class="title inline">购买数量</div>
                <div class="con inline">
                    <div class="num-counter">
                        <div class="btns" :class="{'disabled':buyNums <= 1}" @click="reduceNums">-</div>
                        <input type="number" class="input" :value="buyNums" readonly />
                        <div class="btns" :class="{'disabled':buyNums >= proNums}" @click="addNums">+</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Scroller from 'vux/src/components/scroller'
    import { setCartStorage } from 'vxpath/actions'
    import { cartNums } from 'vxpath/getters'

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
                formatPopShow:false,
                proNums:1,
                buyNums:1,
            }
        },
        ready() {

        },
        components: {
            Scroller
        },
        filters: {

        },
        methods: {
            addNums: function(){
                if(this.buyNums>=this.proNums){
                    return false;
                }
                this.buyNums++;
            },
            reduceNums: function() {
                if(this.buyNums <= 1) {
                    return false;
                }
                this.buyNums--;
            },
            hideFormatPop: function(evt){
                evt.stopPropagation();
                this.formatPopShow = false;
            },
            showFormatPop: function(){
                this.formatPopShow = true;
            }
        },
    }
</script>