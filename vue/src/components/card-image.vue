<template>
	<div class="wrapper-ele" style="">
		<div class="wrapper cardImage">
			<!--<label class="title" v-if="articles.title">{{ articles.title }}</label>-->
			<div class="card-box" style="width:95%;" v-for="item in list" v-link="{name:'article',params:{cid:item.id}}">
				<!--<div class="img" v-lazy:background-image="item.img"></div>-->
				<img :src="item.img" class="img" alt="{{ item.title }}" />
				<div class="mes">
					<div class="words">
						<div class="name">{{ item.title }}</div>
						<!--<div class="desc">-->
						<!--{{ item.sdesc }}-->
						<!--</div>-->
						<!--<div class="proname">-->
						<!--{{ item.proname }}<label>¥{{ item.proprice }}</label>-->
						<!--</div>-->
					</div>
					<div class="reading">
						<span>{{ item.createtime | time }}</span>
						<!--<span>阅读量</span>-->
						<!--<span>{{ item.reading }}</span>-->
					</div>
				</div>
			</div>
			<div class="card-box"></div>
		</div>
	</div>
</template>

<script>

    import axios from 'axios'
    import qs from 'qs'

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
				list: []
			}
		},
		ready () {
			this.message();
		},
        filters: {
            time: function (value) {
                let d = new Date(parseInt(value) * 1000);
                var years = d.getFullYear();
                var month = d.getMonth() + 1;
                var days = d.getDate();
                var hours = d.getHours();
                var minutes = d.getMinutes();
                var seconds = d.getSeconds();
                return years + "-" + month + "-" + days;
            }
        },
        watch: {
            $route() {
                $(window).scrollTop(sessionStorage.getItem("scrolltop"));
            }
        },
		methods: {
		    message () {
				let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                var content = this;
                if(ustore == null) {
                    alert("没有登录，请先登录！");
                    setTimeout(function () {
                        content.$router.go({name: 'login'});
                    }, 800);
                    return false;
				}
				this.$getData('/index/index/productinfo/uid/' + ustore.id + '/pid/' + this.$route.query.pid).then((res) => {
                    if(typeof(res.articles) == 'undefined') {
                        $(".card-box").html("" +
                            "<div>暂时没有活动!</div>").css({
                            "lineHeight" : "30px",
                            "fontSize" : "26px",
                            "color" : "#333",
                            "textAlign" : "center",
                            "margin" : "150px auto",
                        });
                    } else {
                        this.list = res.articles.list;
                    }
				});
			}
		}
	}
	</script>

<style scoped>

	.wrapper-ele {
		background: #fff;
		width: 100%;
		height: 100%;
		position: relative;
		top: 45px;
	}

	.wrapper{
		width:100%;
		font-size:0;
	}

	.cardImage {
		background: #fff;
		position: absolute;
		padding-bottom: 70px;
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
		display:block;
		padding:2%;
		text-align:center;
	}

	.card-box:last-child{
		margin-bottom:0%;
	}

	.card-box .img{
		width:100%;
		height:auto;
		margin-bottom:0.5rem;
		background-color:#eee;
		background-repeat:no-repeat;
		background-position:center;
		background-size:cover;
		overflow:hidden;
	}

	.card-box .mes{
		width: 100%;
		max-width: 100%;
		overflow: hidden;
		position: relative;
		height: 3.5rem;
		line-height: 3.5rem;
	}

	.card-box .mes .activity-data {
		float:right;
		line-height:30px;
		margin-right:23px;
		color:#666;
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
		font-size:1.4rem;
		width:45%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		position:absolute;
		top:0;
		right:0;
		text-align:right;
	}
</style>