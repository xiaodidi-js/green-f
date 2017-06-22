<template>
	<!-- 轮播图 -->
	<banners></banners>
	<div class="sub-content" style="position:relative;top:50px;">
		<!-- 显示抢购 -->
		<card-column :columns="maincolumns" keep-alive></card-column>
		<!-- 热销产品排行榜 -->
		<card-rectangle :testarr="data.index_data"></card-rectangle>
	</div>
	<!-- 回到顶部 -->
	<div class="goto_top"></div>
    <!-- toast提示框 -->
    <toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>

	import CardColumn from 'components/card-column'
    import banners from 'components/banners'
	import CardRectangle from 'components/card-rectangle'
	import CardImage from 'components/card-image'
	import Toast from 'vux/src/components/toast'
    import Swiper from 'vux/src/components/swiper'
    import { myActive,mySearch,commitData } from 'vxpath/actions'
    import axios from 'axios'
    import qs from 'qs'

	export default{
		components: {
			CardColumn,
			CardRectangle,
			CardImage,
			Toast,
            Swiper,
            banners
		},
        vuex: {
            actions: {
                myActive,
                mySearch,
                commitData,
            }
        },
		data() {
			return {
				toastMessage:'',
				toastShow:false,
				data: {
					articles: {title:'',list:[]},
					hotproducts: {title:'',list:[]},
					maincolumns: []
				},
                maincolumns:[],
                searchKey: '',
				arr: {},
				tuijian: 1
			}
		},
        ready() {
            this.main();
            window.scrollTo(0,0);
            $(window).scroll(function() {
                if($(window).scrollTop() >= 350) {
                    $(".goto_top").fadeIn(500);
                } else {
                    $(".goto_top").stop(true,true).fadeOut(500);
                }
            });
            $(".goto_top").click(function(){
                $("html,body").animate({
                    scrollTop:0
                },200);
            });
        },
        filters: {
            timeline: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var hours = d.getHours();
                var minutes = d.getMinutes();
                var seconds = d.getSeconds();
                return (hours > 9 ? hours : '0' + hours) + ':' + (minutes > 9 ? minutes : '0' + minutes) + ":" + (seconds > 9 ? seconds : '0' + seconds)
            }
        },
        created () {
            this.follow();
            this.timeline();
    	},
        computed:{

		},
        methods: {
		    main () {
                axios({
                    method: 'get',
                    url: localStorage.apiDomain + 'public/index/index',
                }).then((response) => {
                    localStorage.setItem("iData",JSON.stringify(response.data));
                    if(localStorage.getItem("iData") != '') {
                        this.data = JSON.parse(localStorage.getItem("iData"));
					}
                    var data = this.data;
                    for (var i = 0; i < data.index_data.length; i++) {
                        if(data.index_data[i].type == 4) {
                            var l = data.index_data[i].arr.length;
                            for (var k = 0; k < l; k++) {
                                data.index_data[i].arr[k].img = data.index_data[i].arr[k].url;
                                data.index_data[i].arr[k].url = data.index_data[i].arr[k].htmlurl;
                            }
                        }
                    }
                });
			},
            follow () {
                let url = '' , openid = sessionStorage.getItem("openid");
                if(sessionStorage.getItem('since')) {
                    axios({
                        method: 'post',
                        url: localStorage.apiDomain + 'public/index/usercenter/sincestar/',
                        data: qs.stringify({
                            sinceid: sessionStorage.getItem('since'),
                            openid: openid
                        })
                    }).then((response) => {
						console.log(response.data);
                    });
                }
            },
            timeline () {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                axios({
                    method: 'get',
                    url: localStorage.apiDomain + 'public/index/sale/SaleTimeSolt/uid',
                }).then((response) => {
                    if(response.data.status === 1) {
                        localStorage.setItem("salesolt",JSON.stringify(response.data.SaleTimeSolt));
                        this.maincolumns = JSON.parse(localStorage.getItem("salesolt"));
                    } else {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                });
            }
		}
	}
</script>

<style scoped>
	.goto_top {
		width:3.7rem;
		height:3.7rem;
		background: url(../images/img13.png) no-repeat;
		background-size: 100%;
		position: fixed;
		right:10px;
		bottom: 6.5rem;
		z-index:1000;
		display:none;
	}
</style>