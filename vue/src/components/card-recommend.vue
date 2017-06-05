<style scoped>

	.card-box{
		width:31.1%;
		height:auto;
		margin:0rem 0rem 1rem 0.5rem;
		background-color:#fff;
		display:inline-block;
		font-size:1.6rem;
		color:#333;
		float:left;
		/*box-shadow:1px 1px 2px #e2e2e2;*/
	}

	.card-box:nth-of-type(1) {
		margin-right:0.39rem;
	}

	.card-box:last-child{
		margin-right:0%;
	}

	.card-box .img{
		width:99%;
		padding-top:90%;
		background-position:center;
		background-size:cover;
		background-color:#e4e4e4;
	}

	.mes{
		padding:5%;
	}

	.mes .name{
		font-size:1.2rem;
		color:#333;
		line-height:1.6rem;
		max-height:3.2rem;
		height:3.2rem;
		overflow:hidden;
		text-overflow:ellipsis;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		white-space:normal;
	}

	.mes .money{
		font-size:1.4rem;
		color:#F9AD0C;
		float:left;
	}

	.mes .money .unit{
		font-size:1.2rem;
		margin-right:0.2rem;
	}

	.icon_shopcar{
		width: 25%;
		height: 2rem;
		line-height: 2.806rem;
		float: right;
		text-align: right;
		background: url('../images/gouwuche.png') no-repeat;
		background-size: 85%;
	}

	.icon_shopcar img{
		width: 2.8rem;
		height: 2.3rem;
	}

</style>

<template>
	<div class="card-box" style="box-shadow: none;" v-for="item in info" v-link="{name:'detail',params:{pid:item.id}}">
		<div class="img" v-bind:style="{backgroundImage:'url('+item.src+')'}"></div>
		<div class="mes">
			<div class="name">{{ item.title }}</div>
			<div class="money">
				<label class="unit">¥</label>{{ item.price }}
			</div>
			<div class="icon_shopcar"></div>
		</div>
	</div>
</template>

<script>
	export default{
		props: {
			info: {
				type: Array,
				default() {
					return []
				}
			},
			cardWidth: {
				type: Number,
				default: 0
			}
		},
		data() {
			return {

			}
		}
	}
</script>