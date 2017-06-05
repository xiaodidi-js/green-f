<style scoped>
	.wrapper{
		width:92%;
		height:auto;
		margin:4%;
		text-align:left;
		font-size:0;
	}

	.wrapper .cbox,.wrapper .wbox{
		display:inline-block;
		vertical-align:top;
		font-size:1.5rem;
	}

	.wrapper .cbox{
		width:5%;
		margin-right:1%;
	}

	.wrapper .wbox{
		width:94%;
		color:#B3B3B3;
		padding-top:0.1rem;
	}

	.wrapper .wbox a{
		color:#F9AD0C;
	}

	.my-icon:before{
		font-size:1.8rem;
	}

	.my-icon-chosen:before{
		color:#f9ad0c;
	}

</style>

<template>
	<div class="wrapper" @click="changeStatus">
		<div class="cbox">
			<icon type="success" class="my-icon my-icon-chosen" v-show="status"></icon>
			<icon type="circle" class="my-icon" v-show="!status"></icon>
		</div>
		<div class="wbox">
			&nbsp;<label>{{ title }}<a v-if="desc != ''" style="color:#81c429">{{ desc }}</a></label>
		</div>
	</div>
</template>

<script>
import Icon from 'vux/src/components/icon'

export default{
	props: {
		title: {
			type: String,
			required: true
		},
		desc: {
			type: String,
			required: false
		},
		status: {
			type: Boolean,
			twoWay: true,
			default: false
		}
	},
	components:{
		Icon
	},
	data() {
		return {

		}
	},
	methods: {
		changeStatus: function(){
			if(this.status === true){
				this.status = false;
			}else{
				this.status = true;
			}
		}
	}
}
</script>