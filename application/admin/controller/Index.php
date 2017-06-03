<?php

namespace app\admin\controller;

class Index extends Base{

	public function index(){
		$memberDb = db('member');
		$productDb = db('product');
		$orderDb = db('member_orders');
		$now = time();
		$today = [];
		$today[] = strtotime(date('Y-m-d',$now));
		$today[] = $today[0]+86399;
		$yesterday = [];
		$yesterday[] = $today[0]-86400;
		$yesterday[] = $today[0]-1;
		//顶部计数数据
		$count = [];
		$count['orders'] =  $orderDb->where('status','egt','-2')->where('createtime','between',$today)->count();
		$yorders = $orderDb->where('status','egt','-2')->where('createtime','between',$yesterday)->count();
		//增长率
		$count['rate'] = $yorders == 0 ? ($count['orders'] - $yorders)*100 : ($count['orders'] - $yorders)/$yorders*100;
		$count['members'] = $memberDb->where('createtime','between',$today)->count();
		//产品销售总量
		$count['pnums'] = $orderDb->alias('o')
								->join('member_orderlist l','o.orderid = l.oid','LEFT')
								->where('o.status','egt','-2')
								->where('o.createtime','between',$today)
								->sum('l.amount');
		$list = [];
		//最近新增产品
		$list['products'] = $productDb->field('id,name,shotcut,description,price')->order('createtime desc')->limit(5)->select();
		//最近新增用户
		$list['members'] = $memberDb->field('id,uname,shotcut,createtime')->order('createtime desc')->limit(8)->select();
		//最近订单列表
		$list['orders'] = $orderDb->alias('o')
								->join('member m','o.uid = m.id','LEFT')
								->order('createtime desc')
								->field('o.id,o.orderid,m.uname,o.paytype,o.status,o.money,o.createtime')
								->limit(10)
								->select();
		//产品销量top5
		$ids = $productDb->order('sale desc,id desc')->limit(5)->column('id');
		$list['sale'] = $productDb->order('sale desc,id desc')->limit(5)->field('name,sale')->select();
		$saleSum = $productDb->where('id','not in',$ids)->sum('sale');
		$list['sale'][] = ['name'=>'其他产品','sale'=>$saleSum];
		//构造图表数据
		$colors = ['#f56954','#00a65a','#f39c12','#00c0ef','#3c8dbc','#d2d6de'];
		$pieData = [];
		$exData = [];
		for($i=0;$i<count($list['sale']);$i++){
			$pieData[$i] = ['value'=>$list['sale'][$i]['sale'],'color'=>$colors[$i],'highlight'=>$colors[$i],'label'=>$list['sale'][$i]['name']];
			$exData[$i] = ['name'=>$list['sale'][$i]['name'],'color'=>$colors[$i],'sale'=>$list['sale'][$i]['sale']];
		}
		$list['sale'] = empty($list['sale']) ? [] : json_encode($pieData);
		$list['exdata'] = empty($list['sale']) ? [] : $exData;
		$this->assign('count',$count);
		$this->assign('list',$list);
		return $this->fetch('index');
	}

}