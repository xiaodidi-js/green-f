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

	// 订单过期
	public function OrderExpire($data){
		$nowtime = time();
		// 判断是否超时
		if($data['endtime'] <= $nowtime){
			$order = $this->where('orderid',$data['orderid'])->field('id,orderid,uid,pay')->find();
			// 判断是否支付
			if($order['pay'] == 1){
				return $stu = 1;
			}
			// 未支付
			$update['status'] = '-1';
			$editorder = $this->where('orderid',$data['orderid'])->update($update);
			// 判断用户有没有自己关闭了
			if($order['pay'] == 0){
				//库存返还和销量记录
                $productDb = db('product');
                $formlistDb = db('product_formlist');
                $where['uid'] = $order['uid'];
                $where['oid'] = $order['orderid'];
                $olist = db('member_orderlist')->where($where)->field('pid,amount,format,sale,share')->select();
                foreach($olist as $k=>$v) {
                    $productDb->where('id',$v['pid'])->setInc('store',$v['amount']);
                    $productDb->where('id',$v['pid'])->setDec('sale',$v['amount']);
                    if(!empty($pv['format'])){
                        $formlistDb->where('pid',$v['pid'])->where('format',$v['format'])->setInc('store',$v['amount']);
                    }
                    // 退还限时抢购库存
                    if($v['sale'] != 0){
                        $querysale = db('sale')->where('id',$v['sale'])->field('data')->find();
                        if(!empty($querysale['data'])){
                            $saledata = unserialize($querysale['data']);
                            if($saledata){
                                foreach ($saledata as $key => &$value) {
                                    if($value['shopid'] == $v['pid']){
                                        $value['saledata'][0]['salenub'] = $value['saledata'][0]['salenub'] + $v['amount'];
                                    }
                                    $sldata[] = $value;
                                }
                                $sldata = serialize($sldata);
                                $slupdate['data'] = $sldata;
                                $edit = db('sale')->where('id',$v['sale'])->update($slupdate);
                                unset($slupdate);
                            }
                        }
                        
                    }

                    // 分享返回库存
                    if($v['share'] != 0){
                        $queryshare = db('product_share')->where('id',$v['share'])->field('data')->find();
                        if(!empty($queryshare['data'])){
                            $sharedata = unserialize($queryshare['data']);
                            if($sharedata){
                                foreach ($sharedata as $key1 => &$value1) {
                                    if($value1['id'] == $v['pid']){
                                        $value1['sharestore'] = $value1['sharestore'] + $v['amount'];
                                    }
                                    $shdata[] = $value1;
                                }
                                $shdata = serialize($shdata);
                                $shupdate['data'] = $shdata;
                                $edit = db('product_share')->where('id',$v['share'])->update($shupdate);
                                unset($shupdate); 
                            }
                        }
                    }
                }
            }
			$stu = 1;
		}else{
			$stu = 0;
		}
		return $stu;
	}
}