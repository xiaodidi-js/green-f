<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/4/24
 * Time: 10:02
 */
namespace app\admin\controller;
use think\Controller,think\Request;
use think\Db;

class Printorder extends Base{
	// 打票机首页
	public function index(){
		$handtake = Model('HandtakePlace');
		$parents = $handtake->where('pid',0)->order('sort desc,id desc')->select();
		$list = array();
		if($parents){
			foreach($parents as $k=>$v){
				$list[$k] = $v;
				$list[$k]['sub'] = $handtake->where('pid',$v['id'])->order('sort desc,id desc')->select();
			}
		}
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 自提点首页
	public function since(){
		$request = Request::instance();
		$route = $request->route();
		$get = $request->get();
		if(empty($get['stime']) || empty($get['etime'])){
			$time = date('Y-m-d');
			$time = strtotime($time);
			$get['stime'] = $time;
			$get['etime'] = $time + 86399;
		}else{
			$get['stime'] = strtotime($get['stime']);
			$get['etime'] = strtotime($get['etime']);
			$istime = $get['stime'];
			$iftime = $get['etime'];
			$route['id'] = $get['id'];
		}
		$querysince = Model('HandtakePlace')->queryallid($route['id']);
		foreach ($querysince as $key1 => &$value1) {
			$querysinceaddress = Model('MemberOrders')->queryalladdress($value1['address'],$get,0);
			$value1['print'] = $querysinceaddress;
		}
		$istime = date('Y-m-d H:i:s',$get['stime']);
		$iftime = date('Y-m-d H:i:s',$get['etime']);
		$tag = db('classify_tag')->select();
		$this->assign('tag',$tag);
		$this->assign('id',$route['id']);
		$this->assign('istime',$istime);
		$this->assign('iftime',$iftime);
		$this->assign('list',$querysince);
		return $this->fetch();
	}

	// 打印查看
	public function print(){
		$request = Request::instance();
		$get = $request->param();
		if(!empty($get['stime'])){
			$istime = $get['stime'];
			$get['stime'] = strtotime($get['stime']);
		}else{
			$istime = date('Y-m-d').' 00:00:00';
			$get['stime'] = strtotime(date('Y-m-d'));
		}
		if(!empty($get['etime'])){
			$iftime = $get['etime'];
			$get['etime'] = strtotime($get['etime']);
		}else{
			$iftime = date('Y-m-d').' 23:59:59';
			$get['etime'] = strtotime($iftime);
		}
		$this->assign('istime',$istime);
		$this->assign('iftime',$iftime);
        $where['o.is_del'] = 0;
        $where['o.pay'] = 1;
        $where['o.receive'] = 0;
        // $where['o.send'] = 0;
        if(!empty($get['kuaidi'])){
        	$where['o.stype'] = 'express';
        	$this->assign('sincename','快递');
        	$this->assign('kuaidi',1);
        }else{
			$sincename = $get['id'];
        	$where['o.stype'] = 'parcel';
			$where['o.address'] = $get['id'];
			$this->assign('sincename',$sincename);
			$this->assign('kuaidi',0);
        }
        $this->assign('printifok',$get['stu']);
        // $where['o.stype'] = 'parcel';
        $where['o.stime'] = array('between',[$get['stime'],$get['etime']]);
        if($get['stu'] == 0){
        	$where['o.print'] = 0;
        }elseif($get['stu'] == 1){
        	$where['o.print'] = 1;
        }
        $queryclass = Model('ProductClassify')->where('tag',$get['tag'])->field('id')->select();
        if($queryclass){
        	foreach ($queryclass as $num => $play) {
            $classid[] = $play['id'];
	        }
	        $where['cid'] = array('in',$classid);
        }
        $field = 'o.id,o.orderid,gift,name,description,tel,sum,stime,address,tips,l.amount,l.activity';
		$list = DB::table('qgs_member_orders o')->join('qgs_member_orderlist l','l.oid=o.orderid')->join('qgs_product p','p.id = l.pid','left')->where($where)->field($field)->select();
		if($list){
			foreach ($list as $key => $value) {
				if(empty($alloid[$value['orderid']])){
					$alloid[$value['orderid']]['tel'] = $value['tel'];
					$alloid[$value['orderid']]['description'] = $value['description'];
					$alloid[$value['orderid']]['tips'] = $value['tips'];
					$alloid[$value['orderid']]['orderid'] = $value['orderid'];
					$alloid[$value['orderid']]['address'] = $value['address'];
					$alloid[$value['orderid']]['id'] = $value['id'];
					$alloid[$value['orderid']]['stime'] = $value['stime'];
					$alloid[$value['orderid']]['sum'] = $value['sum'];
				}
				if($value['gift'] == 1){
					if(empty($alloid[$value['orderid']]['gift_data'])){
						$alloid[$value['orderid']]['gift_data'] = array();
					}
					if($value['activity'] == '-1'){
						$alloid[$value['orderid']]['gift_data'][$key]['activity'] = "【首单用户】";
					}else{
						$queryactivity = Model('SinceMaxgift')->querymaxactivity($value['activity']);
						$alloid[$value['orderid']]['gift_data'][$key]['activity'] = "【满".$queryactivity['maxmoney']."赠送】";
					}
					$alloid[$value['orderid']]['gift_data'][$key]['name'] = $value['name'];
					$alloid[$value['orderid']]['gift_data'][$key]['amount'] = $value['amount'];
				}else{
					if(empty($alloid[$value['orderid']]['shop_data'])){
						$alloid[$value['orderid']]['shop_data'] = array();
					}
					$alloid[$value['orderid']]['shop_data'][$key]['name']  = $value['name'];
					$alloid[$value['orderid']]['shop_data'][$key]['amount'] = $value['amount'];
				}
				if(empty($alloid[$value['orderid']]['gift_data'])){
					$alloid[$value['orderid']]['gift_data'] = null;
				}
				if(empty($alloid[$value['orderid']]['shop_data'])){
					$alloid[$value['orderid']]['shop_data'] = null;
				}
				$orderidAll[$value['orderid']] = $value['orderid'];
			}
		}else{
			$alloid = null;
			$orderidAll = null;
		}
		$tagclass = db('classify_tag')->select();
		$this->assign('tag',$get['tag']);
		$this->assign('tagclass',$tagclass);
		$this->assign('orderidAll',$orderidAll);
		$this->assign('nub',count($alloid));
        $this->assign('list',$alloid);
		return $this->fetch();
	}

	public function printok(){
		$request = Request::instance();
		$post = $request->post();
		if(empty($post['orderid'])){
			return make_json(0, '没有找到订单');
			exit();
		}
		$edit = Model('MemberOrders')->printeditok($post['orderid']);
		if($edit){
			return make_json(1, '确认打印成功');
		}else{
			return make_json(0, '确认打印失败');
		}
	}

	// 标签管理
	public function taglist(){
		$list = db('classify_tag')->select();
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 配置标签管理
	public function configtag(){
		$request = Request::instance();
		$route = $request->route();
		$post = $request->post();
		if(empty($post)){
			$morenlist = db('product_classify')->where('tag',$route['id'])->field('id')->select();
			if(empty($morenlist)){
				$morenlist = null;
			}else{
				foreach ($morenlist as $key => $value) {
					$morenid[] = $value['id'];
				}
				$morenid = implode(',',$morenid);
			}
			if(empty($morenid)){
				$morenid = null;
			}
			$list = db('product_classify')->where('status',1)->field('id,title,tag')->select();
			foreach ($list as $key1 => &$value1) {
				$querytag = db('classify_tag')->where('id',$value1['tag'])->field('name')->find();
				$value1['tagname'] = $querytag['name'];
			}
			$this->assign('id',$route['id']);
			$this->assign('morenid',$morenid);
			$this->assign('list',$list);
			return $this->fetch();
		}else{
			$updatemoren['tag'] = 0 ; 
			$editbianji = db('product_classify')->where('tag',$post['id'])->update($updatemoren);
			$update['tag'] = $post['id'];
			$edit = db('product_classify')->where('id','in',$post['classid'])->update($update);
			if($edit){
				return make_json(1, '配置成功');
			}else{
				return make_json(0, '配置失败');
			}
		}
	}

	// 添加和编辑标签
	public function addedittag(){
		$request = Request::instance();
		$route = $request->route();
		if($request->isAjax()&&$request->isPost()){
			$post = $request->post();
			if(empty($route['id'])){
				$post = $request->post();
				$data['name'] = $post['name'];
				$data['ctime'] = time();
				$editoradd = db('classify_tag')->insert($data);
			}else{
				$data['name'] = $post['name'];
				$editoradd = db('classify_tag')->where('id',$route['id'])->update($data);
			}
			if($editoradd){
				return make_json(1,'保存成功');
			}else{
				return make_json(0,'保存失败');
			}
		}else{
			if(!empty($route['id'])){
				$info = db('classify_tag')->where('id',$route['id'])->find();
				$this->assign('id',$route['id']);
				$this->assign('info',$info);
				return $this->fetch('edittag');
			}else{
				return $this->fetch('addtag');
			}
		}
	}
} 