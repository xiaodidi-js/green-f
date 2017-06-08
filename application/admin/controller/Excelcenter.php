<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/5/3
 * Time: 10:02
 */
namespace app\admin\controller;
use think\Controller,think\Request,think\Db;
use app\admin\controller\Excel;

class Excelcenter extends Base{

//  导出采购Excel中心
    public function ExcelCaiGou(){
        $request = Request::instance();
        $get = $request->get();
        if(empty($get['stime']) && empty($get['etime'])){
            $ymd = date('Y-m-d');
            $ymd = strtotime($ymd);
            $get['stime'] = $ymd;
            $get['etime'] = $ymd+86399;
        }else{
            $get['stime'] = strtotime($get['stime']);
            $get['etime'] = strtotime($get['etime']);
        }
        $where['o.pay'] = 1;
        $where['o.is_del'] = 0;
        $where['o.reject'] = 0;
        $where['o.send'] = 0;
        $where['o.stime'] = array('between',[$get['stime'], $get['etime']]);
        $field = 'o.orderid,name,sum,l.amount,o.stime,o.createtime,o.address';
        $QueryNowOrder = DB::table('qgs_member_orders o')->join('qgs_member_orderlist l','l.oid=o.orderid')->join('qgs_product p','p.id = l.pid','left')->where($where)->field($field)->select();
        if(empty($QueryNowOrder)){
            $QueryNowOrder = null;
        }
        $this->assign('stime',date('Y-m-d H:i:s',$get['stime']));
        $this->assign('etime',date('Y-m-d H:i:s',$get['etime']));
        $this->assign('cgtime',date('Y-m-d',$get['stime']));
        $this->assign('list',$QueryNowOrder);
        return $this->fetch();
    }

//  导出采购Excel表
    public function caigoudaochu(){
        $request = Request::instance();
        $get = $request->get();
        $QueryNowOrder = Model('MemberOrders')->QueryNowOrderShop($get);
        if($QueryNowOrder){
            foreach ($QueryNowOrder as $key => $value){
                $allorder[] = $value['orderid'];
            }
            $queryordershop = Model('MemberOrderlist')->queryshop($allorder);
            $allok = array();
            foreach ($queryordershop as $key2 => $value2){
                if(empty($allok[$value2['pid']])){
                    $allok[$value2['pid']] = array();
                }
                if(empty($allok[$value2['pid']]['amount'])){
                    $allok[$value2['pid']]['amount'] = 0;
                }
                if(empty($allok[$value2['pid']]['share'])){
                    $allok[$value2['pid']]['share'] = 0;
                }
                if(empty($allok[$value2['pid']]['qrcode'])){
                    $allok[$value2['pid']]['qrcode'] = 0;
                }
                $allok[$value2['pid']]['amount'] = $allok[$value2['pid']]['amount'] + $value2['amount'];
                $allok[$value2['pid']]['taocan_amount'] = 0;
                $allok[$value2['pid']]['taocan_weight'] = 0;
                if($value2['share'] != 0){
                    $value2['share'] = 1;
                }
                if($value2['qrcode'] != 0){
                    $value2['qrcode'] = 1;
                }
                $allok[$value2['pid']]['qrcode'] = $allok[$value2['pid']]['qrcode'] + $value2['qrcode'];
                $allok[$value2['pid']]['share'] = $allok[$value2['pid']]['share'] + $value2['share'];
            }
            foreach  ($allok as $key3 => $value3){
                $allid[] = $key3;
            }
            $queryproductshop = Model('Product')->queryidshop($allid);
            foreach ($queryproductshop as $nub => &$play) {
                if($play['taocan']){
                    $taocan = explode(',', $play['taocan']);
                    for($i = 0; $i < $allok[$play['id']]['amount']; $i++){
                        foreach ($taocan as $nub1 => &$play1) {
                            $playok = explode('#', $play1);
                            if(empty($allok[$playok[0]])){
                                $allok[$playok[0]] = array();
                            }
                            if(empty($allok[$playok[0]]['taocan_amount'])){
                                $allok[$playok[0]]['taocan_amount'] = 1;
                            }else{
                                $allok[$playok[0]]['taocan_amount'] = $allok[$playok[0]]['taocan_amount'] + 1;
                            }

                            if(empty($allok[$playok[0]]['taocan_weight'])){
                                $allok[$playok[0]]['taocan_weight'] = $playok[1];
                            }else{
                                $allok[$playok[0]]['taocan_weight'] = $allok[$playok[0]]['taocan_weight'] + $playok[1];
                            }

                            if(empty($allok[$playok[0]]['amount'])){
                                $allok[$playok[0]]['amount'] = 0;
                            }

                        }
                    }  
                }
            }
            foreach  ($allok as $star => $go){
                $allid[] = $star;
            }
            $queryproductshop = Model('Product')->queryidshop($allid);
            foreach ($queryproductshop as $star1 => $go1) {
                $queryshopclass = Model('ProductClassify')->SaleConfigShopClass($go1['cid']);
                $go1['class'] = $queryshopclass['title'];
                $go1['amount'] = $allok[$go1['id']];
                $staff[] = $go1['supplier'];
                $staff[] = $go1['caigouyuan'];
                $staff[] = $go1['fenjianzu'];
                $queryshopstaff = Model('Buyer')->Querystaff($staff);
                unset($staff);
                foreach ($queryshopstaff as $one => $ok) {
                    if($ok['class'] == 1){
                        $go1['fenjianzu'] = $ok['name'];
                    }elseif($ok['class'] == 2){
                        $go1['caigouyuan'] = $ok['name'];
                        $go1['caigouyuantel'] = $ok['tel'];
                    }elseif($ok['class'] == 3){
                        $go1['supplier'] = $ok['name'];
                        $go1['suppliertel'] = $ok['tel'];
                    }
                }
                if($go1['fenjianzu'] == '0'){
                    $go1['fenjianzu'] = '无';
                }
                if($go1['caigouyuan'] == '0'){
                    $go1['caigouyuan'] = '无';
                    $go1['caigouyuantel'] = '无信息';
                }
                if($go1['supplier'] == '0'){
                    $go1['supplier'] = '无';
                    $go1['suppliertel'] = '无信息';
                }
            }
            $excel = new Excel();
            $result = $excel->caigouexcel($queryproductshop);
        }
    }

