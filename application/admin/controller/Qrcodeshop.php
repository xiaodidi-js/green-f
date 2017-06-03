<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/6/2
 * Time: 00:35
 * 分享购买和限时抢购、二维码商品配置流程基本一样,如需改动请按实际情况一起改动修改!
 */
namespace app\admin\controller;
use think\Controller,think\Request,think\Db;
use app\admin\controller\Phpqrcode as PHPqrcode;

class Qrcodeshop extends Base{

	// 分享商品列表
	public function qrcodelist(){
		$list = Model('ProductQrcode')->query();
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 分享购买活动新增和编辑
	public function addoredit(){
		$request = Request::instance();
        $post = $request->post();
        $get = $request->route();
        if (!empty($get['id'])) {
            $cilck = Model('ProductQrcode')->queryinfo($get['id']);
            $cilck['stime'] = date('Y-m-d H:i:s',$cilck['stime']);
            $cilck['etime'] = date('Y-m-d H:i:s',$cilck['etime']);
            $this->assign('info', $cilck);
            $this->assign('id', $get['id']);
            return $this->fetch('edit');
        } elseif (empty($post)) {
            return $this->fetch('add');
        }
        if (!empty($post['id'])) {
            $stime = strtotime($post['stime']);
            $etime = strtotime($post['etime']);
            $update['stime'] = $stime;
            $update['etime'] = $etime;
            $update['stu'] = $post['stu'];
            $update['userclass'] = $post['userclass'];
            $update['name'] = $post['name'];
            $edit = Model('ProductQrcode')->edit($update,$post['id']);
            if ($edit) {
                make_json(1, '编辑成功');
            } else {
                make_json(0, '编辑失败');
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
            $data['userclass'] = $post['userclass'];
            $data['ctime'] = time();
            $add = db('ProductQrcode')->insert($data);
            if ($add) {
                make_json(1, '新增成功');
            } else {
                make_json(0, '新增失败');
            }
        }
	}

	// 删除分享购买
    public function del(){
        $request = Request::instance();
        $post = $request->post();
        if ($post['id']) {
            $update['is_del'] = 1;
            $click = Model('ProductQrcode')->edit($update,$post['id']);
            return make_json(1, '删除成功');
        } else {
            return make_json(0, '找不到这个分享购买活动可能已被删除');
        }
    }

    // 配置页面
	public function config(){
		$request = Request::instance();
		$get = $request->route();
		$where['is_del'] = 0;
		$where['gift'] = 0;
		$cx = Model('ProductQrcode')->queryinfo($get['id']);
		if($cx['data']){
			$morenshop = unserialize($cx['data']);
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
        $cx = Model('ProductQrcode')->queryinfo($post['id']);
        $where['is_del'] = 0;
        $where['gift'] = 0;
        if($cx['data']){
            $morenshop = unserialize($cx['data']);
            foreach ($morenshop as $num => $val) {
                $shopid[] = $val['id'];
            }
            $list = db('product')->where($where)->where('id','in',$shopid)->field('id,shotcut,name,cid,price,store')->select();
            foreach ($list as $key => &$value) {
                foreach ($morenshop as $key1 => $value1) {
                    if($value['id'] == $value1['id']){
                        $cxclass = db('product_classify')->where('id',$value['cid'])->field('title')->find();
                        $value['class'] = $cxclass['title'];
                        $value['qrcodeprice'] = $value1['qrcodeprice'];
                        $value['qrcodestore'] = $value1['qrcodestore'];
                        $value['qrcodeimg'] = $value1['qrcodeimg'];
                    }
                }
            }
        }else{
            $list = null;
        }
        make_json(1,['info'=>$list]);
    }

    // 完成配置保存
    public function configok(){
		$request = Request::instance();
		$post = $request->post();
		$where['id'] = $post['id'];
		if(!empty($post['data'])){
			$data['data'] = serialize($post['data']);
		}else{
			$data['data'] = null;
		}
		$editsince = Model('ProductQrcode')->edit($data,$post['id']);
		if($editsince){
			make_json(1,'更新成功');
		}else{
			make_json(0,'更新失败');
		}
	}

	// 新建商品二维码
	public function addqrcode(){
		$request = Request::instance();
		$post = $request->post();
		if(!empty($post['shopid']) && !empty($post['qrcodeid'])){
			$qrcode = new PHPqrcode;
			$content = 'http://'.$_SERVER['HTTP_HOST'].'/vue/index_prod.html#!/detail/'.$post['shopid'].'/qrcodeid/'.$post['qrcodeid'];
			$path = $qrcode->qrcodeshop($content);
			if($path){
				make_json(1,['qrcodeimg' => $path]);
			}else{
				make_json(0,'生成二维码失败');
			}
		}else{
			make_json(0,'没有商品id或活动id');
		}
	}
}