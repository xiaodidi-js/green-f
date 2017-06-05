<style scoped>
	.wrapper{
		width:100%;
		/*padding:0rem 0rem 1rem 0rem;*/
		font-size:0;
	}

	.title{
		display:block;
		margin:0.5rem 0rem 1rem 0rem;
		font-size:1.4rem;
		color:#F9AD0C;
		font-weight:normal;
		letter-spacing:1px;
		border-left:#F9AD0C solid 5px;
		padding-left:0.8rem;
	}

	.card-box{
		width:90%;
		height:auto;
		margin:0% 3% 2% 3%;
		display:block;
		padding:2%;
		text-align:center;
	}

	.card-box:last-child{
		margin-bottom:0%;
	}

	.card-box .img{
		width:100%;
		max-width:100%;
		height:auto;
		margin-bottom:0.5rem;
		background-color:#eee;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		overflow:hidden;
	}

	.card-box .mes{
		width:100%;
		max-width:100%;
		overflow:hidden;
		position:relative;
	}

	.card-box .mes .words{
		width:70%;
		overflow:hidden;
		font-size:1.6rem;
		text-align:left;
	}

	.card-box .mes .words .name{
		color:#333;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.card-box .mes .words .desc{
		color:#B3B3B3;
		font-size:1.4rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.card-box .mes .words .proname{
		color:#B3B3B3;
		font-size:1.2rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.card-box .mes .words .proname label{
		color:#F9AD0C;
		margin-left:1rem;
	}

	.card-box .mes .reading{
		color:#B3B3B3;
		font-size:1.2rem;
		width:27%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		position:absolute;
		top:0;
		right:0;
		text-align:right;
	}
</style>

<template>
	<div class="wrapper">
		<label class="title" v-if="articles.title">{{ articles.title }}</label>
		<div class="card-box" v-for="item in articles.list" v-link="{name:'article',params:{cid:item.id}}">
			<img v-lazy="item.img" class="img" alt="{{ item.title }}" />
			<div class="mes">
				<div class="words">
					<div class="name">{{ item.title }}</div>
					<div class="desc">
						{{ item.sdesc }}
					</div>
					<div class="proname">
						{{ item.proname }}<label>¥{{ item.proprice }}</label>
					</div>
				</div>
				<div class="reading">
					阅读量{{ item.reading }}
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		props: {
			articles: {
				type: Object,
				default() {
					return {}
				}
			}
		},
		data() {
			return {
				
			}
		}
	}
</script>