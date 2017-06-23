<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
// 定义插件目录
define('ADDON_PATH',__DIR__. '/../addons/');
//定义拓展目录
define('EXTEND_PATH',__DIR__. '/../extend/');
//定义资源目录
define('STATIC_PATH',__DIR__. '/static/');
// 开启系统行为
define('APP_HOOK',true);
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
