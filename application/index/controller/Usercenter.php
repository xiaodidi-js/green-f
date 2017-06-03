<?php
namespace app\index\controller;

use think\Request,think\Token;

class Usercenter extends RestBase
{

    public function __construct(){
        //继承父类构造方法
        parent::__construct();
    }
    
    public function _initialize() {
        $this->checklogin();
    }

    // 我的订单
    public function myorder(){
    	$res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));
		$state = intval($request->param('state'));
        // 判断是否查看全部
        if($state == 5){
        	$where['del'] = 0;
	        // 查询订单状态
	        $where['userid'] = $id;
        }else{
        	$where['stu'] = $state;
        }
        $cxorder = db('member')->where($where)->find();
        if($cxorder){
        	$result = makeResult(1,'ok',['list'=>$cxorder]);
        }else{
        	$result = makeResult(1,'暂时没有订单信息');
        }
        return $this->response($result,'json',200);
    }

    // 我的积分
    public function integral(){
        $res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));
    	// $id = 14;
    	$where['uid'] = $id;
    	$cxscore = db('score_lists')->where($where)->select();
    	if($cxscore){
            foreach ($cxscore as $key => $value) {
                $fenshu[] = $value['amount'];
            }
    		$zongfen = array_sum($fenshu);
    		$result = makeResult(1,'ok',['list'=>$cxscore,'zongfen' => $zongfen]);
    	}else{
    		$result = makeResult(0,'暂时没有积分信息');
    	}
        return $this->response($result,'json',200);
    }

    // 商品收藏
    public function mycollect(){
    	$res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));
    	// $id = 14;
    	$where['uid'] = $id;
    	$cxcollect = db('member_collect')->where($where)->select();
    	if($cxcollect){
    		foreach ($cxcollect as $key => $value) {
	    		$shopwhere['id'] = $value['pid'];
	    		$shopwhere['is_del'] = 0;
	    		$cxshop = db('product')->where($shopwhere)->field('id,name,price,store')->find();
	    		$allcollect[] = $cxshop;
	    	}
	    	$result = makeResult(1,'ok',['list'=>$allcollect]);
    	}else{
    		$result = makeResult(0,'暂时没有收藏信息');
    	}
        return $this->response($result,'json',200);
    }

    // 商品收藏删除
    public function delmycollect(){
    	$res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));
		$pid = intval($request->param('pid'));
		if(!empty($pid)){
			$result = makeResult(0,'你没有收藏该商品');
			return $this->response($result,'json',200);
		}
		$delcollect = db('member_collect')->delete($pid);
		if($delcollect){
			$result = makeResult(1,'取消收藏成功');
		}else{
			$result = makeResult(0,'该商品已取消收藏');
		}
		return $this->response($result,'json',200);
    }

    // 自提点区域
    public function since(){
    	$handtake = Model('HandtakePlace');
    	$jiedao = $handtake->sinceselect();
    	if($jiedao){
    		$result = makeResult(1,'ok',['list'=>$jiedao]);
    	}else{
    		$result = makeResult(0,'暂时没有站点地区信息');
    	}
		return $this->response($result,'json',200);
    }

    // 自提点地址&快递地址
    public function myaddress(){
    	$res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));
    	$state = intval($request->param('state'));
    	$sinceid = intval($request->param('sinceid'));
    	$HandtakePlace = Model('HandtakePlace');
    	$cxuserinfo = db('member')->where('id',$id)->field('handtake')->find();
    	if($state == 0){
    		$cxsince = $HandtakePlace->infosince($sinceid);
    		$result = makeResult(1,'ok',['list' => $cxsince,'moren' => $cxuserinfo['handtake']]);
			return $this->response($result,'json',200);
    	}else{
			$MemberAddress = Model('MemberAddress');
			$express = $MemberAddress->infoexpress($id);
			if($express){
				$result = makeResult(1,'ok',['list'=>$express]);
			}else{
				$result = makeResult(0,'您没有添加快递地址');
			}
			return $this->response($result,'json',200);
    	}
    }


    //	快递&自提点默认修改
    public function addressmoren(){
    	$res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));//用户id
		$state = intval($request->param('state'));//状态<0>为自提<1>为快递
		$addressid = intval($request->param('addressid'));//自提点或快递id
		if($state == 0){
			$data['handtake'] = $addressid;
			$editmoren = db('member')->where('id',$id)->update($data);
			if($editmoren){
				$result = makeResult(1,'修改默认自提点成功');
			}else{
				$result = makeResult(0,'修改默认自提点失败');
			}
		}else{
			$MemberAddress = Model('MemberAddress');
			$where['uid'] = $id;
			$where['is_default'] = 1;
			$data['is_default'] = 0;
			$yuanedit = $MemberAddress->where($where)->update($data);
			$whereinedit['uid'] = $id;
			$whereinedit['id'] = $addressid;
			$editdata['is_default'] = 1;
			$inedit = $MemberAddress->where($whereinedit)->update($editdata);
			if($inedit){
				$result = makeResult(1,'修改默认快递地址成功');
			}else{
				$result = makeResult(0,'修改默认快递地址失败');
			}
		}
		return $this->response($result,'json',200);
    }

    // 删除快递地址
    public function delexpress(){
    	$res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));
		$expressid = intval($request->param('expressid')); //快递地址id
		$where['uid'] = $id;
		$where['id'] = $expressid;
		$del = db('member_address')->where($where)->delete();
		if($del){
			$result = makeResult(1,'删除快递地址成功');
		}else{
			$result = makeResult(0,'删除快递地址失败');
		}
		return $this->response($result,'json',200);
    }

    // 新增快递地址
    public function addexpress(){
    	$res = $this->checklogin();
        if($res){
        	return $res;
        }
        $request = Request::instance();
		$id = intval($request->param('uid'));
		$data['uid'] = $id;
		$data['person'] = $request->param('person');  //姓名
		$data['code'] = $request->param('code');  //邮编
		$data['area'] = $request->param('area');  //区域
		$data['address'] = $request->param('address');    //地址
		$data['tel'] = $request->param('tel');    //电话
		$add = db('member_address')->insert($data);
        if($add){
            $result = makeResult(1,'新增快递地址成功');
        }else{
            $result = makeResult(0,'新增快递地址失败');
        }
        return $this->response($result,'json',200);
    }

    // 个人资料
    public function personal(){
        $res = $this->checklogin();
        if($res){
            return $res;
        }
        $request = Request::instance();
        $id = intval($request->param('uid'));
        $infouser = db('member')->where('id',$id)->field('tel,uname,sex,birthday')->find();
        $infouser['birthday'] = date("Y-m-d",$infouser['birthday']);
        if($infouser['sex'] == 0){
            $infouser['sex'] = '男';
        }else{
            $infouser['sex'] = '女';
        }
        if($infouser){
            $result = makeResult(1,'ok',['list'=>$infouser]);
        }else{
            $result = makeResult(0,'系统找不到这个用户,请联系客服!');
        }
        return $this->response($result,'json',200);
        
    }

    // 修改可修改的个人资料
    public function editpersonal(){
        $res = $this->checklogin();
        if($res){
            return $res;
        }
        $request = Request::instance();
        $id = intval($request->param('uid'));
        $birthday = strtotime($request->param('birthday'));
        $sex = $request->param('sex');
        if($sex == '男'){
            $sex = 0;
        }else{
            $sex = 1;
        }
        $data['sex'] = $sex;
        $data['uname'] = $request->param('uname');
        $data['birthday'] = $birthday;
        $edit = db('member')->where('id',$id)->update($data);
        if($edit){
            $result = makeResult(1,'修改资料成功');
        }else{
            $result = makeResult(0,'修改资料失败,请联系客服');
        }
        return $this->response($result,'json',200);
    }

    // 在线客服
    public function onlie(){
        $chaxun = db('buyer')->where('class',4)->field('name,tel')->select();
        $result = makeResult(1,'ok',['list'=>$chaxun]);
        return $this->response($result,'json',200);
    }

    // 购物车检查当日次日问题
    public function shopingclick(){
        $request = Request::instance();
        $post = $request->post();
        if(empty($post['shoping'])){
            $result = makeResult(0,['msg'=>'没有购物车数据','data'=>$request]);
            return $this->response($result,'json',200);
        }
        $data = $post['shoping'];
        $newdata = $data;
        $nowtime = time();
        foreach ($newdata as $key => &$value) {
            // lzc-配送时间
            if($value['deliverytime'] == 0){
                $stimedate = date('Y-m-d',$nowtime).'00:00';
                $etimedate = date('Y-m-d',$nowtime).'22:00';
                $stime = strtotime($stimedate);
                $etime = strtotime($etimedate);
                if($nowtime >= $stime && $nowtime <= $etime){
                    $ciri = 1;
                }else{
                    $ciri = 0;
                }
                $value['peisongok'] = $ciri;
            }else{
                $stimedate = date('Y-m-d',$nowtime).'00:00';
                $stime = strtotime($stimedate);
                $etimedate = date('Y-m-d',$nowtime).'13:00';
                $etime = strtotime($etimedate);
                if($nowtime >= $stime && $nowtime <= $etime){
                    $dangtian = 1;
                }else{
                    $dangtian = 0;
                }
                $value['peisongok'] = $dangtian;
            }
            foreach ($data as $key1 => $value1) {
                if($value['peisongok'] != $value1['peisongok']){
                    $result = makeResult(0,'购物车存在配送时间比较旧,要清空购物车');
                    return $this->response($result,'json',200);
                }
            }
        }

    }
}