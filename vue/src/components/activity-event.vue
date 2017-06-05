<style type="text/css">

    .activity-body{
        width: 100%;
        height: 100%;
        background: #fff;
        padding-top: 55px;
        color: #666;
        line-height: 26px;
    }

    .lyt-logo{
        width: 100%;
        clear: both;
        position: relative;
        height: 50px;
        line-height: 50px;
    }

    .lyt-logo .readying {
        float:right;

    }

    .lyt-logo span {
        font-size: 16px;
        color: #3cc51f;
        line-height: 50px;
        padding-left: 15px;
        display: block;
        width: 56%;
        height: 40px;
        float: left;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .activity-body .activity-text .next-edit{
        line-height: 40px;
        color:#000;
        border-bottom: 1px solid #eee;
    }

    .activity-body .activity-text .next-desc {
        line-height:30px;
    }

</style>


<template>
    <div class="activity-body">
        <div style="margin:0px 10px 10px;">
            <template v-for="item in data">
                <a href="javascript:void(0);" class="activity-text" style="border:none;">
                    <div class="lyt-logo">
                        <img src="../images/logo_lv.png" alt="" style="width:40px;height:40px;float:left;" />
                        <span>{{ item.proname }}</span>
                    </div>
                    <div style="position: relative;height: 35px;">
                        <div class="readying" style="float:left;line-height:35px;">阅读量:<i>{{ item.reading }}</i></div>
                        <div class="activity-data" style="float:right;line-height:35px;margin-right:0px;">{{ item.createtime | time }}</div>
                    </div>
                    <div class="activity-img">
                        <img :src="item.img" alt="" style="width:100%;" />
                    </div>
                    <p class="next-desc">{{ item.sdesc }}</p>
                </a>
            </template>
        </div>
    </div>
</template>

<script type="text/javascript">

    export default {
        vuex: {
            actions: {

            }
        },
        data() {
            return {
                data: this.$store.state.message
            }
        },
        ready () {
            console.log(this.data);
        },
        filters: {
            time: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var years = d.getFullYear();
                var month = d.getMonth() + 1;
                var days = d.getDate();
                var hours = d.getHours();
                var minutes = d.getMinutes();
                var seconds = d.getSeconds();
                return years + "-" + month + "-" + days;
            }
        },
        method: {
            cancelOrder: function() {
                if(this.disabled){
                    return true;
                }
                this.$dispatch('orderCancel');
                console.log(1);
            },
        }
    }
</script>