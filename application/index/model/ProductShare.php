<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/4/26
 * Time: 10:45
 */
namespace app\index\model;

use think\Model;

class ProductShare extends Model{

	// 查询分享活动
    public function query($nowtime,$id){
        $where['etime'] = array('>=',$nowtime);
        $where['stime'] = array('<=',$nowtime);
        $where['stu'] = 1;
        $where['is_del'] = 0;
        $list = $this->where($where)->order('stime asc')->field('stime,etime,data,id')->select();
        if($list){
            foreach ($list as $key => &$value) {
                $value['data'] = unserialize($value['data']);
                if(!empty($value['data'])){
                    foreach ($value['data'] as $num => $play) {
                        if($play['id'] == $id){
                            $sharedata['shopid'] = $play['id'];
                            $sharedata['sharestore'] = $play['sharestore'];
                            $sharedata['shareprice'] = $play['shareprice'];
                            $sharedata['shareid'] = $value['id'];
                        }
                    }
                }
            }
        }
        if(empty($sharedata)){
            $sharedata = null;
        }
        return $sharedata;
    }

    // 更新编辑
    public function edit($data,$where){
        $edit = $this->where($where)->update($data);
        return $edit;
    }

    // 查询
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
