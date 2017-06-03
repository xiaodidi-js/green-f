<?php
/*用户模型验证器类*/

namespace app\index\validate;

use think\Validate;

class Order extends Validate{

	protected $rule = [
		//支付方式暂有两种,1-wechat,2-alipay
		'paytype' => 'require|in:1,2',
		'stype' => 'require|in:express,parcel',
		'address' => 'require|integer',
		'coupon' => 'integer',
		'score' => 'boolean',
		'products' => 'require|array',
		'paysum' => 'require|number|egt:0.01',
		'tips' => 'checkTips:/^[\s\S]{1,100}$/'
	];

	protected $message = [
		'paytype.require' => '请选择支付方式',
		'paytype.in' => '请选择支付方式',
		'stype.require' => '请选择配送方式',
		'stype.in' => '请选择配送方式',
		'address.require' => '请选择收货地址',
		'address.integer' => '请选择收货地址',
		'coupon.integer' => '优惠券获取失败',
		'score.boolean' => '积分获取失败',
		'products.require' => '请选择要购买的商品',
		'products.array' => '请选择要购买的商品',
		'paysum.require' => '订单总价获取失败',
		'paysum.number' => '订单总价获取失败',
		'paysum.egt' => '订单总价获取失败'
	];

	protected function checkTips($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '备注信息不能超过100个字符';
	}

}