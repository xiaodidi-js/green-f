<?php

namespace app\admin\model;

use think\Model;

class SinceMaxgift extends Model{

	public function querymaxactivity($id){
		$find = $this->where('id',$id)->field('maxmoney')->find();
		return $find;
	}
}
