	<style scoped>
	.bal-wrapper{
		width:100%;
		height:auto;
	}

	.line-con{
		width:100%;
		height:auto;
		font-size:1.6rem;
	}

	.zero-font{
		font-size:0px;
	}

	.l-icon,.l-tit,.l-desc,.l-arr{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
	}

	.l-icon{
		width:6%;
		padding-top:6%;
		margin-right:2%;
		background-position:center;
		background-repeat:no-repeat;
		background-size:contain;
		background-image:url('../images/parcel.png');
	}

	.l-icon.parcel{
		background-image:url('../images/parcel.png');
	}

	.l-icon.express{
		background-image:url('../images/express.png');
	}

	.l-icon.wxpay{
		background-image:url('../images/wxpay.png');
	}

	.l-icon.alipay{
		background-image:url('../images/alipay.png');
	}

	.l-icon.coupon{
		background-image:url('../images/coupon.png');
	}

	.l-icon.score{
		background-image:url('../images/score.png');
	}

	.l-icon.doubt{
		background-image:url('../images/doubt.png');
	}

	.l-tit{
		width:39%;
		margin-right:3%;
		text-align:left;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		color:#808080;
	}

	.l-tit.score{
		width:60%;
	}

	.l-desc{
		width:45%;
		margin-right:2%;
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
		color:#808080;
		text-align:right;
	}

	.l-desc .scross{
		display:inline-block;
		vertical-align:middle;
		width:1.8rem;
		height:1.8rem;
		border-radius:0.9rem;
		background:rgba(130,130,130,0.2);
		color:#fff;
		line-height:1.8rem;
		font-size:1.2rem;
		text-align:center;
		margin:0rem 0.5rem;
	}

	.l-desc.score{
		width:18%;
	}

	.l-desc.radio{
		width:48%;
	}

	.l-arr{
		width:3%;
		text-align:center;
	}

	.l-arr>img{
		width:50%;
		height:auto;
		vertical-align:middle;
	}

	.line-con .addition{
		width: 90%;
		background: #f2f2f2;
		height: 5rem;
		font-size: 1.3rem;
		margin: 0px auto;
		display: block;
		border-radius: 5px;
		line-height: 20px;
		padding: 0px 5px;
	}



	.address-box{
		width:100%;
		height:auto;
		background: #fffaf3;
		background-size: 100% 76px;
		position: relative;
	}

	.address-box .border-line{
		width:100%;
		height:0.6rem;
		background-image:url('../images/address-1.png');
		background-position:left;
		background-repeat:repeat-x;
		background-size:contain;
	}



	.address-box .border-line-vertical{
		width:0.6rem;
		height:100%;
		background-image:url('../images/address-2.png');
		background-position:top;
		background-repeat:repeat-y;
		background-size:contain;
		float:left;
		position: absolute;
		top:0px;
	}

	.line-left{position:absolute;top:0px;left:0px;}
	.line-right{position:absolute;top:0px;right:0px;}

	.address-box .add-con{
		width:100%;
		height:auto;
		margin:0.5rem 0rem;
		font-size:0;
	}

	.address-box .add-con>div{
		display:inline-block;
		vertical-align:middle;
		font-size:1.4rem;
	}

	.nowrap{
		white-space:nowrap;
		text-overflow:ellipsis;
		overflow:hidden;
	}

	.address-box .add-con .add-words {
		margin:0px 10px;
	}

	.address-box .add-con>div.words{
		width: 90%;
		text-align: center;
		padding: 0.3rem 0rem;
		margin: 0px auto;
	}

	.address-box .add-con>div.words .name{
		width:100%;
		color:#333;
		line-height:1.8rem;
		margin-bottom:0.2rem;
	}

	.address-box .add-con>div.words .name .address-left {
		width:3rem;
		float:left;
		display:block;
		font-size:1.2rem;
	}

	.address-box .add-con>div.words .add{
		width:100%;
		color:#333;
		line-height:1.6rem;
		display:-webkit-box;
		-webkit-line-clamp:2;
		-webkit-box-orient:vertical;
		font-size:1.4rem;
		max-height:3.2rem;
		overflow:hidden;
		text-overflow:ellipsis;
	}

	.address-box .add-con>div.words .add.noTips>a{
		color:#c40000;
	}

	.address-box .add-con>div.arrow{
		width:5%;
		text-align:right;
		margin-right:3%;
	}

	.address-box .add-con>div.arrow>img{
		width:30%;
		height:auto;
		transform:rotate(90deg);
		-webkit-transform:rotate(90deg);
	}

	.cell-arr {
		position:absolute;
		top:7px ;
		right:8px;
	}

	.give-container {
		width:100%;
		background: #fff;
		height: 100%;
		margin: 0px 0px 10px;
	}

	.give-container .give-title {
		height:45px;
		line-height:4.5rem;
		color:#808080;
		font-size:1.4rem;
	}

	.give-container .give-title .icon-img1 {
		background: url("../images/list.png") no-repeat;
		width: 6%;
		height: 43%;
		display: block;
		background-size: 95%;
		float:left;
		margin:13px 0px;
	}

	.give-container .give-title span {
		padding-left: 10px;
		width:100%;
	}

	.give-container .give-order {
		clear:both;
		height: 145px;
	}

	.give-container .give-order ul .notActive {
		width: 29.4%;
		float:left;
		margin: 0px 5px;
		transition:0.5s;
		border:2px solid #fff;
	}

	.give-container .give-order ul .activeGift {
		width: 29.4%;
		float:left;
		margin: 0px 5px;
		border:2px solid #c40000;
		transition:0.5s;
	}

	.give-container .give-order ul li .shop-img {
		width: 100%;
		height: 95px;
	}

	.give-container .give-order ul li p {
		font-size:14px;
		line-height: 30px;
		text-align:center;
	}

	/* getShop start */
	.getShop {
		width:100%;
		height:100%;
		background: #fff;
		margin:10px 0px;
		font-size:1.4rem;
	}

	.getShop .getShopDate {
		width:95%;
		margin:0px auto;
		border-bottom: 1px solid #f2f2f2;
		height:3.5rem;
		line-height:3.5rem;
	}

	.getShop .getShopDate .selectInput {
		margin:2px 10px 0px;
		height:3rem;
		width:10rem;
	}

	.getShop .getShopDate .selectInput select {
		width:10rem;
		height:2.5rem;
		text-indent:0.5em;
		line-height:2.5rem;
		background: url("../images/xia.png") no-repeat right;
		background-size: 9%;
		background-position-x: 84px;
	}

	.getShop .getShopTime {
		border-bottom: 1px solid #f2f2f2;
		height:3.5rem;
		line-height:3.5rem;
	}

	.bor {
		position: relative;
		height:3.5rem;
	}

	.bor .rada {
		position: absolute;
	}

	.bor .radb {
		position: absolute;
		left: 8rem;
	}

	.label-radio {
		width:8rem;
		display:block;
		float:left;
		text-indent: 3rem;
		color: #333;
	}

	.label-radio span {
		color: #333;
	}

	.my-icon{
		width:2rem;
		height:2rem;
		display:block;
		background: url("../images/gou2.png") no-repeat;
		background-size: 100%;
		float: left;
		margin:8px 5px;
	}

	.my-icon-chosen {
		width:2rem;
		height:2rem;
		display:block;
		background: url("../images/gou.png") no-repeat;
		background-size: 100%;
	}

	.getShop .getShopTime {
		width:95%;
		margin:0px auto;
	}

	.radio-time {
		border:1px solid #ccc;
		padding:5px;
	}

	.getShop .getInformation {
		width:80%;
		text-align:center;
		margin: 10px auto;
		background: #fff;
	}
	/* getShop end */

