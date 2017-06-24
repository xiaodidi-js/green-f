<?php

namespace app\index\controller;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use think\Request,think\Db;
use think\Cache;
// define('TOKEN', 'lvyangtian');
class Autoreply extends RestBase{

	// 获取微信数据
	public function checktoken(){
		$options = [
		    'debug'  => true,
		    'app_id' => 'wxe25cd8399dfb963b',
		    'secret' => '3f0556d68fc3cc832b59394d5798287e',
		    'token'  => 'lvyangtian',
		    // 'aes_key' => null, // 可选
		    'log' => [
		        'level' => 'debug',
		        'file'  => '.\logs\test.log', // XXX: 绝对路径！！！！
		    ],
		    //...
		];
		$app = new Application($options);

		$server = $app->server;
		$server->setMessageHandler(function ($message) {
			db('notice')->insert(['content'=>json_encode($message)]);
			/*if($message->MsgType == 'event'){
				if($message->Event == 'subscribe'){
					$content = new News([
				        'title'       => '欢迎关注绿秧田微信公众账号',
				        'description' => '绿秧田商城,每日新鲜到货',
				        'url'         => 'http://m.green-f.cn/index_prod.html',
				        'image'       => 'https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1497870530248&di=0bc034e63cc937072be2bbe7443439dc&imgtype=0&src=http%3A%2F%2Fimg.taopic.com%2Fuploads%2Fallimg%2F140127%2F318754-14012G0064721.jpg',
				    ]);
				}
			}else*/
			if($message->MsgType == 'text'){
				$text = $message->Content;
				$where['name'] = array('like','%'.$text.'%');
				$where['gift'] = 0;
				$where['is_sell'] = 1;
				$where['qrcode'] = 0;
				$where['is_del'] = 0;
				$queryshop = db('product')->where($where)->field('id,description,shotcut,name')->find();
				if($queryshop){
					$content = new News([
				        'title'       => $queryshop['name'],
				        'description' => $queryshop['description'],
				        'url'         => 'http://m.green-f.cn/index_prod.html#!/detail/'.$queryshop['id'],
				        'image'       => $queryshop['shotcut'],
				    ]);
				}else{
					$content = new Text(['content' => '您好!你的消息已收到,如有需要请联系客服020-39007485']);
				}
			}
			
		    return $content;
		});
		$response = $app->server->serve();
		// 将响应输出
		$response->send(); 
	}

}
