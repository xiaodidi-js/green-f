<?php
namespace app\admin\controller;
use think\Cache;
use think\Controller;
use think\Cookie;
class Weixin extends Controller
{
	public function wx_get_token($appid,$secret) {
		$info = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();
        $token = Cache::get('access_token');
        if (!$token) {
            $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$info['appid'].'&secret='.,$info['appsecret']);
            $res = json_decode($res, true);
            $token = $res['access_token'];
            // 注意：这里需要将获取到的token缓存起来（或写到数据库中）
            // 不能频繁的访问https://api.weixin.qq.com/cgi-bin/token ，每日有次数限制
            // 通过此接口返回的token的有效期目前为2小时。令牌失效后，JS-SDK也就不能用了。
            // 因此，这里将token值缓存1小时，比2小时小。缓存失效后，再从接口获取新的token，这样
            // 就可以避免token失效。
            $expires = $res['expires_in']-600;
            Cache::set('access_token',$token,$expires);
        }
        return $token;
    }

    // 到货通知
    public function daohuonotice(){
    	$access_token = $this->wx_get_token($info['appid'],$info['appsecret']);
    }
}