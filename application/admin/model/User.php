<?php

namespace app\admin\model;

use think\Model;

class User extends Model{

	protected $table = 'qgs_admin';
	protected $auto = ['pwd'];
	protected $insert = ['headimg','type'=>2,'status'=>0,'createtime'];

	protected function setPwdAttr($val){
		if($val){
			return md5($val);
		}
		return false;
	}

	protected function setHeadimgAttr($val){
		if(!$val){
			$val = rand(1,16);
		}
		return '/images/aheads/'.$val.'.png';
	}

	protected function setCreatetimeAttr($val){
		return time();
	}

}