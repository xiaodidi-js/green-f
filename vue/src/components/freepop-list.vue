<template>
	<div class="mes-line my-common-fadein" :class="{'isChonse':obj.id == this.choseId}">
		<div class="edit" v-link="{name:'address-edit',params:{aid:obj.id}}" v-if="$parent.getType=='express'">
			<img src="../images/add-edit.png" />
		</div>
		<div class="addcon" @click="changeActive()" v-if="$parent.getType=='express'">
			<div class="name nowrap">
				<div class="default" v-if="obj.is_default === 1">默认</div>
				<p style="line-height: 22px;">
					<span class="address-left">地址:</span>
					<span>{{ obj.name }}</span>
				</p>
				<p style="line-height: 22px;">
					<span class="address-left">地点:</span>
					<span>{{ obj.tel }}</span>
				</p>
			</div>
			<div class="address nowrap">
				{{ obj.address  }}
			</div>
		</div>
		<div class="addcon noicon" @click="changeActive" v-else>
			<div class="name nowrap">
				<div class="default" v-if="obj.is_default === 1">默认</div>
				<p style="line-height: 22px;">
					<span class="address-left">地址:</span>
					<span>{{ obj.name }}</span>
				</p>
				<p style="line-height: 22px;">
					<span class="address-left">地点:</span>
					<span>{{ obj.tel }}</span>
				</p>
			</div>
			<div class="address nowrap">
				<p style="line-height: 22px;">
					<span>详细地址</span>
					<span>{{ obj.address  }}</span>
				</p>
			</div>
		</div>
		<div class="check">
			<icon type="success" class="my-icon-chosen" v-show="selSta"></icon>
			<icon type="circle" class="my-icon" @click="changeActive" v-show="!selSta"></icon>
		</div>
	</div>
</template>

<script>
	import Icon from 'vux/src/components/icon'
    import { myGift } from 'vxpath/actions'
    import axios from 'axios'
    import qs from 'qs'

	export default{
		components: {
			Icon
		},
        vuex: {
            getters: {

            },
            actions: {
                myGift
            }
        },
		props: {
			obj: {
				type: Object,
				required: true
			},
			choseId: {
				type: Number,
				default: 0
			},
            sumMoney: {
                type: [String,Number],
                default: 0
			},
            title: {
			    type: String,
				default: '',
			}
		},
		data() {
			return {
                ischonse: false,
			}
		},
		computed: {
			selSta: function(){
                if(this.obj.id === this.choseId) {
					return true;
				}else{
					return false;
				}
			}
		},
		ready () {

		},
		methods: {
			changeActive: function(evt){
//                this.oneGift(this.choseId,this.sumMoney);
			    this.ischonse = true;
				evt.preventDefault();
				evt.stopPropagation();
				this.$dispatch('setChosen',this.obj);
			}
		}
	}
</script>

<style scoped>
	.mes-line{
		width:100%;
		height:auto;
		/*padding-bottom:0.5rem;*/
		/*margin-bottom:0.5rem;*/
		border-bottom:#EFEFEF solid 1px;
		font-size:0;
		background: #fff;
		padding: 10px 0px;
		margin: 5px 0px;
	}

	.mes-line .addcon .address{
		width:100%;
		color:#808080;
	}

	.isChonse{
		width:100%;
		height:auto;
		border-bottom:#EFEFEF solid 1px;
		font-size:0;
		padding: 10px 0px;
		margin: 5px 0px;
		background: #81c429;
	}

	.isChonse .addcon .name {
		color:#fff;
	}

	.isChonse .addcon .address {
		color:#fff;
	}

	.mes-line:last-child{
		border-bottom:none;
	}

	.mes-line .edit,.mes-line .addcon,.mes-line .check{
		display:inline-block;
		vertical-align:middle;
	}

	.mes-line .edit,.mes-line .check{
		width:10%;
		text-align:center;
	}

	.mes-line .edit>img {
		width:75%;
		height:auto;
	}

	.mes-line .addcon{
		width:76%;
		font-size:1.4rem;
		color:#333;
		padding:0% 2%;
		line-height:1.5rem;
	}

	.mes-line .addcon.noicon{
		width:86%;
	}

	.mes-line .addcon .default{
		display: inline-block;
		vertical-align: middle;
		color: #fff;
		background-color: #f9ad0c;
		font-size: 1.4rem;
		border-radius: 0.2rem;
		padding: 3px 6px;
		line-height: 1.4rem;
		/* margin-right: 0.3rem; */
	}

	.mes-line .addcon .name{
		width:100%;
		margin-bottom:0.5rem;
	}

</style>