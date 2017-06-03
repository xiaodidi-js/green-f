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
}