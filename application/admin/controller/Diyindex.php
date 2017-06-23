<?php
namespace app\admin\controller;
use think\Request;
use common\Category;

class Diyindex extends Base{

	public function start(){
		// 查询分类
		$cxclass = db('product_classify')->order('createtime desc')->select();
		$category = new Category(array('id','class','title','cname'));
		$tree = $category->getTree($cxclass);
		// 查询商品推荐
		$where['status'] = 1;
		$cxtuijian = db('product_tuijian')->where($where)->field('id,title')->order('sort desc')->select();
		$this->assign('cxtuijian',$cxtuijian);
		$this->assign('list',$tree);
		return $this->fetch();
	}

	// 读取自定义页面的配置
	public function uploadList(){
		$cxuploadList = db('indexlayout')->order('id desc')->find();
		$cxuploadList = unserialize($cxuploadList['data']);
		return make_json(1,['list' => $cxuploadList]);
	}

	public function list(){
		return $this->fetch();
	}

	public function checkclass(){
		$maa['status'] = 1;
		$ProductClassify = Model('ProductClassify');
		$cx = $ProductClassify->where($maa)->select();
		return make_json(1,['class' => $cx]);
	}

	public function img(){
		$request = Request::instance();
		$files = $request->file();
		foreach($files as $file){
	        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
	        if($info){
	        	$allimg['name'] = $info->getsaveName();
	        	$allimg['url'] = '//'.$_SERVER['HTTP_HOST'].'/public/uploads/'.$info->getsaveName();
	        	return make_json(1,['img' => $allimg]);
	            //保存数值可看$info对象数组
		    }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
		    }    
	    }
	}

	public function layoutok(){
		$request = Request::instance();
		$post = $request->post();
		$post['time'] = time();
		$post['data'] = serialize($post['data']);
		$add = db('indexlayout')->insert($post);
		if($add){
			return make_json(1,'编辑成功');
		}else{
			return make_json(0,'编辑失败');
		}
	}
}