<?php

namespace app\index\controller;
use think\Controller,think\Db;

/**
 * 扩展控制器
 * 用于调度各个扩展的URL访问需求
 */
class Addons extends Controller{

	protected $addons = null;

	public function execute($addons = null, $controller = null, $action = null, $params = ''){

		if(!empty($addons) && !empty($controller) && !empty($action)){
			$check = Db::name('addons')->where('name',$addons)->value('status');
			if(!$check)
				$this->error('插件未安装或已禁用');
			$class = "\addons\\$addons\controller\\$controller";
			$Addons = new $class();
			if($params!=''){
				$tmp_params = explode(',',$params);
				$parr = array();
				foreach($tmp_params as $k=>$v){
					$tval = array();
					$tval = explode('=',$v);
					$tk = $tval[0];
					$tv = isset($tval[1]) ? $tval[1] : '';
					$parr[$tk] = $tv;
				}
				$params = $parr;
			}else{
				$params = array();
			}
			$Addons->$action($params);
		} else {
			$this->error('没有指定插件名称，控制器或操作！');
		}

	}

}
