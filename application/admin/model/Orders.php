<?php

namespace app\admin\model;

use think\Model;

class Orders extends Model{

	/*
	 * where:del
	 * 条件:是否删除
	 * 查询订单
	 */
	public function cxlist($get){
		$where['del'] = 0;
		$field = 'id,stype,sum,stime,stu,orderid,send,pay';
		if(!empty($get['search_key'])){
			$maa['is_del'] = 0;
			$maa['utel'] = $get['search_key'];
			$cxphone = db('member')->where($maa)->field('id')->find();
			if(!empty($cxphone)){
				$where['userid'] = $cxphone['id'];
				$list = $this->where($where)->field($field)->paginate(10);
			}else{
				$where['orderid'] = $get['search_key'];
				$list = $this->where($where)->field($field)->paginate(10);
			}
		}else{
			$list = $this->where($where)->field($field)->paginate(10);
		}
		return $list;
	}

	/*
	 * where:id,del
	 * 条件:是否删除,序号
	 * 查询订单详细
	 */
	public function cxinfo($get){
		$where['del'] = 0;
		$where['id'] = $get['id'];
		$info = $this->where($where)->find();
		return $info;
	}

	/*
	 * where:id
	 * 条件: 序号
	 * 查询快捷修改
	 */
	public function cxbj($get){
		$where['id'] = $get['id'];
		$field = 'pay,send,stype,addressid';
		$list = $this->where($where)->field($field)->find();
		return $list;
	}

	/*
	 * where:id
	 * 条件: 序号
	 * 快捷修改
	 */
	public function kjedit($post){
		$where['id'] = $post['id'];
		$update['pay'] = $post['pay'];
		$update['send'] = $post['send'];
		$update['addressid'] = $post['addressid'];
		$edit = $this->where($where)->update($update);
		return $edit;
	}
}