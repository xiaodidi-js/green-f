<?php
namespace app\index\controller;

use think\Request,think\Db,think\Token,think\Cache;

class App extends RestBase
{

	public function login(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
            	//登录操作
    			$data = $request->param();
    			if(empty($data)){
    				$result = makeResult(0,'登录信息不完整');
    				return $this->response($result,'json',200);
    			}else if(empty($data['utel'])||empty($data['upwd'])){
    				$result = makeResult(0,'请填写登录账号和密码');
    				return $this->response($result,'json',200);
    			}
    			$un = trim($data['utel']);
    			$up = trim($data['upwd']);
    			$info = Db::name('delivery_driver')->where('tel',$un)->where('pwd',md5($up))->find();
    			if(!$info){
    				$result = makeResult(0,'用户名或密码错误');
    				return $this->response($result,'json',200);
    			}else if($info['status']!=1){
    				$result = makeResult(0,'账号已被禁用');
    				return $this->response($result,'json',200);
    			}
                $token = new Token(['id'=>$info['id'],'utel'=>$info['tel'],'upwd'=>$info['pwd']]);
                $token_str = $token->makeToken();
    			$result = makeResult(1,'登录成功',['id'=>$info['id'],'token'=>$token_str]);
    			return $this->response($result,'json',200);
            	break;
            default:
            	break;
        }
	}

	public function choseList(){
		$request = Request::instance();
        switch ($this->method) {
            case 'get':
            	//获取可配置线路
    			$id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                if(!$id||!$gtoken){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = Db::name('delivery_driver')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'账号不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['tel'],'upwd'=>$user['pwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'账号验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                $list = db('delivery_path')->where('aid',$user['aid'])->where('status',1)->order('createtime desc')->field('id,name')->select();
                unset($user);
                $result = [];
                if(!$list){
                    $result = makeResult(1,'empty');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'ok',['list'=>$list]);
                return $this->response($result,'json',200);
            	break;
            default:
            	break;
        }
	}

	public function setTemp(){
		$request = Request::instance();
        switch ($this->method) {
        	case 'get':
                //查询已配置线路
        		$id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $date = strtotime($request->param('date'));
                $time = intval($request->param('time'));
                if(!$id||!$gtoken||!$date||!$time){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = Db::name('delivery_driver')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'账号不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['tel'],'upwd'=>$user['pwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'账号验证失败');
                    return $this->response($result,'json',200);
                }
                unset($user);
                unset($gtoken);
                $check = Db::name('delivery_temp')->where('did',$id)->where('date',$date)->where('type',$time)->count();
                if($check){
                	$result = makeResult(1,'setted');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(2,'unset');
                return $this->response($result,'json',200);
        		break;
            case 'post':
            	//配置线路
    			$id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $date = strtotime($request->put('date'));
                $time = intval($request->put('time'));
                $path = trim($request->put('path'));
                if(!$id||!$gtoken||!$date||!$time){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = Db::name('delivery_driver')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'账号不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['tel'],'upwd'=>$user['pwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'账号验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                $path = explode('-',$path);
                if(empty($path)){
                	$result = makeResult(1,'empty');
                    return $this->response($result,'json',200);
                }else if(count($path)===1&&$path[0]==0){
                	if(empty($user['dpath'])){
                		$result = makeResult(0,'账号未配置默认线路');
                    	return $this->response($result,'json',200);
                	}
                	$path[0] = $user['dpath'];
                }
                unset($user);
                $check = Db::name('delivery_temp')->where('did',$id)->where('date',$date)->where('type',$time)->count();
                if($check){
                	$result = makeResult(0,'当天配送线路已配置');
                    return $this->response($result,'json',200);
                }
                $data = [];
                $ctime = time();
                foreach($path as $k=>$v){
                	$data[] = ['did'=>$id,'pid'=>$v,'date'=>$date,'type'=>$time,'sort'=>($k+1),'createtime'=>$ctime];
                }
                $add = Db::name('delivery_temp')->insertAll($data);
                if(!$add){
                    $result = makeResult(0,'临时线路配置失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'临时线路配置成功');
                return $this->response($result,'json',200);
            	break;
            default:
            	break;
        }
	}

	public function previewList(){
		$request = Request::instance();
        switch ($this->method) {
            case 'get':
            	//查询配送线路列表
    			$id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $date = strtotime($request->param('date'));
                $time = intval($request->param('time'));
                if(!$id||!$gtoken||!$date||!$time){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = Db::name('delivery_driver')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'账号不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['tel'],'upwd'=>$user['pwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'账号验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                /*$atel = Db::name('admin')->where('id',$user['aid'])->value('tel');
                $aid = Db::table('wy_users')->where('username',$atel)->value('id');
                $atoken = Db::table('wy_wxuser')->where('uid',$aid)->value('token');
                unset($atel);
                unset($aid);
                unset($user);*/
                /*switch($atoken){
                	case 'qolngo1456113545':
                		if($time===1){
                			$songtime = strtotime(date('Y-m-d',$date).' 10:30');
                		}else{
                			$songtime = strtotime(date('Y-m-d',$date).' 16:30');
                		}
                		break;
                	default:
                		if($time===1){
                			$songtime = strtotime(date('Y-m-d',$date).' 11:00');
                		}else{
                			$songtime = strtotime(date('Y-m-d',$date).' 17:00');
                		}
                		break;
                }*/
                if($time===1){
                    $songtime = strtotime(date('Y-m-d',$date).' 10:30');
                }else{
                    $songtime = strtotime(date('Y-m-d',$date).' 16:30');
                }
                $list = Db::name('delivery_temp')->alias('t')
                							->join('delivery_path p','t.pid = p.id')
                							->where('t.did',$id)
                							->where('t.date',$date)
                							->where('t.type',$time)
                							->order('t.sort asc')
                							->field('t.id,p.name,p.path')
                							->select();
                $result = [];
                if(empty($list)){
                    $result = makeResult(0,'未配置需要配送的线路');
                    return $this->response($result,'json',200);
                }
                foreach($list as $k=>$v) {
                    $temp = [];
                	if(!empty($v['path'])){
                		$temp = db('handtake_place')->where('id','in',$v['path'])->field('id,name')->select();
                		$temp = empty($temp) ? [] : $temp;
                	}
                	$list[$k]['more'] = false;
                	foreach($temp as $pk=>$pv){
                		$onums = db('member_orders')
											->where('person',$pv['name'])
											->where('send',0)
											->where('reject',0)
											->where('status','eq',0)
											// ->where('token',$atoken)
											->where('stime',$songtime)
											->count();
						$temp[$pk]['onums'] = $onums;
                	}
                    $list[$k]['path'] = $temp;
                }
                $result = makeResult(1,'ok',['list'=>$list]);
                return $this->response($result,'json',200);
            	break;
            default:
            	break;
        }
	}

    public function setStime(){
        $request = Request::instance();
        switch ($this->method) {
            case 'put':
                //设置开始配送时间
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $date = strtotime($request->put('date'));
                $time = intval($request->put('time'));
                if(!$id||!$gtoken||!$date||!$time){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = Db::name('delivery_driver')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'账号不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['tel'],'upwd'=>$user['pwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'账号验证失败');
                    return $this->response($result,'json',200);
                }
                unset($user);
                unset($gtoken);
                $where = ['did'=>$id,'date'=>$date,'type'=>$time];
                $check = Db::name('delivery_temp')->where($where)->order('sort asc')->value('stime');
                $result = [];
                if($check){
                    $result = makeResult(1,'started');
                    return $this->response($result,'json',200);
                }else{
                    $up = Db::name('delivery_temp')->where($where)->update(['stime'=>time()]);
                    if($up){
                        $result = makeResult(1,'ok');
                    }else{
                        $result = makeResult(0,'数据更新失败');
                    }
                    return $this->response($result,'json',200);
                }
                break;
            default:
                break;
        }
    }

	public function sendList(){
		$request = Request::instance();
        switch ($this->method) {
            case 'get':
            	//查询配送列表
    			$id = intval($request->param('uid'));
                $gtoken = trim($request->param('token'));
                $date = strtotime($request->param('date'));
                $time = intval($request->param('time'));
                $change = intval($request->param('change'));
                $sort = intval($request->param('sort'));
                /*if(!$id||!$gtoken||!$date||!$time){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }*/
                $user = Db::name('delivery_driver')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'账号不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['tel'],'upwd'=>$user['pwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'账号验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                //返回数据数组
                $resData = [];
                $resData['deliver'] = $user['name'];
                $resData['pnums'] = Db::name('delivery_temp')->where('did',$id)->where('date',$date)->where('type',$time)->count();
                /*$atel = Db::name('admin')->where('id',$user['aid'])->value('tel');
                $aid = Db::table('wy_users')->where('username',$atel)->value('id');
                $atoken = Db::table('wy_wxuser')->where('uid',$aid)->value('token');
                unset($atel);
                unset($aid);
                unset($user);
                
                switch($atoken){
                	case 'qolngo1456113545':
                		if($time===1){
                			$songtime = strtotime(date('Y-m-d',$date).' 10:30');
                		}else{
                			$songtime = strtotime(date('Y-m-d',$date).' 16:30');
                		}
                        $startPoint = ['name'=>'[顺德区]绿秧田分配中心出发'];
                		break;
                	default:
                		if($time===1){
                			$songtime = strtotime(date('Y-m-d',$date).' 11:00');
                		}else{
                			$songtime = strtotime(date('Y-m-d',$date).' 17:00');
                		}
                        $startPoint = ['name'=>'[禅城区]绿秧田分配中心出发'];
                		break;
                }*/
                if($time===1){
                    $songtime = strtotime(date('Y-m-d',$date).' 10:30');
                }else{
                    $songtime = strtotime(date('Y-m-d',$date).' 16:30');
                }
                $startPoint = ['name'=>'绿秧田分配中心出发'];

                if($change!=0&&$sort!=0){
                    if($change===1){
                        $nowSort = $sort + 1;
                    }else{
                        $nowSort = $sort - 1;
                    }
                    $path = Db::name('delivery_temp')->alias('t')
                                            ->join('delivery_path p','t.pid = p.id')
                                            ->where('t.did',$id)
                                            ->where('t.date',$date)
                                            ->where('t.type',$time)
                                            ->where('t.status',0)
                                            ->where('t.sort',$nowSort)
                                            ->field('p.id,p.name,p.path,t.sort,t.stime')
                                            ->find();
                    if(empty($path)){
                        $path = Db::name('delivery_temp')->alias('t')
                                            ->join('delivery_path p','t.pid = p.id')
                                            ->where('t.did',$id)
                                            ->where('t.date',$date)
                                            ->where('t.type',$time)
                                            ->where('t.status',1)
                                            ->where('t.sort',$nowSort)
                                            ->field('p.id,p.name,p.path,t.sort,t.stime')
                                            ->find();
                    }
                    if(empty($path)){
                        $result = makeResult(0,'empty');
                        return $this->response($result,'json',200);
                    }
                }else{
                    $path = Db::name('delivery_temp')->alias('t')
                                            ->join('delivery_path p','t.pid = p.id')
                                            ->where('t.did',$id)
                                            ->where('t.date',$date)
                                            ->where('t.type',$time)
                                            ->where('t.status',0)
                                            ->order('t.sort asc')
                                            ->field('p.id,p.name,p.path,t.sort,t.stime')
                                            ->find();
                    if(empty($path)){
                        $path = Db::name('delivery_temp')->alias('t')
                                            ->join('delivery_path p','t.pid = p.id')
                                            ->where('t.did',$id)
                                            ->where('t.date',$date)
                                            ->where('t.type',$time)
                                            ->where('t.status',1)
                                            ->order('t.sort asc')
                                            ->field('p.id,p.name,p.path,t.sort,t.stime')
                                            ->find();
                    }
                }
                $startPoint['stime'] = date('Y-m-d H:i:s',$path['stime']);
                $path = empty($path) ? false : $path;
                if($path!==false) {
                    $tmpSort = [];
                	if(!empty($path['path'])){
                        $tpath = array_reverse(explode(',',$path['path']));
                		$temp = db('handtake_place')->alias('p')
                        ->join('delivery_record r',"(p.id = r.point) AND (r.date = $date) AND (r.type = $time) AND (r.path = $path[id]) AND (r.driver = $id)",'LEFT')
                        ->where('p.id','in',$path['path'])
                        ->field('p.id,p.name,p.address,p.tel,r.status')
                        ->select();
                        foreach($tpath as $tpk=>$tpv){
                            foreach($temp as $tmpk=>$tmpv){
                                if($tpv==$tmpv['id']){
                                    $tmpSort[] = $tmpv;
                                    break;
                                }
                            }
                        }
                        unset($temp);
                	}
                    $path['path'] = ['zero'=>[],'send'=>[]];
                    $where['pay'] = 1;
                    $where['send'] = 0;
                    $where['stype'] = 'parcel';
                    $where['reject'] = 0;
                    $where['status'] = array('neq',0);
                    $where['stime'] = $songtime;
                	foreach($tmpSort as $pk=>$pv){
                        $where['person'] = $pv['id'];
                		$onums = db('member_orders')->where($where)->count();
                        $tmpSort[$pk]['onums'] = $onums;
						if($onums>0){
							$path['path']['send'][] = $tmpSort[$pk];
						}else{
							$path['path']['zero'][] = $tmpSort[$pk];
						}
                	}
                    if(count($path['path']['send'])>=1){
                       $path['path']['send'][] = $startPoint; 
                    }
                }else{
                	$result = makeResult(2,'已完成所有线路配送');
                    return $this->response($result,'json',200);
                }
                $resData['path'] = $path;
                $result = makeResult(1,'ok',['sdata'=>$resData]);
                return $this->response($result,'json',200);
            	break;
            case 'put':
                //配送或跳过操作
                $id = intval($request->put('uid'));
                $gtoken = trim($request->put('token'));
                $date = strtotime($request->put('date'));
                $time = intval($request->put('time'));
                $type = intval($request->put('type'));
                $path = intval($request->put('path'));
                $point = trim($request->put('point'));
                $onums = intval($request->put('onums'));
                if(!$id||!$gtoken||!$date||!$time||!$type||!$path||!$point){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $user = Db::name('delivery_driver')->where('id',$id)->find();
                if(!$user){
                    $result = makeResult(-1,'账号不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$user['id'],'utel'=>$user['tel'],'upwd'=>$user['pwd']],$gtoken);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(-1,'账号验证失败');
                    return $this->response($result,'json',200);
                }
                unset($gtoken);
                if(strpos($point,',')>=0){
                    $point = ['in',explode(',',$point)];
                }
                $where = ['driver'=>$id,'date'=>$date,'type'=>$time,'path'=>$path,'point'=>$point];
                $check = Db::name('delivery_record')->where($where)->find();
                if($check){
                    $up = Db::name('delivery_record')->where($where)->update(['status'=>$type,'onums'=>$onums,'createtime'=>time()]);
                }else{
                    if(is_array($point)){
                        $addData = [];
                        $addCtime = time();
                        foreach($point[1] as $pad){
                            $addData[] = ['driver'=>$id,'date'=>$date,'type'=>$time,'path'=>$path,'point'=>$pad,'status'=>$type,'onums'=>$onums,'createtime'=>$addCtime];
                        }
                        $up = Db::name('delivery_record')->insertAll($addData);
                        unset($addData);
                        unset($addCtime);
                    }else{
                        $up = Db::name('delivery_record')->insert(array_merge($where,['status'=>$type,'onums'=>$onums,'createtime'=>time()]));
                    }
                }
                if($up){
                    //发送通知
                    if($type===1){
                        /*$atel = Db::name('admin')->where('id',$user['aid'])->value('tel');
                        $aid = Db::table('wy_users')->where('username',$atel)->value('id');
                        $atoken = Db::table('wy_wxuser')->where('uid',$aid)->value('token');
                        unset($atel);
                        unset($aid);*/
                        $owhere = [];
                        $owhere['rid'] = $point;
                        // $owhere['token'] = $atoken;
                        $owhere['paid'] = 1;
                        $owhere['shou'] = 0;
                        $owhere['tuihuo'] = 0;
                        /*switch($atoken){
                            case 'qolngo1456113545':
                                if($time===1){
                                    $songtime = strtotime(date('Y-m-d',$date).' 10:30');
                                }else{
                                    $songtime = strtotime(date('Y-m-d',$date).' 16:30');
                                }
                                break;
                            default:
                                if($time===1){
                                    $songtime = strtotime(date('Y-m-d',$date).' 11:00');
                                }else{
                                    $songtime = strtotime(date('Y-m-d',$date).' 17:00');
                                }
                                break;
                        }*/
                        if($time===1){
                            $songtime = strtotime(date('Y-m-d',$date).' 10:30');
                        }else{
                            $songtime = strtotime(date('Y-m-d',$date).' 16:30');
                        }
                        $owhere['stime'] = $songtime;
                        // $owhere['status'] = ['neq','0'];
                        $olist = db('member_orders')->where($owhere)->field('id,tel,openid,stime,address,orderid')->select();
                        foreach($olist as $ok=>$ov){
                            $this->fahuonotice($olist['openid'],$olist);
                        }
                        db('member_orders')->where($owhere)->update(['sent'=>1]);
                        unset($owhere);
                    }
                    //配送点数量
                    $pointCount = Db::name('delivery_path')->where('id',$path)->value('count');
                    $pointSendCount = Db::name('delivery_record')->where('driver',$id)->where('date',$date)->where('type',$time)->where('path',$path)->where('status','in',[1,-1])->count();
                    //判断当前线路是否配送完毕
                    if($pointSendCount<$pointCount){
                        $result = makeResult(1,'success',['pstatus'=>$type]);
                        return $this->response($result,'json',200);
                    }
                    //未配送数量
                    $sumCount = Db::name('delivery_temp')->alias('t')
                                                        ->join('delivery_path p','t.pid = p.id','LEFT')
                                                        ->where('t.did',$id)
                                                        ->where('t.date',$date)
                                                        ->where('t.type',$time)
                                                        ->sum('p.count');
                    $sendCount = Db::name('delivery_record')->where('driver',$id)->where('date',$date)->where('type',$time)->where('status','in',[1,-1])->count();
                    //判断所有线路是否配送完毕
                    Db::name('delivery_temp')->where('did',$id)->where('date',$date)->where('type',$time)->where('pid',$path)->where('status',0)->update(['status'=>1]);
                    if($sendCount>=$sumCount){
                        $result = makeResult(3,'complate',['pstatus'=>$type]);
                        return $this->response($result,'json',200);
                    }else if($pointSendCount>=$pointCount){
                        $result = makeResult(2,'next',['pstatus'=>$type]);
                        return $this->response($result,'json',200);
                    }else{
                        $result = makeResult(1,'success',['pstatus'=>$type]);
                        return $this->response($result,'json',200);
                    }
                }else{
                    $result = makeResult(0,'配送数据更新失败');
                    return $this->response($result,'json',200);
                }
                break;
            default:
            	break;
        }
	}

    /*private function getToken($naid){
        $access_token = Cache::get("access_token_".$naid);
        if(!$access_token){
            $atel = Db::name('admin')->where('id',$naid)->value('tel');
            $aid = Db::table('wy_users')->where('username',$atel)->value('id');
            $wxinfo = Db::table('wy_wxuser')->alias('u')->join(['wy_diymen_set'=>'ms',''],'u.token = ms.token','LEFT')->where('u.uid',$aid)->field('u.token,ms.appid,ms.appsecret')->find();
            $json_token = $this->curlPost("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$wxinfo['appid']."&secret=".$wxinfo['appsecret'],[]);
            $access_token = json_decode($json_token,true);
            $access_token = $access_token['access_token'];
            Cache::set("access_token_".$naid,$access_token,6000);
        }
        return $access_token;
    }

    private function curlPost($url,$data){
        $ch = curl_init();
        $header = ["Accept-Charset: utf-8"];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $temp = curl_exec($ch);
        curl_close($ch);
        return $temp;
    }

    private function sendOrderNotice($admin,$orderid,$count,$wecha_id,$songtime,$cartid){
        $inf = Db::table("wy_product_cart")->where('id',$cartid)->find();
        $access_token = $this->getToken($admin);
        $template = [
            'touser'=>$wecha_id,
            'template_id'=>"LHcDyFAfW7rMwu-x_HjsRJ_YxsWx4v7v1O1-eaArgio",
            //'template_id'=>"tkkZJCvVxw8k8OzCRnRlYnWiGw_I-ekWp8444cO5DtU",
            'url'=>"http://wx.quguonet.com/index.php?g=Wap&m=Product&a=orderinfo&token=".$inf['token']."&id=".$cartid."&wecha_id=".$wecha_id,
            'data'=>[
                        'first'=>['value'=>urlencode("您好，您的菜品已到达。收到菜品请及时检查，如菜品有任何问题，12小时内请联系我们（0757-23661177），包退包换，多谢支持！"),'color'=>"#FF0000"],
                        'keyword1'=>['value'=>urlencode($orderid),'color'=>'#FF0000'],
                        'keyword2'=>['value'=>urlencode($count),'color'=>'#FF0000'],
                        'remark'=>['value'=>urlencode('取货时间:'.$songtime),'color'=>'#FF0000'],
                    ]
        ];
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $res = $this->curlPost($url,urldecode($json_template));
        $json = json_decode($res);
        if($json->errcode!=0){
            //短信通知
            $apikey = '9b387e1965c598014e85e8297dbd9c14';
            $tpl_id = 1575000;
            $tpl_value = "#code#=".substr($inf['tel'],-6)."&#time#=".date("Y-m-d H:i:s",$inf['songtime']);
            $res = tpl_send_sms($apikey, $tpl_id, $tpl_value, $inf['tel']);
            if($json->errcode=='40001'){
                Cache::rm("access_token_".$admin);
            }
            file_put_contents('./sendorderlog.txt',$orderid."-".$inf['token']."-".$cartid."-".$res."-".date('Y-m-d H:i:s',time())."\n",FILE_APPEND);
        }
    }*/

    public function appUpdate(){
        $request = Request::instance();
        switch ($this->method) {
            case 'get':
                $result = [];
                $localVersion = trim($request->param('ver'));
                if(!$localVersion){
                    $result = makeResult(-1,"获取本地版本失败");
                    return $this->response($result,'json',200);
                }
                $file = file_get_contents('../AppUpdate/appVersion.json');
                $obj = json_decode($file,true);
                $localVersion = intval(str_replace('.','',$localVersion));
                $serviceVersion = intval(str_replace('.','',$obj['version_code']));
                if($serviceVersion>$localVersion){
                    $result = makeResult(1,"update",$obj);
                    return $this->response($result,'json',200);
                }
                $result = makeResult(0,"none");
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }
}