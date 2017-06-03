<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/5/3
 * Time: 14:28
 */
namespace app\admin\model;
use think\Model;

class MemberOrderlist extends Model{
//  查询订单购买的商品
    public function queryshop($order){
        $list = $this->where('oid','in',$order)->field('pid,amount,oid')->select();
        return $list;
    }
}