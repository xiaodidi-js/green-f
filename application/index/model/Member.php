<?php
/**
 * Created by PhpStorm.
 * User: 罗梓超
 * Date: 2017/5/4
 * Time: 14:28
 */
namespace app\index\model;
use think\Model;

class Member extends Model{
    /**
     * @积分收取
     */
    public function AddJiFen($QueryOrder){
        $QueryJifenAddNub = db('jifen')->where('id',1)->find();
        $JinE = floor($QueryOrder['money']);
        $AddTotalJiFen = $JinE * $QueryJifenAddNub['xiaofei'];
        $AddJiFen = $this->where('id',$QueryOrder['uid'])->setInc('score',$AddTotalJiFen);
        if($AddJiFen){
            $insert['uid'] = $QueryOrder['uid'];
            $insert['type'] = 'orders';
            $insert['amount'] = $AddTotalJiFen;
            $insert['createtime'] = time();
            $JiLuJiFen = db('score_lists')->insert($insert);
            if($JiLuJiFen){
                return $JiLuJiFen;
            }
        }else{
            return 0;
        }
    }
}