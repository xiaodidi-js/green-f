<style scoped>
	.sub-content{height:87%;}
</style>

<template>
	<div class="sub-content">
		<!-- 分类列表 -->
		<card-types :types="data"></card-types>
		<!-- toast提示框 -->
		<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
	</div>
</template>

<script>
import CardTypes from 'components/card-types'
import Toast from 'vux/src/components/toast'

	export default{
		data() {
			return {
				toastMessage:'',
				toastShow:false,
				data:[]
			}
		},
		vuex: {
            actions: {

            }
        },
		components: {
			CardTypes,
			Toast
		},
		route: {

		},
        watch: {
			$route: function(to) {

			}
        },
		ready() {
			this.GetData();
		},
		methods: {
		    GetData() {
                this.$getData('/index/index/columns').then((res) => {
                    this.data = res.classify;
                },(res)=>{
                    this.toastMessage = "网络开小差啦~";
                    this.toastShow = true;
                });
			}
		}
	}

</script>