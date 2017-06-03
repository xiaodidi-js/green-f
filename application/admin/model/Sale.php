<?php

namespace app\admin\model;

use think\Model;

class Sale extends Model{

	// 查询限时抢购活动原有配置商品
	public function SaleConfigShop($id){
		$find = $this->where('id',$id)->field('data')->find();
		return $find;
	}

	// 修改限时抢购配置
	public function EditSaleConfig($post){
	    if(empty($post['data'])){
	        $data['data'] = null;
        }else{
            foreach ($post['info'] as $key => $value) {
                foreach($value['formatAll'] as $key1 => $value1){
                    if(!empty($value1['id'])){
                        $newvalue[$key]['saledata'][$key1]['formatid'] = $value1['id'];
                    }
                    $newvalue[$key]['saledata'][$key1]['saleprice'] = $value1['saledata']['saleprice'];
                    $newvalue[$key]['saledata'][$key1]['salenub'] = $value1['saledata']['salenub'];
                    $newvalue[$key]['saledata'][$key1]['salepaynub'] = $value1['saledata']['salepaynub'];
                    $newvalue[$key]['saledata'][$key1]['salekucunnub'] = $value1['saledata']['salepaynub'];
                }
                $newvalue[$key]['shopid'] = $post['data'][$key];
            }
            $data['data'] = serialize($newvalue);
        }
		$edit = $this->where('id',$post['id'])->update($data);
		return $edit;
	}

    // 查询未删除的限时活动
    public function querysale(){
        $list = $this->where('is_del',0)->field('id,name,stime,etime,stu')->select();
        return $list;
    }

    // 查询指定id的限时活动
    public function querysaleinfo($id){
        $info = $this->where('id', $id)->find();
        return $info;
    }

    // 更新指定id的限时活动
    public function editsale($update,$id){
        $edit = $this->where('id', $id)->update($update);
        return $edit;
    }
}