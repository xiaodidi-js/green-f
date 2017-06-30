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
	<div class="goto"></div>
    <!-- toast提示框 -->
    <toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	<loading :show="loadingShow" text="正在加载..."></loading>
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
    import Loading from 'vux/src/components/loading'

	export default{
		components: {
			CardColumn,
			CardRectangle,
			CardImage,
			Toast,
            Swiper,
            banners,
            Loading
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
				tuijian: 1,
			}
		},
        ready() {
            this.main();
		    var content = this;
            $(window).scroll(function() {
                if($(window).scrollTop() >= 350) {
                    content.commitData({ target: 'scroll', data: $(window).scrollTop() });
                    console.log(content.$store.state.scroll);
                    $(".goto").fadeIn(500);
                } else {
                    $(".goto").stop(true,true).fadeOut(500);
                }
            });
            $(".goto").click(function(){
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
        computed: {

		},
        methods: {
		    main () {
                axios({
                    method: 'get',
                    url: localStorage.apiDomain + 'public/index/index',
                }).then((response) => {
                    if(response.data.status = 1) {
                        this.loadingShow = true;
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