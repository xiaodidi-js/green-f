<style scoped>
	.fixed{
		position:fixed;
		bottom:0;
		left:0;
	}

	.bottom-send{
		box-sizing:border-box;
		width:100%;
		padding:0rem 0.8rem;
		height:4.5rem;
		max-height:4.5rem;
		overflow:hidden;
		background-color:#F2F2F2;
	}

	.stext{
		width:66%;
		padding:0% 2%;
		height:3.3rem;
		margin:0.6rem 0rem;
		border-radius:0.3rem;
		box-shadow:0.1rem 0.1rem 0.1rem #e4e4e4 inset;
		-webkit-box-shadow:0.1rem 0.1rem 0.1rem #e4e4e4 inset;
		-moz-box-shadow:0.1rem 0.1rem 0.1rem #e4e4e4 inset;
		font-size:1.6rem;
		line-height:1.6rem;
		vertical-align:middle;
	}

	.sbtn{
		margin-left:1%;
		width:27%;
		height:3.3rem;
		border:none;
		border-radius:0.3rem;
		box-shadow:0.1rem 0.1rem 0.1rem #e4e4e4;
		-webkit-box-shadow:0.1rem 0.1rem 0.1rem #e4e4e4;
		-moz-box-shadow:0.1rem 0.1rem 0.1rem #e4e4e4;
		background-color:#f9ad0c;
		color:#fff;
		font-size:1.6rem;
		vertical-align:middle;
	}

	.sbtn:active{
		background-color:#E29D0A;
	}

	.sbtn.disabled{
		background-color:#ffc344;
	}
</style>

<template>
	<div class="bottom-send" :class="{'fixed':fixed}">
		<input type="text" class="stext" v-model="text">
		<button class="sbtn" :class="{'disabled':disbtn}" @click="clickBtn">发送</button>
	</div>
</template>

<script>
	export default{
		props: {
			fixed: {
				type: Boolean,
				default: false
			},
			text: {
				type: String,
				twoWay: true,
				required: true
			},
			disbtn: {
				type: Boolean,
				default: false
			}
		},
		data() {
			return {
				
			}
		},
		methods: {
			clickBtn: function(){
				if(this.disbtn){
					return false;
				}
				this.$dispatch('sendMes',this.text);
			}
		}
	}
</script>