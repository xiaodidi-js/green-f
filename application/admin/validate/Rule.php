<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Rule extends Validate{

	protected $rule = [
		'name|规则标识' => 'require|checkEnName:/^[a-zA-Z0-9\/]{1,100}$/',
		'title|规则名称' => 'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,100}$/u',
		'condition|条件表达式' => 'requireIf:type,1'
	];

	protected $message = [
		'condition.requireIf' => '条件表达式不能为空',
	];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '规则名称为1-100个字符(字母、数字和中文)';
	}

	protected function checkEnName($val,$rule,$data){
		if(empty($val)){
			return true;
		}
		$res = preg_match($rule,$val);
		return $res ? true : '规则标识为1-100个字符(字母、数字和斜杠)';
	}

}