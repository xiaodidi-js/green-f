<?php

namespace app\admin\controller;
use think\Controller,think\Request;

class Shop extends Base{

	public function _initialize(){
		parent::_initialize();
		$this->reqdata = $this->request->param();
		$this->postdata = $this->request->post();
	}

	// 订单列表
	public function orderlist(){
		$get = $this->reqdata;
		$Orders = Model('Orders');
		$list = $Orders->cxlist($get);
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 订单详细页
	public function orderxx(){
		$get = $this->reqdata;
		if(empty($get['id'])){
			make_json(0,['没有订单数据序号，请联系趣果科技']);
			exit();
		}
		$Orders = Model('Orders');
		$info = $Orders->cxinfo($get);
		if(empty($info)){
			make_json(0,['这个订单不存在或已经删除']);
			exit();
		}
		$info['createtime'] = date('Y-m-d h:i:s',$info['createtime']);
		if($info['stype'] == '1'){
			$cxps = db('member_address')->where('id',$info['addressid'])->find();
			$info['kddname'] = $cxps['person'];
			$info['kddaddress'] = $cxps['area'].$cxps['address'];
			$info['kddyf'] = '0';
		}else{
			$cxps = db('handtake_place')->where('id',$info['addressid'])->find();
			$info['ztdname'] = $cxps['name'];
			$info['ztdaddress'] = $cxps['address'];
			$info['ztdphone'] = $cxps['tel'];
		}
		$dikou = explode('#',$info['dikou']);
		$info['yhdk'] = $dikou['0'];
		$info['jfdk'] = $dikou['1'];
		$cxuser = db('member')->where('id',$info['userid'])->field('utel')->find();
		$info['tel'] = $cxuser['utel'];
		make_json(1,['info'=>$info]);
	}

	// 订单软删除
	public function delorder(){
		$get = $this->reqdata;
		$update['del'] = 1;
		$del = db('orders')->where('id',$get['id'])->update($update);
		if($del){
			make_json(1,'删除成功');
		}else{
			make_json(0,'删除失败，请联系趣果科技');
		}
	}

	// 快捷编辑查询
	public function getedit(){
		$post = $this->postdata;
		$Orders = Model('Orders');
		if(!empty($post)){
			$edit = $Orders->kjedit($post);
			if($edit){
				make_json(1,'编辑成功');
			}else{
				make_json(0,'内容没有修改');
			}
		}else{
			$get = $this->reqdata;
			$info = $Orders->cxbj($get);
			make_json(1,['info'=>$info]);
		}
	}

	// 查询自提点
	public function selectztd(){
		$get = $this->reqdata;
		$list = db('handtake_place')->where('status',1)->field('id,name,address')->select();
		make_json(1,['list'=>$list]);
	}
}