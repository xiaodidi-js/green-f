<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Column extends Validate{

	protected $rule = [
		'name|栏目名称' => 'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,30}$/u|unique:column',
		'module|模型' => 'checkEnName:/^[a-zA-Z0-9\_]{1,50}$/',
		'controller|控制器' => 'require|checkEnName:/^[a-zA-Z0-9\_]{1,50}$/',
		'action|方法' => 'requireWith:module|checkEnName:/^[a-zA-Z0-9\_]{1,50}$/',
		'pid|父级栏目' => 'number',
		'status|栏目状态' => 'number',
		'level|显示级数' => 'number',
		'icon|栏目图标' => 'checkClass:/^[a-zA-Z0-9\-\s]{1,60}$/'
	];

	protected $message = [
		'name.unique' => '栏目名称已存在',
		'controller.require' => '控制器不能为空',
		'action.requireWith' => '方法不能为空'
	];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '用户名称为1-30个字符(字母、数字和中文)';
	}

	protected function checkEnName($val,$rule,$data){
		if(empty($val)){
			return true;
		}
		$res = preg_match($rule,$val);
		return $res ? true : '内容为1-50个字符(字母、数字和下划线)';
	}

	protected function checkClass($val,$rule,$data){
		if(empty($val)){
			return true;
		}
		$res = preg_match($rule,$val);
		return $res ? true : '栏目图标样式格式不正确';
	}

}