<?php

namespace app\index\model;

use think\Model;

class Product extends Model{
    
    public function querygift($giftid){
    	$where['id'] = $giftid;
    	$where['gift'] = 1;
    	$where['is_del'] = 0;
    	$where['store'] = array('>','0');
    	$info = $this->where($where)->field('id,price,name')->find();
    	return $info;
    }
}