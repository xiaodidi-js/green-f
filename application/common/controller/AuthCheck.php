<?php

namespace app\common\controller;

use think\Controller,think\Request,think\Cache,think\Db;

class AuthCheck extends Controller{

	public function _initialize(){
		//检测域名授权
		$auth_cache = Cache::get('domain_auth_info');
		if(!$auth_cache){
			$request = Request::instance();
			$server = $request->server('HTTP_HOST');
			$uname = Db::name('profile')->where('id',1)->value('name');
			$uname = $uname ? $uname : '';
			$auth_api = './authencation.txt';
			if(!file_exists($auth_api)){
				Cache::set('domain_auth_info','授权检测文件缺失',604800);
				return;
			}
			$api_url = file_get_contents($auth_api);
			if(!$api_url){
				Cache::set('domain_auth_info','授权检测地址缺失',604800);
				return;
			}
			$result = curlPost(['domain'=>$server,'uname'=>$uname],$api_url);
			$result = json_decode($result,true);
			if(!$result){
				Cache::set('domain_auth_info','授权检测错误',604800);
				return;
			}
			if($result['error']!=0){
				Cache::set('domain_auth_info',$result['info'],604800);
				return;
			}
			if(!empty($result['content']['new_api'])&&$result['content']['new_api']!=$api_url){
				if(!is_writable($auth_api)){
					Cache::set('domain_auth_info','授权检测地址文件不可写',604800);
					return;
				}else{
					file_put_contents($auth_api,$result['content']['new_api']);
				}
			}
			Cache::set('domain_auth_info',$result['content'],15724800);
		}
	}

}