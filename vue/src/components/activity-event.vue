

<template>
    <div class="activity-body">
        <div style="margin:0px 10px 0px;">
            <template v-for="item in list">
                <a href="javascript:void(0);" class="activity-text" style="border:none;">
                    <div class="lyt-logo">
                        <img src="../images/logo_lv.png" alt="" style="width:40px;height:40px;float:left;" />
                        <span>{{ item.proname }}</span>
                    </div>
                    <div style="position: relative;height: 35px;">
                        <div class="readying">阅读量:<i>{{ item.reading }}</i></div>
                        <div class="activity-data" style="float:right;line-height:35px;margin-right:0px;">{{ item.createtime | time }}</div>
                    </div>
                    <div class="activity-img">
                        {{ item.content }}
                    </div>
                </a>
            </template>
        </div>
    </div>
</template>

<script type="text/javascript">


    import axios from 'axios'
    import qs from 'qs'

    export default {
        vuex: {
            actions: {

            }
        },
        data() {
            return {
                data: this.$store.state.message,
                list: {},// JSON.parse(sessionStorage.getItem("messgae")),
            }
        },
        ready () {
            console.log(this.$route.query);
            let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
            ustore = JSON.parse(ustore);
            var content = this;
            axios({
                method: 'get',
                url: localStorage.apiDomain + 'public/index/index/productinfo/uid/' + ustore.id + '/pid/' + this.$route.query.pid,
            }).then((response) => {
                content.list = response.data.articles.list;
                console.log(content.list);
            });
//            var ele = document.getElementsByClassName("activity-img")[0];
//            var chil = ele.getElementsByTagName("img");
//            ele.innerHTML = this.list[0].content;
//            // 处理异常
//            try {
//                for(var i in chil) {
//                    chil[i].style.width = "100%";
//                    chil[i].style.height = "100%";
//                    console.log(chil[i].style.width);
//                }
//            } catch(e) {
//                console.log(e);
//            } finally {
//
//            }
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
            },
        },
        computed: {
            list () {
                return this.$store.state.message
            }
        }
    }
</script>

<style type="text/css">

    .activity-body{
        width: 100%;
        height: auto;
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

    .activity-body .lyt-logo .readying {
        float:right;
        font-size:16px;
        color:#2c3e50;
        float:left;line-height:35px;
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

    .activity-body .activity-text .activity-img {
        width: 95%;
        height: 100%;
        text-align: justify;
        background: #fff;
        padding: 10px 10px;
        line-height: 30px;
    }

</style>