    // 完成当天采购
    public function caigouok(){
        $request = Request::instance();
        $post = $request->post();
        $querycaigou = Model('caigou')->queryday($post);
        if($querycaigou){
            make_json(0,'今天已经提交过完成采购了');
        }else{
            $add = Model('caigou')->addcaigouok($post);
            if($add){
                make_json(1,'成功提交完成采购');
            }
        }
    }

    // 查询选择日期是否完成当天采购
    public function querycaigouook(){
        $request = Request::instance();
        $get = $request->get();
        $querycaigou = Model('caigou')->queryday($get);
        if($querycaigou){
            make_json(1,'你选择的日期已完成采购');
        }else{
            make_json(0,'你选择的日期还未完成采购');
        }
    }

//  导出销售Excel中心
    public function ExcelXiaoShou(){
        $request = Request::instance();
        $get = $request->get();
        if(empty($get['stime']) && empty($get['etime'])){
            $ymd = date('Y-m-d');
            $ymd = strtotime($ymd);
            $get['stime'] = $ymd;
            $get['etime'] = $ymd+86399;
        }else{
            $get['stime'] = strtotime($get['stime']);
            $get['etime'] = strtotime($get['etime']);
        }
        $this->assign('stime',date('Y-m-d H:i:s',$get['stime']));
        $this->assign('etime',date('Y-m-d H:i:s',$get['etime']));
        return $this->fetch();
    }

    public function xiaoshoudaochu(){
        $request = Request::instance();
        $get = $request->get();
        $queryorder = Model('MemberOrders')->tongjiorder($get);
        $ordernum = count($queryorder);
        $money = 0;
        foreach ($queryorder as $key => &$value) {
            // 赠品处理
            if($value['gift'] == 1){
                $value['listprice'] = 0;
                $value['price'] = 0;
            }
            if(empty($allok[$value['pid']])){
                $allok[$value['pid']] = $value;
            }else{
                $allok[$value['pid']]['listprice'] = $allok[$value['pid']]['listprice'] + $value['listprice'];
                $allok[$value['pid']]['amount'] = $allok[$value['pid']]['amount'] + $value['amount'];
            }
            $all[] = $value['listprice'];
        }
        $money = array_sum($all);
        if($ordernum != 0 || $money != 0){
            $zonghe = $ordernum / $money;
            $zonghe = round($zonghe,2);
        }else{
            $zonghe = 0;
        }
        $data['ordernum'] = $ordernum;
        $data['money'] = $money;
        $data['zonghe'] = $zonghe;
        $data['data'] = $allok;
        $excel = new Excel();
        $time['stime'] = $get['stime'];
        $time['etime'] = $get['etime'];
        $result = $excel->xiaoshou($data,$time);
    }


}