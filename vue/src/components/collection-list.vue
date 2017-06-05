<style scoped>
	.card-box{
		width:90%;
		height:auto;
		margin:0% auto 3% auto;
		background-color:#fff;
		display:block;
		font-size:0;
		color:#333;
		box-shadow:1px 1px 2px #e2e2e2;
		padding:2%;
		border:#FFF 0.2rem solid;
	}

	.card-box.active{
		border:#81c429 0.2rem solid;
	}

	.card-box:first-child{
		margin-top:3%;
	}

	.card-box .img{
		display:inline-block;
		vertical-align:middle;
		width:30%;
		margin-right:2%;
		background-color:#eee;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
	}

	.card-box .mes{
		display:inline-block;
		vertical-align:middle;
		width:68%;
		font-size:1.4rem;
	}

	.card-box .mes .name{
		color:#4D4D4D;
		line-height:1.6rem;
		white-space:nowrap;
		overflow:hidden;
		text-overflow:ellipsis;
		font-weight:normal;
		margin-bottom:6%;
		font-weight:600;
	}

	.card-box .mes .money{
		font-size:1.8rem;
		color:#F9AD0C;
		position:relative;
		margin-bottom:6%;
	}

	.card-box .mes .money .unit{
		font-size:1.4rem;
		margin-right:0.3rem
	}

	.card-box .mes .money .rush{
		position:absolute;
		bottom:0;
		right:0;
		padding:0.3rem 0.8rem;
		font-size:1.2rem;
		color:#fff;
		background-color:#F9AD0C;
		border-radius:0.3rem;
		text-align:center;
	}

	.card-box .mes .money .rush:active{
		background:#DE9A08;
	}

	.card-box .mes .money .rush.disabled{
		background:#F3C76A;
	}

	.card-box .mes .status{
		width:100%;
		height:auto;
		font-size:1.4rem;
		line-height:2rem;
		color:#CCC;
		position:relative;
		text-align:left;
	}

	.card-box .mes .status .del{
		width:1.6rem;
		height:1.6rem;
		position:absolute;
		top:0.2rem;
		right:0rem;
		background-image:url('../images/del2.png');
		background-position:center;
		background-size:contain;
		background-repeat:no-repeat;
	}
</style>

<template>
	<div class="card-box" @click="changeActive" :class="className" v-link="{name:'detail',params:{pid:pid}}">
		<div class="img">
			<img :src="img" alt="" style="width:100%;height: 100%;" />
		</div>
		<div class="mes">
			<div class="name">{{ pname }}</div>
			<div class="money">
				<label class="unit">¥</label>{{ pprice }}
			</div>
			<div class="status">
				<label v-if="pstore>=1">有货</label><label v-else>缺货</label>
				<div class="del" v-show="mode !== 1" @click="setDel"></div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props: {
			mode: {
				type: Number,
				required: true
			},
			chosen: {
				type: Array,
				twoWay: true,
				required: true
			},
			cid: {
				type: Number,
				required: true
			},
			pid: {
				type: Number,
				required: true
			},
			img: {
				type: String,
				required: true
			},
			pname: {
				type: String,
				required: true
			},
			pprice: {
				type: [Number,String],
				required: true
			},
			pstore: {
				type: Number,
				default: 0
			}
		},
		data() {
			return {
				
			}
		},
		computed: {
			className: function(){
				const obj = {};
				if(this.chosen.length>0&&this.chosen.indexOf(this.cid)>=0&&this.mode===1){
					obj['active'] = true;
				}else{
					obj['active'] = false;
				}
				return obj;
			}
		},
		methods: {
			changeActive: function(evt){
				if(this.mode!==1){
					return false;
				}
				evt.preventDefault();
				evt.stopPropagation();
				let getIndex = this.chosen.indexOf(this.cid);
				if(getIndex>=0){
					this.chosen.splice(getIndex,1);
				}else{
					this.chosen.push(this.cid);
				}
			},
			setDel: function(evt){
				evt.preventDefault();
				evt.stopPropagation();
				this.$dispatch('setDel',this.cid);
			}
		}
	}
</script>