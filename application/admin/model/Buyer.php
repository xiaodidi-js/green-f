<?php

namespace app\admin\model;

use think\Model;

class Buyer extends Model{

	// 查询供应商，采购，分拣
	public function Querystaff($id){
		$list = $this->where('id','in',$id)->where('is_del','0')->field('name,class,tel')->select();
		return $list;
	}
}