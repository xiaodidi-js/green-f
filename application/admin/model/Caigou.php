<?php

namespace app\admin\model;

use think\Model;

class Caigou extends Model{

	// 查询当天是否有确认采购
	public function queryday($post){
		if($post['miao'] == 0){
			$post['miao'] = '10:30';
		}else{
			$post['miao'] = '16:30';
		}
		$time = $post['stime'].$post['miao'];
		$where['time'] = strtotime($time);
		$find = $this->where($where)->find();
		return $find;
	}

	// 完成采购
	public function addcaigouok($post){
		if($post['miao'] == 0){
			$post['miao'] = '10:30';
		}else{
			$post['miao'] = '16:30';
		}
		$time = $post['stime'].$post['miao'];
		$data['time'] = strtotime($time);
		$data['oktime'] = time();
		$add = $this->insert($data);
		return $add;
	}
}