<?php

/**
 * 插件标签注册
 */

namespace app\common\behavior;
use think\Hook,think\Request,think\Cache,think\Db;

class InitHookBehavior{

	public function run(&$content){
		$request = Request::instance();
		if(!empty($request->get('state')) && $request->get('state') === 'Install') return;
        
        $data = Cache::get('hooks');
        if(!$data){
            $hooks = Db::name('hooks')->column('addons','name');
            foreach ($hooks as $key => $value) {
                if($value){
                    $names = explode(',',$value);
                    $data = Db::name('addons')->where('status',1)->where('name','in',$names)->column('name','id');
                    if($data){
                    	//删除卸载遗留的插件
                        $addons = array_intersect($names,$data);
                        //注册插件
                        Hook::add($key,$addons);
                    }
                }
            }
            Cache::set('hooks',Hook::get());
        }else{
            Hook::import($data,false);
        }
	}

}