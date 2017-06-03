<?php

namespace app\index\model;

use think\Model;

class MemberAddress extends Model{

	public function infoexpress($id){
		$where['uid'] = $id;
		$chaxun = $this->where($where)->field('id,name,tel,address,is_default')->select();
		return $chaxun;
	}
}