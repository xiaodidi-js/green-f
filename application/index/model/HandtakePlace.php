<?php

namespace app\index\model;

use think\Model;

class HandtakePlace extends Model{

	// 收货地址选择地区 二级分类
	public function sinceselect(){
		$where['status'] = 1;
    	$where['pid'] = 0;
		$chaxun = $this->where($where)->order('sort desc,id desc')->field('id,name,pid')->select();
    	if($chaxun){
			foreach($chaxun as $k=>$v){
				$list[$k] = $v;
				$list[$k]['sub'] = $this->where('pid',$v['id'])->where('status',1)->order('sort desc,id desc')->field('id,name,pid')->select();
			}
		}
		return $list;
	}

	// 前台返回自提点id查询
	public function infosince($sinceid){
		if($sinceid != 0){
    		$where['pid'] = $sinceid;
    	}
    	$where['status'] = 1;
		$chaxun = $this->where($where)->where('address','not null')->field('id,name,address,tel,pid')->order('sort desc,id desc')->select();
		return $chaxun;
	}
}