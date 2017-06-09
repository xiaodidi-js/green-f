<style>
	.shop_list{
		width:100%;
		padding:0rem 0rem 1rem 0rem;
		font-size:0;
	}

	.shop_list .ui_box {
		width: 47%;
		height: auto;
		background-color: #fff;
		display: inline-block;
		font-size: 1.6rem;
		margin: 4px 5.5px;
		color: #333;
		box-shadow: 1px 1px 2px #e2e2e2;
	}

	.shop_list .ui_box .img{
		width:100%;
		padding-top:100%;
		background-position:center;
		background: url("../images/chelizi.png") no-repeat;
		background-size: 100%;
	}

	.shop_list .ui_box:nth-child(even){
		margin-right:0%;
	}

	.shop_list .ui_box:nth-last-child(2),.wrapper .ui_box:last-child{
		margin-bottom:0%;
	}

	.shop_list .ui_box .mes{
		padding:0.7rem 0.5rem;
	}

	.shop_list .ui_box .mes .list_name{
		width:100%;
		height:3.6rem;
		font-size:1.4rem;
		color:#333;
		line-height:1.8rem;
		max-height:3.6rem;
		overflow:hidden;
		text-overflow:ellipsis;
		font-weight:600;
		word-wrap:break-word;
	}

	.mes .money{
		font-size:1.6rem;
		color:#F9AD0C;
	}

	.mes .money .unit{
		font-size:1.2rem;
		margin-right:0.2rem;
	}

</style>

<template>

	<div class="shop_list">
		<div class="ui_box">
			<div class="img"></div>
			<div class="mes">
				<div class="list_name">
					XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
				</div>
				<div class="money">
					<label class="unit">¥</label>99.9
				</div>
			</div>
		</div>
	</div>

	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>

<script>

    import Toast from 'vux/src/components/toast'

	export default{
		components: {
			Toast,
		},
        props: {

        },
		data() {
			return {

			}
		},
		ready() {

		},
		computed: {

		},
		methods: {

		}
	}
</script>