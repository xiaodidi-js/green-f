<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Classify extends Validate{

	protected $rule = [
		'title|分类名称' => 'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,60}$/u',
		'shotcut|分类图片' => 'url',
		'sort|排序' => 'require|number'
	];

	protected $message = [];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '分类名称为1-60个字符(字母、数字和中文)';
	}

}