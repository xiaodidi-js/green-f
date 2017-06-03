<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/4/26
 * Time: 10:45
 */
namespace app\index\model;

use think\Model;

class MemberOrders extends Model{

	// 查询订单
	public function queryorderfind($where,$field){
		$info = $this->where($where)->field($field)->find();
		return $info;
	}
}