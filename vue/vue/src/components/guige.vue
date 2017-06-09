<style scoped>
	.guige{
		padding:0.5rem;
		border-radius:0.3rem;
		background-color:#f2f2f2;
		color:#a3a3a3;
		text-align:center;
		display:inline-block;
		vertical-align:top;
		margin-bottom:0.5rem;
		margin-right:0.6rem;
		font-size:1.4rem;
	}

	.guige.disabled{
		background-color:#ccc;
		color:#fff;
	}

	.guige.active{
		background-color:#f9ad0c;
		color:#fff;
	}
</style>

<template>
	<div class="guige" :class="className">{{ text }}</div>
</template>

<script>
	export default{
		props: {
			value: {
				type: [String,Number],
				required: true
			},
			text: {
				type: String,
				default: ''
			}
		},
		data() {
			return {
				
			}
		},
		computed: {
			className() {
				const name = {};
				if(this.$parent.guige.indexOf(this.value) >= 0) {
					name['active'] = true;
				}else{
					name['active'] = false;

				}
				return name;
			}
		}
	}
</script>