</style>

<template>
	<div class="bal-wrapper" style="margin-top:47px;">
		<!-- 发货方式 -->
		<my-cell title="到店自提" @click="showAction" :class="deliverType">
			<div class="l-arr cell-arr">
				<img src="../images/arrow.png" />
			</div>
		</my-cell>

		<!-- 自提点地址/收货地址 -->
		<div class="address-box" @click="showPop">
			<div class="border-line"></div>
			<div class="border-line-vertical" style="left: 0px;"></div>
			<div class="add-con">
				<div style="text-align:left;padding-left:2rem;" class="words" v-if="data.address">
					<div class="name">
						<p>
							<span class="address-left">姓名:</span>
							<span>{{ data.address.name }}</span>
						</p>
						<p>
							<span class="address-left">电话:</span>
							<span>{{ data.address.tel }}</span>
						</p>
					</div>
					<div class="add" v-if="data.address.area">
						<p>{{ data.address.area }}</p>
						<p>{{ data.address.address }}</p>
					</div>
					<div class="add" v-else>
						<span class="address-left">地址:</span>
						{{ data.address.address }}
					</div>
				</div>
				<div style="text-align:center;" class="words" v-else>
					<div class="add noTips">
						选择自提点地址？<a @click="showPop">点我设置</a>  <!--  @click="setAddress" -->
					</div>
				</div>
			</div>
			<div class="border-line-vertical" style="right: 0px;"></div>
			<div class="border-line"></div>
		</div>

		<my-cell-item>
			<div class="line-con">
				<textarea placeholder="订单补充说明" maxlength="50" class="addition" v-model="memo"></textarea>
			</div>
		</my-cell-item>

		<!-- 首单列表 -->

		<!-- 商品列表 -->
		<balance-list :list="cartInfo" :gift="listGift" ></balance-list>

		<!-- 首单列表 -->
		<div class="give-container" v-show="showGive">
			<div class="" style="margin:10px 0px;border-bottom: 1px solid #eee;height:46px;width:100%;">
				<div style="margin:0px 10px;">
					<p class="give-title">
						<i class="icon-img1"></i>
						<span>首单用户,就送如下商品,请选择赠品</span>
					</p>
				</div>
			</div>
			<div class="give-order">
				<ul>
					<li @click="chosenGift(item.id)" v-for="item in listGift" class="notActive" :class="{'activeGift':dtype == item.id}">
						<p class="shop-img">
							<img :src="item.shotcut" alt="" style="width:100%;height:100%;" />
						</p>
						<p>{{ item.name }}</p>
					</li>
				</ul>
			</div>
		</div>

		<!-- 支付方式 -->
		<!--<my-cell title="请选择支付方式" style="clear:both;">-->
			<!--<my-cell-item @click="changePayType(pitem.ptype)" v-for="pitem in data.pay">-->
				<!--<div class="line-con zero-font">-->
					<!--<div class="l-icon" :class="pitem.en"></div>-->
					<!--<div class="l-tit">{{ pitem.ch }}</div>-->
					<!--<div class="l-desc radio">-->
						<!--<icon type="success" class="my-icon-chosen" v-show="payType===pitem.ptype"></icon>-->
						<!--<icon type="circle" class="my-icon" v-show="payType!==pitem.ptype"></icon>-->
					<!--</div>-->
				<!--</div>-->
			<!--</my-cell-item>-->
		<!--</my-cell>-->

		<div class="getShop">
			<div class="getShopDate">
				<div style="float:left;">取菜日期:</div>
				<div style="float:left;" class="selectInput">
					<select id="today">
						<option></option>
					</select>
				</div>
				<div style="float:left;">(<i>{{ theDay }}</i>)</div>
			</div>
			<div class="getShopTime">
				<div style="float:left;">取菜时间:</div>
				<div class="bor" style="float:left;">
					<input type="radio" value="1" v-model="shonse" class="my-icon rada my-icon-chosen" />
					<input type="radio" value="2" v-model="shonse" class="my-icon radb" />
					<label class="label-radio" @click="isRadio">10:30</label>
					<label class="label-radio" @click="isRadio">16:30</label>
				</div>
			</div>
			<div class="getInformation">提示：菜品到货后请及时取菜超过3天的菜我们将在第4天进行回收，谢谢！</div>
		</div>

		<!-- 其他选项 -->
		<my-cell>
			<my-cell-item @click="showCou">
				<div class="line-con zero-font">
					<div class="l-icon coupon"></div>
					<div class="l-tit">优惠券</div>
					<div class="l-desc" v-show="coupon == 0">未使用</div>
					<div class="l-desc" v-else>已选择1张优惠券<a class="scross" @click="cancelCoupon">x</a></div>
					<div class="l-arr">
						<img src="../images/arrow.png" />
					</div>
				</div>
			</my-cell-item>

			<my-cell-item style="margin:0px;" v-if="score == 0">
				<div class="line-con zero-font" style="font-size:14px;">没有可用积分</div>
			</my-cell-item>

			<my-cell-item style="margin:0px;" v-else>

				<div class="line-con zero-font">
					<div class="l-icon score"></div>
					<div class="l-tit score">{{ score }}积分(可抵扣{{ scoreMoney.showText }}元)</div>
					<div class="l-desc score">
						<my-switch style="background: #04BE02" :value.sync="scoreSwitch"></my-switch>
					</div>
					<div class="l-icon doubt" style="margin-right:0%;" @click="showAlert"></div>
				</div>
			</my-cell-item>

		</my-cell>

		<!-- 价格详情 -->
		<balance-price :sum="paySum" :coupon="couponMoney" :score="scoreMoney.makePrice" :freight="freight"></balance-price>

	</div>

	<separator :set-height="4.5"></separator>



	<!-- 底部支付按钮 -->
	<bottom-pay :sum="lastPaySum" :fixed="true"></bottom-pay>

	<!-- 发货方式 -->
	<actionsheet :show.sync="actionShow" :menus="data.deliver" :show-cancel="true" cancel-text="取消" @on-click-menu="clickMenu"></actionsheet>

	<!-- 地址/自提点 -->
	<my-freepop :money="lastPaySum" :show.sync="popShow" title="选择地址" :show-confirm="true" :chosen.sync="address"></my-freepop>

	<!-- 优惠券-->
	<my-coupop :show.sync="couShow" title="选择优惠券" :show-confirm="true" :price="paySum" :chosen.sync="coupon"></my-coupop>

	<!-- 弹出提示框 -->
	<alert :show.sync="alertShow" title="积分规则" button-text="知道了">
		<p style="text-align:center;">每<font color="#81c429">100积分</font>可以用作<font color="#81c429">1元</font>抵扣支付金额.</p>
	</alert>

	<!-- toast显示框 -->
	<toast type="text" :show.sync="toastShow">{{ toastMessage }}</toast>

	<!-- loading加载框 -->
	<loading :show="loadingShow" :text="loadingMessage"></loading>
