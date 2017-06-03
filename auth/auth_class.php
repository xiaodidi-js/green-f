<?php

final class Auth{

	private $domain = '';
	private $uname = '';
	const db = 'vue';
	const prefix = 'shop_';

	public function __construct($domain = '',$uname = ''){
		$this->domain = $domain;
		$this->uname = $uname;
	}

	private final function get_client_ip($type = 0){
		$type       =  $type ? 1 : 0;
	    static $ip  =   NULL;
	    if ($ip !== NULL) return $ip[$type];
	    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	        $pos    =   array_search('unknown',$arr);
	        if(false !== $pos) unset($arr[$pos]);
	        $ip     =   trim($arr[0]);
	    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
	        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
	    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
	        $ip     =   $_SERVER['REMOTE_ADDR'];
	    }
	    // IP地址合法验证
	    $long = sprintf("%u",ip2long($ip));
	    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
	    return $ip[$type];
	}

	public function authInfo(){
		//链接数据库
		$conn = mysql_connect('localhost','vue','a123qwe');
		if(!$conn){
			$result = array('error'=>1,'info'=>mysql_error());
			mysql_close();
			echo json_encode($result);
			exit;
		}
		mysql_select_db(self::db,$conn);
		mysql_query("SET NAMES UTF8");

		//获取最新授权接口信息
		$query_api = "SELECT * FROM ".self::prefix."new_api LIMIT 1";
		$result_api = mysql_query($query_api);
		$row_api = mysql_fetch_array($result_api);
		if(!$row_api)
			$row_api['api'] = '';

		//获取用户的ip地址
		$uip = $this->get_client_ip();

		//获取授权信息
		$query_info = "SELECT * FROM ".self::prefix."authencation WHERE domain = '".$this->domain."' LIMIT 1";
		$result_info = mysql_query($query_info);
		$row_info = mysql_fetch_array($result_info);
		$nowtime = time();
		if(!$row_info){
			$query_update = "INSERT INTO ".self::prefix."authencation (uname,domain,ip,status,createtime,updatetime) VALUES ('".$this->uname."','".$this->domain."','".$uip."',1,".$nowtime.",".$nowtime.")";
			$query_result = mysql_query($query_update);
			//判断授权
			if($query_result===false){
				$result = array('error'=>1,'info'=>'域名获取失败');
			}else{
				$content = array('uname'=>$this->uname,'domain'=>$this->domain,'createtime'=>$nowtime,'updatetime'=>$nowtime,'new_api'=>$row_api['api']);
				$result = array('error'=>0,'info'=>'域名获取正常','content'=>$content);
			}
		}else{
			if($uip!=$row_info['ip']){
				$query_update = "UPDATE ".self::prefix."authencation SET uname = '".$this->uname."',ip = '".$uip."',updatetime = ".$nowtime." WHERE id = ".$row_info['id'];
			}else{
				$query_update = "UPDATE ".self::prefix."authencation SET uname = '".$this->uname."',updatetime = ".$nowtime." WHERE id = ".$row_info['id'];
			}
			$query_result = mysql_query($query_update);
			//判断授权
			if($query_result===false){
				$result = array('error'=>1,'info'=>'域名获取失败');
			}else{
				$content = array('uname'=>$row_info['uname'],'domain'=>$row_info['domain'],'createtime'=>$row_info['createtime'],'updatetime'=>$row_info['updatetime'],'new_api'=>$row_api['api']);
				$result = array('error'=>0,'info'=>'域名获取正常','content'=>$content);
			}
		}

		mysql_close();
		return json_encode($result);
	}

}