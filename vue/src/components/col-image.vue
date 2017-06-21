<template>
	<div class="wrapper">
		<img class="col-img" v-lazy="imgMes.src" alt="{{ imgMes.name }}" />
	</div>
</template>

<script>
	export default{
		props: {
			imgMes: {
				type: Object,
				required: true
			}
		},
		data() {
			return {
			}
		},
		ready() {
			
		}
	}
</script>

<style scoped>
	.wrapper{
		width:100%;
		height:auto;
		text-align:center;
	}

	.col-img{
		width:92%;
		height:auto;
		padding:4%;
		border:none;
	}
</style>