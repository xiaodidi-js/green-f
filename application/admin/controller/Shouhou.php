<?php

namespace app\admin\controller;
use think\Controller,think\Request;

class Shouhou extends Base{
	// 首单列表
	public function shoudanlist(){
		$request = Request::instance();
		$get = $request->get();
		if(empty($get['time'])){
			$stime = strtotime(date('Y-m-d'.'00:00:00',time()));
			$etime = strtotime(date('Y-m-d'.'23:59:59',time()));
			$time = date('Y-m-d H:i:s',$stime);
		}
		$this->assign('time',$time);
		return $this->fetch();
	}

	// 未消费用户列表
	public function nopaylist(){
		$request = Request::instance();
		$get = $request->get();
		if(empty($get['daytime'])){
            $get['daytime'] = 0;
        }
		$queryorder = Model('member_orders')->querynopay($get);
		if($queryorder){
			foreach ($queryorder as $key => $value) {
				$alluserid[] = $value['uid'];
			}
			$alluserid = array_unique($alluserid);
			$Uwhere['id'] = array('not in',$alluserid);
			$queryuser = Model('member')->querynotid($Uwhere);
			foreach ($queryuser as $key1 => &$value1) {
				$Qwhere['uid'] = $value1['id'];
				$Qwhere['pay'] = 1;
				$queryorderfind = Model('member_orders')->where($Qwhere)->order('createtime desc')->find();
				$value1['endtime'] = $queryorderfind['createtime'];
				$value1['sum'] = $queryorderfind['sum'];
				$value1['money'] = $queryorderfind['money'];
			}
		}else{
			$queryuser = null;
		}
		$this->assign('daytime',$get['daytime']);
		$this->assign('list',$queryuser);
		return $this->fetch();
	}

	// 菜品消费清单
	public function shoppaylist(){
		$request = Request::instance();
		$get = $request->get();
		$where['p.is_del'] = 0;
		$where['gift'] = 0;
		$where['p.sale'] = array('>=',1);
		if(!empty($get['shopname'])){
			$where['name'] = array('like','%'.$get['shopname'].'%');
		}
		$list = db('product')->alias('p')->join('product_classify c','p.cid = c.id','LEFT')->where($where)->field('p.id,name,title,price,store,sale')->order('p.id desc')->paginate();
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 菜品消费清单详情
	public function shoppayinfo(){
		$request = Request::instance();
		$get = $request->param();
		if(empty($get['stime'])){
			$stime = strtotime(date('Y-m-d'.'00:00:00',time()));
			$etime = strtotime(date('Y-m-d'.'23:59:59',time()));
		}else{
			$stime = strtotime($get['stime']);
			$etime = strtotime($get['etime']);
		}
		$stimedate = date('Y-m-d H:i:s',$stime);
		$etimedate = date('Y-m-d H:i:s',$etime);
		$where['y.createtime'] = array('between',[$stime,$etime]);
		$where['y.pay'] = 1;
		$where['o.pid'] = $get['id'];
		$field = 'y.orderid,y.address,y.tel,y.sum,y.money,o.amount,y.createtime';
		$queryorders = db('member_orderlist o')->join('member_orders y','y.orderid = o.oid')->where($where)->field($field)->paginate();
		$this->assign('list',$queryorders);
		$this->assign('id',$get['id']);
		$this->assign('stime',$stimedate);
		$this->assign('etime',$etimedate);
		return $this->fetch();
	}
}