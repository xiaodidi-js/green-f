<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/5/3
 * Time: 14:04
 */
namespace app\admin\model;
use think\Model;

class HandtakePlace extends Model{

//  用id直接查询自提点
    public function QueryIdsince($id){
        $info = $this->where('id',$id)->field('name,address')->find();
        return $info;
    }

//  查询所有自提点
    public function QuerySinceAll(){
        $list = $this->where('status',1)->where('address','not null')->field('id,name,address')->select();
        return $list;
    }

//  用自提点名称查询
    public function QuerySinceName($name){
        $info = $this->where('address',$name)->field('id,name')->find();
        return $info;
    }
    // 用id查询自提点
    public function queryallid($sinid){
        $where['pid'] = $sinid;
        $where['status'] = 1;
        $list = $this->where($where)->select();
        return $list;
    }

    // 自提点站点统计
    public function tongjixiaoshou($get){
        $stime = strtotime($get['stime']);
        $etime = strtotime($get['etime']);
        $where['a.address'] = array('neq','');
        $list = $this
            ->alias('a')
            // ->join('member_orders o','a.name = o.person','LEFT')
            ->join('member_sincestar u','a.id = u.sid','LEFT')
            ->where($where)
            ->field('a.name,COUNT(u.sid) as sid,a.status')
            ->group('a.id')
            ->select();
        unset($where);
        $where['createtime'] = array('between',[$stime,$etime]);
        $where['pay'] = 1;
        $where['is_del'] = 0;
        foreach ($list as $key => &$value) {
            if($value['status'] == 1){
                $value['status'] = "启用";
            }else{
                $value['status'] = "关闭";
            }
            $where['person'] = $value['name'];
            $queryorder = Model('MemberOrders')
                ->where($where)
                ->field('id,orderid,money')
                ->select();
            if($queryorder){
                $all = 0;
                foreach ($queryorder as $key1 => $value1) {
                    $all = $all + $value1['money'];
                }
                $value['ordernum'] = count($queryorder);
                $value['money'] = $all;
                if($value['money'] == 0 || $value['ordernum'] == 0){
                    $value['moneyhe'] = 0 ;
                }else{
                    $value['moneyhe'] = $value['ordernum'] / $all;
                }
            }else{
                $value['ordernum'] = 0;
                $value['money'] = 0;
                $value['moneyhe'] = 0;
            }
        }
        return $list;
    }
}