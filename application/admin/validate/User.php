<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class User extends Validate{

	protected $rule = [
		'name' => 'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,25}$/u',
		'tel' => 'require|checkTel:/^1\d{10}$/|unique:admin',
		'email|邮箱' => 'require|email|unique:admin',
		'pwd|登录密码' => 'require|checkPwd:/^[a-zA-Z0-9\_@#&%]{6,40}$/u',
		'repwd|确认密码' => 'require|confirm:pwd'
	];

	protected $message = [
		'name.require' => '账号名称不能为空',
		'tel.require' => '手机号码不能为空',
		'tel.unique' => '手机号码已经注册',
		'email.require' => '邮箱不能为空',
		'email.unique' => '邮箱已经注册',
		'pwd.require' => '登录密码不能为空',
		'repwd.require' => '确认密码不能为空',
		'repwd.confirm' => '两次密码不一致'
	];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '账号名称为1-25个字符(字母、数字和中文)';
	}

	protected function checkTel($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '手机号码格式不正确';
	}

	protected function checkPwd($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '登录密码为6-40个字符(字母、数字)和特殊字符(_@#&%)';
	}

}