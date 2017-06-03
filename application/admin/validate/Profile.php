<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Profile extends Validate{

	protected $rule = [
		'name|商家名称' => 'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,100}$/u',
		'description|商家描述' => 'require',
		'appid' => 'require|checkID:/^[a-zA-Z0-9]{16,18}$/',
		'appsecret' => 'require|checkSecret:/^[a-zA-Z0-9]{32}$/',
		'detail|详情页内容' => 'require'
	];

	protected $message = [];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '商家名称为1-100个字符(字母、数字和中文)';
	}

	protected function checkID($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : 'appid格式不正确';
	}

	protected function checkSecret($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : 'appsecret格式不正确';
	}

}