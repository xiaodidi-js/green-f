<style scoped>
	.mes-line{
		width:100%;
		height:auto;
		padding-bottom:1rem;
		margin-bottom:1rem;
		border-bottom:#EFEFEF dashed 1px;
		font-size:0;
	}

	.mes-line:last-child{
		border-bottom:none;
	}

	.mes-line .money,.mes-line .info,.mes-line .check{
		display:inline-block;
		vertical-align:middle;
	}

	.mes-line .money{
		width:20%;
		text-align:center;
		font-size:2.2rem;
		font-weight:bold;
		color:#f9ad0c;
		padding:3% 0%;
	}

	.mes-line .money .unit{
		font-size:1.4rem;
	}

	.mes-line .check{
		width:9.5%;
		text-align:right;
	}

	.mes-line .info{
		width:55%;
		text-align:left;
		margin:0% 3%;
		padding-left:3%;
		border-left:#EFEFEF solid 1px;
	}

	.mes-line .info>div{
		width:100%;
	}

	.mes-line .info>div.tit{
		font-size:1.4rem;
		color:#333;
	}

	.mes-line .info>div.type{
		font-size:1.2rem;
		color:#ccc;
	}

	.mes-line .info>div.date{
		font-size:1.2rem;
		color:#808080;
	}

	.nowrap{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}
</style>

<template>
	<div class="mes-line my-common-fadein" @click="changeActive">
		<div class="money" v-if="obj.type==1||obj.type==3">
			{{ obj.minus_money }}<label class="unit">元</label>
		</div>
		<div class="money" v-else>
			{{ disOff }}<label class="unit">折</label>
		</div>
		<div class="info">
			<div class="tit nowrap">{{ obj.title }}</div>
			<div class="type nowrap" v-if="obj.type==1||obj.type==2">无门槛</div>
			<div class="type nowrap" v-else>买满{{ obj.collect_money }}元可用</div>
			<div class="date nowrap">有效期至{{ obj.etime }}</div>
		</div>
		<div class="check">
			<icon type="success" class="my-icon-chosen" v-show="selSta"></icon>
			<icon type="circle" class="my-icon" @click="changeActive" v-show="!selSta"></icon>
		</div>
	</div>
</template>

<script>
	import Icon from 'vux/src/components/icon'

	export default{
		components: {
			Icon
		},
		props: {
			obj: {
				type: Object,
				required: true
			},
			choseId: {
				type: Number,
				default: 0
			}
		},
		data() {
			return {
				
			}
		},
		methods: {
			changeActive: function(evt){
				evt.preventDefault();
				evt.stopPropagation();
				if(this.obj.id==this.choseId){
					return true;
				}
				this.$dispatch('setChosen',this.obj);
			}
		},
		computed: {
			selSta: function(){
				if(this.obj.id===this.choseId){
					return true;
				}else{
					return false;
				}
			},
			disOff: function(){
				let offnum = 0;
				if(this.obj.type==2||this.obj.type==4){
					offnum = this.obj.discount.toFixed(2)*10;
					if(offnum%10===0){
						offnum = offnum/10;
					}
				}
				return offnum;
			}
		}
	}
</script>