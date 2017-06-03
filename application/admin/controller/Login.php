<?php

namespace app\admin\controller;

use think\Controller,think\Request,think\Hook;

class Login extends Controller{

	public function _initialize(){
		//获取系统信息
		$sysinfo = getSysInfo();
		$this->assign('sysinfo',$sysinfo);
	}

	public function index(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(empty($data['name'])){
				$result['status'] = 0;
				$result['info'] = '请填写登录账号';
				return $result;
			}else if(empty($data['pwd'])){
				$result['status'] = 0;
				$result['info'] = '请填写登录密码';
				return $result;
			}
			$User = model('User');
			$where['tel|email'] = trim($data['name']);
			$check = $User->where($where)->find();
			if(!$check){
				$result['status'] = 0;
				$result['info'] = '用户不存在';
			}else if(md5($data['pwd'])!=$check['pwd']){
				$result['status'] = 0;
				$result['info'] = '用户名或密码不正确';
			}else{
				if(isset($data['remember'])&&$data['remember']==1){
					cookie('aname',$data['name'],604800);
				}else{
					cookie('aname',null);
				}
				session('aid',$check['id']);
				session('aname',$check['name']);
				session('atype',$check['type']);
				session('ahead',$check['headimg']);
				session('astatus',$check['status']);
				Hook::listen('login_log');
				$result['status'] = 1;
				$result['info'] = '用户登录成功';
			}
			return $result;
		}
		$this->assign('aname',cookie('aname'));
		$this->view->engine->layout(false);
		return $this->fetch('index');
	}

	public function register(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$User = model('User');
			$add = $User->validate(true)->allowField(true)->isUpdate(false)->save($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = $User->getError();
			}else{
				$result['status'] = 1;
				$result['info'] = '用户注册成功';
			}
			return $result;
		}
		$this->view->engine->layout(false);
		return $this->fetch('register');
	}

}