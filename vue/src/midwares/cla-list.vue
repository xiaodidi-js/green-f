<template>
	<div class="sub-content"> <!--:style="background:data.background"-->
		<!-- 头部 -->
		<header-search :fixed="true"></header-search>
		<div class="pict" v-if="data.img ==''"></div>
		<div class="imgs" v-else>
			<img :src="data.img" style="width:100%;height:100%;" />
		</div>
		<!-- tab导航栏 -->
		<tab default-color="#333" active-color="#81c429" :line-width="2" class="fixed-tab">
			<tab-item :selected="column === 'hot'" @click="changeColumn('hot')">热卖</tab-item>
			<tab-item :selected="column === 'new'" @click="changeColumn('new')">新品</tab-item>
			<tab-item :selected="column === 'price'" @click="changeColumn('price')">价格</tab-item>
		</tab>
		<!--<separator :set-height="90" unit="px"></separator>-->
		<!-- 分类列表 -->
		<card-square style="padding-bottom: 100px;" :info="data" :no-padding="true" keep-alive></card-square>
		<!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
		<loading :show="loadingShow" text="正在加载..."></loading>

		<!-- 回到顶部 -->
		<div class="goto"></div>

		<!-- 弹出提示框 -->
		<alert :show.sync="alertShow" title="" button-text="知道了">
			<p>商品为空!</p>
		</alert>

	</div>
</template>
<script>

    import HeaderSearch from 'components/header-search'
    import Tab from 'vux/src/components/tab/tab.vue'
    import TabItem from 'vux/src/components/tab/tab-item'
    import CardSquare from 'components/card-square'
    import Toast from 'vux/src/components/toast'
    import Separator from 'components/separator'
    import { commitData } from 'vxpath/actions'
    import Loading from 'vux/src/components/loading'
    import Alert from 'vux/src/components/alert'

    export default {
        data() {
            return {
                toastMessage: '',
                toastShow: false,
                column: 'hot',
                data:{
                    title: '',
                    list: [],
					img: '',
					background: ''
                },
				tuijian: 1,
                alertShow: false,
            }
        },
        components: {
            HeaderSearch,
            Tab,
            TabItem,
            CardSquare,
            Toast,
            Separator,
            Alert
        },
        route: {

        },
        vuex: {
            actions: {
                commitData,
            }
        },
        ready() {
            $(".goto").click(function(){
                $("html,body").animate({
                    scrollTop:0
                },200);
            });
            this.getData('');
        },
		watch: {
            '$route'(to,from) {
                var content = this;
                if(parseInt(to.params.cid) != content.colum && to.name === 'cla-list') {
                    content.getData('');
                }
            }
		},
        methods: {
            getData: function(sk){
                let url = '';
				if(this.$route.query.tuijian == 0) {
                    url = '/index/index/classifylist/cid/' + this.$route.params.cid + '/action/' + this.column;
				}else{
                    url = '/index/index/tuijianclass?id=' + this.$route.params.cid + '&action=' + this.column;
				}

                if(sk.length > 0) {
                    url += '/search/' + sk;
                }
                this.$getData(url).then((res)=>{
				    if(res.status = 1) {
                        this.alertShow = false;
                        this.data.list = res.info.list;
                        this.data.img = res.info.img;
                        this.data.background = res.info.background;
					} else if(response.data.status = 0) {
                        this.$router.go({name : 'index'});
					}
                },(res)=>{
                    this.toastMessage = "网络开小差啦~";
                    this.toastShow = true;
                });
            },
            changeColumn: function(col) {
                if(this.column === col) {
                    return false;
                }
                this.column = col;
                this.getData('');
            }
        },
        events: {
            goSearch: function(skey){
                this.getData(skey);
            }
        }
    }
</script>
<!--  tuijian -->

<style scoped>
	.fixed-tab{
		width:100%;
	}

	.sub-content .imgs {
		width: 100%;
		height: 164px;
		margin-top: 46px;
	}

	.sub-content .pict {
		width: 100%;
		margin-top: 46px;
	}
</style>