</template>

<script>

    import MyCell from 'components/my-cell'
    import MyCellItem from 'components/my-cell-item'
    import MySwitch from 'components/my-switch'
    import Icon from 'vux/src/components/icon'
    import Alert from 'vux/src/components/alert'
    import Actionsheet from 'vux/src/components/actionsheet'
    import MyFreepop from 'components/my-freepop'
    import MyCoupop from 'components/my-coupop'
    import BalanceList from 'components/balance-list'
    import BalancePrice from 'components/balance-price'
    import BottomPay from 'components/bottom-pay'
    import BottomConfirm from 'components/bottom-confirm'
    import Separator from 'components/separator'
    import Toast from 'vux/src/components/toast'
    import Loading from 'vux/src/components/loading'
    import { selCartInfo,selCartSum,selCartIdsNoFormat } from 'vxpath/getters'
    import { clearAll,clearSel } from 'vxpath/actions'
    import Scroller from 'vux/src/components/scroller'

    export default{
        vuex: {
            getters: {
                cartInfo: selCartInfo,
                paySum: selCartSum,
                cartIds: selCartIdsNoFormat
            },
            actions: {
                clearAll,
                clearSel
            }
        },
        data() {
            return {
                loadingShow:false,
                loadingMessage:'',
                toastMessage:'',
                toastShow:false,
                actionShow:false,
                popShow:false,
                couShow:false,
                alertShow:false,
                address:0,
                coupon:0,
                couponObj:null,
                payType:0,
                score:0,
                scoreSwitch:false,
                deliverType:'',
                deliverName:'',
                freight:0,
                memo:'',
                data: {
                    deliver:{},
                    address:null,
                    pay:[]
                },
                listGift: "",
				dtype: 0,
                shopid:0,
                shonse:1,
                theDay: "当日",
                giftstu: 0,	//赠品状态,
                showGive: false,
            }
        },
        components: {
            MyCell,
            MyCellItem,
            MySwitch,
            Icon,
            Alert,
            Actionsheet,
            MyFreepop,
            MyCoupop,
            BalanceList,
            BalancePrice,
            BottomPay,
            BottomConfirm,
            Separator,
            Toast,
            Loading,
            Scroller
        },
        route: {
            data(transition) {
                if(this.cartInfo.length <= 0) {
                    transition.abort();
                    transition.go({name:'index'});
                }
            }
        },
        ready() {
            this.isRadio();
            let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
            ustore = JSON.parse(ustore);
            let pids = '';
            if(this.cartIds.length > 0) {
                pids = this.cartIds.join(',');
            }
            let opid = sessionStorage.getItem('openid');
            if(!opid) {
                opid = '';
            } else {
                opid = '/openid/' + opid;
            }
            this.$http.get(localStorage.apiDomain+'public/index/user/ordersubmission/uid/'+ustore.id+'/token/'+ustore.token+'/ids/'+pids+opid).then((response)=>{
                if(response.data.status===1) {
                    this.data.deliver = response.data.deliver;
                    if(typeof this.data.deliver.express !== 'undefined' && this.data.deliver.express !== '') {
                        this.deliverType = 'express';
                        this.deliverName = this.data.deliver.express;
                    }else{
                        this.deliverType = 'parcel';
                        this.deliverName = this.data.deliver.parcel;
                    }
                    this.data.pay = response.data.pay;
                    this.payType = this.data.pay[0].ptype;
                    this.data.address = response.data.address;
                    if(this.data.address){
                        this.address = this.data.address.id;
                    }
                    this.score = response.data.score;
                    this.freight = response.data.freight;
                }else if(response.data.status === -1) {
                    this.toastMessage = response.data.info;
                    this.toastShow = true;
                    let context = this;
                    setTimeout(function() {
                        context.clearAll();
                        sessionStorage.removeItem('userInfo');
                        localStorage.removeItem('userInfo');
                        context.$router.go({name:'login'});
                    },800);
                }else{
                    this.toastMessage = response.data.info;
                    this.toastShow = true;
                }
            },(response)=>{
                this.toastMessage = '网络开小差了~';
                this.toastShow = true;
            });
        },
        computed: {
            scoreMoney: function() {
                let obj = {};
                let money = this.score / 100;
                obj['showText'] = money.toFixed(2);
                if(this.scoreSwitch) {
                    obj['makePrice'] = obj['showText'];
                }else{
                    obj['makePrice'] = 0;
                }
                return obj;
            },
            couponMoney: function() {
                let money = 0;
                if(this.coupon > 0 && this.couponObj != null) {
                    if(this.couponObj.type == 1 || this.couponObj.type == 3) {
                        money = this.couponObj.minus_money;
                    }else{
                        money = this.paySum * (1-this.couponObj.discount);
                    }
                }
                return money.toFixed(2);
            },
            lastPaySum: function() {
                let lastMoney = parseFloat(this.paySum)+parseFloat(this.freight) - parseFloat(this.scoreMoney.makePrice) - parseFloat(this.couponMoney);
                if(lastMoney <= 0) lastMoney = 0.02;
                return lastMoney.toFixed(2);
            }
        },
        methods: {
            isRadio: function() {
                var date = new Date() , y = date.getFullYear() , m = date.getMonth() + 1 , d = date.getDate();
                var radA = $(".label-radio").eq(0).text();
                var radB = $(".label-radio").eq(1).text();
                var time = null;
                for(let i = 0; i < this.cartInfo.length; i++) {
					if (this.cartInfo[i].deliverytime == 0) {
						this.theDay = "次日";
                        d = date.getDate() + 1;
                        $(".my-icon").eq(1).removeAttr("disabled");
					} else if (this.cartInfo[i].deliverytime == 1) {
						$(".my-icon").eq(0).hide();
                        $(".my-icon").eq(1).css("left","0px");
                        $(".my-icon").eq(1).addClass("my-icon-chosen")
						$(".label-radio").eq(0).hide();
                        this.theDay = "当日";

                        switch($(".my-icon").val()) {
                            case 1:
                        }
					}
				}
                time = y + "-" + m + "-" + d;
                $("#today").find("option:selected").text(time);
				$(".bor").find(".my-icon").change(function () {
					$(this).addClass("my-icon-chosen").siblings().removeClass("my-icon-chosen");
                });
			},
			chosenGift: function (type) {
                if (this.dtype == type) return true;
                this.dtype = type;
                console.log(this.dtype);
                document.getElementsByClassName("addCar")[0].style.background = '#81c429';
                //清除禁用按钮
                document.getElementsByClassName("addCar")[0].disabled = "";
            },
			//首单赠品
            oneGift: function (oid,money) {
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                this.$http.get(localStorage.apiDomain + 'public/index/user/manjiusong/uid/' + ustore.id + '/token/' + ustore.token +'/sinceid/' + oid + '/money/' + money).then((response)=>{
                    if(response.data.status === 1) {
                        this.showGive = true;
                        this.listGift = response.data.maxmoney;
                        console.log(response.data.maxmoney);
						this.giftstu = 1;
                    } else if(response.data.status=== -1) {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    } else if(response.data.status === 0) {
                        this.showGive = true;
                        this.giftstu = 0;
                        this.$http.get(localStorage.apiDomain + 'public/index/user/shoudan/uid/' + ustore.id + '/token/' + ustore.token +'/sinceid/' + oid + '/money/' + money).then((response)=>{
                            this.listGift = response.data.shoudan_data;
                            console.log(this.listGift);
						},(response)=>{
                            this.toastMessage = '网络开小差了~';
                            this.toastShow = true;
                        });
					}
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            changePayType: function(tp){
                this.payType = tp;
            },
            showAlert: function(){
                this.alertShow = true;
            },
            showAction: function(){
                this.actionShow = true;
            },
            clickMenu: function(key){
                if(key === 'cancel'){
                    return true;
                }
                if(this.deliverType==key){
                    return true;
                }
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                ustore = JSON.parse(ustore);
                let pids = '';
                if(this.cartIds.length > 0) {
                    pids = this.cartIds.join(',');
                }
                this.$http.get(localStorage.apiDomain+'public/index/user/addesschange/uid/'+ustore.id+'/token/'+ustore.token+'/type/'+key+'/ids/'+pids).then((response)=>{
                    if(response.data.status===1){
                        this.deliverType = key;
                        this.deliverName = key === 'express' ? this.data.deliver.express : this.data.deliver.parcel;
                        this.freight = response.data.freight;
                        if(typeof response.data.address!=='undefined'){
                            this.data.address = response.data.address;
                            this.address = this.data.address.id;
                        }else{
                            this.data.address = null;
                            this.address = 0;
                            this.freight = 0;
                        }
                    }else if(response.data.status===-1){
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    }else{
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                },(response)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            showPop: function(){
                this.popShow = true;
                let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                this.oneGift(this.address,this.lastPaySum);
//                this.showGive = true;
            },
            showCou: function(){
                this.couShow = true;
            },
            setAddress: function(evt){
                evt.preventDefault();
                evt.stopPropagation();
                this.$router.go({name:'address-add'});
                if(this.deliverType === 'express'){
                    this.$router.go({name:'address-add'});
                }
            },
            cancelCoupon: function(evt){
                evt.preventDefault();
                evt.stopPropagation();
                this.coupon = 0;
                this.couponObj = null;
            },
        },
        events: {
			submitOrder: function() {

			    console.log(this.dtype);

                if(!this.deliverType) {
                    this.toastMessage = '未选择收货方式';
                    this.toastShow = true;
                    return false;
                }else if(!this.address) {
                    this.toastMessage = '未选择收货地址';
                    this.toastShow = true;
                    return false;
                }else if(this.payType <= 0) {
                    this.toastMessage = '未选择支付方式';
                    this.toastShow = true;
                    return false;
                }else if(this.cartInfo.length <= 0) {
                    this.toastMessage = '未选择要购买的商品';
                    this.toastShow = true;
                    return false;
                }else if(this.lastPaySum <= 0){
                    this.toastMessage = '支付金额不能小于等于0';
                    this.toastShow = true;
                    return false;
                } else if(this.shonse != 0 && this.shonse == -1) {
                    this.toastMessage = '请选择配送时间！';
                    this.toastShow = true;
                    return false;
				}
				let _this = this;
                for(let i = 0; i < this.cartInfo.length; i++) {
                    this.loadingMessage = '正在提交...';
                    this.loadingShow = true;
                    let ustore = sessionStorage.getItem('userInfo') || localStorage.getItem('userInfo');
                    ustore = JSON.parse(ustore);
                    let pdata = {
                        uid:ustore.id,
                        token:ustore.token,
                        paytype:this.payType,
                        products:this.cartInfo,
                        stype:this.deliverType,
                        address:this.address,
                        coupon:this.coupon,
                        score:this.scoreSwitch,
                        paysum:this.lastPaySum,
                        tips:this.memo,
                        openid: sessionStorage.getItem("openid"),//sessionStorage.getItem("openid"),
                        pshonse:this.shonse,
                        gift:{'shopid':this.dtype,'id':this.shopid,'giftstu':this.giftstu},
                    };
                    this.$http.post(localStorage.apiDomain + 'public/index/user/getSubmitOrder',pdata).then((response)=>{
                        if(response.data.status===1){
                            this.clearSel();
                            this.$router.replace('order/detail/' + response.data.oid);
                            this.loadingShow = false;
                        }else if(response.data.status === -1) {
                            this.loadingShow = false;
                            this.toastMessage = response.data.info;
                            this.toastShow = true;
                            let context = this;
                            setTimeout(function(){
                                context.clearAll();
                                sessionStorage.removeItem('userInfo');
                                localStorage.removeItem('userInfo');
                                context.$router.go({name:'login'});
                            },800);
                        }else{
                            this.loadingShow = false;
                            this.toastMessage = response.data.info;
                            this.toastShow = true;
                        }
                    },(response)=>{
                        this.loadingShow = false;
                        this.toastMessage = '网络开小差了~';
                        this.toastShow = true;
                    });
                    return true;
				}
            }
        }
    }
</script>