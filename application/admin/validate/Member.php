<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Member extends Validate{

	protected $rule = [
		'uname|账号名称' => 'require|checkName:/^[\x{4e00}-\x{9fa5}\w]{1,100}$/u',
		'utel|注册手机' => 'require|checkTel:/^[\d]{9,11}$/',
		'upwd|登录密码' => 'checkPwd:/^[\w@\+\?\.\*-\_\#\^]{6,30}$/',
		'cpwd|确认密码' => 'requireWith:upwd|confirm:upwd',
		'sex|性别' => 'number',
		'birthday|生日' => 'date',
		'shotcut|头像'	=> 'url'
	];

	protected $message = [
		'cpwd.confirm' => '两次输入密码不一致'
	];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '账号昵称为1-30个字符(字母、数字和中文)';
	}

	protected function checkPwd($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '账号密码为6-30个字符(字母、数字和符号{@,+,?,.,*,-,_,#,^})';
	}

	protected function checkTel($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '手机号码格式不正确';
	}

}