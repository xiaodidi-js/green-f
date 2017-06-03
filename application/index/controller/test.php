
<?php
//获取订单信息
    public function getSubmitOrder(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $oid = trim($request->param('oid'));
                if(!$id||!$gtoken||!$oid){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = db('member')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'用户不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['utel'],'upwd'=>$user['upwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'用户验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                //获取订单信息
                $order = db('member_orders')->where('id',$oid)->where('uid',$id)->where('is_del',0)->field('uid,postcode,wxoid,openid,sinfo,scom,is_del',true)->find();
                if(!$order){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }
                $order['statext'] = '待支付';
                //获取购买商品列表
                $products = db('member_orderlist')->alias('l')->join('product p','l.pid = p.id','LEFT')->join('member_orders k','l.oid = k.orderid')->where('l.uid',$id)->where('l.oid',$order['orderid'])->order('l.id desc')->field('p.id,p.name,p.shotcut,l.price,l.amount as nums,l.fname as formatName,p.deliverytime,k.stime')->select();
                //构造订单状态条数据
                $status = [];
                $active = 0;
                //提交状态
                if($order['createtime']){
                    $status[] = ['status'=>1,'title'=>'提交订单','time'=>date('Y-m-d H:i:s',$order['createtime'])];
                    $active = 0;
                    $order['statext'] = '待支付';
                }else{
                    $status[] = ['status'=>0,'title'=>'提交订单','time'=>0];
                }
                unset($order['createtime']);
                //支付状态
                if($order['pay']){
                    $status[] = ['status'=>1,'title'=>'已支付','time'=>date('Y-m-d H:i:s',$order['paytime'])];
                    $active = 1;
                    $order['statext'] = '待发货';
                }else{
                    $status[] = ['status'=>0,'title'=>'已支付','time'=>0];
                }
                unset($order['paytime']);
                //发货状态
                if($order['send']){
                    $status[] = ['status'=>1,'title'=>'商品出库','time'=>date('Y-m-d H:i:s',$order['stime'])];
                    $active = 2;
                    $order['statext'] = '待收货';
                }else{
                    $status[] = ['status'=>0,'title'=>'商品出库','time'=>0];
                }
                unset($order['stime']);
                //收货状态
                if($order['receive']){
                    $status[] = ['status'=>1,'title'=>'已收货','time'=>date('Y-m-d H:i:s',$order['gtime'])];
                    $active = 3;
                    $order['statext'] = '确认收货';
                }else{
                    $status[] = ['status'=>0,'title'=>'已收货','time'=>0];
                }
                unset($order['gtime']);

                //订单状态
                if($order['status']==-1){
                    $order['statext'] = '用户取消';
                }else if($order['status']==-2){
                    $order['statext'] = '申请售后';
                }

                //退货状态
                if($order['reject']==1&&$order['rtime']){
                    $status[3] = ['status'=>1,'title'=>'已退货','time'=>date('Y-m-d H:i:s',$order['rtime'])];
                    $order['statext'] = '已退货';
                }

                foreach($products as $k=>$v){
                    $products[$k]['price'] = floatval($v['price']/$v['nums']);
                }
                
                //返回数据
                $info = [];
                $info['pindex'] = $active;
                $info['process'] = $status;
                $info['order'] = $order;
                $info['products'] = $products;
                $result = makeResult(1,'ok',$info);
                return $this->response($result,'json',200);
                break;
            case 'post':
                $data = $request->put();
                $id = intval($data['uid']);
                $gtoken = trim($data['token']);
                // lzc-订单获取openid
                // $openid = trim($data['openid']);
                $openid = '123';
                $data['paytype'] = intval($data['paytype']);
                //token验证
                if(!$data){
                    $result = makeResult(0,'未提交数据');
                    return $this->response($result,'json',200);
                // lzc
                // }else if(!$id||!$gtoken){
                }else if(!$id||!$gtoken||!$openid){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = db('member')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'用户不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['utel'],'upwd'=>$user['upwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'用户验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                unset($data['uid']);
                unset($data['token']);
                //判断微信版本号
                if($data['paytype']===1){
                    $header = $request->header('user-agent');
                    $judge = judgeWechatVersion($header);
                    if(strpos($header,config('wxheader'))!==false&&$judge===false){
                        $result = makeResult(0,'当前微信版本过低,无法发起支付');
                        return $this->response($result,'json',200);
                    }
                }
                //订单数据处理
                $validate = validate('Order');
                if(!$validate->check($data)){
                    $result = makeResult(0,$validate->getError());
                    return $this->response($result,'json',200);
                }
                unset($validate);
                //开始构造订单数据数组
                $now = time();
                $orderData = [];
                $productsData = [];
                //处理地址信息
                if($data['stype']=='express'){
                    $addressInfo = db('member_address')->where('id',$data['address'])->where('uid',$id)->field('person,code,area,address,tel')->find();
                    if(!$addressInfo){
                        $result = makeResult(0,'收货地址不存在');
                        return $this->response($result,'json',200);
                    }
                    $orderData['person'] = $addressInfo['person'];
                    $orderData['postcode'] = $addressInfo['code'];
                    $orderData['address'] = str_replace(' ','',$addressInfo['area'].$addressInfo['address']);
                    $orderData['tel'] = $addressInfo['tel'];
                    $area = explode(' ',$addressInfo['area']);
                    $aid = db('product_area')->where('name',$area[0])->value('id');
                }else{
                    $addressInfo = db('handtake_place')->where('id',$data['address'])->where('status',1)->field('name,address,tel')->find();
                    if(!$addressInfo){
                        $result = makeResult(0,'收货地址不存在');
                        return $this->response($result,'json',200);
                    }
                    $orderData['person'] = $addressInfo['name'];
                    $orderData['postcode'] = '';
                    $orderData['address'] = $addressInfo['address'];
                    // $orderData['tel'] = $addressInfo['tel'];
                    // lzc-编辑订单再也不保存自提点的手机号码,现在保存用户号码
                    $user = db('member')->where('id',$id)->field('utel')->find();
                    $orderData['tel'] = $user['utel'];
                    
                    $aid = 0;
                }
                unset($addressInfo);
                //检查并获取优惠券
                $clistDb = db('coupon_list');
                if($data['coupon']){
                    $couponInfo = db('coupon')->where('id',$data['coupon'])->where('stime','<=',$now)->where('etime','>=',$now)->where('status',1)->field('collect_money,minus_money,discount,type')->find();
                    if(!$couponInfo){
                        $result = makeResult(0,'优惠券已过期或不存在');
                        return $this->response($result,'json',200);
                    }else if($clistDb->where('uid',$id)->where('cid',$data['coupon'])->find()){
                        $result = makeResult(0,'优惠券已失效');
                        return $this->response($result,'json',200);
                    }
                }
                //处理积分
                if($data['score']){
                    $orderData['score'] = intval($user['score'])/100;
                }else{
                    $orderData['score'] = 0;
                }

                // 检查是否有填写配送时间
                if(empty($data['pshonse'])){
                    $result = makeResult(0,'没有选择配送时间');
                    return $this->response($result,'json',200);
                }

                //生成订单号
                $orderDb = db('member_orders');
                do{
                   $orderNum = $this->makeOrderNumber(); 
                }while(empty($orderNum)||$orderDb->where('orderid',$orderNum)->find());
                //初始化添加数据
                $orderData['uid'] = $id;
                $orderData['pay'] = 0;
                $orderData['paytype'] = $data['paytype'];
                $orderData['tips'] = trim(strip_tags($data['tips']));
                $orderData['orderid'] = $orderNum;
                $orderData['createtime'] = $now;
                $orderData['send'] = 0;
                $orderData['stype'] = strtolower(trim($data['stype']));
                $orderData['receive'] = 0;
                $orderData['reject'] = 0;
                $orderData['status'] = 0;
                $orderData['is_del'] = 0;
                $orderData['sum'] = 0;
                $orderData['money'] = 0;
                $orderData['freight'] = 0;

                // lzc-记录openid
                $orderData['openid'] = $openid;
                

                //存储商品id
                $pids = [];
                //处理商品数据
                if(count($data['products'])<=0){
                    $result = makeResult(0,'请选择要购买的商品');
                    return $this->response($result,'json',200);
                }
                $productDb = db('product');

                // lzc-查询限时抢购数据 1/6
                $intime = date('Y-m-d');
                $nowtime = time();
                $querysale = Model('Sale')->querysale($nowtime);
                foreach($data['products'] as $pk=>$pv){
                    //释放多余变量
                    unset($data['products'][$pk]['shotcut']);
                    unset($data['products'][$pk]['store']);
                    //获取商品库存、价格和运费等信息
                    $getField = 'p.deliverytime,p.id,p.name,p.price,p.is_promote,p.promote_price,p.promote_start,p.promote_end,p.store,p.is_sell,p.is_del,form.format,form.price as fprice,form.store as fstore,freight.freight,form.id as formatid';
                    $productInfo = $productDb->alias('p')
                                            ->join('product_formlist as form','(p.id = form.pid) AND form.format = "'.$pv['format'].'"','LEFT')
                                            ->join('product_freight freight','(p.id = freight.pid) AND freight.aid = '.$aid,'LEFT')
                                            ->where('p.id',$pv['id'])
                                            ->field($getField)
                                            ->find();
                    // 配送时间
                    if($pv['deliverytime'] == 0){
                        $intime = time()+86400;
                    }else{
                        $intime = time();
                    }
                    $nowdate = date('Y-m-d',$intime);
                    if($data['pshonse'] == 1){
                        $nowdate = $nowdate.'10:30';
                    }else{
                        $nowdate = $nowdate.'16:30';
                    }
                    $nowdate = strtotime($nowdate);
                    $orderData['stime'] = $nowdate;

                    // lzc-判断限时抢购开始，如果你要修改的不涉及限时抢购可以忽略 2/6
                    if($querysale){
                        if($querysale['datashop']){
                            foreach ($querysale['datashop'] as $lzcKey1 => $lzcValue1) {
                                // 判断是否活动正在开始，判断商品id是否等于选中的商品id
                                if($lzcValue1['shopid'] == $productInfo['id']){
                                    $saledata['nowshop'] = $lzcValue1;
                                    $saledata['saleid'] = $querysale['id'];
                                    foreach ($saledata['nowshop']["saledata"] as $key1 => &$value1){
                                        // 不用判断规格
                                        // if(empty($productInfo['formatid'])){
                                        $productInfo['fprice'] = $value1['price'];
                                        $productInfo['salepaynub'] = $value1['salepaynub'];
                                        $productInfo['salenub'] = $value1['salenub'];
                                        $productInfo['salekucunnub'] = $value1['salekucunnub'];
                                        $guigeok = 1;
                                        /*}else{
                                            // 判断选中的规格id是否符合
                                            if($value1['formatid'] == $productInfo['formatid']){
                                                $productInfo['fprice'] = $value1['saleprice'];
                                                $productInfo['salepaynub'] = $value1['salepaynub'];
                                                $productInfo['salenub'] = $value1['salenub'];
                                                $productInfo['salekucunnub'] = $value1['salekucunnub'];
                                                // 是否符合选中的规格
                                                $guigeok = 1;
                                            }else{
                                                // 是否符合选中的规格
                                                $guigeok = 0;
                                            }
                                        }*/
                                    }

                                    if($productInfo['salekucunnub'] == 0){
                                        $result = makeResult(0,'已售完');
                                        $shouwan = 1;
                                    }else{
                                        $shuliang = $productInfo['salekucunnub'] - $pv['nums'];
                                        if($shuliang < 0){
                                            $result = makeResult(0,'现在库存只有'.$productInfo['salekucunnub']);
                                            $kucunbuzu = 1;
                                        }else{
                                            $productInfo['salekucunnub'] = $productInfo['salekucunnub'] - $pv['nums'];
                                            $value1['salekucunnub'] = $productInfo['salekucunnub'];
                                            $lzcValue1["saledata"] = $value1;
                                            $sale[$lzcKey1] = $lzcValue1;
                                        }
                                    }
                                    if($guigeok){
                                        // 查询已经购买了多少份
                                        $where['o.pay'] = 1;
                                        $where['o.openid'] = $openid;
                                        $where['l.pid'] = $saledata['nowshop']['shopid'];
                                        $where['l.sale'] = $saledata['saleid'];
                                        $querysalenum = db('member_orders o')->join('member_orderlist l','l.oid = o.orderid')->where($where)->field('id')->count();
                                        if($productInfo['salepaynub'] < $querysalenum){
                                            $result = makeResult(0,$productInfo['name'].'限时抢购只可买'.$productInfo['salepaynub'].'份');
                                            return $this->response($result,'json',200);
                                        }
                                    }
                                }
                            }
                        }
                        // 判断有没有警告
                        if(!empty($shouwan) || !empty($kucunbuzu)){
                            return $this->response($result,'json',200);
                        }
                        // 
                        if(empty($saledata)){
                            $saledata = null;
                            $saledata['saleid'] = 0;
                        }
                    }else{
                        $saledata = null;
                        $saledata['saleid'] = 0;
                    }
                    // lzc-判断限时抢购结束，如果你要修改的不涉及限时抢购可以忽略 3/6

                    //检查商品状态
                    if($productInfo['is_sell']!=1||$productInfo['is_del']==1){
                        $result = makeResult(0,$productInfo['name'].'已下架');
                        return $this->response($result,'json',200);
                    }

                    /*
                     *  限时抢购
                     *  $saledata['nowshop'] 是否选择了限时抢购的商品
                     *  $guigeok 是否满足选定限时抢购的规格
                     */
                    //lzc-限时抢购增加条件如果限时抢购为空就不经过这里了，因为已经判断好规格 4/6
                    if(!empty($pv['format'])){
                        if($productInfo['fstore']<$pv['nums']){
                            $result = makeResult(0,$productInfo['name'].'库存不足(剩余:'.$productInfo['fstore'].'件)');
                            return $this->response($result,'json',200);
                        } 
                        //计算商品总价
                        $orderData['sum'] += floatval($productInfo['fprice']) * intval($pv['nums']);
                        //构造订单列表
                        $productsData[] = ['uid'=>$id,'oid'=>$orderNum,'pid'=>$productInfo['id'],'price'=>floatval($productInfo['fprice']) * intval($pv['nums']),'amount'=>$pv['nums'],'format'=>$pv['format'],'fname'=>$pv['formatName']/*限时抢购记录订单列表*/,'sale'=>$saledata['saleid']];
                    }else{
                        if($productInfo['store']<$pv['nums']){
                            $result = makeResult(0,$productInfo['name'].'库存不足(剩余:'.$productInfo['store'].'件)');
                            return $this->response($result,'json',200);
                        }
                        //计算商品总价
                        //判断是否优惠活动
                        if($productInfo['is_promote']==1&&$now>=$productInfo['promote_start']&&$now<=$productInfo['promote_end']&&$productInfo['promote_price']){
                            $orderData['sum'] += floatval($productInfo['promote_price']) * intval($pv['nums']);
                            //构造订单列表
                            $productsData[] = ['uid'=>$id,'oid'=>$orderNum,'pid'=>$productInfo['id'],'price'=>floatval($productInfo['promote_price']) * intval($pv['nums']),'amount'=>$pv['nums'],'format'=>$pv['format'],'fname'=>$pv['formatName']/*限时抢购记录订单列表*/,'sale'=>$saledata['saleid']];
                        }else{
                            $orderData['sum'] += floatval($productInfo['price']) * intval($pv['nums']);
                            //构造订单列表
                            $productsData[] = ['uid'=>$id,'oid'=>$orderNum,'pid'=>$productInfo['id'],'price'=>floatval($productInfo['price']) * intval($pv['nums']),'amount'=>$pv['nums'],'format'=>$pv['format'],'fname'=>$pv['formatName']/*限时抢购记录订单列表*/,'sale'=>$saledata['saleid']];
                        }
                    }
                    //计算运费
                    if(!in_array($pv['id'],$pids)&&$data['stype']=='express'){
                        $pids[] = $pv['id'];
                        $orderData['freight'] += floatval($productInfo['freight']);
                    }
                    unset($productInfo);
                    // 清除guigeok不再进处理规格
                    unset($guigeok);
                }
                // 限时抢购清除数组
                unset($querysale);
                //计算实际支付金额
                if(isset($couponInfo)){
                    if(($couponInfo['type']==3||$couponInfo['type']==4)&&$orderData['sum']<floatval($couponInfo['collect_money'])){
                        $result = makeResult(0,'订单金额不满足优惠券使用金额');
                        return $this->response($result,'json',200);
                    }
                    if($couponInfo['type']==1||$couponInfo['type']==3){
                        $orderData['coupon'] = floatval($couponInfo['minus_money']);
                    }else{
                        $orderData['coupon'] = (1-floatval($couponInfo['discount'])) * $orderData['sum'];
                    }
                    $orderData['money'] = $orderData['sum'] + $orderData['freight'] - $orderData['coupon'] - $orderData['score'];
                }else{
                    $orderData['coupon'] = 0;
                    $orderData['money'] = $orderData['sum'] + $orderData['freight'] - $orderData['score'];
                }

                //防止恶意提交订单
                if($orderDb->where('createtime','>=',$now-5)->where('pay',0)->where('status',0)->where('is_del',0)->find()){
                    $result = makeResult(0,'请勿频繁提交订单');
                    return $this->response($result,'json',200);
                }
                //检查实际支付金额
                $orderData['money'] = $orderData['money']<=0 ? 0.01 : floatval($orderData['money']);
                //插入订单数据
                $add = $orderDb->insertGetId($orderData);
                if(!$add){
                    $result = makeResult(0,'订单提交失败');
                    return $this->response($result,'json',200);
                }
                //添加优惠券使用数据
                if(isset($couponInfo)){
                    $clistDb->insert(['uid'=>$id,'cid'=>$data['coupon'],'usetime'=>$now]);
                }
                //添加积分使用记录
                if($orderData['score']>0){
                    db('score_lists')->insert(['uid'=>$id,'type'=>'orders','amount'=>'-'.$user['score'],'createtime'=>$now]);
                    db('member')->where('id',$id)->update(['score'=>0]);
                }
                //插入订单列表数据
                db('member_orderlist')->insertAll($productsData);
                unset($orderData);
                unset($data);
                unset($user);
                // 限时抢购记录销量 不会影像正常商品的库存 6/6
                if(!empty($saledata['nowshop'])){

                }else{
                    //库存扣减和销量记录
                    $formlistDb = db('product_formlist');
                    foreach($productsData as $k=>$v) {
                        $productDb->where('id',$v['pid'])->setDec('store',$v['amount']);
                        if(!empty($pv['format'])){
                            $formlistDb->where('pid',$v['pid'])->where('format',$v['format'])->setDec('store',$v['amount']);
                        }
                    }
                }

                
                unset($formlistDb);
                unset($productsData);
                //返回信息
                $result = makeResult(1,'订单提交成功',['oid'=>$add]);
                return $this->response($result,'json',200);
                break;
            case 'put':
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $oid = intval($request->put('oid'));
                $opid = trim($request->put('opid'));
                if(!$id||!$gtoken||!$oid||!$opid){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = db('member')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'用户不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['utel'],'upwd'=>$user['upwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'用户验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);

                //支付成功的时候修改订单状态，否则跳过
                $paysuccess = intval($request->put('paysuccess'));
                if($paysuccess){
                    $ptime = time();
                    $up = db('member_orders')->where('id',$oid)->where('uid',$id)->update(['pay'=>1,'paytime'=>$ptime]);
                    if($up){
                        $result = makeResult(1,'订单支付成功',['time'=>date('Y-m-d H:i:s',$ptime)]);
                    }else{
                        $queryorder = db('member_orders')->where('id',$oid)->find();
                        if($queryorder['pay'] == 1){
                            $result = makeResult(1,'订单支付成功');
                        }else{
                            $result = makeResult(0,'订单支付失败');
                        }
                    }
                    return $this->response($result,'json',200);
                }

                //获取订单信息
                $order = db('member_orders')->where('id',$oid)->where('uid',$id)->where('is_del',0)->find();
                if(!$order){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }
                //生成订单信息
                Loader::import('wxpay.lib.WxPay#Api',EXTEND_PATH);
                Loader::import('wxpay.tools.WxPay#JsApiPay',EXTEND_PATH);
                // Loader::import('wxpay.tools.log',EXTEND_PATH);
                $tools = new \JsApiPay();

                //初始化日志
                // $logHandler= new \CLogFileHandler(APP_PATH.'/../public/logs/wxpay'.date('Y-m-d').'.log');
                // $log = \Log::Init($logHandler, 15);
                $order['money'] = $order['money']*100;
                //订单数据
                $shoper = db('profile')->where('id',1)->field('name,description')->find();
                $input = new \WxPayUnifiedOrder();
                $input->SetBody($shoper['name'].'订单');
                $input->SetAttach($shoper['description']);
                $input->SetOut_trade_no($order['orderid']);
                $input->SetTotal_fee($order['money']);
                $input->SetTime_start(date("YmdHis"));
                $input->SetTime_expire(date("YmdHis",time()+600));
                $input->SetGoods_tag("common");
                $input->SetNotify_url(config('notify_url.wechat'));
                $input->SetTrade_type("JSAPI");
                $input->SetOpenid($opid);
                $wxOrder = \WxPayApi::unifiedOrder($input);

                //返回数据
                $info = [];
                if($wxOrder['return_code']=='SUCCESS'&&$wxOrder['result_code']=='SUCCESS'){
                    /*$Index = new Index;
                    $wxorderok = $Index->payoknotice($opid,$order);*/
                    $jsApiParameters = $tools->GetJsApiParameters($wxOrder);
                    $info['payment'] = $jsApiParameters;
                    $result = makeResult(1,'ok',$info);
                    return $this->response($result,'json',200);
                }

                //失败时记录日志
                // \Log::DEBUG("unifiedOrder: ".json_encode($wxOrder)."\n");
                $result = makeResult(0,$wxOrder['return_msg']);
                return $this->response($result,'json',200);
                break;
            case 'delete':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $oid = trim($request->param('oid'));
                if(!$id||!$gtoken||!$oid){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = db('member')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'用户不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['utel'],'upwd'=>$user['upwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'用户验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                //获取订单信息
                $orderDb = db('member_orders');
                $order = $orderDb->where('id',$oid)->where('uid',$id)->where('is_del',0)->field('id,pay,paytime,orderid,send,receive')->find();
                if(!$order){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }else if($order['pay']==1||$order['send']==1||$order['receive']==1){
                    $result = makeResult(0,'订单已支付');
                    return $this->response($result,'json',200);
                }
                $up = $orderDb->where('id',$order['id'])->update(['paytime'=>time(),'status'=>-1]);
                if(!$up){
                    $result = makeResult(0,'订单取消失败');
                    return $this->response($result,'json',200);
                }
                //库存返还和销量记录
                $productDb = db('product');
                $formlistDb = db('product_formlist');
                $olist = db('member_orderlist')->where('uid',$id)->where('oid',$order['orderid'])->field('pid,amount,format')->select();
                foreach($olist as $k=>$v) {
                    $productDb->where('id',$v['pid'])->setInc('store',$v['amount']);
                    $productDb->where('id',$v['pid'])->setDec('sale',$v['amount']);
                    if(!empty($pv['format'])){
                        $formlistDb->where('pid',$v['pid'])->where('format',$v['format'])->setInc('store',$v['amount']);
                    }
                }
                //返回信息
                $result = makeResult(1,'订单已取消');
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }