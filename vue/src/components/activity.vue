<style type="text/css">
    .activity-index{
        width:100%;
        z-index:-1;
        margin-bottom: 68px;
        padding-top: 48px;
    }

    .activity-index .activity-text{
        font-size: 1.5rem;
        line-height: 2rem;
        color: #333;
        text-align: left;
        border-bottom:1px solid #ccc;
        display:block;
        padding-bottom:35px;
    }

    .activity-text .arrow{
        width: 1rem;
        height: 18px;
        background: url('../images/arrow.png') no-repeat;
        background-size: contain;
        background-position: center;
        position: absolute;
        right: 0px;
        top: 6px;
    }

    .activity-index .activity-text .act-title{
        width:18rem;
        height:30px;
        line-height:30px;
        float:left;
        display:block;
        font-size:13px;
        overflow:hidden;
        text-overflow:ellipsis;
        color:#000;
    }

    .activity-data{
        float:right;
        line-height:30px;
        margin-right:23px;
        color:#666;
    }

</style>

<template>
    <div style="width:100%;height:auto;background: #fff;padding: 10px 0px;">
        <div class="activity-index" id="activity">
            <template v-for="item in data">
                <div style="margin:0px 10px 10px;">
                    <a class="activity-text" v-link="{name:'activity-event',query:{cid:item.id}}"> <!-- v-link="{name:'activity-event',params:{pid:item.id}}" @click="goActivity" -->
                        <div class="">
                            <img :src="item.img" alt="" style="width:100%;height:100%;" />
                        </div>
                        <div style="position: relative">
                            <span class="act-title">{{ item.title }}</span>
                            <span class="activity-data">{{ item.createtime | time }}</span>
                            <div class="arrow"></div>
                        </div>
                    </a>
                </div>
            </template>
        </div>
    </div>
</template>

<script type="text/javascript">

    import { myMessage } from 'vxpath/actions'
    import axios from 'axios'
    import qs from 'qs'

    export default {
        vuex: {
            actions: {
                myMessage,
            }
        },
        data() {
            return {
                data: []
            }
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
        ready() {
            this.Message();
        },
        methods: {
            goActivity:function () {
                var _self = this;
                this.$router.go({
                    name:'activity-event',
                    params:{
                        arr:this.myMessage(this.data)
                    }
                });
            },
            Message:function() {
                this.$http.get(localStorage.apiDomain + 'public/index/index/productinfo').then((response)=>{
                    this.data = response.data.articles.list;
                    console.log(this.data);
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            }
        }
    }
</script>