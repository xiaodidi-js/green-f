<?php
namespace app\index\controller;

use think\Controller,think\Request;

class Uynotify extends Controller{

	//又拍云回调地址
    public function getNotify(){
        $request = Request::instance();
        if ($request->isPost()) {
            //获取post参数
            $data = $request->post();
            if($data){
                $attachment = [];
                //判断额外参数[操作类型,用户id,渠道]
                if(isset($data['ext-param'])&&!empty($data['ext-param'])){
                    $params = explode(',',$data['ext-param']);
                    $attachment['action'] = $params[0];
                    $attachment['uid'] = $params[1];
                    $attachment['channel'] = $params[2];
                    //其他操作
                    switch($params[0]){
                        case 'himg':
                            //更新头像
                            db('member')->where('id',$params[1])->update(['shotcut'=>config('upyun_config.domain').$data['url']]);
                            break;
                        default:
                            break;
                    }
                }
                $attachment['title'] = isset($params[0]) ? $params[0].date('YmdHis').rand(1000,9999) : 'file'.date('YmdHis').rand(1000,9999);
                $attachment['type'] = isset($data['image-type']) ? $data['image-type'] : 'file';
                $attachment['size'] = $data['file_size'];
                $attachment['url'] = $data['url'];
                $attachment['status'] = 1;
                $attachment['createtime'] = time();
                //更新附件表
                db('attachment')->insert($attachment);
                $result = 'success';
            }else{
                $result = 'fail';
            }
            return $result;
        }
    }

}