<?php

namespace app\admin\model;

use think\Model;

class ProductClassify extends Model{

//    用id查询分类
	public function SaleConfigShopClass($cid){
		$find = $this->where('id',$cid)->field('title')->find();
		return $find;
	}

}