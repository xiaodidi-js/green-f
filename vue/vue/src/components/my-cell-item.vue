<style scoped>
	.line{
		width:100%;
		height:auto;
		border-bottom:#f2f2f2 solid 1px;
		font-size:1.4rem;
		color:#333;
		padding:1rem 0rem;
		background: #fff;
		margin-top: 1rem;
	}

	.line:last-child{
		border-bottom:none;
	}
</style>

<template>
	<div class="line">
		<slot></slot>
	</div>
</template>

<script>
	export default{
		data() {
			return {
				
			}
		}
	}
</script>