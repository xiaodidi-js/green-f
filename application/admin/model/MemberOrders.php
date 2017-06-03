<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/5/3
 * Time: 14:04
 */
namespace app\admin\model;
use think\Model;

class MemberOrders extends Model{

    /*报表*/

//	查询当天订单
    public function QueryNowOrderShop($get){
        $where['pay'] = 1;
        $where['is_del'] = 0;
        $list = $this->where($where)->whereTime('createtime', 'between', [$get['stime'], $get['etime']])->field('id,sum,orderid')->select();
        return $list;
    }

    /*
	 * where:id
	 * 条件: 序号
	 * 快捷修改
	 */
    public function FastEdit($post,$since){
        $where['id'] = $post['id'];
        $post['stime'] = strtotime($post['stime']);
        if($post['stype'] != 'parcel'){
            $update['snum'] = $post['snum'];
            $update['scom'] = $post['scom'];
            $update['stime'] = $post['stime'];
        }else{
            $update['address'] = $since['address'];
            $update['person'] = $since['name'];
            $update['stime'] = $post['stime'];
        }
        $update['send'] = $post['send'];
        $edit = $this->where($where)->update($update);
        return $edit;
    }

    /*
	 * where:id
	 * 条件: 序号
	 * 查询快捷修改
	 */
    public function QueryFastEdit($get){
        $where['id'] = $get['id'];
        $field = 'pay,send,stype,address,scom,snum,stime';
        $info = $this->where($where)->field($field)->find();
        $info['stime'] = date('Y-m-d H:i:s',$info['stime']);
        $QuerySince = Model('HandtakePlace')->QuerySinceName($info['address']);
        $info['addresseid'] = $QuerySince['id'];
        $info['addressename'] = $QuerySince['name'];
        return $info;
    }

//  用id查询订单,并查出没有收货的订单
    public function QueryOrder($id){
        $where['id'] = $id;
        $where['receive'] = 0;
        $where['send'] = 1;
        $info = $this->where('id',$id)->field('id,money,uid')->find();
        return $info;
    }

//  编辑收货
    public function EditReceive($id){
        $update['receive'] = 1;
        $Edit = $this->where('id',$id)->update($update);
        return $Edit;
    }

//  用配送时间查询订单
    public function peisongtimeorder($get){
        $where['stime'] = strtotime($get['time']);
        $where['is_del'] = 0;
        $field = 'id,person,tel,sum,money,paytype,pay,orderid,status,createtime,send,receive,createtime,stime';
        $list = $this->where($where)->field($field)->select();
        return $list;
    }

    // 用自提点地址查询订单
    public function queryalladdress($sinceaddress,$get,$class){
        $where['address'] = $sinceaddress;
        $where['is_del'] = 0;
        $where['pay'] = 1;
        $where['receive'] = 0;
        $where['send'] = 0;
        $where['stype'] = 'parcel';
        $where['createtime'] = array('between',[$get['stime'],$get['etime']]);
        $where['print'] = 0;
        if($class == 0){
            $list = $this->where($where)->count();
        }else{
            $queryclass = Model('ProductClassify')->where('tag',$get['tag'])->field('id')->select();
            if($queryclass){
                foreach ($queryclass as $key => $value) {
                    $classid[] = $value['id'];
                }
                $where['cid'] = array('in',$classid);
            }
            $list = $this->where($where)->field('id,orderid,stime,tel,tips,sum,address')->select();
        }
        return $list;
    }

    // 编辑已打印
    public function printeditok($orderid){
        $update['print'] = 1;
        $edit = $this->where('orderid','in',$orderid)->update($update);
        return $edit;
    }

    // 用id查询
    public function queryidorder($id){
        $info = $this->where('id',$id)->find();
        return $info;
    }

    // 售后管理-未消费
    public function querynopay($get){
        if($get['daytime'] == 0){
            // 3天
            $stime = strtotime(date('Y-m-d'.'00:00:00',time()-3600*72));
        }elseif($get['daytime'] == 1){
            // 一星期
            $stime = strtotime(date('Y-m-d'.'00:00:00',time()-3600*168));
        }elseif($get['daytime'] == 2){
            // 一个月
            $stime = strtotime(date('Y-m-d'.'00:00:00',time()-3600*720));
        }
        $etime = strtotime(date('Y-m-d'.'23:59:59',time()));
        $where['pay'] = 1;
        $where['createtime'] = array('between',[$stime,$etime]);
        $list = $this->where($where)->field('uid')->select();
        return $list;
    }
}