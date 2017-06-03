<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Handtake extends Validate{

	protected $rule = [
		'name|名称' => 'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,50}$/u',
		'sort|排序' => 'require|number'
	];

	protected $message = [];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '名称为1-50个字符(字母、数字和中文)';
	}

}