<?php

namespace app\admin\model;

use think\Model;

class Addons extends Model{

	protected $insert = ['create_time'];

	protected function setCreateTimeAttr($val){
		return time();
	}

	/**
     * 获取插件列表
     * @param string $addon_dir
     */
	public function getList($addon_dir = ''){
		if(!$addon_dir)
			$addon_dir = ADDON_PATH;
		$dirs = array_map('basename',glob($addon_dir.'*',GLOB_ONLYDIR));
		if(!file_exists($addon_dir)||$dirs===false){
			$this->error = '插件目录不可读或不存在';
			return false;
		}
		$addons = array();
		$list = db('addons')->where('name','in',$dirs)->select();
		foreach($list as $addon){
			$addon['uninstall'] = 0;
			$addons[$addon['name']] = $addon;
		}
		foreach($dirs as $name){
			if(!isset($addons[$name])){
				$class = get_addon_class($name);
				if(!class_exists($class)){ // 实例化插件失败忽略执行
					\think\Log::record('插件'.$name.'的入口文件不存在！');
					continue;
				}
				$obj = new $class();
				$addons[$name] = $obj->info;
				if($addons[$name]){
					$addons[$name]['uninstall'] = 1;
					unset($addons[$name]['status']);
				}
			}
		}
		int_to_string($addons,['status'=>[-1=>'损坏', 0=>'禁用', 1=>'启用', null=>'未安装']]);
		$addons = list_sort_by($addons,'uninstall','desc');
		return $addons;
	}

	/**
	 * 获取插件后台列表
	 * @param $name 插件名称标识
	 */
	public function getAdminList($name){

	}

	/**
	 * 获取插件配置
	 * @return array
	 */
	public function getConfig(){
		$config = $this->value('config');
		if($config)
			$config = json_decode($config);
		return $config;
	}

}