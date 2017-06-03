<?php

namespace app\admin\model;

use think\Model;

class Article extends Model{

	protected $table = 'qgs_product_article';
	protected $auto = ['price','visitor','content'];
	protected $insert = ['updatetime','createtime'];
	protected $update = ['updatetime'];

	protected function setPriceAttr($val){
		return floatval($val);
	}

	protected function setVisitorAttr($val){
		return intval($val);
	}

	protected function setContentAttr($val){
		return htmlspecialchars($val);
	}

	protected function setCreatetimeAttr($val){
		return time();
	}

	protected function setUpdatetimeAttr($val){
		return time();
	}

}