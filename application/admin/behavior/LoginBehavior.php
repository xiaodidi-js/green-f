<?php
/**
* 权限验证
*/

namespace app\admin\behavior;

use think\Db;

class LoginBehavior
{
	
	public function run(&$return){
		$now = time();
		$ip = get_client_ip();
		Db::name('login_log')->insert(['aid'=>session('aid'),'ip'=>$ip,'lgtime'=>$now]);
	}

}

?>