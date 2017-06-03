<?php
namespace app\index\controller;

use think\controller\Rest;
use think\Request;
use think\Token;
class RestBase extends Rest
{
    public $sysinfo;

    public function __construct(){
        //继承父类构造方法
        parent::__construct();
        //设置跨域访问
        $this->sysinfo = getSysInfo();
        // if($this->sysinfo&&$this->sysinfo['cross']&&!empty($this->sysinfo['crossdomain'])){
            //设置允许跨域
            header("Access-Control-Allow-Origin:*");
            header("Access-Control-Allow-Methods:POST,GET,OPTIONS,PUT,DELETE");
            header("Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept");
        // }
    }

	// 检查登陆
    public function checklogin(){
        $request = Request::instance();
		$id = intval($request->param('uid')); //用户id
        $gtoken = trim($request->param('token')); //用户登录成功令牌
        if(!$id||!$gtoken){
            $result = makeResult(-1,'没有用户令牌,登录失败');
            return $this->response($result,'json',200);
        }
        $user = db('member')->where('id',$id)->field('id,utel,upwd')->find();
        if(!$user){
            $result = makeResult(-1,'该用户不存在,登录失败');
            return $this->response($result,'json',200);
        }
        $token = new Token(['id'=>$user['id'],'utel'=>$user['utel'],'upwd'=>$user['upwd']],$gtoken);
        if(!$token||!$token->checkToken()){
            $result = makeResult(-1,'用户令牌不正确,登录失败');
            return $this->response($result,'json',200);
        }
    }
}