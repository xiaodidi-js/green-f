<?php
namespace app\index\controller;

use think\Controller,think\Request;
class Home extends controller
{
	private $appid = 'wxe25cd8399dfb963b';
	private $appsecret = '3f0556d68fc3cc832b59394d5798287e';

	public function __construct(){
		//查询微信公众号信息
		$info = db('profile')->where('id',1)->field('appid,appsecret')->find();
		if($info&&(!$this->appid||!$this->appsecret)){
			$this->appid = $info['appid'];
			$this->appsecret = $info['appsecret'];
		}
	}

	//获取auth授权access_token
	private function get_auth_token($code='') {
        $res = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code');
        $res = json_decode($res, true);
        if(!empty($res['access_token'])&&!empty($res['openid'])){
        	return $res;
        }
        return false;
    }

	//网页授权方法
	public function index(){
		$request = Request::instance();
        $fontBack = urldecode($request->param('back'));
        if($fontBack){
            $fontBack = strpos($fontBack,'?')===false ? $fontBack : strstr($fontBack,'?',true);
            session('fontBack',$fontBack);
        }

		//获取code参数
		$code = trim($request->param('code'));
        $backUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].url('index/home/index'));
        $infoUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$this->appid.'&redirect_uri='.$backUrl.'&response_type=code&scope=snsapi_base&state=qgshop#wechat_redirect';
        if($code){
            $state = trim($request->param('state'));
            if($state!='qgshop'){
                $this->redirect($infoUrl);
                exit;
            }
            $res = $this->get_auth_token($code);
            if($res){
            	//获取成功则跳转至前端首页
                if(session('fontBack')){
                    $this->redirect('http://m.green-f.cn/index_prod.html#!'.session('fontBack').'?opid='.$res['openid'].'&wxtoken='.$res['access_token']);
                }else{
                    $this->redirect('http://m.green-f.cn/index_prod.html#!/index?opid='.$res['openid']);
                }
            	exit;
            }else{
            	$this->redirect($infoUrl);
            	exit;
            }
        }else{
            $this->redirect($infoUrl);
            exit;
        }
	}

    //获取用户信息
    public function get_user_full($openid,$access_token){
        $get_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_URL,$get_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        /*if(!empty($json_obj['errcode'])){
            if($json_obj['errcode'] == 40001){
                Cookie::delete('access_token_'.$this->appid);
                $this->get_user_full($openid);
            }
        }*/
        return $json_obj;
    }

    
}