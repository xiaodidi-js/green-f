<template>
	<separator :set-height="9.1"></separator>
	<!-- 订单状态 -->
	<div class="bl-info-box status">
		<!--<div class="icon">-->
			<!--<img src="{{ orderImage }}" style="width:100%;height:100%;"/>-->
		<!--</div>-->
		<div class="content">
			<div class="sta-line">
				<label class="stit">订单状态：</label>
				<label class="stat">{{ state }}</label>
			</div>
			<div class="sta-line">
				配送公司：{{ distribution }}
			</div>
			<div class="sta-line">
				快递单号：{{ orderNumber }}
			</div>
		</div>
	</div>

	<!-- 配送司机信息 -->
	<div class="driver">
		<div class="driver-img">
			<img src="../images/img33.png" alt="" style="width:100%;height:100%;" />
		</div>
		<div class="driver-text">
			<p style="color: #898989;">派送员</p>
			<p>{{ person }}</p>
		</div>
		<div class="driver-call">
			<a href="tel:{{phone}}" style="display:">
				<div class="call" @click="callPerson()">
					<img src="../images/call.png" alt="" style="width:100%;height:100%;" />
				</div>
				<div class="allow"></div>
			</a>
		</div>
	</div>

	<!-- 物流信息 -->
	<div style="background: #fff;width: 100%;height: 100%;position: relative;top: 10px;">
		<div class="express-box">
			<div class="line-info">
				<div class="icon first">
					<img src="../images/epoint.png" />
				</div>
				<div class="con-box">
					<div class="ebtit">
						佛山市[签收]佛山市【顺德大良B站】，李代已签收
                    </div>
					<div class="ebtime">
						2016-07-04 18:20:59
                    </div>
				</div>
			</div>
			<div class="line-info">
				<div class="icon">
					<img src="../images/expoint.png" />
				</div>
				<div class="con-box">
					<div class="ebtit">
						佛山市[签收]佛山市【顺德大良B站】，李代已签收
                    </div>
					<div class="ebtime">
						2016-07-04 18:20:59
                    </div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>

	import Separator from 'components/separator'

	export default{
		components: {
			Separator
		},
		data() {
			return {
//				doDay: 0,
				state: '',			//	状态
                distribution: '',	//	公司名
                orderNumber: '',	//	订单号
				person: '',			//	派件人
				phone: 0,			//	电话号码
				orderImage: '',
                options: [],		//	订单列表
				rid: 0,
				oid: 0,				//	订单ID
			}
		},
		ready() {
			this.express();
		},
        watch: {
            '$route'(to) {
                if(to.name === 'express') {
                    this.express();
				}
            }
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
                return years + "-" + month + "-" + days + " " + (hours > 9 ? hours : '0' + hours) + ':' + (minutes > 9 ? minutes : '0' + minutes);
            }
        },
		methods: {
			express() {
                var lists = JSON.parse(localStorage.getItem('orderList'));
				for(var i in lists) {
				    this.rid = lists[i].rid;
					this.state = lists[i].state;
					this.doDay = lists[i].stime;
                    this.distribution = lists[i].distribution;
                    this.orderNumber = lists[i].orderNumber;
                    this.phone = lists[i].phone;
                    this.person = lists[i].person;
					this.options = lists[i].order;
					console.log(this.doDay);
					for(var y in this.options) {
					    this.oid = this.options[y].id;
					    console.log(this.options[y].id);
					}
				}
			    this.$getData('/index/app/getdelivery/uid/' + this.$ustore.id + "/rid/" + this.rid + "/stime/" + this.doDay + "/oid/" + this.oid).then((res) => {
                    console.log(res);
                    if(res.status === 0) {
						$(".express-box").html(res.info).css({
							"fontSize" : "1.6rem",
							"textAlign" : "center",
						});
					}
				});
			}
		}
	}
</script>

