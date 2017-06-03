<?php

namespace addons\TestRun;
use app\common\controller\Addons;

/**
 * 测试插件运行插件
 * @author samhong
 */

    class TestRun extends Addons{

        public $info = array(
            'name'=>'TestRun',
            'title'=>'测试插件运行',
            'description'=>'测试插件运行.',
            'status'=>1,
            'author'=>'samhong',
            'version'=>'0.1'
        );

        public $hooks = ["app_inint"];
        

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

		//实现的app_inint钩子方法
        public function app_begin($param){
            //dump('run success');
        }


    }