<style type="text/css">
    .activity-body{
        width:100%;
        padding-top:10px;
        z-index:-1;
    }

    .activity-body .activity-text{
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

    .activity-body .activity-text .act-title{
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
    <div style="width:100%;height:100%;background: #fff;">
        <div class="activity-body" id="activity">
            <template v-for="item in data">
                <div style="margin:0px 10px 10px;">
                    <a href="javascript:void(0);" class="activity-text" @click="goActivity()"> <!-- v-link="{name:'activity-event',params:{pid:item.id}}" -->
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

    import { myVipMessage } from 'vxpath/actions'
    import axios from 'axios'
    import qs from 'qs'

    export default {
        vuex: {
            actions: {
                myVipMessage
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
            this.vipMessage();
        },
        methods: {
            goActivity:function () {
                var _self = this;
                this.$router.go({
                    name:'activity-event',
                    params:{
                        arr:this.myVipMessage(this.data)
                    }
                });
            },
            vipMessage:function() {
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