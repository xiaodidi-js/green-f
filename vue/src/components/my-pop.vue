<style scoped>
	.masker{
		position:fixed;
		top:0;
		left:0;
		width:0%;
		height:0%;
		z-index:1000;
		background-color:transparent;
	}

	.masker.show{
		width:100%;
		height:100%;
		background-color:rgba(0,0,0,0.6);
		display:block;
		transition:background .6s;
		-webkit-transition:background .6s;
	}

	.panel{
		position:fixed;
		bottom:0;
		left:0;
		width:100%;
		max-height:100%;
		z-index:5000;
		transform:translateY(100%);
		-webkit-transform:translateY(100%);
		backface-visibility:hidden;
		-webkit-backface-visibility:hidden;
		-webkit-transition:-webkit-transform .3s;
		transition:transform .3s,-webkit-transform .3s;
		background-color:#FFF;
	}

	.panel.show{
		transform:translate(0);
		-webkit-transform:translate(0);
	}

	.panel .con-box{
		width:94%;
		padding:0% 3% 0% 3%;
		max-height:20rem;
		overflow-x:hidden;
		overflow-y:scroll;
		-webkit-overflow-scrolling:touch;
		margin-bottom:5%;
	}

	.panel .title{
		width:100%;
		font-size:1.6rem;
		color:#333;
		letter-spacing:0.2rem;
		text-align:center;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		padding-bottom:5%;
		background-color:#fff;
		padding-top:5%;
	}

	.panel .btn{
		width:100%;
		padding:3% 0%;
		background-color:#f9ad0c;
		text-align:center;
		font-size:1.6rem;
		color:#fff;
		letter-spacing:0.2rem;
	}

	.my-icon:before{
		font-size:1.6rem;
		color:#f26c60;
		margin-right:0.3rem;
		line-height:1.9rem;
	}

	.mes-line{
		width:100%;
		height:auto;
		padding-bottom:0.8rem;
		margin-bottom:0.8rem;
		border-bottom:#EFEFEF solid 1px;
		font-size:0;
	}

	.mes-line:last-child{
		border-bottom:none;
	}

	.mes-line .tick,.mes-line .tips-title{
		display:inline-block;
		vertical-align:top;
	}

	.mes-line .tick{
		width:10%;
	}

	.mes-line .tips-title{
		width:90%;
		font-size:1.4rem;
		color:#333;
	}

	.mes-line .desc{
		width:90%;
		margin-left:10%;
		font-size:1.4rem;
		color:#b3b3b3;
	}
</style>

<template>
	<div class="masker" :class="{'show':show}" @click="hidePanel" @touchmove.stop.prevent @touchend.stop @touchstart.stop></div>
	<div class="panel" :class="{'show':show}" @touchmove.stop.prevent @touchend.stop @touchstart.stop>
		<div class="title">{{ title }}</div>
		<div class="con-box" v-on:touchmove="conMove">
			<div class="mes-line" v-for="item in service">
				<div class="tick">
					<icon type="success_circle" class="my-icon"></icon>
				</div>
				<div class="tips-title">
					{{ item.title }}
				</div>
				<div class="desc" v-if="item.sdesc">
					{{ item.sdesc }}
				</div>
			</div>
		</div>
		<div class="btn" v-if="showConfirm" @click="hidePanel">{{ confirmText }}</div>
	</div>
</template>

<script>
	import Icon from 'vux/src/components/icon'

	export default{
		components: {
			Icon
		},
		props: {
			show: {
				type:Boolean,
				required:true,
				twoWay:true
			},
			title: {
				type: String,
				default: '系统信息'
			},
			showConfirm: Boolean,
		    confirmText: {
			    type: String,
			    default: '确定'
		    },
		    service: {
		    	type: Array,
		    	default() {
		    		return []
		    	}
		    }
		},
		data() {
			return {
				
			}
		},
		methods: {
			"hidePanel": function(){
				this.show = false;
			},
			"conMove": function(evt){
				evt.stopPropagation();
			}
		}
	}
</script>