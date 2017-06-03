<?php

namespace app\admin\controller;

use think\Controller,think\Authority,think\Config,think\Request,think\Response,think\exception\HttpResponseException;

class Base extends \app\common\controller\AuthCheck{

	public $col_tree = [];
	public $cur_tree = [];
	public $notice = [];
	public $sys_config = [];

	public function _initialize(){
		//继承父类方法
		parent::_initialize();
		//检测登录
		if(!session("aid")||!session("aname")||!session("atype")){
			$this->redirect('admin/login/index');
		}

		//获取系统信息
		$sysinfo = getSysInfo();
		$this->assign('sysinfo',$sysinfo);

		//权限检测认证
		$request = Request::instance();
		if(Config::get("auth_config.auth_on")){
	   	   $auth = new Authority();
	   	   $arr = array(
		   	   	'admin/index/index',
		   	   	'admin/system/unlogin'
	   	   );
	   	   $nurl = strtolower($request->module().'/'.$request->controller().'/'.$request->action());
	   	   if(session('atype')!=1){
		   	   if(!in_array($nurl, $arr)){
			   	   	if(!$auth->getAuth($nurl,session('aid'),'or',$request->param())||session('astatus')!=1){
			   	   		if($request->isAjax()){
			   	   			$result['status'] = 0;
			   	   			$result['info'] = '所属用户组没有权限';
			   	   			$response = Response::create($result,'json');
        					throw new HttpResponseException($response);
			   	   		}else{
			   	   			$this->error('所属用户组没有权限');
			   	   			die;
			   	   		}
			       	}
		   	   }
		   	}
		}

		//获取栏目树
		$all_col = $this->get_sub_tree($request);
		$this->col_tree = $all_col[0];
		$this->cur_tree = $all_col[1];
		$this->assign('col_tree',$this->col_tree);
		$this->assign('cur_tree',$this->cur_tree);

		//获取最新通知
		$this->notice = db('notice')->where('status',1)->order('createtime desc,level desc')->field('id,level,content')->find();
		$this->assign('notice',$this->notice);

		//获取授权信息
		$this->sys_config = $this->getConfigFile();
		$auth = cache('domain_auth_info');
		$this->assign('copyright',$this->sys_config['copyright'] ? $this->sys_config['copyright'] : $this->sys_config['default_copyright']);
		$this->assign('auth',$auth);
	}

	private function get_sub_tree($reqobj){
		$col_db = db('column');
		$req_module = strtolower($reqobj->module());
		$req_controller = strtolower($reqobj->controller());
		$req_action = strtolower($reqobj->action());
		$col_tree = $col_db->where('pid',0)->where('status',1)->field('id,name,module,controller,action,icon')->order('id asc')->select();
		if(!$col_tree){
			return [];
		}
		$authority = new Authority();
		$cur_tree = array();
		foreach($col_tree as $k=>$v){
			$col_tree[$k]['link'] = $v['module'] ? $v['module'].'/'.$v['controller'].'/'.$v['action'] : '#';
			if($req_controller==$v['controller']){
				$cur_tree[] = ['name'=>$v['name'],'url'=>$col_tree[$k]['link']];
			}
			$col_tree[$k]['sub'] = $col_db->where('pid',$v['id'])->where('status',1)->field('id,name,module,controller,action,icon')->order('level desc,id asc')->select();
			if(count($col_tree[$k]['sub'])>0){
				foreach($col_tree[$k]['sub'] as $sk=>$sv){
					$col_tree[$k]['sub'][$sk]['link'] = $sv['module'] ? $sv['module'].'/'.$sv['controller'].'/'.$sv['action'] : '#';
					if($req_controller==$sv['controller']&&$req_action==$sv['action']){
						$cur_tree[] = ['name'=>$sv['name'],'url'=>$col_tree[$k]['sub'][$sk]['link']];
					}
					if(session("atype")!=1&&!$authority->getAuth($col_tree[$k]['sub'][$sk]['link'],session('aid'))){
						unset($col_tree[$k]['sub'][$sk]);
					}
				}
			}
			if(count($col_tree[$k]['sub'])==0&&$col_tree[$k]['link']=='#'){
				unset($col_tree[$k]);
			}
		}
		if(count($cur_tree)==1){
			$act = db('auth_rule')->where('name',$req_module.'/'.$req_controller.'/'.$req_action)->field('name as url,title as name')->find();
			$all_col[0] = $col_tree;
			if($act){
				$cur_tree[] = $act;
				$all_col[1] = $cur_tree;
			}else{
				$all_col[1] = $cur_tree;
			}
		}else{
			$all_col[0] = $col_tree;
			$all_col[1] = $cur_tree;
		}
		return $all_col;
	}

	private function getConfigFile(){
		$file = config('sys_info');
		if(!file_exists($file)||!is_readable($file)){
			return ['sitename'=>'','seoname'=>'','keywords'=>'','description'=>'','masteremail'=>'','copyright'=>'','cross'=>0,'crossdomain'=>'','default_copyright'=>'Copyright © 2014-2015 Quguo Co.Ltd. All rights reserved.'];
		}
		$config = file_get_contents($file);
		return json_decode($config,true);
	}

}