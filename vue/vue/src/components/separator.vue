<style scoped>
	.separator{
		width:100%;
	}
</style>

<template>
	<div class="separator" :style="{height:setHeight+unit}"></div>
</template>

<script>
	export default{
		props: {
			setHeight: {
				type: Number,
				default: 4.5
			},
			unit: {
				type: String,
				default: 'rem'
			}
		},
		data() {
			return {

			}
		}
	}
</script>