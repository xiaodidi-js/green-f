<template>
	<!-- 轮播图 -->
	<banners></banners>
	<div class="sub-content" style="position:relative;top:50px;">
		<!-- 显示抢购 -->
		<card-column :columns="maincolumns"></card-column>
		<!-- 热销产品排行榜 -->
		<card-rectangle :testarr="data"></card-rectangle>
	</div>
	<!-- 回到顶部 -->
	<div class="goto"></div>
    <!-- toast提示框 -->
    <toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>

	<!--<loading :show="loadingShow" :text="loadingMessage"></loading>-->

</template>

<script>

	import CardColumn from 'components/card-column'
    import banners from 'components/banners'
	import CardRectangle from 'components/card-rectangle'
	import CardImage from 'components/card-image'
	import Toast from 'vux/src/components/toast'
    import Swiper from 'vux/src/components/swiper'
    import { myActive, mySearch, commitData} from 'vxpath/actions'
    import Loading from 'vux/src/components/loading'

	export default{
		components: {
			CardColumn,
			CardRectangle,
			CardImage,
			Toast,
            Swiper,
            banners,
            Loading,
		},
        vuex: {
            actions: {
                myActive,
                mySearch,
                commitData,
				scrollWidth: true,
            }
        },
		data() {
			return {
				toastMessage: '',
				toastShow: false,
                loadingShow: false,
                loadingMessage: '',
				data: {
					articles: {title:'',list:[]},
					hotproducts: {title:'',list:[]},
					maincolumns: []
				},
                maincolumns:[],
                searchKey: '',
				arr: {},
				tuijian: 1,
				scroll: ''
			}
		},
        ready() {
		    var that = this;
            $(".goto").click(function(){
                $("html,body").animate({
                    scrollTop:0
                },200);
            });
            $(window).scroll(function() {
                localStorage.setItem('heiVal', $(document).scrollTop());
                that.commitData({target: 'scroll', data: localStorage.getItem('heiVal')});
			});
            $(window).scrollTop(localStorage.getItem('heiVal'));
        },
        mounted() {

		},
        destroyed () {
            this.scrollWidth = false;
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
            this.main();
            this.follow();
            this.timeline();
    	},
        computed: {

		},
        methods: {
		    main() {
                this.loadingMessage = '请稍候......';
                this.loadingShow = true;
                this.$getData('/index/index').then((res) => {
                    this.loadingShow = false;
                    this.data = res.index_data;
                    for (var i in this.data) {
                        if(this.data[i].type == 4) {
                            var l = this.data[i].arr.length;
                            for (var k = 0; k < l; k++) {
                                this.data[i].arr[k].img = this.data[i].arr[k].url;
                                this.data[i].arr[k].url = this.data[i].arr[k].htmlurl;
                            }
                        }
                    }
                })
			},
            follow () {
                let openid = sessionStorage.getItem("openid");
                if(sessionStorage.getItem('since')) {
                    var options = {
                        sinceid: sessionStorage.getItem('since'),
                        openid: openid
					};
                    this.$postData('/index/usercenter/sincestar/',options).then((res) => {});
                }
            },
            timeline () {
                this.$getData('/index/sale/SaleTimeSolt/uid').then((res) => {
                    if(res.status === 1) {
                        this.maincolumns = res.SaleTimeSolt;
                    } else {
                        this.toastMessage = res.info;
                        this.toastShow = true;
                    }
                });
            }
		}
	}
</script>

<style>

</style>