<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/5/4
 * Time: 14:28
 */
namespace app\index\model;
use think\Model;

class ProductSharelist extends Model{

	public function queryuser($user,$id,$shopid){
		$where['aid'] = $id;
		$where['uid'] = $user['id'];
		$where['pid'] = $shopid;
		$info = $this->where($where)->find();
		return $info;
	}

}