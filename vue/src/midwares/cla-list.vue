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
		<card-square style="padding-bottom: 100px;" :info="data" :no-padding="true"></card-square>
		<!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	</div>
</template>
<script>

    import HeaderSearch from 'components/header-search'
    import Tab from 'vux/src/components/tab/tab.vue'
    import TabItem from 'vux/src/components/tab/tab-item'
    import CardSquare from 'components/card-square'
    import Toast from 'vux/src/components/toast'
    import Separator from 'components/separator'

    export default {
        data() {
            return {
                toastMessage:'',
                toastShow:false,
                column:'hot',
                data:{
                    title: '',
                    list: [],
					img: '',
					background: ''
                },
				tuijian: 1
            }
        },
        components: {
            HeaderSearch,
            Tab,
            TabItem,
            CardSquare,
            Toast,
            Separator
        },
        route: {

        },
        ready() {
            this.getData('');
        },
        methods: {
            getData: function(sk){
                let url = '';
				if(this.$route.query.tuijian == 0) {
                    url = localStorage.apiDomain+'public/index/index/classifylist/cid/' + this.$route.params.cid + '/action/' + this.column;
				}else{
                    url = localStorage.apiDomain+'public/index/index/tuijianclass?id=' + this.$route.params.cid + '&action=' + this.column;
				}
                if(sk.length > 0) {
                    url += '/search/' + sk;
                }
                this.$http.get(url).then((response)=>{
				    if(response.data.status = 1) {
                        if(response.data.info.list == "") {
                            alert("商品为空！");
//                        this.$router.go({name : 'cla-list'});
//                        location.reload();
                            return false;
                        } else {
                            this.data.list = response.data.info.list;
                            this.data.img = response.data.info.img;
                            this.data.background = response.data.info.background;
                        }
					} else if(response.data.status = 0) {
                        this.$router.go({name : 'index'});
					}
                },(response)=>{
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
