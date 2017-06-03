<?php
namespace app\index\controller;
use think\Cache;
use think\Controller;
use think\Cookie;
class Weixin extends Controller
{
    protected function _initialize() {
        $profile = db('profile')->where('id',1)->field('appid,appsecret')->find();
        $this->appid = $profile['appid'];
        $this->appsecret = $profile['appsecret'];
    }

    public function callback(){
        $code = $this->request->param('code');
        $json_obj = self::getOpenid($code);
        if($openid = $json_obj['openid']) {
            Cookie::set('openid',$openid);
            // $data['openid'] = $openid;
            // $add = db('openid')->insert($data);
            $result = makeResult(1,'ok',['openid'=>$openid]);
            return $result;
        }else{
            $result = makeResult(0,'获取不到微信id,请联系客服');
            return $result;
        }
        // header("Location: http://tixiao.quguonet.com/vue");
        // exit();
        
    }


    private function getOpenid($code = 0){
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appid.'&secret='.$this->appsecret.'&code='.$code.'&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_URL,$get_token_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        return $json_obj;
    }

    //获取用户信息
    public function get_user_full($openid){
        $access_token = $this->wx_get_token();
        $get_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$access_token.'&openid='.$openid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_URL,$get_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        if(!empty($json_obj['errcode'])){
            if($json_obj['errcode'] == 40001){
                Cookie::delete('access_token_'.$this->appid);
                $this->get_user_full($openid);
            }
        }
    //fileappend('test'.$res,'test.txt');
        return $json_obj;
    }

    //验证token是否失效
    private function testToken($token){
        $get_url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid=o-gwAj3XzCGE6vEqu-RS6QM3N3BA';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_URL,$get_url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $json_obj = json_decode($res,true);
        if(!array_key_exists('subscribe',$json_obj)){
            Cache::rm('access_token_'.$this->appid);
            $token = $this->wx_get_token();
        }
        return $token;
    }

    public function wx_get_token() {
        $access_token =  Cache::get('access_token_'.$this->appid);

        if (!$access_token) {
            $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret);
            $res = json_decode($res, true);
            $access_token = $res['access_token'];
            Cache::set('access_token_'.$this->appid,$access_token,3600);
        }
        $access_token = $this->testToken($access_token);
        return $access_token;
    }

    public function check_token($res){
        $arr = json_decode($res);
        if($arr['errcode'] == 40001){
            $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appsecret);
            $res = json_decode($res, true);
            Cache::set('access_token_'.$this->appid,$res['access_token'],3600);
        }
    }

    public function wx_get_jsapi_ticket(){

        $ticket = "";
        do{
            $ticket =  Cache::get('wx_ticket_'.$this->appid);
            if (!empty($ticket)) {
                break;
            }
            $access_token = $this->wx_get_token();
            $url2 = sprintf("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi",
                $access_token);

            $res = file_get_contents($url2);
            $res = json_decode($res, true);
            $ticket = $res['ticket'];
            Cache::set('wx_ticket_'.$this->appid,$ticket,3600);
        }while(0);

        return $ticket;
    }
}