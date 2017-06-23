<template>
	<div class="card-box" :class="className">
		<!--<div class="addition" v-if="store == 0"></div>-->
		<div class="addition">
			<icon type="success" class="my-icon-chosen" @click="unActIt()" v-show="showVal"></icon>
			<icon type="circle" class="my-icon" @click="actIt()" v-show="!showVal"></icon>
		</div>
		<div class="maininfo">
			<div class="img"  v-link="{name:'detail',params:{pid:pid}}"  v-if="store == 0"> <!-- v-lazy:background-image="img" -->
				<div class="overtext">已售罄</div>
				<div v-lazy:background-image="img" class="lazyImg"></div>
			</div>
			<div class="img"  v-link="{name:'detail',params:{pid:pid}}" v-else> <!-- v-lazy:background-image="img" -->
				<div v-lazy:background-image="img" class="lazyImg"></div>
			</div>
			<div class="mes">
				<div class="name">{{ pname }}</div>
				<div class="format" v-if="pfname == ''">&nbsp;</div>
				<div class="format" v-else>{{ pfname }}</div>
				<div class="money">
					<label class="unit">¥</label>{{ pprice }}
				</div>
				<div class="del" v-show="mode === 1" @click.stop="setDel()"></div>
				<div class="status">
					<div class="num-counter" style="float:left;">
						<button class="btns" :class="{'disabled':pnums <= 0}" @click.stop="rdcNums()"> - </button>
						<input type="number" class="input" :value="pnums" @click.stop @touchstart.stop readonly />
						<button class="btns" :class="{'disabled':pnums >= pstore}" @click.stop="addNums()"> + </button>
					</div>
					<div class="elestore" style="">
						<span>库存</span>
						<span>{{ store }}</span>
					</div>

				</div>
			</div>
		</div>
		<div class="addition aw" v-show="mode !== 1" v-link="{name:'detail',params:{pid:pid}}">
			<img src="../images/arrow.png" />
		</div>
	</div>
	<!-- 确定弹框 -->
	<confirm :show.sync="confirmShow" title="删除商品" confirm-text="确定" cancel-text="取消" @on-confirm="confirmDel">
		<p style="text-align:center;">确定删除该商品吗？</p>
	</confirm>
</template>

