<style scoped>
	.com-wrapper{
		width:100%;
		height:100%;
		background-color:#FFF;
		padding-bottom:5rem;
	}
	.card-box{
		width:97%;
		height:auto;
		border-bottom:#E6E6E6 dashed 1px;
	}
	.card-box .pro-mes{
		width:100%;
		padding: 5% 0% 5% 0%;
		border-bottom:#F2F2F2 1px solid;
		font-size:0;
	}
	.card-box .pro-mes:last-child{
		border-bottom:none;
	}
	.card-box:last-child{
		border-bottom:none;
	}
	.card-box .pro-mes .shotcut,.card-box .pro-mes .words{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
	}
	.card-box .pro-mes .shotcut{
		width:22%;
		margin-right:3%;
		height: 54px;
		background-color:#DDD;
		background-size:cover;
		background-position:center;
		background-repeat:no-repeat;
		overflow:hidden;
	}
	.card-box .pro-mes .words{
		width:75%;
	}
	.card-box .pro-mes .words .name{
		width:100%;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		overflow:hidden;
	}
	.card-box .pro-mes .words .format{
		width:100%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		font-size:1.2rem;
		color:#ccc;
	}
	.card-box .pro-mes .words .money{
		font-size:1.4rem;
		color:#F9AD0C;
		text-align:left;
		margin-top:0.7rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}
	.card-box .pro-mes .words .unit{
		font-size:1.2rem;
	}
	.card-box .pro-mes .com-text{
		width:96%;
		height:4rem;
		font-size:1.4rem;
		line-height:1.8rem;
		color:#333;
		background-color:#F2F2F2;
		margin:1rem 0rem;
		padding:2%;
		border-radius:0.3rem;
	}
</style>
<template>
	<div class="com-wrapper">
		<div class="card-box" v-for="item in products" style="width:95%;box-shadow: none;margin: 0px auto;">
			<div class="pro-mes">
				<div class="shotcut">
					<img :src="item.shotcut" style="width:100%;height:100%;" />
				</div>
				<div class="words">
					<div class="name">{{ item.name }}</div>
					<div class="format">{{ item.fname }}</div>
					<div class="money">
						<label class="unit">¥</label>
						{{ item.price }}
                    </div>
				</div>
			</div>
			<div class="pro-mes">
				<rater :value.sync="item.stars" :margin="20" active-color="#F9AD0C" :font-size="30" style="width:100%;text-align:center;"></rater>
				<textarea class="com-text" placeholder="请写下你对宝贝的感受" v-model="item.content"></textarea>
				<pic-uploader :imgs.sync="item.imgs" :toast-message.sync="toastMessage" :toast-show.sync="toastShow" :pid="$index" ftype="comimg"></pic-uploader>
			</div>
		</div>
	</div>
	<!-- toast提示框 -->
	<toast :show.sync="toastShow" type="text">{{ toastMessage }}</toast>
</template>
<script>
    import Rater from 'vux/src/components/rater'
    import PicUploader from 'components/pic-uploader'
    import Toast from 'vux/src/components/toast'
    export default{
        components:{
            Rater,
            PicUploader,
            Toast
        },
        props: {
            products: {
                type: Array,
                twoWay: true,
                default() {
                    return []
                }
            }
        },
        data() {
            return {
                toastMessage:'',
                toastShow:false
            }
        }
    }
</script>