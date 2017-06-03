<?php

namespace app\admin\model;

use think\Model;

class ProductQrcode extends Model{

	// 查询未删除的
	public function query(){
		$list = $this->where('is_del',0)->field('id,name,stime,etime,stu')->select();
		return $list;
	}

	// 查询指定id的
	public function queryinfo($id){
		$info = $this->where('id', $id)->find();
		return $info;
	}

	// 更新指定id的
	public function edit($update,$id){
		$edit = $this->where('id', $id)->update($update);
		return $edit;
	}
}