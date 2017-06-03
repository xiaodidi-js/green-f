<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
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

/**
 * select返回的数组进行整数映射转换
 *
 * @param array $map  映射关系二维数组  array(
 *                                          '字段名1'=>array(映射关系数组),
 *                                          '字段名2'=>array(映射关系数组),
 *                                           ......
 *                                       )
 * @return array
 *
 *  array(
 *      array('id'=>1,'title'=>'标题','status'=>'1','status_text'=>'正常')
 *      ....
 *  )
 *
 */
function int_to_string(&$data,$map=['status'=>[1=>'正常',-1=>'删除',0=>'禁用',2=>'未审核',3=>'草稿']]) {
    if($data === false || $data === null ){
        return $data;
    }
    $data = (array)$data;
    foreach ($data as $key => $row){
        foreach ($map as $col=>$pair){
            if(isset($row[$col]) && isset($pair[$row[$col]])){
                $data[$key][$col.'_text'] = $pair[$row[$col]];
            }
        }
    }
    return $data;
}

/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 返回数组指定列
 * @param $array array 原始数组
 * @param $columns array 要筛选的列
 * @return 包含筛选列的数组 || false
 */
function array_get_columns($array,$columns){
    if(!is_array($array)||count($array)==0){
      return false;
    }else if(!is_array($columns)||count($columns)==0){
      return false;
    }
    $result = [];
    foreach($array as $k=>$v){
      foreach($v as $vk=>$vv){
          if(in_array($vk,$columns)){
            $result[$k][$vk] = $vv;
          }
      }
    }
    if(count($result)>0){
      return $result;
    }
    return false;
}

/**
 * 处理插件钩子
 * @param string $hook   钩子名称
 * @param mixed $params 传入参数
 */
function hook($hook,$params=array()){
    \think\Hook::listen($hook,$params);
}

/**
 * 获取插件类名
 * @param string $name 插件名字标识
 * @return string
 *
 */
function get_addon_class($name){
  $class = "addons\\".strtolower($name)."\\$name";
  return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name){
    $class = get_addon_class($name);
    if(class_exists($class)) {
        $addon = new $class();
        return $addon->getConfig();
    }else {
        return array();
    }
}

//基于数组创建目录和文件
function create_dir_or_files($files){
    foreach ($files as $key => $value) {
        if(substr($value, -1) == '/'){
            mkdir($value);
        }else{
            @file_put_contents($value, '');
        }
    }
}

//curlPost
function curlPost($data, $url, $second = 30, $header=[]){
    $ch = curl_init();
    //设置超时
    curl_setopt($ch, CURLOPT_TIMEOUT, $second);

    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
    //设置header
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    if(is_array($header)&&count($header)>0){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    //要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    //post提交方式
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //运行curl
    $res = curl_exec($ch);
    //返回结果
    curl_close($ch);
    if($res){
        return $res;
    }else{
        return false;
    }
}

//curlGet
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $temp = curl_exec($ch);
    return $temp;
}

//获取系统配置信息
function getSysInfo(){
    $file = config('sys_info');
    if(!file_exists($file)||!is_readable($file)){
        return ['sitename'=>'','seoname'=>'','keywords'=>'','description'=>'','masteremail'=>'','copyright'=>'','cross'=>0,'crossdomain'=>'','default_copyright'=>'Copyright © 2014-2015 Quguo Co.Ltd. All rights reserved.'];
    }
    $config = file_get_contents($file);
    return json_decode($config,true);
}

//组合返回信息
function makeResult($status=0,$info='',$others=[]){
    $base = ['status'=>$status,'info'=>$info];
    if(is_array($others)&&count($others)>0){
        $base = array_merge($base,$others);
    }
    return $base;
}

//发送短信
function sendSms($text='',$tel=''){
    $result = [];
    if(empty($text)){
        $result = makeResult(0,'未提供短信内容');
        return $result;
    }else if(empty($tel)){
        $result = makeResult(0,'未提供接收号码');
        return $result;
    }
    $data = ['apikey'=>config('yunpian_config.apikey'),'mobile'=>$tel,'text'=>$text];
    $header = ['Content-Type:application/x-www-form-urlencoded;charset=utf-8','Accept:application/json'];
    $data = http_build_query($data);
    $info = curlPost($data,config('yunpian_config.url_single'),30,$header);
    $info = json_decode($info,true);
    if(!$info||$info['code']!=0){
        $result = makeResult(0,$info['msg']);
    }else{
        $result = makeResult(1,$info['msg']);
    }
    return $result;
}

//判断wechat版本号是否大于5.0
function judgeWechatVersion($header=''){
    if(empty($header)){
        return false;
    }
    $info = explode(config('wxheader').'/',$header);
    if(count($info)<=1){
        return false;
    }
    $code = str_replace('.','',substr($info[1],0,5));
    if($code>500){
        return true;
    }
    return false;
}

/**
 * json返回
 * @param  [type] $status [description]
 * @param  [type] $data   [description]
 * @param  string $url    [description]
 * @return [type]         [description]
 */
function make_json($status, $data , $url = ''){
    $arr['status'] =$status;
    $arr['msg'] = $data;
    $arr['url'] = $url;
    echo json_encode($arr);
    die;
}
