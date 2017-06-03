<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Product extends Validate{

	protected $rule = [
		'sn_code|产品编码' => 'require|unique:product|checkCode:/^[\s\S]{1,50}$/',
		'name|产品名称' => 'require|checkName:/^[\s\S]{1,100}$/',
		'description|产品描述' => 'require|checkDesc:/^[\s\S]{1,150}$/',
		'price|产品价格' => 'require|number',
		'promote_price|优惠价格' => 'requireIf:is_promote,1|number',
		'promote_time|活动时间' => 'requireIf:is_promote,1',
		'store|产品库存' => 'require|number',
		'virtual_sale|虚拟销量' => 'require|number',
		'supplier|供应商' => 'checkSupName:/^[\s\S]{1,30}$/',
		'warn_num|库存警告' => 'require|number',
		'shotcut|产品缩略图' => 'require|url',
		'gallery|产品轮播图' => 'require|array',
		'sort|产品排序' => 'require|number'
	];

	protected $message = [
		'promote_price.requireIf' => '请填写优惠价格',
		'promote_time.requireIf' => '请选择活动时间'
	];

	protected $scene = [
		'update' => ['name','description','price','promote_price','promote_time','virtual_sale','supplier','warn_num','shotcut','gallery','sort']
	];

	protected function checkCode($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '产品编码为1-50个字符';
	}

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '产品名称为1-100个字符';
	}

	protected function checkDesc($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '产品描述为1-150个字符';
	}

	protected function checkSupName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '分类名称为1-30个字符';
	}

}