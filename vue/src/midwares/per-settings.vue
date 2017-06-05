<style scoped>
	
</style>

<template>
	<div class="sub-content">
		<settings></settings>
		<separator :set-height="1.5"></separator>
	</div>
</template>

<script>
	import Settings from 'components/settings'
	import Separator from 'components/separator'

	export default{
		components: {
			Settings,
			Separator
		},
		data() {
			return {
				
			}
		},
		route: {

		},
		ready() {

		}
	}
</script>