<template>
	<div class="bal-wrapper">
		{{ demo | json}}
		<!-- 发货方式 -->
		<my-cell :title="myCellTitle" @click="showAction" :class="deliverType">
			<div class="l-arr cell-arr">
				<img src="../images/arrow.png" />
			</div>
		</my-cell>
		<!-- 自提点地址/收货地址 -->
		<div class="address-box" @click="showPop">
			<div class="border-line"></div>
			<div class="border-line-vertical" style="left: 0px;"></div>
			<div class="add-con">
				<div style="text-align:left;padding-left:2rem;background: none;" class="words" v-if="data.address" style="background: none;">
					<div class="name">
						<p>{{ deliverName }}</p>
						<p v-if="deliverName === '到店自提' ">
							<span class="address-left">姓名:</span>
							<span>{{ wxName }}</span>
						</p>
						<p v-if="deliverName === '快递配送' ">
							<span class="address-left">姓名:</span>
							<span class="expressName">{{ data.address.name }}</span> <!-- data.address.name -->
						</p>
						<p>
							<span class="address-left">电话:</span>
							<span>{{ telphone }}</span>
						</p>
					</div>
					<div class="add" v-if="data.address.area">
						<p>
							<span>详细地址:</span>
							<span>{{ data.address.address }}</span>
						</p>
					</div>
					<div class="add" v-else>
						<span class="address-left">地址:</span>
						<span>{{ data.address.address }}</span>
					</div>
				</div>
				<div style="text-align:center;" class="words" v-else>
					<div class="add noTips">
						<span>选择自提点地址？</span>
						<a @click="showPop">点我设置</a>  <!--  @click="setAddress" -->
					</div>
				</div>
			</div>
			<div class="border-line-vertical" style="right: 0px;"></div>
			<div class="border-line"></div>
		</div>

		<my-cell-item>
			<div class="line-con">
				<textarea placeholder="订单补充说明（若在自提点的送货上门范围内，可在此填写更为详细的地址来获取送货上门的服务。）" maxlength="150" class="addition" v-model="memo"></textarea>
			</div>
		</my-cell-item>

		<!-- 首单列表 -->

		<!-- 商品列表 -->
		<balance-list :list="cartInfo" :gift="listGift" ></balance-list>

		<!-- 首单列表 -->
		<div class="give-container" v-show="openpop">
			<div class="" style="margin:10px 0px 5px;border-bottom: 1px solid #eee;height:46px;width:100%;">
				<div style="margin:0px 10px;">
					<p class="give-title">
						<i class="icon-img1"></i>
						<span>{{ description }}</span>
					</p>
				</div>
			</div>
			<div class="give-order">
				<ul>
					<li @click="chosenGift(item.id,item.store)" v-for="item in list" class="notActive" :class="{'activeGift':shopid == item.id}">
						<p class="shop-img" v-if="item.store == '' ">
							<span class="shopover">已售罄</span>
							<img :src="item.shotcut" alt="" style="width:100%;height:100%;" />
						</p>
						<p class="shop-img" v-else>
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
			<!--<my-cell-item @click="showCou">-->
			<!--<div class="line-con zero-font">-->
			<!--<div class="l-icon coupon"></div>-->
			<!--<div class="l-tit">优惠券</div>-->
			<!--<div class="l-desc" v-show="coupon == 0">未使用</div>-->
			<!--<div class="l-desc" v-else>已选择1张优惠券<a class="scross" @click="cancelCoupon">x</a></div>-->
			<!--<div class="l-arr">-->
			<!--<img src="../images/arrow.png" />-->
			<!--</div>-->
			<!--</div>-->
			<!--</my-cell-item>-->
			<my-cell-item style="margin:0px;display: none;" v-if="score == 0">
				<div class="line-con zero-font" style="font-size:14px;">没有可用积分</div>
			</my-cell-item>

			<my-cell-item style="margin:0px;display: none;" v-else>
				<div class="line-con zero-font">
					<div class="l-icon score"></div>
					<div class="l-tit score">{{ score }}积分(可抵扣{{ scoreMoney.showText }}元)</div>
					<div class="l-desc score">
						<my-switch style="background: #04BE02" :value.sync="scoreSwitch"></my-switch>
					</div>
					<div class="l-icon doubt" v-show="switchShow" style="margin-right:0%;" @click="showAlert"></div>
				</div>
			</my-cell-item>
		</my-cell>

		<!-- 价格详情 -->
		<balance-price :sum="paySum" :coupon="couponMoney"
					   :score="scoreMoney.makePrice" :freight="freight"
					   :openbtn="scoreSwitch"></balance-price>

	</div>

	<separator :set-height="4.5"></separator>

	<!-- 底部支付按钮 -->
	<bottom-pay :sum="lastPaySum" :fixed="true"></bottom-pay>

	<!-- 发货方式 -->
	<actionsheet :show.sync="actionShow" :menus="data.deliver" :show-cancel="true" cancel-text="取消" @on-click-menu="clickMenu"></actionsheet>

	<!-- 地址/自提点 -->
	<my-freepop :show.sync="popShow" :pop="openpop" title="选择地址" :chonse="chonseParcel" :show-confirm="true" :chosen.sync="address" :money="lastPaySum" :lists="list"></my-freepop>

	<!-- 优惠券-->
	<my-coupop :show.sync="couShow" title="选择优惠券" :show-confirm="true" :price="paySum" :chosen.sync="coupon"></my-coupop>

	<!-- 弹出提示框 -->
	<alert :show.sync="alertShow" title="积分规则" button-text="知道了">
		<p style="text-align:center;">每<font color="#81c429">100积分</font>可以用作<font color="#81c429">{{ sNumber }}元</font>抵扣支付金额.</p>
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
    import { clearAll, clearSel, addressid} from 'vxpath/actions'
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
                clearSel,
                addressid,
            }
        },
        data() {
            return {
                loadingShow: false,
                loadingMessage: '',
                toastMessage: '',	//提示信息
                toastShow: false,
                actionShow:false,
                popShow:false,
                couShow:false,
                alertShow:false,
                address:0,			//快递地址
                coupon:0,
                couponObj:null,
                payType:0,			//支付方式
                score:0,			//积分
                scoreSwitch: false, //积分开关
                scoreNumber: 0,		//积分
                sNumber: 0,			//积分 0/1
                deliverType:'',
                deliverName:'',
                freight:0,			//	快递费
                memo:'',			//订单说明
                data: {				//数据
                    deliver:{},
                    address:null,
                    pay:[]
                },
                list: '',//this.$store.state.myGift, //赠品
                dtype: 0,
                shopid:0,
                shonse:1,
                theDay: "当日",
                giftstu: 0,	//赠品状态,
                openpop: false,
                description: "",
                lastPaySum: 0,		//	金额
                myCellTitle: '',
                chonseParcel: false, //显示隐藏自提点选择框
                wxName: '',			 // 微信名称
                expressName: '',		 //	收件人名称
                telphone: 0,	//	电话号码
                switchShow: false,
                ar: ['22:00','23:59'],
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
            console.log(this.cartInfo);
            this.submitReady();
        },
        computed: {
            list: function(){
                return this.$store.state.giftList
            },
            description () {
                return this.$store.state.song
            },
            giftstu () {
                return this.$store.state.giftstu
            },
            openpop () {
                return this.$store.state.visibleEle
            },
            scoreMoney: function() {
                let obj = {}, money = this.score / 100;
                if(this.scoreSwitch) {
                    if(money > 1) {
                        var count = parseInt(this.paySum);
                        count -= 1;
                        money = count;
                    } else {
                        return money = this.score / 100;
                    }
				}
                obj['showText'] = money.toFixed(2);
                if(this.scoreSwitch) {
                    this.switchShow = true;
                    this.scoreNumber = 1;
                    obj['makePrice'] = obj['showText'];
                    this.$getData('/index/index/jifenmoney').then((res) => {
                        this.sNumber = parseInt(res.info.jifen);
                    });
                } else {
                    this.switchShow = false;
                    this.scoreNumber = 2;
                    this.sNumber = 0;
                    obj['makePrice'] = 0;
                }
                return obj;
            },
            couponMoney: function() {
                let money = 0;
                if(this.coupon > 0 && this.couponObj != null) {
                    if(this.couponObj.type == 1 || this.couponObj.type == 3) {
                        money = this.couponObj.minus_money;
                    } else {
                        money = this.paySum * (1 - this.couponObj.discount);
                    }
                }
                return money.toFixed(2);
            },
            lastPaySum: function() {
                let lastMoney =
					parseFloat(this.paySum) +
					parseFloat(this.freight) -
					parseFloat(this.scoreMoney.makePrice) -
					parseFloat(this.couponMoney);
                if(lastMoney <= 0) lastMoney = 1;
                return lastMoney.toFixed(2);
            }
        },
        watch: {
            '$route'(to) {
                if(to.name == 'submit') {
                    this.submitReady();
                }
            },
        },
        methods: {
            //	设置提交订单时间 如果超出时间范围则提交不了订单
            checkTime: function (ar) {
                var d = new Date(),
					that = this,
					time = null,
					date = new Date(),
					y = date.getFullYear(),
					m = date.getMonth() + 1;
                var current = d.getHours() * 60 + d.getMinutes();
                var ar_begin = ar[0].split(':');
                var ar_end = ar[1].split(':');
                var b = parseInt(ar_begin[0]) * 60 + parseInt(ar_begin[1]);
                var e = parseInt(ar_end[0]) * 60 + parseInt(ar_end[1]);
                if (current >= b && current <= e) {
                    var new_date = new Date(y, m, 1);	//取当年当月中的第一天
                    var thatTime = new_date.getFullYear() + '-' + (new_date.getMonth() + 1) + '-' + (new_date.getDate() + 1);
                    time = thatTime;
                    $("#today").find("option:selected").text(time);
                }
			},
            getLastDay(year, month) {
                var new_year = year;  	//取当前的年份
                var new_month = month++;//取下一个月的第一天，方便计算（最后一天不固定）
                if (month > 12)	{		//如果当前大于12月，则年份转到下一年
                    new_month -= 12;    //月份减
                    new_year++;      	//年份增
                }
                var new_date = new Date(new_year, new_month, 1);        //取当年当月中的第一天
                var day = new Date(new_date.getTime() - 1000 * 60 * 60 * 24);
                return day.getDate();//获取当月最后一天日期
            },
            submitReady() {
                let pids = '';
                if(this.cartIds.length > 0) {
                    pids = this.cartIds.join(',');
                }
                var opid = sessionStorage.getItem('openid');
                if(!opid) {
                    opid = '';
                } else {
                    opid = '/openid/' + opid;
                }
                this.$getData('/index/user/ordersubmission/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/ids/' + pids + opid).then((res)=>{
                    if(res.status === 1) {
                        this.data.deliver = res.deliver;
                        if(typeof this.data.deliver.express !== 'undefined' && this.data.deliver.express !== '') {
                            this.deliverType = 'express';
                            this.deliverName = this.data.deliver.express;
                        } else {
                            this.deliverType = 'parcel';
                            this.deliverName = this.data.deliver.parcel;
                        }
                        //	获取用户的电话号码
                        this.$getData('/index/login/useredit/uid/' + this.$ustore.id).then((res)=>{
                            this.telphone = res.utel;
                            localStorage.setItem('tel',this.data.tel);
                        },(res)=>{
                            this.toastMessage = '网络开小差了~';
                            this.toastShow = true;
                        });
                        //	判断有没有快递配送
                        typeof(res.address) == '' ? this.myCellTitle = '到店自提' : this.myCellTitle = '请选择配送方式';
                        this.data.pay = res.pay;
                        this.payType = this.data.pay[0].ptype;
                        this.data.address = res.address;
                        this.addressid(this.data.address.id);
                        this.address = this.data.address.id;
                        //	获取微信信息
                        let openid = sessionStorage.getItem("openid");
                        this.$getData('/index/index/get_weixin?openid=' + openid).then((res)=>{  /* 'os0CqxBBANhLuBLTsViL3C0zDlNs' */
                            this.wxName = res.info.weixindata.nickname;
                        });
                        if(this.data.address) {
                            this.address = this.data.address.id;
                        }
                        this.score = res.score;
                        this.freight = res.freight;
                    } else if (res.status === -1) {
                        this.toastMessage = res.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function () {
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name: 'login'});
                        }, 800);
                    } else {
                        this.toastMessage = res.info;
                        this.toastShow = true;
                    }
                },(res)=>{
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            isRadio: function() {
                var date = new Date() , y = date.getFullYear() , m = date.getMonth() + 1 , d = date.getDate();
                var time = null;
                for(let i = 0; i < this.cartInfo.length; i++) {
                    switch (true) {
						case this.cartInfo[i].deliverytime == 0:
                            this.theDay = "次日";
                            $(".my-icon").eq(1).removeAttr("disabled");
                            var doDay = this.getLastDay(y,m);
                            var new_date = new Date(y, m, 1);	//取当年当月中的第一天
                            var thatTime = new_date.getFullYear() + '-' + (new_date.getMonth() + 1) + '-' + new_date.getDate();
                            if(d === doDay) {
                                time = thatTime;
                            } else {
                                d = date.getDate() + 1;
                                time = y + "-" + m + "-" + d;
                            }
                            $("#today").find("option:selected").text(time);

						case this.cartInfo[i].deliverytime == 1:
                            $(".my-icon").eq(0).hide();
                            $(".my-icon").eq(1).css("left","0px");
                            $(".my-icon").eq(1).addClass("my-icon-chosen");
                            $(".label-radio").eq(0).hide();
                            this.theDay = "当日";
                            time = y + "-" + m + "-" + d;
                            $("#today").find("option:selected").text(time);
					};
                }
                this.checkTime(this.ar);
                $(".bor").find(".my-icon").change(function () {
                    $(this).addClass("my-icon-chosen").siblings().removeClass("my-icon-chosen");
                });
            },
            chosenGift: function (type,store) {
                if(store == '') {
                    return false;
                } else {
                    if (this.shopid == type) return true;
                    this.shopid = type;
                    document.getElementsByClassName("addCar")[0].style.background = '#81c429';
                    //清除禁用按钮
                    document.getElementsByClassName("addCar")[0].disabled = "";
                }
            },
            changePayType: function(tp){
                this.payType = tp;
            },
            showAlert: function(){
                this.alertShow = true;
            },
            showAction: function(){
                this.actionShow = true;
                if (this.deliverName === '快递配送') {
                    this.chonseParcel = false;
                    $(".expressName").text(this.data.address.name);
                } else if (this.deliverName === '到店自提') {
                    this.chonseParcel = true;
                }
            },
            clickMenu: function(key){
                if(key === 'cancel'){
                    return true;
                }
                if(this.deliverType==key){
                    return true;
                }
                let content = this, pids = '';
                if(this.cartIds.length > 0) {
                    pids = this.cartIds.join(',');
                }
                this.$getData('/index/user/addesschange/uid/' + this.$ustore.id + '/token/' + this.$ustore.token + '/type/' + key + '/ids/' + pids).then((res)=>{
                    if (res.status === 1) {
                        content.deliverType = key;
                        content.deliverName = key === 'express' ? content.data.deliver.express : content.data.deliver.parcel;
                        content.freight = res.freight;
                        if(typeof res.address !== 'undefined') {
                            content.data.address = res.address;
                            content.data.address.name = res.address.person;
                            content.address = content.data.address.id;
                        } else {
                            content.data.address = null;
                            content.address = 0;
                            content.freight = 0;
                        }
                    } else if (res.status === -1) {
                        this.toastMessage = res.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    } else {
                        this.toastMessage = response.data.info;
                        this.toastShow = true;
                    }
                },(res) => {
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
            },
            showPop: function() {
                let content = this;
                content.popShow = true;
                content.openpop = true;
                if (content.deliverName == '快递配送') {
                    content.chonseParcel = false;
                    $(".commentButton").css("width","45%");
                    $(".con-box").css({
                        "marginTop" : "17px",
                        "height" : "80%"
                    });
                } else if (content.deliverName == '到店自提') {
                    content.chonseParcel = true;
                    $(".commentButton").css("width","93%");
                    $(".con-box").css({
                        "marginTop" : "10px",
                        "height" : "70%"
                    });
                }
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
                switch (true) {
					case !this.deliverType:
                        this.toastMessage = '未选择收货方式';
                        this.toastShow = true;
                        return false;
					case !this.address:
                        this.toastMessage = '未选择收货地址';
                        this.toastShow = true;
                        return false;
					case this.payType <= 0:
                        this.toastMessage = '未选择支付方式';
                        this.toastShow = true;
                        return false;
					case this.cartInfo.length <= 0:
                        this.toastMessage = '未选择要购买的商品';
                        this.toastShow = true;
                        return false;
					case this.lastPaySum <= 0:
                        this.toastMessage = '支付金额不能小于等于0';
                        this.toastShow = true;
                        return false;
					case this.shonse != 0 && this.shonse == -1:
                        this.toastMessage = '请选择配送时间！';
                        this.toastShow = true;
                        return false;
				}
                for(var i in this.cartInfo) {
                    switch (true) {
                        case this.cartInfo[i].deliverytime == 0:
                            break;
                        case this.cartInfo[i].deliverytime == 1:
                            alert("抱歉，当日配送商品已截单。请到次日配送专区选购，谢谢合作！");
                            this.$route.go({name: 'card'});
                            break;
					}
                }
                this.loadingMessage = '正在提交...';
                this.loadingShow = true;
                let pdata = {
                    uid: this.$ustore.id,
                    token: this.$ustore.token,
                    paytype: this.payType,
                    products: this.cartInfo,
                    stype: this.deliverType,
                    address: this.address,
                    coupon: this.coupon,
                    score: this.sNumber,
                    scoreNumber: this.scoreNumber,
                    paysum: this.lastPaySum,
                    tips: this.memo,
                    openid: 'os0CqxBBANhLuBLTsViL3C0zDlNs',//sessionStorage.getItem("openid"), os0CqxBBANhLuBLTsViL3C0zDlNs
                    pshonse: this.shonse,
                    gift: {'shopid':this.shopid,'id':this.address,'giftstu':this.giftstu},
                };
                this.$postData('/index/user/getSubmitOrder',pdata).then((res)=>{
                    if (res.status == 1) {
                        this.clearSel();
                        this.$router.replace('order/detail/' + res.oid);
                        this.loadingShow = false;
                    } else if (res.status == 0) {
                        alert(res.info);
                        this.loadingShow = false;
                        this.$router.go({name:'cart'});
                    } else if (res.status == -1) {
                        this.loadingShow = false;
                        this.toastMessage = res.info;
                        this.toastShow = true;
                        let context = this;
                        setTimeout(function(){
                            context.clearAll();
                            sessionStorage.removeItem('userInfo');
                            localStorage.removeItem('userInfo');
                            context.$router.go({name:'login'});
                        },800);
                    } else {
                        this.loadingShow = false;
                        alert(res.info);
                    }
                },(res)=>{
                    this.loadingShow = false;
                    this.toastMessage = '网络开小差了~';
                    this.toastShow = true;
                });
                return true;
            }
        }
    }
</script>

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
	.line-con .addition {
		width: 90%;
		background: #f2f2f2;
		height: 8rem;
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
	.address-box .add-con>div.words .name p,add p {
		line-height: 2.5rem;
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
		height: 130px;
		overflow-x: auto;
		overflow-y: hidden;
	}
	.give-container .give-order ul .notActive {
		width: 23.7%;
		float: left;
		transition: 0.5s;
		border: 2px solid #fff;
	}
	.give-container .give-order ul .activeGift {
		width: 23.7%;
		float:left;
		border:2px solid #c40000;
		transition:0.5s;
	}
	.give-container .give-order ul li .shop-img {
		width: 100%;
		height: 75px;
		position: relative;
	}
	.give-container .give-order ul li .shop-img .shopover {
		font-size:16px;
		position: absolute;
		top:0px;
		left:0px;
		line-height: 75px;
		text-align:center;
		width:100%;
		height:75px;
		background: rgba(0,0,0,0.5);
		color:#fff;
	}
	.give-container .give-order ul li p {
		font-size: 12px;
		line-height: 20px;
		text-align: left;
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