<?php
ini_set("display_errors", "OFF");
session_start();
//将部署KEY填写在api_key.txt文件内
$API_FILE = 'api_key.txt';
$myfile = fopen($API_FILE, "r") or die('缺少api_key!');

$key = fread($myfile,filesize($API_FILE));
fclose($myfile);
if (!$key) {
    die('缺少api_key!');
}
define('APIKEY', trim($key));
define('API_URL', 'http://task.quguonet.com/Home/Index/index');

$data = $_GET;

if ($data['action'] != 'webhook') {
	check_sign($data);
} else { //webhook

	$result = curlPost(API_URL, array('key'=>APIKEY));
	$result = json_decode($result, true);
	if ($result['status'] == 0) {
		$arr['status'] = 0;
		$arr['msg'] = '缺少key';
		json($arr);
	}

	if ($result['type'] == 1) {
		$arr['status'] = 0;
		$arr['msg'] = '处于生产环境中';
		json($arr);
	}

	if ($result['type'] == 2 && !$result['ref']) {
		$arr['status'] = 0;
		$arr['msg'] = '未设置开发环境的分支';
		json($arr);
	} elseif ($result['type'] == 2 && $result['ref']) {
		$requestBody = file_get_contents("php://input");
		if (empty($requestBody)) {
		    die('send fail');
		}
		file_put_contents('webhook.txt', 'coding数据：'. $requestBody."\n", FILE_APPEND);
		$ref_conf = $result['ref'];
		$data = json_decode($requestBody, true);
		$token = $data['token'];
		if ($token != APIKEY) {
			file_put_contents('webhook.txt', 'token不匹配'."\n", FILE_APPEND);
			exit();
		}
		$ref = $data['ref'];
		if (!strstr($ref, $ref_conf)) {
			file_put_contents('webhook.txt', '分支不匹配（'.$ref.','.$ref_conf.')'."\n", FILE_APPEND);
			exit();
		}
		$commit = 'sudo /usr/bin/git checkout -- .';
		exec($commit);
		$commit = 'sudo /usr/bin/git pull';
		exec($commit);
		$commit = 'sudo /usr/bin/git checkout -b '. $ref_conf .' remotes/origin/'.$ref_conf;
		exec($commit);
		$commit = 'sudo /usr/bin/git checkout '.$ref_conf;
		exec($commit);
		exit();
	}

	//coding发过的数据格式
	//$str = '{"ref":"refs/heads/feature/限时限购","before":"eb5360ead420ce1031377b59b7928542b8016c73","commits":[{"committer":{"name":"helo","email":"758861884@qq.com"},"web_url":"https://coding.net/t/quguonet/p/wxquguo/git/commit/5e3cc68369aea6e8719854ba9336ec728f74d59e","short_message":"update README.md\n","sha":"5e3cc68369aea6e8719854ba9336ec728f74d59e"}],"after":"5e3cc68369aea6e8719854ba9336ec728f74d59e","event":"push","repository":{"owner":{"path":"/u/quguo","web_url":"https://coding.net/u/quguo","global_key":"quguo","name":"quguo","avatar":"https://dn-coding-net-production-static.qbox.me/ac5e5b9c-4fe6-47e8-8146-304e1ae3ca29.jpg?imageMogr2/auto-orient/format/jpeg/crop/!500x500a0a0"},"https_url":"https://git.coding.net/quguonet/wxquguo.git","web_url":"https://coding.net/t/quguonet/p/wxquguo","project_id":"248515","ssh_url":"git@git.coding.net:quguonet/wxquguo.git","name":"wxquguo","description":"wxquguo"},"user":{"path":"/u/hee93","web_url":"https://coding.net/u/hee93","global_key":"hee93","name":"helo","avatar":"/static/fruit_avatar/Fruit-13.png"},"token":"asdf"}';
}

switch ($data['action']) {
	case 'get_access_token':
		check_code($data);
		break;

	case 'fetch_tags':
		fetch_tags();
		break;

	case 'check_out':
		check_out($data);
		break;

	case 'rollback':
		rollback();
		break;

	case 'changeMaster':
		changeMaster();
		break;
}

function curlPost($url, $data){
    $ch = curl_init();
    $header = "Accept-Charset: utf-8";
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

function check_sign($data = array()){
	if ($data['action'] != 'get_access_token') {
		if (!$data['access_token']) {
			$arr['status'] = 1;
			$arr['msg'] = 'access_token 缺少';
			json($arr);
		}
		if ($_SESSION['sign']) {
			if ($data['access_token'] != $_SESSION['sign']) {
				$arr['status'] = 1;
				$arr['msg'] = 'access_token 失效';
				json($arr);
			}
		}
	}
}


//检查key是否过期
function check_code($data = array()){
	if (time() > $_SESSION['sign_time']) {
		$sign = md5(APIKEY);
		if ($data['code'] != $sign) {
			$arr['status'] = 1;
			$arr['msg'] = '验证失败';
			json($arr);
		}
		$sign = get_access_token();
	} else {
		$sign = $_SESSION['sign'];
	}
	$arr['status'] = 0;
	$arr['access_token'] = $sign;
	json($arr);
}

//生成用户操作密钥
function get_access_token(){
	$str = '01234567890QWERASDFZXCVTYGHBNUJMIKOLP';
	$access_token = '';
	for ($i=0;$i<32;$i++) {
		$access_token.=$str[mt_rand(0,strlen($str)-1)];
	}
	$_SESSION['sign'] = $access_token;
	$_SESSION['sign_time'] = time() + 10;
	return $access_token;
}

function do_commit($commit = ''){
	exec($commit, $info);
	return $info;
}

function json($value = ''){
	$value = json_encode($value);
	echo 'jsonpCallback('.$value.')';
	exit();
}

function fetch_tags(){
	$commit = 'sudo /usr/bin/git pull';
	$result = do_commit($commit);
	$arr['status'] = $result;
	$arr['tags'] = list_tags();
	$arr['branch'] = get_branch();
	$arr['branch_status'] = get_status();
	json($arr);
}

function list_tags(){
	$commit = '/usr/bin/git tag -l --sort=-v:refname';
	$result = do_commit($commit);
	$arr = array();
	foreach($result as $v){
		$tags = explode(' ', $v);
		foreach($tags as $v){
			if ($v) {
				$arr[] = $v;
			}
		}
	}
	return $arr;
}

function check_out($data = array()){

	if (!$data['v']) {
		exit();
	}
	$commit = "/usr/bin/git checkout ".$data['v'];
    $result = do_commit($commit);
	$arr['status'] = 0;
	$arr['type'] = 1;
	$arr['msg'] = '已成功执行操作';
	json($arr);
}

function get_branch(){
	$commit = '/usr/bin/git branch';
	$result = do_commit($commit);
	return $result;
}

function get_status(){
	$commit = '/usr/bin/git status';
	$result = do_commit($commit);
	return $result;
}

function get_status_v(){
	$commit = '/usr/bin/git status -v';
	$result = do_commit($commit);
	return $result;
}

function rollback(){
	$commit = '/usr/bin/git checkout -- .';
	$result = do_commit($commit);
	$arr['status'] = 0;
	$arr['type'] = 1;
	$arr['msg'] = '清除成功, 请刷新页面再操作'.$result;
	json($arr);
}

function changeMaster(){
	$commit = '/usr/bin/git checkout master';
	$result = do_commit($commit);
	$arr['status'] = 0;
	$arr['type'] = 1;
	$arr['msg'] = '操作成功, 请刷新页面再操作';
	json($arr);
}

?>
