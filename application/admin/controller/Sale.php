<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/4/24
 * Time: 10:02
 * 分享购买和限时抢购、二维码商品配置流程基本一样,如需改动请按实际情况一起改动修改!
 */
namespace app\admin\controller;
use think\Controller,think\Request;

class Sale extends Base
{

    // 限时抢购列表
    public function TimeSlotList()
    {
        $List = Model('sale')->querysale();
        $this->assign('list', $List);
        return $this->fetch();
    }

    // 限时抢购新增&编辑
    public function AddOrEditSale()
    {
        $request = Request::instance();
        $post = $request->post();
        $get = $request->route();
        if (!empty($get['id'])) {
            $cilck = Model('sale')->querysaleinfo($get['id']);
            $this->assign('info', $cilck);
            $this->assign('id', $get['id']);
            return $this->fetch('editsale');
        } elseif (empty($post)) {
            return $this->fetch('addsale');
        }
        if (!empty($post['id'])) {
            $stime = strtotime($post['stime']);
            $etime = strtotime($post['etime']);
            $update['stime'] = $stime;
            $update['etime'] = $etime;
            $update['stu'] = $post['stu'];
            $update['name'] = $post['name'];
            $edit = Model('sale')->editsale($update,$post['id']);
            if ($edit) {
                return make_json(1, '编辑成功');
            } else {
                return make_json(0, '编辑失败');
            }
        } else {
            if (empty($post['stime']) || empty($post['etime']) || empty($post['name'])) {
                return make_json(0, '请填写每个输入框');
            }
            $stime = strtotime($post['stime']);
            $etime = strtotime($post['etime']);
            if ($stime >= $etime) {
                return make_json(0, '开始时间大过结束时间，无效请重新选择');
            }
            $data['stime'] = $stime;
            $data['etime'] = $etime;
            $data['stu'] = $post['stu'];
            $data['name'] = $post['name'];
            $data['createtime'] = time();
            $add = db('sale')->insert($data);
            if ($add) {
                return make_json(1, '新增成功');
            } else {
                return make_json(0, '新增失败');
            }
        }
    }

    // 删除限时抢购
    public function DelSale()
    {
        $request = Request::instance();
        $post = $request->post();
        if ($post['id']) {
            $update['is_del'] = 1;
            $click = Model('sale')->editsale($update,$post['id']);
            return make_json(1, '删除成功');
        } else {
            return make_json(0, '找不到这个限时抢购活动可能已被删除');
        }
    }

    // 配置限时抢购列表
    public function ConfigSale()
    {
        $request = Request::instance();
        $get = $request->route();
        $info = Model('sale')->field('name')->find();
        $this->assign('name',$info['name']);
        $this->assign('id', $get['id']);
        return $this->fetch();
    }

    // 配置限时抢购商品
    public function ConfigSaleShop()
    {
        $request = Request::instance();
        $get = $request->get();
        if (!empty($get['id'])) {
            // 查询活动原有设置的商品
            $cilck = Model('sale')->SaleConfigShop($get['id']);
            $SaleShop = unserialize($cilck['data']);
            if ($SaleShop) {
                foreach ($SaleShop as $key4 => $value4) {
                    $SaleShopId[] = $value4['shopid'];
                }
            }
            if ($SaleShop) {
                foreach ($SaleShop as $key2 => $value2) {
                    $SaleShop = Model('product')->SaleConfigOriginalShop($value2);
                    if($SaleShop){
                        $SaleOriginalShop[] = $SaleShop;
                    }
                }
                foreach ($SaleOriginalShop as $key1 => &$value1) {
                    $ClickClass = Model('product_classify')->SaleConfigShopClass($value1['cid']);
                    $value['class'] = $ClickClass['title'];
                }
                // 查询活动没有设置的所有商品
                $SaleAllShop = Model('product')->SaleConfigAllShop($SaleShopId);
            } else {
                $SaleOriginalShop = null;
                $SaleAllShop = Model('product')->SaleConfigAllShop(0);
            }
            // 查询分类名
            foreach ($SaleAllShop as $key => &$value) {
                $ClickClass = Model('product_classify')->SaleConfigShopClass($value['cid']);
                $value['class'] = $ClickClass['title'];
            }
            return make_json(1, ['OriginalShop_data' => $SaleOriginalShop, 'AllShop_data' => $SaleAllShop]);
        } else{
            return make_json(0, '找不到这个限时抢购活动可能已被删除');
        }
    }

    // 查询新增&删除商品数据
    public function ClickShopData()
    {
        $request = Request::instance();
        $post = $request->post();
        $ClickShop = Model('product')->SaleClickOneShop($post['shop_id']);
        return make_json(1, ['AddOrDeleteShop_data' => $ClickShop]);
    }

    // 数据更新
    public function EditSaleConfigShop()
    {
        $request = Request::instance();
        $post = $request->post();
        $edit = Model('sale')->EditSaleConfig($post);
        if ($edit) {
            return make_json(1, '更新成功');
        } else {
            return make_json(0, '您没有作出更改');
        }
    }
}