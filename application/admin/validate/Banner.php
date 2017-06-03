<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Banner extends Validate{

	protected $rule = [
		'title|标题' => 'require|checkName:/^[\s\S]{1,100}$/',
		'img|banner图片' => 'require|url',
		'url|链接地址' => 'url',
		'sort|排序' => 'require|number'
	];

	protected $message = [];

	protected function checkName($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '分类名称为1-60个字符(字母、数字和中文)';
	}

}