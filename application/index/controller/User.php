<?php
namespace app\index\controller;
use think\Request,think\Token,think\Loader;
class User extends RestBase
{
    public function __construct(){
        //继承父类构造方法
        parent::__construct();
    }

    //图片上传又拍云
    public function makeInfoForUpyun(){
    	$form_api_secret = config('upyun_config.form_api');
        $param['bucket'] = config('upyun_config.bucket');
    	$param['save-key'] = config('upyun_config.save_key');
    	$param['expiration'] = time() + 1800;
        $param['notify-url'] = config('upyun_config.notify');
    	$request = Request::instance();
    	switch($this->method){
    		case 'put':
                if(!empty($request->put('ext-param')))
                    $param['ext-param'] = trim($request->put('ext-param'));
                if(!empty($request->put('allow-file-type')))
                    $param['allow-file-type'] = trim($request->put('allow-file-type'));
                if(!empty($request->put('ftype'))){
                    $ftype = explode('/',$request->put('ftype'));
                    if($ftype[0]=='image'){
                        $param['x-gmkerl-thumb'] = '/rotate/auto';
                    }
                }
                $json = json_encode($param);
                $policy = base64_encode($json);
                $signature = md5($policy.'&'.$form_api_secret);
				$merge = ['policy'=>$policy,'signature'=>$signature,'url'=>'http://v0.api.upyun.com/'.$param['bucket'],'notify'=>$param['notify-url'],'domain'=>config('upyun_config.domain')];
                if(!empty($param['ext-param']))
                    $merge['param'] = $param['ext-param'];
                if(!empty($param['x-gmkerl-thumb']))
                    $merge['thumb'] = $param['x-gmkerl-thumb'];
                $result = makeResult(1,'ok',$merge);
				return $this->response($result,'json',200);
    			break;
    		default:
    			break;
    	}
    }
    