<style scoped>
	.bl-info-box{
		width: 100%;
		padding: 0.8rem 0%;
		background-color: #fff;
		margin-bottom: 3%;
		font-size: 1.4rem;
		position: fixed;
		top: 46px;
		left: 0;
		z-index: 100;
	}

	.bl-info-box.status{
		font-size:0;
		text-align:left;
	}

	.bl-info-box.status .icon,.bl-info-box.status .content{
		display:inline-block;
		vertical-align:top;
		font-size:1.4rem;
	}

	.bl-info-box.status .icon{
		width: 23%;
		height: 70px;
		margin-right: 2%;
		text-align: center;
		float: left;
	}

	.bl-info-box.status .icon>img{
		width:80%;
		height:auto;
	}

	.bl-info-box.status .content {
		width: 90%;
		padding: 0px 5%;
	}

	.bl-info-box.status .content .sta-line{
		width:100%;
		height:2rem;
		line-height:2rem;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		color:#808080;
		padding-bottom:0.5rem;
	}

	.bl-info-box.status .content .sta-line:last-child{
		padding-bottom:0%;
	}

	.bl-info-box.status .content .sta-line .stit{
		color:#333;
	}

	.bl-info-box.status .content .sta-line .stat{
		color:#fa9d0c;
	}

	/* driver start */
	.driver {
		width: 100%;
		height: 7rem;
		background: #fff;
		margin: 50px 0px 0px;
	}

	.driver .driver-img {
		width: 44px;
		height: 44px;
		padding: 13px 15px;
		float: left;
	}

	.driver .driver-text {
		font-size: 1.4rem;
		padding: 16px 0px;
		float: left;
	}

	.driver .driver-call {
		float: right;
	}

	.driver .driver-call .call {
		width: 35px;
		height: 35px;
		padding: 18px;
		float: left;
		position: relative;
		right: 28px;
	}

	.driver .driver-call .allow {
		width: 10px;
		height: 18px;
		background: url("../images/img34.png") no-repeat;
		background-size: 100%;
		float: right;
		margin: 26px 0px;
		position: relative;
		right: 20px;
	}

	/* driver end */

	.express-box{
		width: 93%;
		padding: 5% 0% 0% 6%;
		background: #fff;
		height: 100%;
	}

	.express-box .line-info{
		width: 100%;
		height: auto;
		border-left: #ccc solid 0.1rem;
		padding-top: 3%;
		font-size: 0;
	}

	.express-box .line-info:first-child{
		padding-top: 0%;
	}

	.express-box .line-info:first-child .ebtit{
		color: #333;
	}

	.express-box .line-info:first-child .ebtime{
		color: #808080;
	}

	.express-box .line-info>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
		color:#ccc;
	}

	.express-box .line-info .icon{
		width:8%;
		margin-left:-4%;
		margin-right:1%;
		text-align:center;
		font-size:0;
		padding:0.5rem 0rem;
		position: relative;
		top: -5px;
	}

	.express-box .line-info .icon .epoint {
		width:15px;
		height: 15px;
		background: #55a532;
		border-radius: 100px;
	}

	.express-box .line-info .icon>img{
		width:45%;
		height:auto;
		vertical-align:middle;
	}

	.express-box .line-info .icon.first{
		/*vertical-align:top;*/
		animation: zoom 2.5s linear infinite normal;
		-webkit-animation: zoom 2.5s linear infinite normal;
		/*animation:jump 1.5s linear infinite normal;*/
		/*-webkit-animation:jump 1.5s linear infinite normal;*/
	}

	.express-box .line-info .icon.first>img{
		width:65%;
		height:auto;
		vertical-align:middle;
	}

	.express-box .line-info .con-box{
		width: 87%;
		border-bottom: #ccc solid 0.1rem;
		padding: 0% 3% 3% 1%;
	}

	.express-box .line-info .con-box .ebtit{
		width:100%;
		max-width:100%;
		text-align:left;
	}

	.express-box .line-info .con-box .ebtime{
		width:100%;
		max-width:100%;
		font-size:1.2rem;
		text-align:left;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	@keyframes jump{
		0% {transform:translateY(0px);}
		65% {transform:translateY(-6px);}
		100% {transform:translateY(0px);}
	}

	@-webkit-keyframes jump{
		0% {transform:translateY(0px);}
		65% {transform:translateY(-6px);}
		100% {transform:translateY(0px);}
	}
</style>