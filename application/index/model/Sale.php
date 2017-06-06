<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/4/26
 * Time: 10:45
 */
namespace app\index\model;

use think\Model;

class Sale extends Model{

//   根据时间段返回这个时间段的数据
    public function ClickSaleShop($ClickTime){
        $infoWhere['stu'] = 1;
//        $infoWhere['']
        $info = $this->where()->field('data')->select();

    }

//    查看全部时间段的限时抢购活动
    public function ClickAllTime(){
        $where['stu'] = 1;
        $nowtime = date('Y-m-d').'00:00:00';
        $StrNowTime = strtotime($nowtime);
        $endtime = date('Y-m-d').'23:59:59';
        $StrEndTime = strtotime($endtime);
        $newtime = time();
        $list = $this->where('stu',1)->where('is_del',0)->where('etime','between time',[$StrNowTime,$StrEndTime])->order('stime asc')->field('stime,etime')->select();
//      如果是现在的时段活动就默认显示1
        foreach ($list as $key => &$value){
            if($value['stime'] <= $newtime && $value['etime'] >= $newtime){
                $value['nowsale'] = 1;
            }elseif($value['etime'] <= $newtime){
                $value['nowsale'] = 2;
            }else{
                $value['nowsale'] = 0;
            }
            $value['servertime'] = time();
        }
        return $list;
    }

//  查询点击时间段的限时抢购商品
    public function QueryClickTimeShop($get){
        $list = $this->where('stu',1)->where('is_del',0)->whereTime('stime','between',[$get['stime'],$get['etime']])->field('data')->find();
        if($list){
            $data = unserialize($list['data']);
            if($data){
                $where['is_del'] = 0;
                $where['is_dell'] = 1;
                foreach($data as $key => &$value){
                    $QueryShop = db('product')->where('id',$value['shopid'])->find();
                    $value['name'] = $QueryShop['name'];
                    $value['shotcut'] = $QueryShop['shotcut'];
                }
            }
        }else{
            $data = null;
        }
        return $data;
    }

    // 查询限时抢购
    public function query($nowtime,$id){
        $where['etime'] = array('>=',$nowtime);
        $where['stime'] = array('<=',$nowtime);
        $where['stu'] = 1;
        $list = $this->where($where)->order('stime asc')->field('stime,etime,data,id')->select();
        if($list){
            foreach ($list as $key => &$value) {
                $value['data'] = unserialize($value['data']);
                if(!empty($value['data'])){
                    foreach ($value['data'] as $num => $play) {
                        if($play['shopid'] == $id){
                            $play['saleid'] = $value['id'];
                            $slaedata = $play;
                        }
                    }
                }
            }
        }
        if(empty($slaedata)){
            $slaedata = null;
        }
        return $slaedata;
    }

    // 更新编辑
    public function edit($data,$where){
        $edit = $this->where($where)->update($data);
        return $edit;
    }


    // 查询限时抢购
    public function queryshop($nowtime){
        $newtime = time();
        $where['etime'] = array('>=',$nowtime);
        $where['stime'] = array('<=',$nowtime);
        $where['stu'] = 1;
        $where['is_del'] = 0;
        $list = $this->where($where)->order('stime asc')->field('stime,etime,data,id')->find();
        if($list){
            $list['datashop'] = unserialize($list['data']);
        }
        return $list;
    }
    
}