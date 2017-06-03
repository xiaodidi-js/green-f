<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Hooks extends Validate{

	protected $rule = [
		'name|钩子名称' => 'require|checkName:/^[a-zA-Z0-9\_]{1,40}$/u'
	];

	protected $message = [];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
        if($res&&$val=='app_init'){
            return "不能添加\"app_init\"钩子";
        }
		return $res ? true : '钩子名称(字母、数字和下划线)格式不正确';
	}

}