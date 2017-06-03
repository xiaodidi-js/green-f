<?php
/*用户模型验证器类*/

namespace app\admin\validate;

use think\Validate;

class Article extends Validate{

	protected $rule = [
		'title|文章标题' => 'require|checkTitle:/^[\s\S]{1,50}$/u',
		'short_desc|短描述' => 'require|checkDesc:/^[\s\S]{1,75}$/u',
		'shotcut|文章缩略图' => 'require|url',
//		'product|产品名称' => 'require|checkProduct:/^[\s\S]{1,50}$/u',
//		'price|产品价格' => 'require|number',
		'visitor|阅读量' => 'require|number',
		'content|文章内容' => 'require'
	];

	protected $message = [];

	protected function checkTitle($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '文章标题为1-50个字符';
	}

	protected function checkDesc($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '文章标题为1-75个字符';
	}

	protected function checkProduct($val,$rule,$data){
		$res = preg_match($rule,$val);
		return $res ? true : '产品名称为1-50个字符';
	}

}