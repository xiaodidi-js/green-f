<?php

namespace app\admin\controller;
use think\Controller,think\Request;

class Gift extends Base{

	public function _initialize(){
		parent::_initialize();
		$this->reqdata = $this->request->param();
		$this->postdata = $this->request->post();
	}

	// 自提点
	public function Giftlist(){
		$list = db('handtake_place')->where('status',1)->where('address','not null')->select();
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 配置页面
	public function configure(){
		$get = $this->reqdata;
		$where['is_del'] = 0;
		$where['gift'] = 1;
		$cxsince = db('handtake_place')->where('id',$get['id'])->field('shoudan')->find();
		if($cxsince['shoudan']){
			$morenshop = unserialize($cxsince['shoudan']);
			$morenshop = implode(",",$morenshop);
			$list = db('product')->where($where)->where('id','not in',$morenshop)->field('id,shotcut,name,cid,price')->select();
		}else{
			$list = db('product')->where($where)->field('id,shotcut,name,cid,price')->select();
		}
		
		foreach ($list as $key => &$value) {
			$cxclass = db('product_classify')->where('id',$value['cid'])->field('title')->find();
			$value['class'] = $cxclass['title'];
		}
		$this->assign('id',$get['id']);
		$this->assign('list',json_encode($list));
		return $this->fetch();
	}

	// 添加到赠品列表
	public function shopinfo(){
		$get = $this->reqdata;
		$where['id'] = $get['id'];
		$info = db('product')->where($where)->field('id,shotcut,name,cid,price,createtime,store')->find();
		$cxclass = db('product_classify')->where('id',$info['cid'])->field('title')->find();
		$info['class'] = $cxclass['title'];
		make_json(1,['info'=>$info]);
	}

	// 已选赠品
	public function morenshop(){
		$post = $this->postdata;
		$cxsince = db('handtake_place')->where('id',$post['id'])->field('shoudan')->find();
		$where['is_del'] = 0;
		$where['gift'] = 1;
		if($cxsince['shoudan']){
			$morenshop = unserialize($cxsince['shoudan']);
			$morenshop = implode(",",$morenshop);
			$list = db('product')->where($where)->where('id','in',$morenshop)->field('id,shotcut,name,cid,price')->select();
			foreach ($list as $key => &$value) {
				$cxclass = db('product_classify')->where('id',$value['cid'])->field('title')->find();
				$value['class'] = $cxclass['title'];
			}
		}else{
			$list = null;
		}
		
		make_json(1,['info'=>$list]);
		
	}

	// 修改首单自提点赠品
	public function onepay(){
		$post = $this->postdata;
		$where['id'] = $post['id'];
		if(!empty($post['tianjia'])){
			$data['shoudan'] = serialize($post['tianjia']);
		}else{
			$data['shoudan'] = null;
		}
		$editsince = db('handtake_place')->where($where)->update($data);
		if($editsince){
			make_json(1,'更新成功');
		}else{
			make_json(0,'更新失败');
		}
	}

	// 满就送列表
	public function maxgift(){
		$list = db('since_maxgift')->field('maxmoney,id')->select();
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 满就送添加
	public function addmaxgift(){
		$get = $this->reqdata;
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$post = $this->postdata;
            if(empty($post['since'])){
                $data['useshop'] = null;
            }else{
                $data['useshop'] = serialize($post['since']);
            }
            if(empty($post['tianjia'])){
                $data['shopid'] = null;
            }else{
                $data['shopid'] = serialize($post['tianjia']);
            }
			$data['maxmoney'] = $post['maxmoney'];
			if(!empty($post['id'])){
				$oksince = db('since_maxgift')->where('id',$post['id'])->update($data);
			}else{
			    if($data['shopid'] == null ){
			        unset($data['shopid']);
                }
				$oksince = db('since_maxgift')->insert($data);
			}
			if($oksince){
				make_json(1,'更新成功');
			}else{
				make_json(0,'更新失败');
			}
		}else{
			$cxsince = db('since_maxgift')->where('id',$get['id'])->field('shopid')->find();
			$where['is_del'] = 0;
			$where['gift'] = 1;
			$list = db('product')->where($where)->field('id,shotcut,name,cid,price')->select();
			foreach ($list as $key => &$value) {
				$cxclass = db('product_classify')->where('id',$value['cid'])->field('title')->find();
				$value['class'] = $cxclass['title'];
			}
			$since = db('handtake_place')->where('address','not null')->where('status',1)->field('id,name')->select();
			$this->assign('since',$since);
			$this->assign('list',json_encode($list));
			return $this->fetch();
		}
	}

	public function editmaxgift(){
		$get = $this->reqdata;
		$cxsince = db('since_maxgift')->where('id',$get['id'])->field('shopid')->find();
		$where['is_del'] = 0;
		$where['gift'] = 1;
		if($cxsince['shopid']){
			$morenshop = unserialize($cxsince['shopid']);
			$morenshop = implode(",",$morenshop);
			$list = db('product')->where($where)->where('id','not in',$morenshop)->field('id,shotcut,name,cid,price')->select();
		}else{
			$list = db('product')->where($where)->field('id,shotcut,name,cid,price')->select();
		}

		// 商品分类赋值
		foreach ($list as $key => &$value) {
			$cxclass = db('product_classify')->where('id',$value['cid'])->field('title')->find();
			$value['class'] = $cxclass['title'];
		}

		// 查询全部自提点
		$since = db('handtake_place')->where('address','not null')->where('status',1)->field('id,name')->select();

		// 把所有自提点ID筛选出来给全选用
		foreach ($since as $key1 => $value1) {
			$allid[] = $value1['id'];
		}
		$allid = implode(',',$allid);
		// 满就送已选自提点格式化
		$maxgift = db('since_maxgift')->where('id',$get['id'])->field('useshop,maxmoney')->find();
		// 满就送满足金额赋值
		$maxmoney = $maxgift['maxmoney'];
		$maxgift = unserialize($maxgift['useshop']);
		if(!empty($maxgift)){
            $maxgift = implode(',',$maxgift);
        }else{
            $maxgift = null;
        }
        $this->assign('allid',$allid);
		$this->assign('maxgift',$maxgift);
		$this->assign('maxmoney',$maxmoney);
		$this->assign('id',$get['id']);
		$this->assign('since',$since);
		$this->assign('list',json_encode($list));
		return $this->fetch();
	}

	public function morenmaxshop(){
		$post = $this->postdata;
		$cxsince = db('since_maxgift')->where('id',$post['id'])->field('shopid')->find();
		$where['is_del'] = 0;
		$where['gift'] = 1;
		if($cxsince['shopid']){
			$morenshop = unserialize($cxsince['shopid']);
			$morenshop = implode(",",$morenshop);
			$list = db('product')->where($where)->where('id','in',$morenshop)->field('id,shotcut,name,cid,price')->select();
		}else{
			$list = null;
		}
		foreach ($list as $key => &$value) {
			$cxclass = db('product_classify')->where('id',$value['cid'])->field('title')->find();
			$value['class'] = $cxclass['title'];
		}
		make_json(1,['info'=>$list]);
	}

	public function maxdel(){
		$post = $this->postdata;
		$deldata = db('since_maxgift')->where('id',$post['id'])->delete();
		if($deldata){
			make_json(1,'删除成功');
		}else{
			make_json(0,'删除失败');
		}
	}
}