    public function userCollection(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                if(!$id||!$gtoken){
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
                unset($user);
                $list = db('member_collect')->alias('c')->join('product p','c.pid = p.id','LEFT')->where('uid',$id)->order('c.createtime desc')->field('c.id,c.pid,p.name,p.shotcut,p.price,p.store')->select();
                $result = [];
                if(!$list){
                    $result = makeResult(1,'none');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok',['list'=>$list]);
                return $this->response($result,'json',200);
                break;
            case 'put':
                $data = $request->put();
                $data['uid'] = intval($data['uid']);
                $data['pid'] = intval($data['pid']);
                $data['token'] = trim($data['token']);
                if(!$data){
                    $result = makeResult(0,'未提交数据');
                    return $this->response($result,'json',200);
                }else if(!$data['uid']||!$data['pid']||empty($data['token'])){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = db('member')->where('id',$data['uid'])->find();
                if(!$user){
                    $result = makeResult(-1,'用户不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['utel'],'upwd'=>$user['upwd']],$data['token']);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'用户验证失败');
                    return $this->response($result,'json',200);
                }
                unset($data['token']);
                unset($user);
                $collect = db('member_collect');
                if($collect->where('uid',$data['uid'])->where('pid',$data['pid'])->find()){
                    $add = $collect->where('uid',$data['uid'])->where('pid',$data['pid'])->delete();
                    $success = '取消收藏成功';
                    $fail = '取消收藏失败';
                }else{
                    $add = db('member_collect')->insert(['uid'=>$data['uid'],'pid'=>$data['pid'],'createtime'=>time()]);
                    $success = '添加收藏成功';
                    $fail = '添加收藏失败';
                }
                if(!$add){
                    $result = makeResult(0,$fail);
                }else{
                    $result = makeResult(1,$success);
                }
                return $this->response($result,'json',200);
                break;
            case 'delete':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $type = intval($request->param('type'));
                $cid = trim($request->param('cid'));
                if(!$id||!$gtoken||!$cid){
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
                unset($user);
                if($type===1){
                    $del = db('member_collect')->where('id','in',$cid)->delete();
                }else{
                    $del = db('member_collect')->where('id',$cid)->delete();
                }
                if(!$del){
                    $result = makeResult(0,'取消收藏失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'取消收藏成功');
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //用户信息
    public function userInfo(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                if(!$id||!$gtoken){
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
                unset($user);
                $list = db('member')->where('id',$id)->field('uname,score,shotcut')->find();
                $result = [];
                if(!$list){
                    $result = makeResult(0,'信息获取失败');
                    return $this->response($result,'json',200);
                }
                $list['shotcut'] = empty($list['shotcut']) ? '' : $list['shotcut'];
                $result = makeResult(1,'ok',$list);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //地址列表
    public function addressList(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                if(!$id||!$gtoken){
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
                unset($user);
                $list = db('member_address')->where('uid',$id)->order('id desc')->field('id,person as name,tel,area,address,is_default')->select();
                $result = [];
                if(!$list){
                    $result = makeResult(0,'没有已添加地址');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok',['list'=>$list]);
                return $this->response($result,'json',200);
                break;
            case 'put':
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $aid = intval($request->put('aid'));
                if(!$id||!$gtoken||!$aid){
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
                unset($user);
                $address = db('member_address');
                $address->where('uid',$id)->where('id','<>',$aid)->where('is_default','<>',0)->update(['is_default'=>0]);
                $up = $address->where('uid',$id)->where('id',$aid)->update(['is_default'=>1]);
                if(!$up){
                    $result = makeResult(0,'fail');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok');
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //地址信息
    public function addressInfo(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $aid = intval($request->param('aid'));
                if(!$id||!$gtoken||!$aid){
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
                unset($user);
                $info = db('member_address')->where('id',$aid)->field('id',true)->find();
                if(!empty($info['area'])) $info['area'] = explode(' ',$info['area']);
                $result = [];
                if(!$info){
                    $result = makeResult(0,'信息获取失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok',$info);
                return $this->response($result,'json',200);
                break;
            case 'post':
                $data = $request->put();
                $id = intval($data['uid']);
                $gtoken = trim($data['token']);
                $result = [];
                if(!$data){
                    $result = makeResult(0,'未提交数据');
                    return $this->response($result,'json',200);
                }else if(!$id||!$gtoken){
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
                unset($data['token']);
                unset($user);
                if(!$data['person']){
                    $result = makeResult(0,'请填写收货人姓名');
                    return $this->response($result,'json',200);
                }else if(!$data['tel']){
                    $result = makeResult(0,'请填写收货人电话');
                    return $this->response($result,'json',200);
                }else if(!$data['code']){
                    $result = makeResult(0,'请填写邮政编码');
                    return $this->response($result,'json',200);
                }else if(!$data['area']){
                    $result = makeResult(0,'请选择收货省份地区');
                    return $this->response($result,'json',200);
                }else if(!$data['address']){
                    $result = makeResult(0,'请填写详细收货地址');
                    return $this->response($result,'json',200);
                }
                $addressDb = db('member_address');
                if($addressDb->where('uid',$id)->where('is_default',1)->count()){
                    $data['is_default'] = 0;
                }else{
                    $data['is_default'] = 1;
                }
                $add = $addressDb->insert($data);
                if(!$add){
                    $result = makeResult(0,'地址添加失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'地址添加成功');
                return $this->response($result,'json',200);
                break;
            case 'put':
                $data = $request->put();
                $id = intval($data['uid']);
                $gtoken = trim($data['token']);
                $result = [];
                if(!$data){
                    $result = makeResult(0,'未提交数据');
                    return $this->response($result,'json',200);
                }else if(!$id||!$gtoken){
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
                unset($user);
                if(!$data['person']){
                    $result = makeResult(0,'请填写收货人姓名');
                    return $this->response($result,'json',200);
                }else if(!$data['tel']){
                    $result = makeResult(0,'请填写收货人电话');
                    return $this->response($result,'json',200);
                }else if(!$data['code']){
                    $result = makeResult(0,'请填写邮政编码');
                    return $this->response($result,'json',200);
                }else if(!$data['area']){
                    $result = makeResult(0,'请选择收货省份地区');
                    return $this->response($result,'json',200);
                }else if(!$data['address']){
                    $result = makeResult(0,'请填写详细收货地址');
                    return $this->response($result,'json',200);
                }
                $data['id'] = intval($data['id']);
                $up = db('member_address')->update($data);
                if(!$up){
                    $result = makeResult(0,'地址修改失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'地址修改成功');
                return $this->response($result,'json',200);
                break;
            case 'delete':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $aid = intval($request->param('aid'));
                if(!$id||!$gtoken||!$aid){
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
                unset($user);
                $del = db('member_address')->delete($aid);
                if(!$del){
                    $result = makeResult(0,'地址删除失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok');
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //优惠券信息
    public function couponInfo(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                if(!$id||!$gtoken){
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
                unset($user);
                $now = time();
                $list = db('coupon')->where('status',1)->where('etime','>=',$now)->order('createtime desc')->field('id,shotcut,description,stime,etime,type,collect_money,minus_money,discount')->select();
                if(!$list){
                    $result = makeResult(1,'ok',['coupon'=>[]]);
                    return $this->response($result,'json',200);
                }
                $unuselist = [];
                $uselist = db('coupon_list')->where('uid',$id)->column('usetime','cid');
                foreach($list as $k=>$v) {
                    $vid = $v['id'];
                    if(!isset($uselist[$vid])||!$uselist[$vid]){
                        $unuselist[] = array_merge($v,['remain'=>ceil(($v['etime']-$now)/86400),'stime'=>date('Y-m-d',$v['stime']),'etime'=>date('Y-m-d',$v['etime'])]);
                    }
                }
                unset($list);
                unset($uselist);
                $result = makeResult(1,'ok',['coupon'=>$unuselist]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //优惠券列表
    public function couponList(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $price = floatval($request->param('price'));
                if(!$id||!$gtoken){
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
                unset($user);
                $now = time();
                $list = db('coupon')->where('(status = 1 AND etime >= :etime AND type IN (1,2)) OR (status = 1 AND etime >= :etime1 AND type IN (3,4) AND collect_money <= :price)',['etime'=>$now,'etime1'=>$now,'price'=>$price])->order('createtime desc')->field('id,title,etime,type,collect_money,minus_money,discount')->select();
                if(!$list){
                    $result = makeResult(0,'fail');
                    return $this->response($result,'json',200);
                }
                $unuselist = [];
                $uselist = db('coupon_list')->where('uid',$id)->column('usetime','cid');
                foreach($list as $k=>$v) {
                    $vid = $v['id'];
                    if(!isset($uselist[$vid])||!$uselist[$vid]){
                        $unuselist[] = array_merge($v,['remain'=>ceil(($v['etime']-$now)/86400),'etime'=>date('Y-m-d',$v['etime'])]);
                    }
                }
                unset($list);
                unset($uselist);
                $result = makeResult(1,'ok',['coupon'=>$unuselist]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //提交订单
    public function orderSubmission(){
        $request = Request::instance();
        $header = $request->header('user-agent');
        switch($this->method){
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $pids = trim($request->param('ids'));
                $opid = trim($request->param('openid'));
                if(!$id||!$gtoken){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = db('member')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'用户不存在');
                    return $this->response($result,'json',200);
                }
                //验证token
                $token = new Token(['id'=>$user['id'],'utel'=>$user['utel'],'upwd'=>$user['upwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'用户验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                //openid处理
                if(empty($user['openid'])||$opid!=$user['openid']){
                    db('member')->where('id',$id)->update(['openid'=>$opid]);
                }
                
                //收货&支付配置
                $shopConfig = db('pay_config')->field('express,handtake,alipay,wxpay')->where('id',1)->find();
                $payConfig = [];
                $deliverConfig = [];
                if($shopConfig){
                    if($shopConfig['express']==1)
                        $deliverConfig['express'] = '快递配送';
                    if($shopConfig['handtake']==1)
                        $deliverConfig['parcel'] = '到店自提';
                    if($shopConfig['wxpay']==1)
                        $payConfig[] = ['ch'=>'微信支付','en'=>'wxpay','ptype'=>1];
                    if($shopConfig['alipay']==1&&strpos($header,config('wxheader'))===false)
                        $payConfig[] = ['ch'=>'支付宝支付','en'=>'alipay','ptype'=>2];
                }else{
                    $payConfig[] = ['ch'=>'微信支付','en'=>'wxpay','ptype'=>1];
                    $deliverConfig['express'] = '快递配送';
                }
                //收货地址
                if(isset($deliverConfig['express'])){
                    $addressConfig = db('member_address')->where('uid',$id)->where('is_default',1)->field('id,person as name,area,address,tel')->order('id desc')->find();
                    //运费配置
                    if($pids&&$addressConfig){
                        $tmpArray = explode(' ',$addressConfig['area']);
                        $tmpArea = $tmpArray ? $tmpArray[0] : '';
                        $aid = db('product_area')->where('name',$tmpArea)->value('id');
                        $fee = db('product_freight')->where('pid','IN',$pids)->where('aid',$aid)->sum('freight');
                        unset($tmpArray);
                        unset($tmpArea);
                        unset($aid);
                        $freightConfig = $fee ? $fee : 0;
                    }else{
                        $freightConfig = 0;
                    }
                }else{
                    $addressConfig = db('handtake_place')->where('id',$user['handtake'])->where('pid','<>',0)->where('status',1)->field('id,name,address,tel')->order('id desc')->find();
                    //运费配置
                    $freightConfig = 0;
                }
                //最终输出数组
                $configs = ['deliver'=>$deliverConfig,'pay'=>$payConfig,'address'=>$addressConfig,'score'=>intval($user['score']),'freight'=>$freightConfig];
                unset($user);
                $result = makeResult(1,'ok',$configs);
                return $this->response($result,'json',200);
                break;
            case 'post':
                break;
            default:
                break; 
        }
    }

    //获取地址 or 自提点列表
    public function addressChosen(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $type = trim($request->param('type'));
                if(!$id||!$gtoken){
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
                if(!empty($type)){
                    if($type=='express'){
                        $where['uid'] = $id;
                        $list = db('member_address')->where($where)->order('id desc')->field('id,person as name,tel,area,address,is_default')->select(); 
                    }else{
                        $where['status'] = 1;
                        $where['pid'] = array('<>',0);
                        $where['address'] = array('<>','');
                        $where['tel'] = array('<>','');
                        $list = db('handtake_place')->where($where)->order('sort desc,id asc')->field('id,name,tel,address,pid')->select();
                        if($list){
                            foreach($list as $lk=>$lv){
                                $list[$lk]['area'] = '';
                                if($user['handtake']==$lv['id']){
                                    $list[$lk]['is_default'] = 1;
                                }else{
                                    $list[$lk]['is_default'] = 0;
                                }
                            }
                        }
                    }
                }else{
                    $list = [];
                }
                unset($user);
                $result = [];
                if(!$list){
                    $result = makeResult(0,'没有已添加地址');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok',['list'=>$list]);
                return $this->response($result,'json',200);
                break;
            case 'post':
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $type = trim($request->put('type'));
                $pids = trim($request->put('ids'));
                $area = trim($request->put('area'));
                if(!$id||!$gtoken||!$pids){
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
                unset($user);
                if(!empty($type)&&$type=='express'&&!empty('area')){
                    $tmpArray = explode(' ',$area);
                    $tmpArea = $tmpArray ? $tmpArray[0] : '';
                    $aid = db('product_area')->where('name',$tmpArea)->value('id');
                    $fee = db('product_freight')->where('pid','IN',$pids)->where('aid',$aid)->sum('freight');
                    unset($tmpArray);
                    unset($tmpArea);
                    unset($aid);
                    $freight = $fee ? $fee : 0;
                }else{
                    $freight = 0;
                }
                $result = makeResult(1,'ok',['freight'=>$freight]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //切换地址
    public function addessChange(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $type = trim($request->param('type'));
                $pids = trim($request->param('ids'));
                if(!$id||!$gtoken){
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
                if(!empty($type)){
                    if($type=='express'){
                        $list = db('member_address')->where('uid',$id)->where('is_default',1)->field('id,person,area,address,tel')->order('id desc')->find();
                        //运费配置
                        if($pids&&$list){
                            $tmpArray = explode(' ',$list['area']);
                            $tmpArea = $tmpArray ? $tmpArray[0] : '';
                            $aid = db('product_area')->where('name',$tmpArea)->value('id');
                            $fee = db('product_freight')->where('pid','IN',$pids)->where('aid',$aid)->sum('freight');
                            unset($tmpArray);
                            unset($tmpArea);
                            unset($aid);
                            $freight = $fee ? $fee : 0;
                        }else{
                            $freight = 0;
                        }
                    }else{
                        $list = db('handtake_place')->where('id',$user['handtake'])->where('pid','<>',0)->where('status',1)->field('id,name as person,address,tel')->order('id desc')->find();
                        $freight = 0;
                    }
                }else{
                    $list = [];
                }
                unset($user);
                $result = [];
                if(!$list){
                    $result = makeResult(1,'fail');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok',['address'=>$list,'freight'=>$freight]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //生成随机字符串
    private function makeNonceStr(){
        $str = str_replace('.','',config('app_version')).time().rand(10000,99999);
        $str = md5($str);
        return strtoupper($str);
    }

    //生成订单号
    private function makeOrderNumber(){
        $number = str_replace('.','',config('app_version')).date('YmdHis').rand(100,999);
        return $number;
    }

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
                $openid = trim($data['openid']);
                // lzc-活动状态
                // $openid = '123';
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

                // lzc-时间规划局
                $NowTimeStamp = time();
                $NextDayTimeStamp = time()+86400;
                
                // 满赠送
                

                $productDb = db('product');
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
                    if($pv['activestu'] == '1'){
                        
                        // 限时抢购活动
                        $Activedata = $this->SaleActive($productInfo,$pv['nums'],$user);
                        if(!empty($Activedata['error'])){
                            return $this->response($Activedata['error'],'json',200);
                        }
                        if($Activedata['noshop'] == 0){
                            $dbactive = 'sale';
                            $productInfo['price'] = $Activedata['data']['saleprice'];
                            $KuCunModel = Model('Sale');
                            $saleid = $Activedata['data']['saleid'];
                            $shareid = 0;
                            $qrcodeid = 0;
                        }else{
                            $saleid = 0;
                            $shareid = 0;
                            $qrcodeid = 0;
                        }
                    }elseif($pv['activestu'] == '2'){
                        $saleid = 0;
                        $shareid = $Activedata['data']['saleid'];
                        $qrcodeid = 0;
                        // 分享购买活动
                        $queryactive = Model('ProductShare')->query($NowTimeStamp);
                        $this->ShareActive($productInfo,$pv['nums'],$user);
                        $dbactive = 'share';
                    }elseif($pv['activestu'] == '3'){
                        $saleid = 0;
                        $shareid = 0;
                        $qrcodeid = $Activedata['data']['saleid'];
                        // 二维码购买活动
                        $queryactive = Model('ProductQrcode')->query($NowTimeStamp);
                        $this->QrcodeActive($productInfo,$pv['nums'],$user);
                        $dbactive = 'qrcode';
                    }
                    // 配送时间
                    if($pv['deliverytime'] == 0){
                        $intime = $NextDayTimeStamp;
                    }else{
                        $intime = $NowTimeStamp;
                    }
                    $nowdate = date('Y-m-d',$intime);
                    if($data['pshonse'] == 1){
                        $nowdate = $nowdate.'10:30';
                    }else{
                        $nowdate = $nowdate.'16:30';
                    }
                    $nowdate = strtotime($nowdate);
                    $orderData['stime'] = $nowdate;

                    //检查商品状态
                    if($productInfo['is_sell']!=1||$productInfo['is_del']==1){
                        $result = makeResult(0,$productInfo['name'].'已下架');
                        return $this->response($result,'json',200);
                    }

                    //检测库存
                    if(!empty($pv['format'])){
                        if($productInfo['fstore']<$pv['nums']){
                            $result = makeResult(0,$productInfo['name'].'库存不足(剩余:'.$productInfo['fstore'].'件)');
                            return $this->response($result,'json',200);
                        }
                        //计算商品总价
                        $orderData['sum'] += floatval($productInfo['fprice']) * intval($pv['nums']);
                        //构造订单列表
                        $productsData[] = ['uid'=>$id,'oid'=>$orderNum,'pid'=>$productInfo['id'],'price'=>floatval($productInfo['fprice']) * intval($pv['nums']),'amount'=>$pv['nums'],'format'=>$pv['format'],'fname'=>$pv['formatName']];
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
                            $productsData[] = ['uid'=>$id,'oid'=>$orderNum,'pid'=>$productInfo['id'],'price'=>floatval($productInfo['promote_price']) * intval($pv['nums']),'amount'=>$pv['nums'],'format'=>$pv['format'],'fname'=>$pv['formatName']];
                        }else{
                            $orderData['sum'] += floatval($productInfo['price']) * intval($pv['nums']);
                            //构造订单列表
                            // 优惠活动构造订单
                            if($pv['activestu'] > 0 && !empty($dbactive)){
                                $productsData[] = ['uid'=>$id,'oid'=>$orderNum,'pid'=>$productInfo['id'],'price'=>floatval($productInfo['price']) * intval($pv['nums']),'amount'=>$pv['nums'],'format'=>$pv['format'],'fname'=>$pv['formatName'],'sale'=>$saleid,'share'=>$shareid,'qrcode'=>$qrcodeid];
                                // 开始更新库存
                                if(!empty($Activedata['update']) && !empty($KuCunModel)){
                                    // 序列化数据
                                    $Activeupdate['data'] = serialize($Activedata['update']);
                                    // 活动id
                                    $ActiveWhere['id'] = $Activedata['data']['saleid'];
                                    $EditActive = $KuCunModel->edit($Activeupdate,$ActiveWhere);
                                }
                            }else{
                                $productsData[] = ['uid'=>$id,'oid'=>$orderNum,'pid'=>$productInfo['id'],'price'=>floatval($productInfo['price']) * intval($pv['nums']),'amount'=>$pv['nums'],'format'=>$pv['format'],'fname'=>$pv['formatName'],'sale'=>0,'share'=>0,'qrcode'=>0];
                            }
                        }
                    }
                    //计算运费
                    if(!in_array($pv['id'],$pids)&&$data['stype']=='express'){
                        $pids[] = $pv['id'];
                        $orderData['freight'] += floatval($productInfo['freight']);
                    }

                    unset($productInfo);
                    unset($Activedata);
                }
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
                //库存扣减和销量记录
                $formlistDb = db('product_formlist');
                foreach($productsData as $k=>$v) {
                    $productDb->where('id',$v['pid'])->setDec('store',$v['amount']);
                    $productDb->where('id',$v['pid'])->setInc('sale',$v['amount']);
                    if(!empty($pv['format'])){
                        $formlistDb->where('pid',$v['pid'])->where('format',$v['format'])->setDec('store',$v['amount']);
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

    //订单后续操作
    public function orderOperation(){
        $request = Request::instance();
        switch($this->method){
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
                $orderid = db('member_orders')->where('id',$oid)->where('uid',$id)->where('is_del',0)->value('orderid');
                if(!$orderid){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }
                //获取购买商品列表
                $field = 'p.id,p.name,p.shotcut,l.price,l.amount as nums,l.format,l.fname as formatName,f.store as fstore,p.store,p.deliverytime';
                $products = db('member_orderlist')->alias('l')
                                            ->join('product p','l.pid = p.id','LEFT')
                                            ->join('product_formlist f','l.pid = f.pid AND l.format = f.format','LEFT')
                                            ->where('l.uid',$id)
                                            ->where('l.oid',$orderid)
                                            ->order('l.id desc')
                                            ->field($field)
                                            ->select();
                if(!$products){
                    $result = makeResult(0,'商品列表获取失败');
                    return $this->response($result,'json',200);
                }
                //处理库存
                foreach($products as $k=>$v){
                    if(!empty($v['format'])&&!empty($v['fstore'])){
                        $products[$k]['store'] = $v['fstore'];
                    }
                    unset($products[$k]['fstore']);
                }
                //返回列表信息
                $result = makeResult(1,'ok',['list'=>$products]);
                return $this->response($result,'json',200);
                break;
            case 'put':
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $oid = intval($request->put('oid'));
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

                $orderDb = db('member_orders');
                //检查订单
                $order = $orderDb->where('id',$oid)->where('uid',$id)->where('is_del',0)->find();
                if(!$order){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }else if($order['status']==-1){
                    $result = makeResult(0,'订单已取消');
                    return $this->response($result,'json',200);
                }else if($order['pay']!=1){
                    $result = makeResult(0,'订单未支付');
                    return $this->response($result,'json',200);
                }else if($order['send']!=1){
                    $result = makeResult(0,'订单未发货');
                    return $this->response($result,'json',200);
                }else if($order['receive']==1&&$order['gtime']){
                    $result = makeResult(0,'订单已确认收货');
                    return $this->response($result,'json',200);
                }

                //更新收货信息
                $gtime = time();
                $up = $orderDb->where('id',$order['id'])->update(['receive'=>1,'gtime'=>$gtime,'status'=>1]);
                if(!$up){
                    $result = makeResult(0,'确认收货失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'确认收货成功',['time'=>$gtime]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //订单查询操作
    public function orderSelection(){
        $request = Request::instance();
        switch($this->method){
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $type = intval($request->param('type'));
                if(!$id||!$gtoken){
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
                //构造订单查询条件
                $where = [];
                $where['uid'] = $id;
                $where['is_del'] = 0;
                switch($type){
                    case 1:
                        //待付款
                        $where['pay'] = 0;
                        $where['send'] = 0;
                        $where['receive'] = 0;
                        $where['status'] = 0;
                        $where['reject'] = 0;
                        break;
                    case 2:
                        //待发货
                        $where['pay'] = 1;
                        $where['send'] = 0;
                        $where['receive'] = 0;
                        $where['status'] = 0;
                        $where['reject'] = 0;
                        break;
                    case 3:
                        //待收货
                        $where['pay'] = 1;
                        $where['send'] = 1;
                        $where['receive'] = 0;
                        $where['status'] = 0;
                        $where['reject'] = 0;
                        break;
                    case 4:
                        //待评价
                        $where['pay'] = 1;
                        $where['send'] = 1;
                        $where['receive'] = 1;
                        $where['status'] = 1;
                        $where['comment'] = 0;
                        $where['reject'] = 0;
                        break;
                    case 5:
                        //售后
                        $where['pay'] = 1;
                        $where['status'] = -2;
                        $where['reject'] = 0;
                        break;
                    default:
                        break;
                }
                //查询订单
                $orderDb = db('member_orders');
                $list = $orderDb->where($where)->order('createtime desc')->field('id,orderid,status,pay,send,receive,reject,createtime,money as price,scid,snum')->select();
                //查询数量
                $amout = [];
                $amount['unpay'] = $orderDb->where('uid',$id)->where('pay',0)->where('send',0)->where('receive',0)->where('status',0)->where('reject',0)->where('is_del',0)->count();
                $amount['unsend'] = $orderDb->where('uid',$id)->where('pay',1)->where('send',0)->where('receive',0)->where('status',0)->where('reject',0)->where('is_del',0)->count();
                $amount['unreceive'] = $orderDb->where('uid',$id)->where('pay',1)->where('send',1)->where('receive',0)->where('status',0)->where('reject',0)->where('is_del',0)->count();
                $amount['uncomment'] = $orderDb->where('uid',$id)->where('pay',1)->where('send',1)->where('receive',1)->where('status',1)->where('comment',0)->where('reject',0)->where('is_del',0)->count();
                $amount['service'] = $orderDb->where('uid',$id)->where('pay',1)->where('status',-2)->where('reject',0)->where('is_del',0)->count();
                //处理数据
                if($list){
                    $plistDb = db('member_orderlist');
                    $productDb = db('product');
                    //查询产品图
                    foreach($list as $k=>$v){
                        $list[$k]['imgs'] = [];
                        $list[$k]['createtime'] = date('Y/m/d H:i:s',$v['createtime']);
                        $list[$k]['imgs'] = $productDb->where('id','in',$plistDb->where('uid',$id)->where('oid',$v['orderid'])->column('pid'))->limit(4)->column('shotcut');
                        // unset($list[$k]['orderid']);
                        // lzc
                    }
                }else{
                    $list = [];
                }
                $result = makeResult(1,'ok',['count'=>$amount,'list'=>$list]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //评论提交
    public function productsCommention(){
        $request = Request::instance();
        switch ($this->method){
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $oid = intval($request->param('oid'));
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
                //查询订单信息
                $order = db('member_orders')->where('id',$oid)->where('uid',$id)->where('comment',0)->where('is_del',0)->field('orderid,createtime')->find();
                if(!$order){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }
                //查询购买产品
                //获取购买商品列表
                $field = 'p.id,p.name,p.shotcut,p.price,f.price as fprice,l.format,l.fname';
                $products = db('member_orderlist')->alias('l')
                                            ->join('product p','l.pid = p.id','LEFT')
                                            ->join('product_formlist f','l.pid = f.pid AND l.format = f.format','LEFT')
                                            ->where('l.uid',$id)
                                            ->where('l.oid',$order['orderid'])
                                            ->order('l.id desc')
                                            ->field($field)
                                            ->select();
                if(!$products){
                    $result = makeResult(0,'商品列表获取失败');
                    return $this->response($result,'json',200);
                }
                foreach($products as $k=>$v){
                    if(!empty($v['fprice'])){
                        $products[$k]['price'] = $v['fprice'];
                    }
                    unset($products[$k]['fprice']);
                    $products[$k]['stars'] = 0;
                    $products[$k]['content'] = '';
                    $products[$k]['imgs'] = [['url'=>'','state'=>0,'active'=>1],['url'=>'','state'=>0,'active'=>0],['url'=>'','state'=>0,'active'=>0],['url'=>'','state'=>0,'active'=>0]];
                }
                $result = makeResult(1,'ok',['createtime'=>date('Y-m-d H:i:s',$order['createtime']),'uyhost'=>config('upyun_config.domain'),'notify'=>config('upyun_config.notify'),'list'=>$products]);
                return $this->response($result,'json',200);
                break;
            case 'post':
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $oid = intval($request->put('oid'));
                $comments = json_decode(trim($request->put('comments')),true);
                if(!$id||!$gtoken||!$oid||empty($comments)){
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
                unset($user);
                //处理评价数据
                $cdata = [];
                $now = time();
                foreach($comments as $k=>$v){
                    $fmt = empty($v['format']) ? '' : $v['format'];
                    $fmtn = empty($v['fname']) ? '' : $v['fname'];
                    if(!empty($v['imgs'])){
                        $imgs = [];
                        foreach($v['imgs'] as $vk=>$vv){
                            if(!empty($vv['url'])){
                                $imgs[] = ['src'=>$vv['url'],'w'=>intval($vv['w']),'h'=>intval($vv['h'])];
                            }
                        }
                        $imgs = count($imgs)>0 ? json_encode($imgs) : '';
                    }else{
                        $imgs = '';
                    }
                    $cdata[] = ['uid'=>$id,'oid'=>$oid,'pid'=>$v['id'],'format'=>$fmt,'fname'=>$fmtn,'top'=>0,'parent'=>0,'stars'=>intval($v['stars']),'content'=>trim($v['content']),'imgs'=>$imgs,'createtime'=>$now];
                }
                //插入数据
                $add = db('product_comments')->insertAll($cdata);
                unset($comments);
                if(!$add){
                    $result = makeResult(0,'评价失败');
                    return $this->response($result,'json',200);
                }
                //更新订单评论状态
                db('member_orders')->where('id',$oid)->where('uid',$id)->update(['comment'=>1]);
                $result = makeResult(1,'评价成功');
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //评论详情
    public function commentDetail(){
        $request = Request::instance();
        switch ($this->method){
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $oid = intval($request->param('oid'));
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
                //查询订单信息
                $order = db('member_orders')->where('id',$oid)->where('uid',$id)->where('comment',1)->where('is_del',0)->field('orderid,createtime')->find();
                if(!$order){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }
                //查询商品评论信息
                $commentsDb = db('product_comments');
                $field = 'c.id,c.stars,c.content,c.imgs,c.createtime,c.fname,p.name,p.shotcut,p.price,f.price as fprice';
                $list = $commentsDb->alias('c')
                                ->join('product p','c.pid = p.id')
                                ->join('product_formlist f','c.pid = f.pid AND c.format = f.format','LEFT')
                                ->where('c.uid',$id)
                                ->where('c.oid',$oid)
                                ->where('c.top',0)
                                ->where('c.parent',0)
                                ->where('c.status',1)
                                ->order('c.id asc')
                                ->field($field)
                                ->select();
                if(!$list){
                    $list = [];
                }else{
                    foreach($list as $k=>$v){
                        $list[$k]['createtime'] = date('Y-m-d',$v['createtime']);
                        if(!empty($v['fprice'])){
                            $v['price'] = $v['fprice'];
                        }
                        unset($list[$k]['fprice']);
                        $list[$k]['imgs'] = json_decode($v['imgs']);
                        $subs = $commentsDb->where('oid',$oid)->where('top',$v['id'])->where('status',1)->order('parent asc,createtime asc')->field('content,createtime')->select();
                        if(!$subs){
                            $subs = [];
                        }else{
                            foreach($subs as $sk=>$sv){
                                $subs[$sk]['createtime'] = date('Y-m-d',$sv['createtime']);
                            }
                        }
                        $list[$k]['subs'] = $subs;
                        unset($subs);
                    }
                }
                //返回数据
                $result = makeResult(1,'ok',['createtime'=>date('Y-m-d H:i:s',$order['createtime']),'list'=>$list]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    //售后申请
     public function afterService(){
        $request = Request::instance();
        switch ($this->method){
            case 'get':
                $id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $oid = intval($request->param('oid'));
                $message = intval($request->param('message'));
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
                //查询订单信息
                $order = db('member_orders')->where('id',$oid)->where('uid',$id)->where('pay',1)->where('is_del',0)->field('orderid,money,createtime')->find();
                if(!$order){
                    $result = makeResult(0,'订单信息获取失败');
                    return $this->response($result,'json',200);
                }
                //查询商品信息
                $olDb = db('member_orderlist');
                $count = $olDb->where('uid',$id)->where('oid',$order['orderid'])->count();
                $field = 'p.name,p.shotcut';
                $products = $olDb->alias('l')
                                    ->join('product p','l.pid = p.id','LEFT')
                                    ->where('l.uid',$id)
                                    ->where('l.oid',$order['orderid'])
                                    ->order('l.id asc')
                                    ->field($field)
                                    ->find();
                if(!$products){
                    $result = makeResult(0,'商品信息获取失败');
                    return $this->response($result,'json',200);
                }
                //输出售后信息
                if($message){
                    $serviceDb = db('product_service');
                    $info = $serviceDb->where('oid',$oid)->where('top',0)->where('parent',0)->field('id,content,imgs,createtime,status')->find();
                    if(!$info){
                        $result = makeResult(0,'售后申请信息获取失败');
                        return $this->response($result,'json',200);
                    }
                    $info['imgs'] = empty($info['imgs']) ? [] : json_decode($info['imgs']);
                    $info['createtime'] = date('Y-m-d',$info['createtime']);
                    //查询回复消息
                    $subs = $serviceDb->where('oid',$oid)->where('top',$info['id'])->order('parent asc')->field('id,uid,content,createtime')->select();
                    if(!$subs){
                        $subs = [];
                    }else{
                        foreach($subs as $sk=>$sv){
                            $subs[$sk]['createtime'] = date('Y-m-d',$sv['createtime']);
                        }
                    }
                    $info['subs'] = $subs;
                    //返回数据
                    $result = makeResult(1,'ok',['createtime'=>date('Y-m-d H:i:s',$order['createtime']),'price'=>$order['money'],'name'=>$products['name'],'shotcut'=>$products['shotcut'],'count'=>$count,'message'=>$info]);
                    return $this->response($result,'json',200);
                }
                //返回数据
                $result = makeResult(1,'ok',['createtime'=>date('Y-m-d H:i:s',$order['createtime']),'price'=>$order['money'],'name'=>$products['name'],'shotcut'=>$products['shotcut'],'count'=>$count]);
                return $this->response($result,'json',200);
                break;
            case 'post':
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $oid = intval($request->put('oid'));
                $content = trim($request->put('content'));
                $imgs = json_decode(trim($request->put('imgs')),true);
                if(!$id||!$gtoken||!$oid){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }else if(empty($content)){
                    $result = makeResult(0,'请填写申请售后的原因');
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
                unset($user);
                //处理插入数据
                $sdata = [];
                $sdata['oid'] = $oid;
                $sdata['uid'] = $id;
                $sdata['top'] = 0;
                $sdata['parent'] = 0;
                $sdata['imgs'] = [];
                foreach($imgs as $k=>$v){
                    if(!empty($v['url'])){
                        $sdata['imgs'][] = ['src'=>$v['url'],'w'=>intval($v['w']),'h'=>intval($v['h'])];
                    }
                }
                $sdata['imgs'] = count($sdata['imgs'])>0 ? json_encode($sdata['imgs']) : '';
                $sdata['content'] = $content;
                $sdata['status'] = 0;
                $sdata['createtime'] = time();
                //插入数据
                $add = db('product_service')->insert($sdata);
                if(!$add){
                    $result = makeResult(0,'申请提交失败');
                    return $this->response($result,'json',200);
                }
                db('member_orders')->where('id',$oid)->where('uid',$id)->update(['status'=>-2]);
                $result = makeResult(1,'申请提交成功');
                return $this->response($result,'json',200);
                break;
            case 'put':
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $oid = intval($request->put('oid'));
                $top = intval($request->put('top'));
                $content = trim($request->put('content'));
                if(!$id||!$gtoken||!$oid||!$top){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }else if(empty($content)){
                    $result = makeResult(0,'请填写回复内容');
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
                unset($user);
                $serviceDb = db('product_service');
                //处理插入数据
                $sdata = [];
                $sdata['oid'] = $oid;
                $sdata['uid'] = 0;
                $sdata['top'] = $top;
                $pinfo = $serviceDb->where('top',$top)->where('oid',$oid)->order('parent desc')->find();
                $sdata['parent'] = intval($pinfo['id']);
                $sdata['content'] = $content;
                $sdata['status'] = 0;
                $sdata['createtime'] = time();
                //插入数据
                $add = $serviceDb->insertGetId($sdata);
                unset($pinfo);
                if(!$add){
                    $result = makeResult(0,'内容提交失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok',['id'=>$add,'uid'=>0,'content'=>$content,'createtime'=>date('Y-m-d',$sdata['createtime'])]);
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    // 推荐商品
    public function cainixihuan(){
        $data = db('profile')->field('commend')->find();
        $tijian = explode(',',$data['commend']);
        foreach ($tijian as $key => $value) {
            $where['id'] = $value;
            $where['is_del'] = 0;
            $where['is_sell'] = 1;
            $datashop = db('product')->where($where)->field('id,name,price,starprice,shotcut,deliverytime')->find();
            $nowtime = time();
            if($datashop['deliverytime'] == 0){
                $stimedate = date('Y-m-d',$nowtime).'00:00';
                $etimedate = date('Y-m-d',$nowtime).'22:00';
                $stime = strtotime($stimedate);
                $etime = strtotime($etimedate);
                if($nowtime >= $stime && $nowtime <= $etime){
                    $ciri = 1;
                }else{
                    $ciri = 0;
                }
                $datashop['peisongok'] = $ciri;
            }else{
                $stimedate = date('Y-m-d',$nowtime).'00:00';
                $stime = strtotime($stimedate);
                $etimedate = date('Y-m-d',$nowtime).'13:00';
                $etime = strtotime($etimedate);
                if($nowtime >= $stime && $nowtime <= $etime){
                    $dangtian = 1;
                }else{
                    $dangtian = 0;
                }
                $datashop['peisongok'] = $dangtian;
            }
            if($datashop){
                $shop[] = $datashop;
            }
        }
        $result = makeResult(1,'ok',['tuijian_shop'=>$shop]);
        return $this->response($result,'json',200);
    }

    // 首单
    public function shoudan(){
        $request = Request::instance();
        $since = intval($request->param('sinceid'));
        $id = intval($request->param('uid'));
        $gtoken = trim($request->param('token'));
        if(!$id||!$gtoken){
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
        // 测试用
        /*$since = 8;
        $id = 14;*/
        $where['pay'] = 1;
        $where['is_del'] = 0;
        $where['uid'] = $id;
        $shoudan = db('member_orders')->where($where)->field('id')->find();
        if(!$shoudan){
            $result = makeResult(0,'你不是首单用户');
            return $this->response($result,'json',200);
        }else{
            $where1['id'] = $since;
            $where1['status'] = 1;
            $cilcksince = db('handtake_place')->where($where1)->field('shoudan')->find();
            $shoudanshop = unserialize($cilcksince['shoudan']);
            if($shoudanshop){
                $where2['is_sell'] = 1;
                $where2['gift'] = 1;
                $where2['is_del'] = 0;
                foreach ($shoudanshop as $key => $value) {
                    $where2['id'] = $value;
                    $cileckshop = db('product')->where($where2)->field('id,name,price,starprice,shotcut')->find();
                    $shoudanok[] = $cileckshop;
                } 
                $result = makeResult(1,'ok',['shoudan_data'=>$shoudanok]);
            }else{
                $result = makeResult(0,'该自提点没有赠品');
            }
            return $this->response($result,'json',200);
        }
    }

    // 满就送
    public function manjiusong(){
        $request = Request::instance();
        $since = intval($request->param('sinceid'));
        $money = intval($request->param('moeny'));
        $id = intval($request->param('uid'));
        $gtoken = trim($request->param('token'));
        if(!$id||!$gtoken){
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
        // 测试用
        /*$since = 8;
        $money = 0;
        $id = 14;*/
        // 满足价格排序 由高到低
        $sincemax = db('since_maxgift')->where('maxmoney','<=',$money)->order('maxmoney asc')->select();
        foreach ($sincemax as $key => $value) {
            $ziti[] = unserialize($value['useshop']);
        }
        foreach ($ziti as $key1 => $value1) {
            if(in_array($since, $value1)){
                $product_id = unserialize($sincemax[$key1]['shopid']);
                $giftid = $sincemax[$key1]['id'];
            }
        }
        if(!empty($product_id)){
            foreach ($product_id as $key => $value) {
                $where['id'] = $value;
                $where['is_sell'] = 1;
                $where['gift'] = 1;
                $where['is_del'] = 0;
                $cxshop = db('product')->where($where)->field('id,name,price,starprice,shotcut,store')->find();
                $cxshop['giftid'] = $giftid;
                $bigshop[] = $cxshop;
            }
        }else{
            $bigshop = null;
        }
        if($bigshop){
            $result = makeResult(1,'ok',['maxmoney'=>$bigshop]);
            return $this->response($result,'json',200);
        }else{
            $result = makeResult(0,'该自提点没有赠品');
            return $this->response($result,'json',200);
        }
    }


    public function test(){
        $redis = new \Redis();
        $redis->connect('127.0.0.1', 6379);
        echo "Connection to server sucessfully";
         //查看服务是否运行
        echo "Server is running: " . $redis->ping();
        $work['job'] = 'Work';
        $time = time();
        $work['id'] = md5($time);
        $work['attempts'] = $time;
        $ids[3] = 1;
        $ids[4] = time() + (60 * 15);
        $work['data'] = $ids;
        $work = json_encode($work);
        echo $redis->zAdd('queues:default:delayed', $time, $work);
    }

    public function SaleActive($productInfo,$num,$user){
        $NowTimeStamp = time();
        $queryactive = Model('Sale')->query($NowTimeStamp,$productInfo['id']);
        if(empty($queryactive)){
            $result = makeResult(0,'您参与的活动已结束,请重新放入购物车下单!');
            return $Activedata['error'] = $result;
        }
        if($queryactive){
            $Active['saleprice'] = $queryactive['saledata'][0]['saleprice'];
            $Active['salenub'] = $queryactive['saledata'][0]['salenub'];
            $Active['salepaynub'] = $queryactive['saledata'][0]['salepaynub'];
            $Active['salekucunnub'] = $queryactive['saledata'][0]['salekucunnub'];
            $Active['saleid'] = $queryactive['saleid'];
            $Active['shopid'] = $queryactive['shopid'];
            // 判断库存
            if($Active['salekucunnub'] == 0){
                $result = makeResult(0,'已售完');
                return $Activedata['error'] = $result;
            }else{
                $shuliang = $Active['salekucunnub'] - $num;
                if($shuliang < 0){
                    $result = makeResult(0,'现在库存只有'.$Active['salekucunnub'].'份');
                    return $Activedata['error'] = $result;
                }
            }
            // 扣除库存
            $queryactive['saledata'][0]['salekucunnub'] = $queryactive['saledata'][0]['salekucunnub'] - $num;
            // 检查名额
            $where['o.pay'] = 1;
            $where['o.tel'] = $user['utel'];
            $where['l.pid'] = $Active['shopid'];
            $where['l.sale'] = $Active['saleid'];
            $querysalenum = db('member_orders o')->join('member_orderlist l','l.oid = o.orderid')->where($where)->field('id')->count();
            if($Active['salepaynub'] <= $querysalenum){
                $result = makeResult(0,$Active['name'].'限时抢购只可买'.$Active['salepaynub'].'份');
                return $Activedata['error'] = $result;
            }
            if(empty($Active)){
                $Activedata['noshop'] = 1;
                $Activedata['data'] = null;
                $Activedata['update'] = null;
            }else{
                $Activedata['noshop'] = 0;
                $Activedata['data'] = $Active;  
                $Activedata['update'] = $queryactive;
            }
        }else{
            $Activedata['noshop'] = 1;
            $Activedata['data'] = null;
            $Activedata['update'] = null;
        }
        return $Activedata;
    }
}
