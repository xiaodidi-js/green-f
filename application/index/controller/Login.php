<?php
namespace app\index\controller;

use think\Request,think\Token;

class Login extends RestBase
{
    public function __construct(){
        //继承父类构造方法
        parent::__construct();
    }

    public function userAction(){
        $request = Request::instance();
        switch($this->method) {
            case 'get':
                //登录操作
                $data = $request->param();
                if(empty($data)){
                    $result = makeResult(0,'登录信息不完整');
                    return $this->response($result,'json',200);
                }else if(empty($data['uname'])||empty($data['upwd'])){
                    $result = makeResult(0,'请填写登录账号和密码');
                    return $this->response($result,'json',200);
                }
                $un = trim($data['uname']);
                $up = trim($data['upwd']);
                $info = db('member')->where('utel',$un)->where('upwd',md5($up))->find();
                if(!$info){
                    $result = makeResult(0,'用户名或密码错误');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$info['id'],'utel'=>$info['utel'],'upwd'=>$info['upwd']]);
                $token_str = $token->makeToken();
                $result = makeResult(1,'登录成功',['id'=>$info['id'],'token'=>$token_str,'time'=>time()]);
                return $this->response($result,'json',200);
                break;
            case 'post':
                //注册操作
                $data = $request->put();
                if(empty($data)){
                    $result = makeResult(0,'注册信息不完整');
                    return $this->response($result,'json',200);
                }
                $validate = validate('Member');
                if(!$validate->scene('register')->check($data)){
                    $result = makeResult(0,$validate->getError());
                    return $this->response($result,'json',200);
                }
                $member_code = db('member_code');
                $codeCheck = $member_code->where('tel',$data['utel'])->where('code',$data['code'])->where('action',1)->where('status',1)->order('time desc')->find();
                if(!$codeCheck){
                    $result = makeResult(0,'验证码错误');
                    return $this->response($result,'json',200);
                }else if((time()-$codeCheck['time'])>1800){
                    $result = makeResult(0,'验证码已过期');
                    return $this->response($result,'json',200);
                }
                $data['uname'] = '用户'.$data['utel'];
                $data['upwd'] = md5($data['upwd']);
                unset($data['cpwd']);
                unset($data['code']);
                $member = db('member');
                $check = $member->where('utel',$data['utel'])->find();
                if($check){
                    $result = makeResult(0,'手机号码已注册');
                    return $this->response($result,'json',200);
                }
                $data['createtime'] = time();
                $add = db('member')->insertGetId($data);
                if(!$add){
                    $result = makeResult(0,'信息提交失败');
                    return $this->response($result,'json',200);
                }
                $member_code->where('id',$codeCheck['id'])->update(['status'=>2]);
                $token = new Token(['id'=>$add,'utel'=>$data['utel'],'upwd'=>$data['upwd']]);
                $token_str = $token->makeToken();
                $result = makeResult(1,'注册成功',['id'=>$add,'token'=>$token_str,'time'=>$data['createtime']]);
                return $this->response($result,'json',200);
                break;
            case 'put':
                //找回密码
                $data = $request->put();
                if(empty($data)){
                    $result = makeResult(0,'提交信息不完整');
                    return $this->response($result,'json',200);
                }
                $member = db('member');
                $validate = validate('Member');
                if(!$validate->scene('register')->check($data)){
                    $result = makeResult(0,$validate->getError());
                    return $this->response($result,'json',200);
                }
                $check = $member->where('utel',$data['utel'])->find();
                $data['upwd'] = md5($data['upwd']);
                if(!$check){
                    $result = makeResult(0,'手机号码未注册');
                    return $this->response($result,'json',200);
                }else if($data['upwd']===$check['upwd']){
                    $result = makeResult(0,'密码没有更改');
                    return $this->response($result,'json',200);
                }
                $member_code = db('member_code');
                $codeCheck = $member_code->where('tel',$data['utel'])->where('code',$data['code'])->where('action',2)->where('status',1)->order('time desc')->find();
                if(!$codeCheck){
                    $result = makeResult(0,'验证码错误');
                    return $this->response($result,'json',200);
                }else if((time()-$codeCheck['time'])>1800){
                    $result = makeResult(0,'验证码已过期');
                    return $this->response($result,'json',200);
                }
                $up = $member->where('id',$check['id'])->update(['upwd'=>$data['upwd']]);
                if(!$up){
                    $result = makeResult(0,'密码修改失败');
                    return $this->response($result,'json',200);
                }
                $member_code->where('id',$codeCheck['id'])->update(['status'=>2]);
                $result = makeResult(1,'密码修改成功');
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    public function userEdit(){
        $request = Request::instance();
        switch($this->method) {
            case 'get':
                $uid = intval($request->param('uid'));
                if(!$uid){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $info = db('member')->where('id',$uid)->field('uname,utel,sex,birthday')->find();
                if(!$info){
                    $result = makeResult(0,'用户信息不存在');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'获取成功',$info);
                return $this->response($result,'json',200);
                break;
            case 'put':
                $data = $request->put();
                $data['id'] = intval($data['id']);
                if(empty($data)){
                    $result = makeResult(0,'提交信息不完整');
                    return $this->response($result,'json',200);
                }else if(!$data['id']){
                    $result = makeResult(0,'参数错误');
                    return $this->response($result,'json',200);
                }
                $member = db('member');
                $check = $member->where('id',$data['id'])->where('utel',$data['utel'])->find();
                if(!$check){
                    $result = makeResult(0,'用户信息不存在');
                    return $this->response($result,'json',200);
                }
                $token = new Token(['id'=>$check['id'],'utel'=>$check['utel'],'upwd'=>$check['upwd']],$data['token']);
                if(!$token||!$token->checkToken()){
                    $result = makeResult(0,'用户验证失败');
                    return $this->response($result,'json',200);
                }
                unset($data['token']);
                $validate = validate('Member');
                $scene = empty($data['upwd']) ? 'edit' : 'editPwd';
                if(!$validate->scene($scene)->check($data)){
                    $result = makeResult(0,$validate->getError());
                    return $this->response($result,'json',200);
                }
                if(!empty($data['opwd'])&&!empty($data['upwd'])){
                    $data['upwd'] = md5($data['upwd']);
                    if(md5($data['opwd'])!=$check['upwd']){
                        $result = makeResult(0,'旧密码不正确');
                        return $this->response($result,'json',200);
                    }else if($data['upwd']==$check['upwd']){
                        $result = makeResult(0,'密码没有更改');
                        return $this->response($result,'json',200);
                    }
                }else{
                    unset($data['upwd']);
                }
                unset($data['opwd']);
                unset($data['cpwd']);
                $up = $member->update($data);
                if(!$up){
                    $result = makeResult(0,'信息修改失败');
                    return $this->response($result,'json',200);
                }
                if(!empty($data['upwd'])){
                    $token->changeData('upwd',$data['upwd']);
                    $token_str = $token->makeToken();
                    $result = makeResult(1,'信息修改成功',['id'=>$data['id'],'token'=>$token_str,'time'=>time()]);
                }else{
                    $result = makeResult(1,'信息修改成功');
                }
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }

    public function getCodeBySms(){
        $request = Request::instance();
        $member_code = db('member_code');
        switch($this->method) {
            case 'post':
                $tel = trim($request->put('tel'));
                if(!$tel){
                    $result = makeResult(0,'请输入您的手机号码');
                    return $this->response($result,'json',200);
                }else if(!preg_match('/^[\d]{9,11}$/',$tel)){
                    $result = makeResult(0,'手机号码格式不正确');
                    return $this->response($result,'json',200);
                }
                $check = $member_code->where('tel',$tel)->where('action',1)->where('status',1)->order('time desc')->find();
                if($check&&(time()-$check['time']<=120)){
                    $result = makeResult(0,'请勿频繁操作');
                    return $this->response($result,'json',200);
                }
                $code = rand(10000,99999);
                $info = sendSms("【绿秧田】您的验证码是".$code,$tel);
                $data = [];
                $data['tel'] = $tel;
                $data['code'] = $code;
                $data['action'] = 1;
                $data['time'] = time();
                if(!$info['status']){
                    $data['status'] = -1;
                    $data['error'] = $info['info'];
                }else{
                    $data['status'] = 1;
                }
                $add = $member_code->insert($data);
                if(!$add){
                    $result = makeResult(0,'验证码发送失败');
                    return $this->response($result,'json',200);
                }
                if(!$info['status']){
                    $result = makeResult(0,'验证码发送失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'发送成功');
                return $this->response($result,'json',200);
                break;
            case 'put':
                $tel = trim($request->put('tel'));
                if(!$tel){
                    $result = makeResult(0,'请输入您的手机号码');
                    return $this->response($result,'json',200);
                }else if(!preg_match('/^[\d]{9,11}$/',$tel)){
                    $result = makeResult(0,'手机号码格式不正确');
                    return $this->response($result,'json',200);
                }
                $check = $member_code->where('tel',$tel)->where('action',2)->where('status',1)->order('time desc')->find();
                if($check&&(time()-$check['time']<=120)){
                    $result = makeResult(0,'请勿频繁操作');
                    return $this->response($result,'json',200);
                }
                $code = rand(10000,99999);
                $info = sendSms("【绿秧田】您的验证码是".$code,$tel);
                $data = [];
                $data['tel'] = $tel;
                $data['code'] = $code;
                $data['action'] = 2;
                $data['time'] = time();
                if(!$info['status']){
                    $data['status'] = -1;
                    $data['error'] = $info['info'];
                }else{
                    $data['status'] = 1;
                }
                $add = $member_code->insert($data);
                if(!$add){
                    $result = makeResult(0,'验证码发送失败');
                    return $this->response($result,'json',200);
                }
                if(!$info['status']){
                    $result = makeResult(0,'验证码发送失败');
                    return $this->response($result,'json',200);
                }
                $result = makeResult(1,'发送成功');
                return $this->response($result,'json',200);
                break;
            default:
                break;
        }
    }
}
