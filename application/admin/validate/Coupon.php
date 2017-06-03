<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Coupon extends Validate{

	protected $rule = [
		'title|优惠券标题' => 'require|checkTitle:/^[\s\S]{1,50}$/u',
		'description|优惠券描述' => 'checkDesc:/^[\s\S]{1,100}$/u',
		'shotcut|优惠券logo' => 'url',
		'stime|开始时间' => 'require|date',
		'etime|结束时间' => 'require|date',
		'type|优惠券类型' => 'require|number',
		'status|状态' => 'require|number'
	];

	protected $message = [];

	protected function checkTitle($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '优惠券标题为1-50个字符';
	}

	protected function checkDesc($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '优惠券标题为1-100个字符';
	}

}