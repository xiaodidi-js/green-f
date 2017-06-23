<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/5/3
 * Time: 10:02
 * 分享购买和限时抢购、二维码商品配置流程基本一样,如需改动请按实际情况一起改动修改!
 */
namespace app\admin\controller;
use think\Controller,think\Request,think\Db;

class Shareshop extends Base{

	// 分享商品列表
	public function sharelist(){
		$list = Model('ProductShare')->queryshare();
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 分享购买活动新增和编辑
	public function addoreditshare(){
		$request = Request::instance();
        $post = $request->post();
        $get = $request->route();
        if (!empty($get['id'])) {
            $cilck = Model('ProductShare')->queryshareinfo($get['id']);
            $cilck['stime'] = date('Y-m-d H:i:s',$cilck['stime']);
            $cilck['etime'] = date('Y-m-d H:i:s',$cilck['etime']);
            $this->assign('info', $cilck);
            $this->assign('id', $get['id']);
            return $this->fetch('editshare');
        } elseif (empty($post)) {
            return $this->fetch('addshare');
        }
        if (!empty($post['id'])) {
            $stime = strtotime($post['stime']);
            $etime = strtotime($post['etime']);
            $update['stime'] = $stime;
            $update['etime'] = $etime;
            $update['stu'] = $post['stu'];
            $update['name'] = $post['name'];
            $edit = Model('ProductShare')->editshare($update,$post['id']);
            if ($edit) {
                return make_json(1, '编辑成功');
            } else {
                return make_json(0, '编辑失败');
            }
        } else {
            if (empty($post['stime']) || empty($post['etime']) || empty($post['name'])) {
                return make_json(0, '请填写每个输入框');
            }
            $stime = strtotime($post['stime']);
            $etime = strtotime($post['etime']);
            if ($stime >= $etime) {
                return make_json(0, '开始时间大过结束时间，无效请重新选择');
            }
            $data['stime'] = $stime;
            $data['etime'] = $etime;
            $data['stu'] = $post['stu'];
            $data['name'] = $post['name'];
            $data['ctime'] = time();
            $add = db('ProductShare')->insert($data);
            if ($add) {
                return make_json(1, '新增成功');
            } else {
                return make_json(0, '新增失败');
            }
        }
	}

	// 删除分享购买
    public function delshare(){
        $request = Request::instance();
        $post = $request->post();
        if ($post['id']) {
            $update['is_del'] = 1;
            $click = Model('ProductShare')->editshare($update,$post['id']);
            return make_json(1, '删除成功');
        } else {
            return make_json(0, '找不到这个分享购买活动可能已被删除');
        }
    }

    // 配置页面
	public function configshare(){
		$request = Request::instance();
		$get = $request->route();
		$where['is_del'] = 0;
		$where['gift'] = 0;
		$cxshare = Model('ProductShare')->queryshareinfo($get['id']);
		if($cxshare['data']){
			$morenshop = unserialize($cxshare['data']);
			foreach ($morenshop as $num => $val) {
                $shopid[] = $val['id'];
            }
			$list = db('product')->where($where)->where('id','not in',$shopid)->field('id,shotcut,name,cid,price')->select();
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

    // 已选分享购买商品
    public function morenshop(){
    	$request = Request::instance();
		$post = $request->post();
        $cxshare = Model('ProductShare')->queryshareinfo($post['id']);
        $where['is_del'] = 0;
        $where['gift'] = 0;
        if($cxshare['data']){
            $morenshop = unserialize($cxshare['data']);
            foreach ($morenshop as $num => $val) {
                $shopid[] = $val['id'];
            }
            $list = db('product')->where($where)->where('id','in',$shopid)->field('id,shotcut,name,cid,price,store')->select();
            foreach ($list as $key => &$value) {
                foreach ($morenshop as $key1 => $value1) {
                    if($value['id'] == $value1['id']){
                        $cxclass = db('product_classify')->where('id',$value['cid'])->field('title')->find();
                        $value['class'] = $cxclass['title'];
                        $value['shareprice'] = $value1['shareprice'];
                        $value['sharestore'] = $value1['sharestore'];
                    }
                    
                }
            }
        }else{
            $list = null;
        }
        return make_json(1,['info'=>$list]);
    }

    // 完成配置保存
    public function configok(){
		$request = Request::instance();
		$post = $request->post();
		$where['id'] = $post['id'];
        foreach ($post['data'] as $key => $value) {
            $where['stime'] = array('elt',$now);
            $where['etime'] = array('egt',$now);
            $queryshare = db('sale')->where($where)->field('data')->find();
            if($queryshare){
                foreach (unserialize($queryshare['data']) as $key1 => $value1) {
                    if($value1['id'] == $value['id']){
                        $queryshop = Model('ProductShare')->where('id',$value['id'])->field('name')->find();
                        return make_json(0,$queryshop['name'].'商品已参加了限时抢购');
                    }
                }
            }
            
        }
		if(!empty($post['data'])){
			$data['data'] = serialize($post['data']);
		}else{
			$data['data'] = null;
		}
		$editsince = Model('ProductShare')->editshare($data,$post['id']);
		if($editsince){
			return make_json(1,'更新成功');
		}else{
			return make_json(0,'更新失败');
		}
	}
}