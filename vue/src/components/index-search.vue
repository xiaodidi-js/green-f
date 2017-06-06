<style>

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

	<div class="order-search" :class="{'fixed':fixed}"  style="background: #81c429;">
		<div class="logo" style="background: none;width:50px;float:left;">
			<img src="../images/logo_lv.png" alt="" style="width:40px;height:40px;margin: 5px 15px;" />
		</div>
		<div class="search" style="width:65%;position:relative;left:12px;">
			<input type="text" @keydown="keyCodefun" placeholder="请输入您要搜索的商品" v-model="searchKey" />
			<input type="button" class="order-search-btn" @click="goSearch()" value="搜索" />
		</div>
		<div class="customer">
			<a href="javascript:void(0)" class="txt-service" @click="goPage"></a>
		</div>
	</div>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>

</template>

<script>

    import Toast from 'vux/src/components/toast'
    import { myActive } from 'vxpath/actions'

	export default{
		components: {
			Toast,
		},
        vuex: {
            actions: {
                myActive
            }
        },
        props: {
            bgcolor: {
                type: String,
                default: ''
            },
            fixed: {
                type: Boolean,
                default: false
            },
            top: {
                type: Number,
                default: 0
            },
            unit: {
                type: String,
                default: 'rem'
            }
        },
		data() {
			return {
                toastMessage:'',
                toastShow:false,
				searchKey: ''
			}
		},
		ready() {
			this.keyCodefun();
		},
		computed: {

		},
		methods: {
            keyCodefun: function (event) {
                var _this = this;
                var e = event || window.event;
                if(e && e.keyCode == 13) {
                    _this.goSearch();
                }
            },
            goSearch: function() {
				this.searchKey = this.searchKey.replace(/(^\s*)|(\s*$)/g,'');
				if(this.searchKey === "") {
                    this.toastMessage = "请输入关键字...";
                    this.toastShow = true;
				}
				if(this.searchKey.length <= 0) {
					return false;
				}
				this.$dispatch('goSearch',this.searchKey);
			},
			goPage () {
                this.myActive(5);
                this.$router.go({name: 'per-orders'})
			}
		}
	}
</script>