<script>
	import Icon from 'vux/src/components/icon'
	import Confirm from 'vux/src/components/confirm'
	import { increNums,reduceNums,delSingle } from 'vxpath/actions'

	export default{
		vuex: {
			actions: {
				increNums,
				reduceNums,
				delSingle,
			}
		},
		components: {
			Icon,
			Confirm,
		},
		props: {
			mode: {
				type: Number,
				required: true
			},
			pid: {
				type: [Number,String],
				required: true
			},
			chosen: {
				type: Array,
				twoWay: true,
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
			pnums: {
				type: [Number,String],
				required: true
			},
			pstore: {
				type: Number,
				default: 0
			},
			pformat: {
				type: String,
				default: ''
			},
			pfname: {
				type: String,
				default: ''
			},
            pdelivery: {
			    type: [Number,String],
				default: ''
			},
            peisongok: {
			    type: [Number,String],
				default: ''
			},
            store: {
			    type: [Number,String],
				default: ''
			},
            activepay: {
                type: Number,
                default: 0
			},
            activestu: {
                type: Number,
                default: 0
			}
		},
		data() {
			return {
				confirmShow: false,
                storeHidden: true,
			}
		},
		computed: {
			className: function(){
				const obj = {};
				if(this.chosen.length > 0) {
					for(let ch = 0;ch < this.chosen.length; ch++) {
						if(this.chosen[ch].id == this.pid && this.chosen[ch].format == this.pformat) {
							obj['active'] = true;
							break;
						} else {
							obj['active'] = false;
						}
					}
				}else{
					obj['active'] = false;
				}
				return obj;
			},
			showVal: function(){
				if(this.className.active){
					return true;
				}else{
					return false;
				}
			}
		},
		ready () {

		},
		methods: {
			actIt: function(){
				if(!this.className.active){
					this.chosen.push({
						id:this.pid,
						format:this.pformat
					});
				}
			},
			unActIt: function(){
				if(this.className.active){
					let getIndex = null;
					for(let ch = 0;ch < this.chosen.length; ch++) {
						if(this.chosen[ch].id == this.pid && this.chosen[ch].format == this.pformat) {
							getIndex = ch;
							break;
						}
					}
					if(getIndex >= 0) {
						this.chosen.splice(getIndex,1);
					}
				}
			},
			setDel: function() {
				this.confirmShow = true;
			},
			addNums: function() {
				if(this.pnums < this.pstore) {
					this.increNums(this.pid,this.pformat);
				}
			},
			rdcNums: function(evt) {
				if(this.pnums > 0) {
					if(this.pnums == 1) {
						this.setDel();
					}else{
						this.reduceNums(this.pid,this.pformat);
					}
				}
			},
			confirmDel: function(){
			    console.log(this.pid,this.pformat);
				this.delSingle(this.pid,this.pformat);
			}
		}
	}
</script>


<style scoped>
	.card-box{
		width:96%;
		height:auto;
		margin:auto;
		background-color:#fff;
		display:block;
		font-size:0;
		color:#333;
		box-shadow:1px 1px 2px #e2e2e2;
		padding:2%;
		border-bottom:#f2f2f2 solid 1px;
	}

	.card-box:last-child{
		border-bottom:none;
	}

	.card-box .maininfo,.card-box .addition{
		display:inline-block;
		vertical-align:middle;
		width:84%;
	}

	.card-box .addition{
		width:10%;
		text-align:center;
	}

	.card-box .addition.aw{
		width:6%;
	}

	.card-box .addition.aw>img{
		width:40%;
		height:auto;
	}

	.card-box .maininfo .img{
		display:inline-block;
		vertical-align:middle;
		width:33%;
		height: auto;
		margin-right:2%;
		background-color:#eee;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		position: relative;
	}

	.card-box .maininfo .img .lazyImg {
		width:100%;
		padding-top:100%;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
	}

	.card-box .maininfo .img .overtext {
		width:100%;
		height:100%;
		text-align:center;
		line-height:8.4rem;
		background: rgba(0,0,0,0.5);
		position: absolute;
		top:0px;
		left:0px;
		font-size:16px;
		color:#fff;
		z-index: 100;
	}

	.card-box .maininfo .mes{
		display:inline-block;
		vertical-align:middle;
		width:65%;
		position: relative;
		font-size:1.4rem;
	}

	.card-box .maininfo .mes .name{
		color:#4D4D4D;
		line-height:1.6rem;
		white-space:nowrap;
		overflow:hidden;
		text-overflow:ellipsis;
		font-weight:normal;
		margin-bottom:2%;
		font-weight:600;
	}

	.card-box .maininfo .mes .format{
		color:#d4d4d4;
		line-height:1.2rem;
		font-size:1.2rem;
		white-space:nowrap;
		overflow:hidden;
		text-overflow:ellipsis;
		font-weight:normal;
		margin-bottom:2%;
	}

	.card-box .maininfo .mes .money{
		font-size:1.6rem;
		color:#F9AD0C;
		position:relative;
		margin-bottom:2%;
		float:left;
	}

	.card-box .maininfo .mes .money .unit{
		font-size:1.2rem;
		margin-right:0.3rem
	}

	.card-box .maininfo .mes .status{
		width:100%;
		height:auto;
		font-size:1.4rem;
		line-height:2rem;
		color:#CCC;
		position:relative;
		text-align:left;
		clear: both;
	}

	.card-box .maininfo .mes .del{
		width:1.6rem;
		height:1.6rem;
		position:absolute;
		top: 3.9rem;
		right: 0rem;
		background-image:url('../images/del2.png');
		background-position:center;
		background-size:contain;
		background-repeat:no-repeat;
	}

	.my-icon:before{
		color:#ccc;
	}

	.my-icon-chosen:before{
		color:#f9ad0c;
	}

	.num-counter{
		width:51%;
		height:auto;
		text-align:left;
		font-size:0;
		overflow:hidden;
	}

	.num-counter .btns{
		display: inline-block;
		vertical-align: top;
		width: 2rem;
		height: 2.7rem;
		line-height: 2.5rem;
		font-size: 1.2rem;
		font-weight: bold;
		color: #333;
		border: #CACACA solid 1px;
		text-align: center;
		background: #fff;
	}

	.num-counter .btns.disabled{
		color:#c8c8cd;
	}

	.status .elestore {
		float:left;
		line-height: 27px;
		padding-left: 5px;
		color: #333;
	}

	.num-counter .btns.disabled:active{
		background-color:#fff;
	}

	.num-counter .btns:active{
		background:#81c429;
		color:#fff;
	}

	.num-counter .input{
		display:inline-block;
		vertical-align:top;
		width:4.5rem;
		height:2.5rem;
		line-height:2.5rem;
		font-size:1.2rem;
		color:#333;
		border-top:#CACACA solid 1px;
		border-bottom:#CACACA solid 1px;
		text-align:center;
		border-radius:0;
	}
</style>