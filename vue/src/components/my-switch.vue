<template>
	<input type="checkbox" class="my-switch" v-model="value" />
</template>

<script>
	export default{
		props: {
			value: {
				type: Boolean,
				default: true,
				twoWay: true
			}
		},
		data() {
			return {
				
			}
		}
	}
</script>

<style scoped>
	.my-switch {
		-webkit-appearance: none;
		-moz-appearance: none;
		appearance: none;
		position: relative;
		width: 36.4px;
		height: 22.4px;
		border: 1px solid #DFDFDF;
		outline: 0;
		border-radius: 11.2px;
		box-sizing: border-box;
		background: #DFDFDF;
		vertical-align:middle;
		margin:3px;
	}

	.my-switch:checked {
		border-color: #04BE02;
		/*background-color: #04BE02;*/
	}

	.my-switch:before {
		content: " ";
		position: absolute;
		top: 0;
		left: 0;
		width: 35px;
		height: 21px;
		border-radius: 10.5px;
		border-top-left-radius: 10.5px;
		border-top-right-radius: 10.5px;
		border-bottom-right-radius: 10.5px;
		border-bottom-left-radius: 10.5px;
		background-color: #F2F2F2;
		-webkit-transition: -webkit-transform .3s;
		transition: -webkit-transform .3s;
		transition: transform .3s;
		transition: transform .3s, -webkit-transform .3s;
	}

	.my-switch:checked:before {
		-webkit-transform: scale(0);
		transform: scale(0);
	}

	.my-switch:after {
		content: " ";
		position: absolute;
		top: -0.5px;
		left: 0;
		width: 21px;
		height: 21px;
		border-radius: 10.5px;
		background-color: #FFFFFF;
		box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
		-webkit-transition: -webkit-transform .3s;
		transition: -webkit-transform .3s;
		transition: transform .3s;
		transition: transform .3s, -webkit-transform .3s;
	}

	.my-switch:checked:after {
		-webkit-transform: translateX(14px);
		transform: translateX(14px);
	}

</style>