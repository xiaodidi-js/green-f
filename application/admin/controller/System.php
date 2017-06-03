<?php

namespace app\admin\controller;

use think\Request,think\Validate,think\Loader;

class System extends Base{

	public function index(){
		return $this->fetch('index');
	}

	public function column(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$list = db('column')->where('name','like','%'.$key.'%')->order('id desc')->paginate();
		}else{
			$list = db('column')->order('id desc')->paginate();
		}
		$this->assign('list',$list);
		return $this->fetch('column');
	}

	public function addColumn(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = Loader::validate('Column');
			$data['level'] = intval($data['level']) ? intval($data['level']) : 1;
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$add = db('column')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '栏目添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '栏目添加成功';
			}
			return $result;
		}
		$list = db('column')->where('pid = 0')->order('id desc')->field('id,name')->select();
		$this->assign('list',$list);
		return $this->fetch('add_column');
	}

	public function editColumn(){
		$request = Request::instance();
		$col_db = db('column');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = Loader::validate('Column');
			$data['level'] = intval($data['level']) ? intval($data['level']) : 1;
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$add = $col_db->update($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '栏目修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '栏目修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$list = $col_db->where('pid = 0')->order('id desc')->field('id,name')->select();
		$info = $col_db->where('id ='.$id)->find();
		$this->assign('list',$list);
		$this->assign('info',$info);
		return $this->fetch('edit_column');
	}

	public function delColumn(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('column')->delete($id);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '栏目删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '栏目删除成功';
			}
			return $result;
		}
	}

	public function account(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$list = db('admin')->where('type',2)->where('id','neq',session('aid'))->where('name','like','%'.$key.'%')->order('id desc')->paginate();
		}else{
			$list = db('admin')->where('type',2)->where('id','neq',session('aid'))->order('id desc')->paginate();
		}
		$items = $list->toArray();
		$items = $items['data'];
		if($items){
			foreach($items as $k=>$v){
				$ids = db('auth_group_access')->where('uid',$v['id'])->value('group_id');
				if($ids){
					$groups = db('auth_group')->where('id',$ids)->value('title');
					$groups = $groups ? $groups : '暂无分组';
				}else{
					$groups = '暂无分组';
				}
				$items[$k]['groups'] = $groups;
			}
		}
		$this->assign('list',$items);
		$this->assign('page',$list->render());
		unset($list);
		return $this->fetch('account');
	}

	public function addAccount(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$user = model('User');
			$add = $user->validate(true)->allowField(true)->save($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = $user->getError();
			}else{
				$check = db('auth_group_access')->where('uid',$add)->find();
				if($check){
					db('auth_group_access')->where('uid',$check['uid'])->update(['group_id'=>$data['group_id']]);
				}else{
					db('auth_group_access')->insert(['uid'=>$add,'group_id'=>$data['group_id']]);
				}
				$result['status'] = 1;
				$result['info'] = '账号添加成功';
			}
			return $result;
		}
		$list = db('auth_group')->order('id desc')->field('id,title')->select();
		$this->assign('list',$list);
		return $this->fetch('add_account');
	}

	public function editAccount(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$user = model('User');
			$where = ['id'=>$data['id']];
			unset($data['id']);
			if(!$data['pwd']){
				$validate = new Validate(['name|账号名称'=>'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,25}$/u','tel|手机号码'=>'require|checkTel:/^1\d{10}$/|unique:admin,tel,'.$where['id'],'email|邮箱'=>'require|email|unique:admin,email,'.$where['id']]);
				$validate->extend([
					'checkName' => function($val,$rule){
						return preg_match($rule,$val) ? true : '账号名称为1-25个字符(字母、数字和中文)';
					},
					'checkTel' => function($val,$rule){
						return preg_match($rule,$val) ? true : '手机号码格式不正确';
					}
				]);
				if(!$validate->check($data)){
					$result['status'] = 0;
					$result['info'] = $validate->getError();
					return $result;
				}
				$add = $user->allowField(['tel','name','email','headimg','status'])->save($data,$where);
			}else{
				$validate = new Validate(['name|账号名称'=>'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,25}$/u','tel|手机号码'=>'require|checkTel:/^1\d{10}$/|unique:admin,tel,'.$where['id'],'email|邮箱'=>'require|email|unique:admin,email,'.$where['id'],'pwd|登录密码'=>'require|checkPwd:/^[a-zA-Z0-9\_@#&%]{6,40}$/u','repwd|确认密码'=>'require|confirm:pwd']);
				$validate->extend([
					'checkName' => function($val,$rule){
						return preg_match($rule,$val) ? true : '账号名称为1-25个字符(字母、数字和中文)';
					},
					'checkTel' => function($val,$rule){
						return preg_match($rule,$val) ? true : '手机号码格式不正确';
					},
					'checkPwd' => function($val,$rule){
						return preg_match($rule,$val) ? true : '登录密码为6-40个字符(字母、数字)和特殊字符(_@#&%)';
					}
				]);
				if(!$validate->check($data)){
					$result['status'] = 0;
					$result['info'] = $validate->getError();
					return $result;
				}
				$add = $user->allowField(true)->save($data,$where);
			}
			$check = db('auth_group_access')->where('uid',$where['id'])->find();
			if($check){
				$up = db('auth_group_access')->where('uid',$check['uid'])->update(['group_id'=>$data['group_id']]);
			}else{
				$up = db('auth_group_access')->insert(['uid'=>$where['id'],'group_id'=>$data['group_id']]);
			}
			if(!$add&&!$up){
				$result['status'] = 0;
				$result['info'] = '账号修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '账号修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$list = db('auth_group')->order('id desc')->field('id,title')->select();
		$info = db('admin')->where('id',$id)->find();
		$info['headimg'] = explode('.',str_replace('/images/aheads/','',$info['headimg']));
		$info['headimg'] = $info['headimg'][0];
		$group_id = db('auth_group_access')->where('uid',$id)->value('group_id');
		$this->assign('list',$list);
		$this->assign('info',$info);
		$this->assign('group_id',$group_id);
		return $this->fetch('edit_account');
	}

	public function changeAccount(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('id'));
			$type = intval($request->post('type'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$up = db('admin')->where('id',$id)->update(['status'=>$type]);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '操作失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '操作成功';
			}
			return $result;
		}
	}

	public function delAccount(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('admin')->delete($id);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '账号删除失败';
			}else{
				db('auth_group_access')->where('uid',$id)->delete();
				$result['status'] = 1;
				$result['info'] = '账号删除成功';
			}
			return $result;
		}
	}

	public function power(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$list = db('auth_rule')->where('title','like','%'.$key.'%')->order('id desc')->paginate();
		}else{
			$list = db('auth_rule')->order('id desc')->paginate();
		}
		$this->assign('list',$list);
		return $this->fetch('power');
	}

	public function addRule(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$check = $this->validate($data,'Rule');
			if($check!==true){
				$result['status'] = 0;
				$result['info'] = $check;
				return $result;
			}
			$data['params'] = '';
			if(isset($data['key'])&&isset($data['key'])){
				if(is_array($data['key'])&&is_array($data['key'])&&count($data['key'])>0){
					$dkey = '';
					foreach($data['key'] as $k=>$v){
						$dkey = $v;
						$data['params'][$dkey] = isset($data['val'][$k]) ? $data['val'][$k] : '';
					}
					$data['params'] = json_encode($data['params']);
				}
			}
			unset($data['key']);
			unset($data['val']);
			$nameArr = array('admin/addons/detailpage','admin/addons/execute');
			if(in_array(strtolower($data['name']),$nameArr)&&empty($data['params'])){
				$result['status'] = 0;
				$result['info'] = '请添加参数';
				return $result;
			}
			$add = db('auth_rule')->insert($data);
			if($add){
				$result['status'] = 1;
				$result['info'] = '规则添加成功';
			}else{
				$result['status'] = 0;
				$result['info'] = '规则添加失败';
			}
			return $result;
		}
		$list = db('column')->where('pid',0)->order('id desc')->field('id,name')->select();
		$this->assign('list',$list);
		return $this->fetch('add_rule');
	}

	public function editRule(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$check = $this->validate($data,'Rule');
			if($check!==true){
				$result['status'] = 0;
				$result['info'] = $check;
				return $result;
			}
			$data['params'] = '';
			if(isset($data['key'])&&isset($data['key'])){
				if(is_array($data['key'])&&is_array($data['key'])&&count($data['key'])>0){
					$dkey = '';
					foreach($data['key'] as $k=>$v){
						$dkey = $v;
						$data['params'][$dkey] = isset($data['val'][$k]) ? $data['val'][$k] : '';
					}
					$data['params'] = json_encode($data['params']);
				}
			}
			unset($data['key']);
			unset($data['val']);
			$nameArr = array('admin/addons/detailpage','admin/addons/execute');
			if(in_array(strtolower($data['name']),$nameArr)&&empty($data['params'])){
				$result['status'] = 0;
				$result['info'] = '请添加参数';
				return $result;
			}
			$up = db('auth_rule')->update($data);
			if($up){
				$result['status'] = 1;
				$result['info'] = '规则修改成功';
			}else{
				$result['status'] = 0;
				$result['info'] = '规则修改失败';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$list = db('column')->where('pid',0)->order('id desc')->field('id,name')->select();
		$info = db('auth_rule')->where('id',$id)->find();
		$info['params'] = empty($info['params']) ? '' : json_decode($info['params'],true);
		$this->assign('info',$info);
		$this->assign('list',$list);
		return $this->fetch('edit_rule');
	}

	public function delRule(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('auth_rule')->delete($id);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '规则删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '规则删除成功';
			}
			return $result;
		}
	}

	public function adminGroup(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$list = db('auth_group')->where('title','like','%'.$key.'%')->order('id desc')->paginate();
		}else{
			$list = db('auth_group')->order('id desc')->paginate();
		}
		$this->assign('list',$list);
		return $this->fetch('admin_group');
	}

	public function addGroup(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$pattern = '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,50}$/u';
			$check = db('auth_group')->where('title',trim($data['title']))->find();
			if(empty($data['title'])){
				$result['status'] = 0;
				$result['info'] = '分组名称不能为空';
				return $result;
			}else if(!preg_match($pattern,$data['title'])){
				$result['status'] = 0;
				$result['info'] = '分组名称为1-50个字符(中文、字母和数字)';
				return $result;
			}else if($check){
				$result['status'] = 0;
				$result['info'] = '分组名称已经已存在';
				return $result;
			}else if(!is_array($data['rules'])||count($data['rules'])==0){
				$result['status'] = 0;
				$result['info'] = '未分配分组拥有的权限';
				return $result;
			}
			$data['rules'] = implode(',',$data['rules']);
			$add = db('auth_group')->insert($data);
			if($add){
				$result['status'] = 1;
				$result['info'] = '分组添加成功';
			}else{
				$result['status'] = 0;
				$result['info'] = '分组添加失败';
			}
			return $result;
		}
		$column = db('column')->where('pid',0)->order('id asc')->field('id,name')->select();
		$rules = db('auth_rule')->field('id,title,cid')->order('id asc')->select();
		$groups = $this->getGroupData($rules);
		$list = array();
		foreach($column as $k=>$v){
			$list[$v['name']] = array_key_exists($v['id'], $groups) ? $groups[$v['id']] : [];
		}
		unset($groups);
		$this->assign('list',$list);
		return $this->fetch('add_group');
	}

	private function getGroupData($data){
		if(!$data||!is_array($data)){
			return false;
		}
		$groupArr = array();
		foreach($data as $k=>$v){
			$groupArr[$v['cid']][] = $v;
		}
		return $groupArr;
	}

	public function editGroup(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$pattern = '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,50}$/u';
			$check = db('auth_group')->where('title',trim($data['title']))->where('id','neq',$data['id'])->find();
			if(empty($data['title'])){
				$result['status'] = 0;
				$result['info'] = '分组名称不能为空';
				return $result;
			}else if(!preg_match($pattern,$data['title'])){
				$result['status'] = 0;
				$result['info'] = '分组名称为1-50个字符(中文、字母和数字)';
				return $result;
			}else if($check){
				$result['status'] = 0;
				$result['info'] = '分组名称已经已存在';
				return $result;
			}else if(!is_array($data['rules'])||count($data['rules'])==0){
				$result['status'] = 0;
				$result['info'] = '未分配分组拥有的权限';
				return $result;
			}
			$data['rules'] = implode(',',$data['rules']);
			$up = db('auth_group')->update($data);
			if($up){
				$result['status'] = 1;
				$result['info'] = '分组修改成功';
			}else{
				$result['status'] = 0;
				$result['info'] = '分组修改失败';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$column = db('column')->where('pid',0)->order('id asc')->field('id,name')->select();
		$rules = db('auth_rule')->field('id,title,cid')->order('id asc')->select();
		$info = db('auth_group')->where('id',$id)->find();
		$groups = $this->getGroupDataEdit($rules,explode(',',$info['rules']));
		$list = array();
		foreach($column as $k=>$v){
			$list[$v['name']] = array_key_exists($v['id'], $groups) ? $groups[$v['id']] : [];
		}
		unset($groups);
		$this->assign('info',$info);
		$this->assign('list',$list);
		return $this->fetch('edit_group');
	}

	private function getGroupDataEdit($data,$chosen){
		if(!$data||!is_array($data)){
			return false;
		}
		$groupArr = array();
		foreach($data as $k=>$v){
			if(in_array($v['id'],$chosen)){
				$v['chosen'] = 1;
			}else{
				$v['chosen'] = 0;
			}
			$groupArr[$v['cid']][] = $v;
		}
		return $groupArr;
	}

	public function delGroup(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('auth_group')->delete($id);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '分组删除失败';
			}else{
				db('auth_group_access')->where('group_id',$id)->delete();
				$result['status'] = 1;
				$result['info'] = '分组删除成功';
			}
			return $result;
		}
	}

	public function editMyself(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$user = model('User');
			if(!$data['pwd']){
				$validate = new Validate(['name|账号名称'=>'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,25}$/u','tel|手机号码'=>'require|checkTel:/^1\d{10}$/|unique:admin,tel,'.session('aid'),'email|邮箱'=>'require|email|unique:admin,email,'.session('aid')]);
				$validate->extend([
					'checkName' => function($val,$rule){
						return preg_match($rule,$val) ? true : '账号名称为1-25个字符(字母、数字和中文)';
					},
					'checkTel' => function($val,$rule){
						return preg_match($rule,$val) ? true : '手机号码格式不正确';
					}
				]);
				if(!$validate->check($data)){
					$result['status'] = 0;
					$result['info'] = $validate->getError();
					return $result;
				}
				$add = $user->allowField(['tel','name','email','headimg','status'])->save($data,['id'=>session('aid')]);
			}else{
				$validate = new Validate(['name|账号名称'=>'require|checkName:/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]{1,25}$/u','tel|手机号码'=>'require|checkTel:/^1\d{10}$/|unique:admin,tel,'.session('aid'),'email|邮箱'=>'require|email|unique:admin,email,'.session('aid'),'pwd|登录密码'=>'require|checkPwd:/^[a-zA-Z0-9\_@#&%]{6,40}$/u','repwd|确认密码'=>'require|confirm:pwd']);
				$validate->extend([
					'checkName' => function($val,$rule){
						return preg_match($rule,$val) ? true : '账号名称为1-25个字符(字母、数字和中文)';
					},
					'checkTel' => function($val,$rule){
						return preg_match($rule,$val) ? true : '手机号码格式不正确';
					},
					'checkPwd' => function($val,$rule){
						return preg_match($rule,$val) ? true : '登录密码为6-40个字符(字母、数字)和特殊字符(_@#&%)';
					}
				]);
				if(!$validate->check($data)){
					$result['status'] = 0;
					$result['info'] = $validate->getError();
					return $result;
				}
				$add = $user->allowField(true)->save($data,['id'=>session('aid')]);
			}
			if(session('atype')!=1){
				$check = db('auth_group_access')->where('uid',session('aid'))->find();
				if($check){
					$up = db('auth_group_access')->where('uid',$check['uid'])->update(['group_id'=>$data['group_id']]);
				}else{
					$up = db('auth_group_access')->insert(['uid'=>session('aid'),'group_id'=>$data['group_id']]);
				}
				if(!$add&&!$up){
					$result['status'] = 0;
					$result['info'] = '账号修改失败';
				}else{
					$result['status'] = 1;
					$result['info'] = '账号修改成功';
				}
			}else{
				if(!$add){
					$result['status'] = 0;
					$result['info'] = '账号修改失败';
				}else{
					$result['status'] = 1;
					$result['info'] = '账号修改成功';
				}
			}
			return $result;
		}
		$id = intval(session('aid'));
		if(!$id){
			$this->error('参数错误');
		}
		$list = db('auth_group')->order('id desc')->field('id,title')->select();
		$info = db('admin')->where('id',$id)->find();
		$info['headimg'] = explode('.',str_replace('/images/aheads/','',$info['headimg']));
		$info['headimg'] = $info['headimg'][0];
		$group_id = db('auth_group_access')->where('uid',$id)->value('group_id');
		$this->assign('list',$list);
		$this->assign('info',$info);
		$this->assign('group_id',$group_id);
		return $this->fetch('edit_myself');
	}

	public function unlogin(){
		session('aid',null);
		session('aname',null);
		session('atype',null);
		session('astatus',null);
		$this->redirect('admin/login/index');
	}

	public function lglog(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if($key){
			$list = db('login_log')->alias('l')->join('qgs_admin a','l.aid = a.id','LEFT')->where('a.name','like','%'.$key.'%')->order('lgtime desc')->field('a.tel,a.name,a.type,l.id,l.ip,l.lgtime')->paginate();
		}else{
			$past = time() - 604800;
			db('login_log')->where('lgtime','lt',$past)->delete();
			$list = db('login_log')->alias('l')->join('qgs_admin a','l.aid = a.id','LEFT')->order('lgtime desc')->field('a.tel,a.name,a.type,l.id,l.ip,l.lgtime')->paginate();
		}
		$this->assign('list',$list);
		return $this->fetch('lglog');
	}

	public function info(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if($key){
			$list = db('notice')->where('title','like','%'.$key.'%')->order('id desc')->paginate();
		}else{
			$list = db('notice')->order('id desc')->paginate();
		}
		$this->assign('list',$list);
		return $this->fetch('info');
	}

	public function addInfo(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!$data['title']){
				$result['status'] = 0;
				$result['info'] = '标题不能为空';
				return $result;
			}else if(!$data['content']){
				$result['status'] = 0;
				$result['info'] = '内容不能为空';
				return $result;
			}
			$data['title'] = strip_tags($data['title']);
			$data['content'] = htmlspecialchars(strip_tags($data['content']));
			$data['createtime'] = time();
			$add = db('notice')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '消息添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '消息添加成功';
			}
			return $result;
		}
		return $this->fetch('add_info');
	}

	public function editInfo(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!$data['title']){
				$result['status'] = 0;
				$result['info'] = '标题不能为空';
				return $result;
			}else if(!$data['content']){
				$result['status'] = 0;
				$result['info'] = '内容不能为空';
				return $result;
			}
			$data['title'] = strip_tags($data['title']);
			$data['content'] = htmlspecialchars(strip_tags($data['content']));
			$up = db('notice')->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '消息修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '消息修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = db('notice')->where('id',$id)->find();
		$this->assign('info',$info);
		return $this->fetch('edit_info');
	}

	public function delInfo(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('notice')->delete($id);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '信息删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '信息删除成功';
			}
			return $result;
		}
	}

	public function systemInfo(){
		$request = Request::instance();
		$config = $this->sys_config;
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			$data['cross'] = isset($data['cross']) ? $data['cross'] : 0;
			if(!$data){
				$result = ['status'=>0,'info'=>'没有提交数据'];
				return $result;
			}
			if(empty($data['sitename'])){
				$result = ['status'=>0,'info'=>'请填写网站标题'];
				return $result;
			}else if(empty($data['seoname'])){
				$result = ['status'=>0,'info'=>'请填写网站副标题'];
				return $result;
			}else if(intval($data['cross'])==1 && empty($data['crossdomain'])){
				$result = ['status'=>0,'info'=>'请填写跨域访问域名'];
				return $result;
			}
			if(!empty($data['crossdomain']) && intval($data['cross'])==1){
				$pattern = '/^(\*|(http|https):\/\/([\w.:]+))$/i';
				if(!preg_match($pattern,$data['crossdomain'])){
					$result = ['status'=>0,'info'=>'跨域访问域名格式不正确'];
					return $result;
				}
			}
			$data = array_merge($config,$data);
			$cross = intval($data['cross']);
			if($cross != 1){
				$data['crossdomain'] = '';
			}
			$up = $this->saveConfigFile($data);
			if(!$up){
				$result = ['status'=>0,'info'=>'系统信息保存失败,没有文件写入权限'];
			}else{
				$result = ['status'=>1,'info'=>'系统信息保存成功'];
			}
			return $result;
		}
		$this->assign('info',$config);
		return $this->fetch('system_info');
	}

	private function getConfigFile(){
		$file = config('sys_info');
		if(!file_exists($file)||!is_readable($file)){
			return ['sitename'=>'','seoname'=>'','keywords'=>'','description'=>'','masteremail'=>'','copyright'=>'','cross'=>0,'crossdomain'=>'','default_copyright'=>'Copyright © 2014-2015 Quguo Co.Ltd. All rights reserved.'];
		}
		$config = file_get_contents($file);
		return json_decode($config,true);
	}

	private function saveConfigFile($data){
		$file = config('sys_info');
		if(empty($data)||!is_array($data)){
			return false;
		}
		$config = file_put_contents($file,json_encode($data));
		if($config>0){
			return true;
		}
		return false;
	}

	public function attachment(){
		$list = db('attachment')->order('id desc')->paginate();
		$this->assign('list',$list);
		return $this->fetch('attachment');
	}

	public function delAttachment(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			Loader::import('upyun.Uprest',EXTEND_PATH);
			$uconfig = config('upyun_config');
			$upyun = new \UpYun($uconfig['bucket'],$uconfig['user'],$uconfig['pwd']);
			$attachment = db('attachment');
			$path = $attachment->where('id',$id)->value('url');
			if(empty($path)){
				$attachment->delete($id);
				$result['status'] = 1;
				$result['info'] = '删除成功';
				return $result;
			}
			$del = $upyun->delete($path);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$attachment->delete($id);
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

}