<style scoped>
	.give-container {
		width:100%;
		background: #fff;
		height: 100%;
		margin: 0px 0px 10px;
	}

	#give-list {
		display:none;
	}

	.give-container .give-title {
		height:45px;
		line-height:4.5rem;
		color:#808080;
		font-size:1.4rem;
	}

	.give-container .give-title .icon-img1 {
		background: url("../images/list.png") no-repeat;
		width: 6%;
		height: 43%;
		display: block;
		background-size: 100%;
		float:left;
		margin:13px 0px;
	}

	.give-container .give-title span {
		padding-left: 10px;
		width:100%;
	}

	.give-container .give-order {
		clear:both;
		height: 145px;
	}

	.give-container .give-order ul li {
		width: 29.4%;
		margin: 0px 6px;
	}

	.give-container .give-order ul li .shop-img {
		width: 100%;
		height: 95px;
		border:1px solid #ccc;
	}

	.give-container .give-order ul li p {
		font-size:14px;
		line-height: 30px;
	}

</style>

<template>
	<div class="give-container" id="give-list">
		<div class="" style="margin:10px 0px;border-bottom: 1px solid #eee;height:46px;width:100%;">
			<div style="margin:0px 10px;">
				<p class="give-title">
					<i class="icon-img1"></i>
					<span>首单用户,就送如下商品,请选择赠品</span>
				</p>
			</div>
		</div>
		<div class="give-order">
			<ul>
				<li>
					<p class="shop-img">
						<img src="../images/cm.png" alt="" style="width:100%;height:100%;" />
					</p>
					<p>车厘子水果...</p>
				</li>
			</ul>
		</div>
	</div>
</template>

<script>
    export default{
        props: {
			givedata: []
        },
        data() {
            return {

            }
        },
        ready() {
            var _this = this;
            this.$http.get(localStorage.apiDomain+'public/index/user/shoudan').then((response)=>{
//                _this.givedata = response.data.tuijian_shop;
                console.log(response.data);
            },(response)=>{
                this.toastMessage = '网络开小差了~';
                this.toastShow = true;
            })
        }
    }
</script>