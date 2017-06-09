<style scoped>
	.bl-info-box{
		width:94%;
		padding:0.8rem 3%;
		background-color:#fff;
		margin-bottom:3%;
		font-size:1.4rem;
		position:fixed;
		top:46px;
		left:0;
		z-index:100;
	}

	.bl-info-box.status{
		font-size:0;
		text-align:left;
	}

	.bl-info-box.status .icon,.bl-info-box.status .content{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
	}

	.bl-info-box.status .icon{
		width:8%;
		margin-right:2%;
		text-align:center;
	}

	.bl-info-box.status .icon>img{
		width:80%;
		height:auto;
	}

	.bl-info-box.status .content{
		width:90%;
	}

	.bl-info-box.status .content .sta-line{
		width:100%;
		height:2rem;
		line-height:2rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		color:#808080;
		padding-bottom:0.5rem;
	}

	.bl-info-box.status .content .sta-line:last-child{
		padding-bottom:0%;
	}
	
	.bl-info-box.status .content .sta-line .stit{
		color:#333;
	}

	.bl-info-box.status .content .sta-line .stat{
		color:#fa9d0c;
	}

	.express-box{
		width:93%;
		padding-left:7%;
		padding-top:3%;
	}

	.express-box .line-info{
		width:100%;
		height:auto;
		border-left:#ccc solid 0.1rem;
		padding-top:3%;
		font-size:0;
	}

	.express-box .line-info:first-child{
		padding-top:0%;
	}

	.express-box .line-info:first-child .ebtit{
		color:#333;
	}

	.express-box .line-info:first-child .ebtime{
		color:#808080;
	}

	.express-box .line-info>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		color:#ccc;
	}

	.express-box .line-info .icon{
		width:8%;
		margin-left:-4%;
		margin-right:1%;
		text-align:center;
		background-color:#efefef;
		font-size:0;
		padding:0.5rem 0rem;
	}

	.express-box .line-info .icon>img{
		width:45%;
		height:auto;
		vertical-align:middle;
	}

	.express-box .line-info .icon.first{
		vertical-align:top;
		animation:jump 1.5s linear infinite normal;
		-webkit-animation:jump 1.5s linear infinite normal;
	}

	.express-box .line-info .icon.first>img{
		width:65%;
		height:auto;
		vertical-align:middle;
	}

	.express-box .line-info .con-box{
		width:92%;
		border-bottom:#ccc solid 0.1rem;
		padding-right:3%;
		padding-bottom:3%;
	}

	.express-box .line-info .con-box .ebtit{
		width:100%;
		max-width:100%;
		text-align:left;
	}

	.express-box .line-info .con-box .ebtime{
		width:100%;
		max-width:100%;
		font-size:1.2rem;
		text-align:left;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	@keyframes jump{
		0% {transform:translateY(0px);}
		65% {transform:translateY(-6px);}
		100% {transform:translateY(0px);}
	}

	@-webkit-keyframes jump{
		0% {transform:translateY(0px);}
		65% {transform:translateY(-6px);}
		100% {transform:translateY(0px);}
	}
</style>

<template>
	<separator :set-height="9.1"></separator>

	<!-- 订单状态 -->
	<div class="bl-info-box status">
		<div class="icon">
			<img src="../images/ordersgray.png" />
		</div>
		<div class="content">
			<div class="sta-line">
				<label class="stit">订单状态：</label>
				<label class="stat">待收货</label>
			</div>
			<div class="sta-line">
				配送公司：顺丰快递
			</div>
			<div class="sta-line">
				快递单号：201601610234949254
			</div>
		</div>
	</div>

	<!-- 物流信息 -->
	<div class="express-box">
		<div class="line-info">
			<div class="icon first">
				<img src="../images/expos.png" />
			</div>
			<div class="con-box">
				<div class="ebtit">
					佛山市[签收]佛山市【顺德大良B站】，李代已签收
				</div>
				<div class="ebtime">
					2016-07-04 18:20:59
				</div>
			</div>
		</div>
		<div class="line-info">
			<div class="icon">
				<img src="../images/expoint.png" />
			</div>
			<div class="con-box">
				<div class="ebtit">
					佛山市[签收]佛山市【顺德大良B站】，李代已签收
				</div>
				<div class="ebtime">
					2016-07-04 18:20:59
				</div>
			</div>
		</div>
		<div class="line-info">
			<div class="icon">
				<img src="../images/expoint.png" />
			</div>
			<div class="con-box">
				<div class="ebtit">
					佛山市[签收]佛山市【顺德大良B站】，李代已签收
				</div>
				<div class="ebtime">
					2016-07-04 18:20:59
				</div>
			</div>
		</div>
		<div class="line-info">
			<div class="icon">
				<img src="../images/expoint.png" />
			</div>
			<div class="con-box">
				<div class="ebtit">
					佛山市[签收]佛山市【顺德大良B站】，李代已签收
				</div>
				<div class="ebtime">
					2016-07-04 18:20:59
				</div>
			</div>
		</div>
		<div class="line-info" v-for="item in 10">
			<div class="icon">
				<img src="../images/expoint.png" />
			</div>
			<div class="con-box">
				<div class="ebtit">
					佛山市[签收]佛山市【顺德大良B站】，李代已签收
				</div>
				<div class="ebtime">
					2016-07-04 18:20:59
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import Separator from 'components/separator'

	export default{
		components: {
			Separator
		},
		data() {
			return {
				
			}
		}
	}
</script>