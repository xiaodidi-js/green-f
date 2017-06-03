<?php

namespace app\admin\model;

use think\Model;

class ProductShare extends Model{

	// 查询未删除的分享活动
	public function queryshare(){
		$list = $this->where('is_del',0)->field('id,name,stime,etime,stu')->select();
		return $list;
	}

	// 查询指定id的分享活动
	public function queryshareinfo($id){
		$info = $this->where('id', $id)->find();
		return $info;
	}

	// 更新指定id的分享活动
	public function editshare($update,$id){
		$edit = $this->where('id', $id)->update($update);
		return $edit;
	}
}