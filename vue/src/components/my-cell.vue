<style scoped>
	.my-cell{
		width:97%;
		height:auto;
		padding-left:3%;
		/*margin-bottom:3%;*/
		/*margin-top:1rem;*/
		position:relative;
	}

	.my-cell .line{
		width:97%;
		height:auto;
		border-bottom:#f2f2f2 solid 1px;
		font-size:1.4rem;
		color:#333;
		padding-right:3%;
	}

	.my-cell .line.title{
		padding-top:0.8rem;
		padding-bottom:0.8rem;
	}

</style>

<template>
	<div class="my-cell" :style="{backgroundColor:bgcolor}" style="">
		<div class="line title" v-if="title !== ''">{{ title }}</div>
		<slot></slot>
	</div>
</template>

<script>
	export default{
		props: {
			bgcolor: {
				type: String,
				default: '#fff'
			},
			title: {
				type: String,
				default: ''
			}
		},
		data() {
			return {
				
			}
		}
	}
</script>