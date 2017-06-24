<?php

namespace app\admin\controller;
use think\Controller,think\Request,think\Db;

class Delivery extends Base{

	/* 配送线路 */

	public function path(){
		$request = Request::instance();
		$key = trim($request->param('search_key'));
		$where = [];
		if(!empty($key)){
			$where['name'] = ['like','%'.$key.'%'];
		}
		$where['aid'] = session('aid');
		$count = Db::name('delivery_path')->where($where)->count();
		$Page = new \think\Page($count,config('paginate.list_rows'));
		$list = Db::name('delivery_path')->where($where)->order('id desc')->limit($Page->firstRow,$Page->listRows)->select();
		foreach($list as $k=>$v){
			$list[$k]['path'] = db('handtake_place')->where(['id'=>['in',$v['path']]])->limit(2)->column('name');
			$list[$k]['path'] = empty($list[$k]['path']) ? '' : implode(',',$list[$k]['path']).'...';
		}
		$show = $Page->show();
		$this->assign('list',$list);
		$this->assign('show',$show);
		return $this->fetch('path');
	}

	public function addPath(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result = makeResult(0,'没有提交数据');
				return $result;
			}
			$data['name'] = trim($data['name']);
			$data['path'] = trim($data['path']);
			if(empty($data['name'])){
				$result = makeResult(0,'请填写线路名称');
				return $result;
			}else if(empty($data['path'])){
				$result = makeResult(0,'请选择线路配送点');
				return $result;
			}
			$data['count'] = substr_count($data['path'],',')+1;
			$data['aid'] = session('aid');
			$data['status'] = intval($data['status']);
			$data['createtime'] = time();
			$add = db('delivery_path')->insert($data);
			if(!$add){
				$result = makeResult(0,'线路添加失败');
				return $result;
			}
			$result = makeResult(1,'线路添加成功');
			return $result;
		}
		/*$user = model('User');
		$token = $user->get_user_token();
		$where['token'] = $token;*/
		$where['pid'] = 0;
		$list = db('handtake_place')->where($where)->field('id,name')->select();
		foreach($list as $k=>$v){
			$areas = db('handtake_place')->where(['pid'=>$v['id']])->column('id');
			$areas = empty($areas) ? [] : $areas;
			if($areas){
				$list[$k]['subs'] = db('handtake_place')->where(['pid'=>['in',$areas]])->field('id,name,status')->select();
			}else{
				$list[$k]['subs'] = array();
			}
			unset($areas);
		}
		$this->assign('list',$list);
		return $this->fetch('add_path');
	}

	public function searchPoints(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$key = trim($request->post('key'));
			/*$user = model('User');
			$token = $user->get_user_token();
			$where['token'] = $token;*/
			$where['pid'] = 0;
			$tops = db('handtake_place')->where($where)->column('id');
			if (empty($tops)) {
	            return makeResult(0,'搜索不到相关配送点');
	        }
	        $parents = db('handtake_place')->where('pid','in',$tops)->column('id');
			if (empty($parents)) {
	            return makeResult(0,'搜索不到相关配送点');
	        }
	        if(empty($key)){
				$list = db('handtake_place')->where('pid','in',$parents)->field('id,name,status')->select();
			}else{
				$list = db('handtake_place')->where('pid','in',$parents)->where('name','like',"%$key%")->field('id,name,status')->select();
			}
	        if (empty($list)) {
	            return makeResult(0,'搜索不到相关配送点');
	        }
	        return makeResult(1,'ok',['list'=>$list]);
		}
	}

	public function editPath(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result = makeResult(0,'没有提交数据');
				return $result;
			}
			$data['name'] = trim($data['name']);
			$data['path'] = trim($data['path']);
			if(empty($data['name'])){
				$result = makeResult(0,'请填写线路名称');
				return $result;
			}else if(empty($data['path'])){
				$result = makeResult(0,'请选择线路配送点');
				return $result;
			}
			$data['count'] = substr_count($data['path'],',')+1;
			$data['status'] = intval($data['status']);
			$up = db('delivery_path')->update($data);
			if(!$up){
				$result = makeResult(0,'线路修改失败');
				return $result;
			}
			$result = makeResult(1,'线路修改成功');
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = Db::name('delivery_path')->where('id',$id)->field('id,name,path,status')->find();
		if(!$info){
			$this->error('线路信息不存在');
		}
		$tmpArr = empty($info['path']) ? [] : explode(',',$info['path']);
		/*没有分区所以不用
		$user = model('User');
		$token = $user->get_user_token();
		$where['token'] = $token;*/
		$where['pid'] = 0;
		$list = db('handtake_place')->where($where)->field('id,name')->select();
		foreach($list as $k=>$v){
			$areas = db('handtake_place')->where('pid',$v['id'])->column('id');
			$areas = empty($areas) ? [] : $areas;
			if($areas){
				$list[$k]['subs'] = db('handtake_place')->where(['pid'=>['in',$areas]])->field('id,name,status')->select();
			}else{
				$list[$k]['subs'] = array();
			}
			unset($areas);
		}
		$tmpPath = db('handtake_place')->where('id','in',$tmpArr)->field('id,name')->select();
		if(empty($tmpPath)){
			$info['path'] = [];
		}else{
			$info['path'] = [];
			foreach($tmpArr as $tk=>$tv){
				foreach($tmpPath as $pk=>$pv){
					if($tv==$pv['id']){
						$info['path'][] = $pv;
					}
				}
			}
		}
		$this->assign('info',$info);
		$this->assign('tarr',$tmpArr);
		$this->assign('list',$list);
		return $this->fetch('edit_path');
	}

	public function delPath(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('did'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('delivery_path')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	/* 配送线路 */

	/* 配送司机 */

	public function driver(){
		$request = Request::instance();
		$key = trim($request->param('search_key'));
		$where = [];
		if(!empty($key)){
			$where['d.name|d.tel'] = ['like','%'.$key.'%'];
		}
		$where['d.aid'] = session('aid');
		$list = Db::name('delivery_driver')->alias('d')->join('qgs_delivery_path p','d.dpath = p.id','LEFT')->where($where)->order('d.id desc')->field('d.id,d.name,d.tel,d.status,d.createtime,p.name as path')->paginate();
		$this->assign('list',$list);
		return $this->fetch('driver');
	}

	public function addDriver(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result = makeResult(0,'没有提交数据');
				return $result;
			}
			$data['name'] = trim($data['name']);
			$data['tel'] = trim($data['tel']);
			$data['pwd'] = trim($data['pwd']);
			if(empty($data['name'])){
				$result = makeResult(0,'请填写司机名称');
				return $result;
			}else if(empty($data['tel'])){
				$result = makeResult(0,'请填写联系电话');
				return $result;
			}else if(!preg_match('/^[\d-]{8,13}$/',$data['tel'])){
				$result = makeResult(0,'联系电话格式不正确');
				return $result;
			}else if(empty($data['pwd'])){
				$result = makeResult(0,'请填写登录密码');
				return $result;
			}else if(!preg_match('/^[\w@\+\?\.\*-\_\#\^]{6,30}$/',$data['pwd'])){
				$result = makeResult(0,'登录密码为6-30位字符');
				return $result;
			}else if($data['pwd']!==$data['repwd']){
				$result = makeResult(0,'两次密码填写不一致');
				return $result;
			}
			$check = Db::name('delivery_driver')->where('tel',$data['tel'])->count();
			if($check>0){
				$result = makeResult(0,'联系电话已存在');
				return $result;
			}
			unset($data['repwd']);
			$data['pwd'] = md5($data['pwd']);
			$data['dpath'] = intval($data['dpath']);
			if($data['dpath']!=0){
				$check = Db::name('delivery_driver')->where('dpath',$data['dpath'])->count();
				if($check>0){
					$result = makeResult(0,'该线路已被设为其他司机的默认线路');
					return $result;
				}
			}
			$data['aid'] = session('aid');
			$data['status'] = intval($data['status']);
			$data['createtime'] = time();
			$add = Db::name('delivery_driver')->insert($data);
			if(!$add){
				$result = makeResult(0,'司机账号添加失败');
				return $result;
			}
			$result = makeResult(1,'司机账号添加成功');
			return $result;
		}
		$list = db('delivery_path')->where('aid',session('aid'))->order('id desc')->field('id,name')->select();
		$this->assign('list',$list);
		return $this->fetch('add_driver');
	}

	public function editDriver(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result = makeResult(0,'没有提交数据');
				return $result;
			}
			$data['name'] = trim($data['name']);
			$data['tel'] = trim($data['tel']);
			$data['pwd'] = trim($data['pwd']);
			if(empty($data['name'])){
				$result = makeResult(0,'请填写司机名称');
				return $result;
			}else if(empty($data['tel'])){
				$result = makeResult(0,'请填写联系电话');
				return $result;
			}else if(!preg_match('/^[\d-]{8,13}$/',$data['tel'])){
				$result = makeResult(0,'联系电话格式不正确');
				return $result;
			}
			if(empty($data['pwd'])){
				unset($data['pwd']);
				unset($data['repwd']);
			}else{
				if(!preg_match('/^[\w@\+\?\.\*-\_\#\^]{6,30}$/',$data['pwd'])){
					$result = makeResult(0,'登录密码为6-30位字符');
					return $result;
				}else if($data['pwd']!==$data['repwd']){
					$result = makeResult(0,'两次密码填写不一致');
					return $result;
				}
				unset($data['repwd']);
				$data['pwd'] = md5($data['pwd']);
			}
			$check = Db::name('delivery_driver')->where('id','<>',$data['id'])->where('tel',$data['tel'])->count();
			if($check>0){
				$result = makeResult(0,'联系电话已存在');
				return $result;
			}
			$data['dpath'] = intval($data['dpath']);
			if($data['dpath']!=0){
				$check = Db::name('delivery_driver')->where('id','<>',$data['id'])->where('dpath',$data['dpath'])->count();
				if($check>0){
					$result = makeResult(0,'该线路已被设为其他司机的默认线路');
					return $result;
				}
			}
			$data['aid'] = session('aid');
			$data['status'] = intval($data['status']);
			$up = Db::name('delivery_driver')->update($data);
			if(!$up){
				$result = makeResult(0,'司机账号修改失败');
				return $result;
			}
			$result = makeResult(1,'司机账号修改成功');
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = Db::name('delivery_driver')->where('id',$id)->field('pwd,aid,createtime',true)->find();
		if(!$info){
			$this->error('司机账号不存在');
		}
		$list = db('delivery_path')->where('aid',session('aid'))->order('id desc')->field('id,name')->select();
		$this->assign('list',$list);
		$this->assign('info',$info);
		return $this->fetch('edit_driver');
	}

	public function delDriver(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('did'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('delivery_driver')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function driverRecord(){
		$request = Request::instance();
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$where = [];
		$where['r.driver'] = $id;
		$tpWhere = [];
		$tpWhere['t.did'] = $id;
		//筛选条件
		$time = trim($request->param('time'));
		$type = intval($request->param('type'));
		$path = trim($request->param('path'));
		if(!empty($time)&&strtotime($time)){
			$ctime = strtotime($time);
			$where['r.date'] = $ctime;
			switch($type){
				case 1:
					$where['r.type'] = 1;
					$tpWhere['t.type'] = 1;
					break;
				case 2:
					$where['r.type'] = 2;
					$tpWhere['t.type'] = 2;
					break;
				default:
					$where['r.type'] = ['in',[1,2]];
					$tpWhere['t.type'] = ['in',[1,2]];
					break;
			}
		}else{
			$ctime = strtotime(date('Y-m-d',time()));
			$where['r.date'] = $ctime;
			$where['r.type'] = ['in',[1,2]];
			$tpWhere['t.type'] = ['in',[1,2]];
		}
		$tpWhere['t.date'] = $ctime;
		if(!empty($path)){
			$cpath = intval($path);
			$where['r.path'] = $cpath;
		}
		$list = Db::name('delivery_record')->alias('r')
									->join(['qgs_handtake_place'=>'sp',''],'r.point = sp.id','LEFT')
									->join('delivery_path p','r.path = p.id','LEFT')
									->where($where)
									->order('r.id desc')
									->field('r.id,p.name as path,sp.name,sp.address,r.status,r.onums,r.createtime')
									->paginate();
		$paths = Db::name('delivery_path')->where('aid',session('aid'))->order('id desc')->field('id,name')->select();
		$tmpPath = Db::name('delivery_temp')->alias('t')
									->join('delivery_path p','t.pid = p.id')
									->where($tpWhere)
									->group('p.id')
									->column('p.id,p.name,p.count,sum(p.count) as nums');
		if(!empty($tmpPath)){
			$pswhere = [];
			$pswhere['driver'] = $id;
			$pswhere['date'] = $ctime;
			$pswhere['type'] = $where['r.type'];
			foreach($tmpPath as $tpk=>$tpv){
				$pswhere['path'] = $tpk;
				$tmpPath[$tpk]['arrive'] = Db::name('delivery_record')->where(array_merge($pswhere,['status'=>1]))->count();
				$tmpPath[$tpk]['jump'] = Db::name('delivery_record')->where(array_merge($pswhere,['status'=>-1]))->count();
				$tmpPath[$tpk]['unsend'] = $tpv['nums'] - ($tmpPath[$tpk]['arrive'] + $tmpPath[$tpk]['jump']);
			}
		}
		$this->assign('tmpPath',$tmpPath);
		$this->assign('ctime',$ctime);
		$this->assign('id',$id);
		$this->assign('list',$list);
		$this->assign('paths',$paths);
		return $this->fetch('driver_record');
	}

	/* 配送司机 */

}