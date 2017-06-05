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

	.order-search{
		width:100%;
		height:50px;
		background: #343136;
		position: fixed;
		top:0px;
		left:0px;
		z-index: 99;
	}

	.order-search .search{
		font-size: 14px;width: 70%;
		height: 35px;margin: 0px auto;
		position: relative;top: 8px;
		background: url("../images/search-1.png") no-repeat #fff left;
		background-size: 20px 20px;
		background-position-x: 6px;
	}

	.order-search .search input[type='text']{
		margin: 5px 0px 0px 29px;
		height: 25px;
		border: none;
		width: 67%;
	}

	.order-search .customer {
		float:right;
		position: absolute;
		top:5px;
		text-align:center;
		width:14%;
		right:0px;
		color:#fff;
	}


	.order-search .customer .icon-kefu {
		font-size: 21px;
	}

	.order-search .customer .txt-service {
		display:block;
		width: 2.8rem;
		height: 3.7rem;
		background: url('../images/logo_kefu.png') no-repeat;
		background-size:100%;
		position: absolute;
		top: 0px;
		left: 10px;
	}

	.order-search-btn{
		position: absolute;
		right: 0px;
		top: 0px;
		line-height: 35px;
		width: 18%;
		height: 35px;
		color: #81c429;
		background: #f7f7f7;
		font-size: 14px;
		-webkit-appearance: none;
		-moz-appearance: none;
		-ms-appearance: none;
		-o-appearance: none;
		appearance: none;
	}

	/* search start */
	.search{
		background: #81c429;
		width:100%;
		height:66px;
	}
	.search .logo{
		width:56px;
		height:54px;
		float:left;
		padding: 5px 5px 5px 10px;
	}

	/* search end */

</style>

<template>
	<div class="order-search"  style="background: #81c429;">
		<div class="logo" style="background: none;width:50px;float:left;">
			<img src="../images/logo_lv.png" alt="" style="width:40px;height:40px;margin: 5px 15px;" />
		</div>
		<div class="search" style="width:65%;position:relative;left:12px;">
			<input type="text" placeholder="请输入您要搜索的商品" v-model="searchKey" @keydown="breakSearch()" />
			<input type="button" class="order-search-btn" @click="goSearch()" value="搜索" />
		</div>
		<div class="customer">
			<a href="javascript:void(0)" class="txt-service" @click="goPage"></a>
		</div>
	</div>
	<!-- 轮播图 -->
	<banners></banners> <!--  :testarr="data.index_data" -->
	<div class="sub-content">
		<!-- 显示抢购 -->
		<card-column :columns="maincolumns" keep-alive></card-column>
		<!-- 热销产品排行榜 -->
		<card-rectangle :testarr="data.index_data"></card-rectangle>
		<!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	</div>
	<div class="goto_top"></div>
</template>

<script>
	import CardColumn from 'components/card-column'
    import banners from 'components/banners'
	import CardRectangle from 'components/card-rectangle'
	import CardImage from 'components/card-image'
	import Toast from 'vux/src/components/toast'
    import Swiper from 'vux/src/components/swiper'
    import { myActive,mySearch } from 'vxpath/actions'
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
                mySearch
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
				arr: [],
				tuijian: 1
			}
		},
		route: {

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
		ready() {
			this.indexMessage();
            this.timeline();
            $(window).scroll(function(){
                if($(window).scrollTop() >= 350){
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
            this.breakSearch();
		},
        methods: {
		    //按钮回车事件
            breakSearch: function (event) {
				var e = window.event || event;
				if(e && e.keyCode == 13) {
					console.log(1);
					this.goSearch();
				}
            },
            goSearch: function() {
                var _self = this;
                this.$http.get(localStorage.apiDomain + 'public/index/index/searchshop?shopname=' + this.searchKey).then((response)=>{
                    console.log(response.data.info.data);
                    let arr = [];
                    arr = response.data.info;
                    this.$router.go({
                        name:'search',
                        params:{
                            arr:this.mySearch(response.data.info.data)
						}
                    });
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
//                axios({
//                    method: 'get',
//                    url: localStorage.apiDomain + '/public/index/index/searchshop?shopname=' + this.searchKey,
//                }).then((response) => {
//                    console.log(response);
//                });
//				this.$router.go({
//					name:"search",
//					data:this.searchKey
//				});
			},
		    indexMessage: function() {
                /*let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
				 ustore = JSON.parse(ustore);
				 console.log(ustore);*/
                let url = '';
                url = localStorage.apiDomain + 'public/index/index';
                this.$http.get(url).then((response)=>{
                    this.data = response.data;
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
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
			},
            timeline: function() {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                var _this = this;
                this.$http.get(localStorage.apiDomain + 'public/index/sale/SaleTimeSolt/uid').then((response) => {
                    if(response.data.status===1) {
                        this.maincolumns = response.data.SaleTimeSolt;
                        console.log(this.maincolumns);
                    } else if(response.data.status===-1) {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    } else {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            goPage () {
                this.myActive(5);
                this.$router.go({name: 'per-orders'})
            }
		}
	}
</script>