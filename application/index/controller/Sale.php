<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/4/26
 * Time: 10:08
 */
namespace app\index\controller;

use think\Request,think\Token,think\Loader;

class Sale extends RestBase{

//    得出今天的限时抢购活动
    public function SaleTimeSolt(){
        $request = Request::instance();
        $Sale = Model('Sale');
        $ClickTimeSolt = $Sale->ClickAllTime();
        foreach ($ClickTimeSolt as $key => &$value) {
            $time['stime'] = $value['stime'];
            $time['etime'] = $value['etime'];
            $Sale = Model('sale');
            $ClickSaleShop = $Sale->QueryClickTimeShop($time);
            $value['arr'] = $ClickSaleShop;
            $value['servertime'] = time();
        }
        $result = makeResult(1,'ok',['SaleTimeSolt'=>$ClickTimeSolt]);
        return $this->response($result,'json',200);
    }

//    点击后得出当前时间段的限时抢购商品
    public function SaleShop(){
        $request = Request::instance();
        $get = $request->get();
        if(!empty($get['stime'] && $get['etime'])){
            $Sale = Model('sale');
            $ClickSaleShop = $Sale->QueryClickTimeShop($get);
            if($ClickSaleShop){
                $result = makeResult(1,'ok',['SaleShop'=>$ClickSaleShop]);
                return $this->response($result,'json',200);
            }else{
                $result = makeResult(0,'该时段没有抢购商品');
                return $this->response($result,'json',200);
            }
        }else{
            $result = makeResult(0,'没有传关键时间');
            return $this->response($result,'json',200);
        }
    }
}
