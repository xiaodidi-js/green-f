<?php

namespace app\admin\model;

use think\Model;

class Product extends Model{

	protected $auto = ['price','promote_price','sort','store'];
	protected $insert = ['updatetime','createtime'];
	protected $update = ['updatetime'];

	protected function setPriceAttr($val){
		return floatval($val);
	}

	protected function setPromotePriceAttr($val){
		return floatval($val);
	}

	protected function setSortAttr($val){
		return intval($val);
	}

	protected function setStoreAttr($val){
		return intval($val);
	}

	protected function setCreatetimeAttr($val){
		return time();
	}

	protected function setUpdatetimeAttr($val){
		return time();
	}

	public function editstore($post){
		$data['store'] = $post['store'];
		$edit = $this->where('id',$post['id'])->update($data);
		return $edit;
	}

	public function alldel($post){
		$maa['is_del'] = 1;
		foreach($post['id'] as $key => $value){
			$del = $this->where('id',$value)->update($maa);
		}
		return $del;
	}

	public function alldownup($post){
		foreach ($post['id'] as $key => $value) {
			$cx = $this->where('id',$value)->find();
			if($cx['is_sell'] == 0){
				$maa['is_sell'] = 1;
			}else{
				$maa['is_sell'] = 0;
			}
			$update = $this->where('id',$value)->update($maa);
		}
		return $update;
	}

	/*限时抢购*/

	// 限时抢购查询已选择的商品
	public function SaleConfigOriginalShop($data){
		$where['is_del'] = 0;
		$where['gift'] = 0;
//		查询商品id
		$find = $this->where($where)->where('id',$data['shopid'])->field('id,shotcut,name,cid,store')->find();
		$ShopFormatwhere['pid'] = $find['id'];
//		查询这个商品下的规格
        $QueryShopFormat = db('product_formlist')->where($ShopFormatwhere)->select();
//          如果这个商品有规格就把规格的数量和限时抢购资料绑定
            if($QueryShopFormat){
                foreach($QueryShopFormat as $key => &$value){
                    $ShopFormatName = explode(',',$value['format']);
                    foreach($ShopFormatName as $key1 => $value1){
                        $FormatNamewhere['id'] = $value1;
                        $QueryShopFormatName = db('product_formvalue')->where($FormatNamewhere)->find();
                        $Format[$key1] = $QueryShopFormatName['value'];
                    }
                    $FormatAll[$key]['arr'] = implode('',$Format);
                    $FormatAll[$key]['price'] = $value['price'];
                    $FormatAll[$key]['store'] = $value['store'];
                    $FormatAll[$key]['id'] = $value['id'];
                    $FormatAll[$key]['saledata']['saleprice'] = $data['saledata'][$key]['saleprice'];
                    $FormatAll[$key]['saledata']["salenub"] = $data['saledata'][$key]['salenub'];
                    $FormatAll[$key]['saledata']["salepaynub"] = $data['saledata'][$key]['salepaynub'];
                    $find['formatAll'] = $FormatAll;
                }
            }else{
//              如果没有规格的就只赋值限时抢购这个商品
                $FormatAll[0]['saledata']['saleprice'] = $data['saledata'][0]['saleprice'];
                $FormatAll[0]['saledata']["salenub"] = $data['saledata'][0]['salenub'];
                $FormatAll[0]['saledata']["salepaynub"] = $data['saledata'][0]['salepaynub'];
                $find['formatAll'] = $FormatAll;
            }

		return $find;
	}

	// 限时抢购查看全部商品 除了 赠品 已删除 已选择的商品
	public function SaleConfigAllShop($NotIn){
		$where['is_del'] = 0;
		$where['gift'] = 0;
		$list = $this->where($where)->where('id','not in',$NotIn)->field('id,shotcut,name,cid,store')->select();
		return $list;
	}

	// 限时抢购查询指定ID的商品
	public function SaleClickOneShop($id){
		$find = $this->where('id',$id)->field('id,shotcut,name,cid,store,price')->find();
		$where['pid'] = $find['id'];
		$QueryShopFormat = db('product_formlist')->where($where)->select();
		if($QueryShopFormat){
            foreach($QueryShopFormat as $key => &$value){
                $ShopFormatName = explode(',',$value['format']);
                foreach($ShopFormatName as $key1 => $value1){
                    $FormatNamewhere['id'] = $value1;
                    $QueryShopFormatName = db('product_formvalue')->where($FormatNamewhere)->find();
                    $Format[$key1] = $QueryShopFormatName['value'];
                }
                $FormatAll[$key]['arr'] = implode('',$Format);
                $FormatAll[$key]['price'] = $value['price'];
                $FormatAll[$key]['store'] = $value['store'];
                $FormatAll[$key]['id'] = $value['id'];
                $find['formatAll'] = $FormatAll;
            }
        }else{
            $find['formatAll'] = [];
        }
		return $find;
	}

//	用id查看商品
    public function queryidshop($id){
	    $list = $this->where('id','in',$id)->field('sn_code,supplier,caigouyuan,fenjianzu,name,cid,weight,id,unit,taocan,gift')->select();
	    return $list;
    }
}