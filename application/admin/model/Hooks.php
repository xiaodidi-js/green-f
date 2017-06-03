<?php

namespace app\admin\model;

use think\Model;

class Hooks extends Model{

	protected $auto = ['update_time'];

	protected function setUpdateTimeAttr($val){
		return time();
	}

}