<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/4/26
 * Time: 10:45
 */
namespace app\index\model;

use think\Model;

class ProductQrcode extends Model{

	// 查询二维码商品
    public function query($nowtime){
        $newtime = time();
        $where['etime'] = array('>=',$nowtime);
        $where['stime'] = array('<=',$nowtime);
        $where['stu'] = 1;
        $list = $this->where($where)->order('stime asc')->field('stime,etime,data,id')->find();
        if($list){
            $list['datashop'] = unserialize($list['data']);
        }
        return $list;
    }
}
