<?php
namespace app\index\controller;

use think\Request,think\Loader;
use app\index\controller\Index;
Loader::import('wxpay.lib.WxPay#Api',EXTEND_PATH);
Loader::import('wxpay.lib.WxPay#Notify',EXTEND_PATH);
Loader::import('wxpay.tools.log',EXTEND_PATH);

class Wxnotify extends \WxPayNotify{

	public function __construct(){
		$logHandler= new \CLogFileHandler(APP_PATH.'/../public/logs/wxnotify'.date('Y-m-d').'.log');
		\Log::Init($logHandler, 15);
	}

	public function Queryorder($transaction_id){
		$input = new \WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = \WxPayApi::orderQuery($input);
		\Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg){

		\Log::DEBUG("notify: ".json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id",$data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}

		//验证返回信息是否成功
		if(!array_key_exists("return_code",$data)||$data['return_code']!='SUCCESS'){
			$msg = "异步信息返回失败";
			return false;
		}

		//获取异步信息更新订单数据
		$where = [];
		$where['orderid'] = $data['out_trade_no'];
		$ordersDb = db('member_orders');
		$info = $ordersDb->where($where)->find();
		if(!$info){
			$msg = "商户订单查询失败";
			return false;
		}
		$update = [];
		$update['wxoid'] = $data['transaction_id'];
		$update['openid'] = $data['openid'];
		$update['paytype'] = 1;
		if(!$info['pay']||!$info['paytime']){
			$update['pay'] = 1;
			$update['paytime'] = time();
		}
		unset($info);
		$up = $ordersDb->where($where)->update($update);
		if(!$up){
			$msg = "商户订单更新失败";
			return false;
		}else{
			$queryorder = db('member_orders')->where('orderid',$data['out_trade_no'])->find();
			$Index = new Index;
            $wxorderok = $Index->payoknotice($queryorder['openid'],$queryorder);
		}
		return true;
	}

	public function getWxNotify(){
		$notify = new Wxnotify();
		$notify->Handle(false);
	}

}