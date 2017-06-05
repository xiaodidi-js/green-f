<style scoped>
	.wrapper{
		width:100%;
		padding:0rem 0rem 1rem 0rem;
		font-size:0;
		margin-bottom:25px;
		overflow: hidden;
	}

	.wrapper.nopadding{
		padding-bottom: 0;
	}

	.wrapper-top {
		margin-top: 166px;
	}

	.wrapper .title{
		display:block;
		margin:0.5rem 0rem 1rem 0rem;
		font-size:1.4rem;
		color:#F9AD0C;
		font-weight:normal;
		letter-spacing:1px;
		border-left:#F9AD0C solid 5px;
		padding-left:0.8rem;
	}

	.wrapper .ui_box {
		width: 47%;
		height: auto;
		background-color: #fff;
		display: block;
		float:left;
		font-size: 1.6rem;
		margin: 4px 5.5px;
		color: #333;
		box-shadow: 1px 1px 2px #e2e2e2;
	}

	.wrapper .ui_box:nth-child(even){
		margin-right:0%;
	}

	.wrapper .ui_box:nth-last-child(2),.wrapper .ui_box:last-child{
		margin-bottom:0%;
	}

	.parent{
		width:100%;
		height:auto;
		margin:0;
		padding:0;
	}

	.img{
		width:100%;
		background-position:center;
		background-size:cover;
		background-repeat:no-repeat;
	}

	.wrapper .ui_box .mes{
		padding:0.7rem 0.5rem;
	}

	.wrapper .ui_box .mes .name{
		font-size:1.4rem;
		color:#333;
		line-height:1.8rem;
		max-height:3.6rem;
		height:3.6rem;
		overflow:hidden;
		text-overflow:ellipsis;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		font-weight:600;
	}

	.mes .money{
		font-size:1.8rem;
		color:#F9AD0C;
	}

	.mes .money .unit{
		font-size:1.2rem;
		margin-right:0.2rem;
	}
</style>

<template>
	<template v-if="info.title">
		<div class="wrapper" style="padding-bottom: 100px;" :class="{'nopadding':noPadding}" >
			<label class="title">{{ info.title }}</label>
			<div class="parent">
				<div class="ui-box" v-link="{name:'detail',params:{pid:item.id}}" v-for="item in info.list">
					<div class="img" v-if="item.src == ''"></div>
					<div class="img" v-else>
						<img :src="item.src" alt="" style="width:100%;height:100%;" />
					</div>
					<div class="mes">
						<div class="name">{{ item.title }}</div>
						<div class="money">
							<label class="unit">¥</label>{{ item.price }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</template>
	<template v-else>
		<div class="wrapper" :class="{'nopadding':noPadding}" >
			<div class="ui_box" v-link="{name:'detail',params:{pid:item.id}}" v-for="item in info.list">
				<div class="img" v-if="item.src == ''"></div>
				<div class="img" v-else>
					<img :src="item.src" alt="" style="width:100%;height:100%;" />
				</div>
				<div class="mes">
					<div class="name">
						{{ item.title }}
					</div>
					<div class="money">
						<label class="unit">¥</label>{{ item.price }}
					</div>
				</div>
			</div>
		</div>
	</template>

	<!--<div class="wrapper" style="padding-bottom: 70px;" :class="{'nopadding':noPadding}">-->

		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--本地四季豆 500g/份-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--黑茄子 约500g/份 皮薄美味-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--本地四季豆 500g/份-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--黑茄子 约500g/份 皮薄美味-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--本地四季豆 500g/份-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--黑茄子 约500g/份 皮薄美味-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

			<!--<div class="ui_box">-->
				<!--<div class="img">-->
					<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--黑茄子 约500g/份 皮薄美味-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

		<!--<div class="ui_box">-->
			<!--<div class="img">-->
				<!--<img src="http://file.green-f.cn/2017/06/04/09/02/13/upload_ee6be3b84e9a1cb157db3f56b9c2cfc8.jpg" alt="" style="width:100%;height:100%;" />-->
			<!--</div>-->
			<!--<div class="mes">-->
				<!--<div class="name">-->
					<!--本地四季豆 500g/份-->
				<!--</div>-->
				<!--<div class="money">-->
					<!--<label class="unit">¥</label>99-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->

	<!--</div>-->


</template>

<script>
	export default{
		props: {
			info: {
				type: Object,
				required: true
			},
			noPadding: {
				type: Boolean,
				default: false
			}
		},
		data() {
			return {

			}
		}
	}
</script>