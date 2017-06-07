<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // +----------------------------------------------------------------------
    // | 应用设置
    // +----------------------------------------------------------------------

    // 应用命名空间
    'app_namespace'          => 'app',
    // 应用调试模式
    'app_debug'              => true,
    // 应用Trace
    'app_trace'              => false,
    // 应用模式状态
    'app_status'             => '',
    // 是否支持多模块
    'app_multi_module'       => true,
    // 注册的根命名空间
    'root_namespace'         => [

        'addons' => '../addons/'

    ],
    // 扩展配置文件
    'extra_config_list'      => ['database', 'route', 'validate'],
    // 扩展函数文件
    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    // 默认JSONP格式返回的处理方法
    'default_jsonp_handler'  => 'jsonpReturn',
    // 默认JSONP处理方法
    'var_jsonp_handler'      => 'callback',
    // 默认时区
    'default_timezone'       => 'PRC',
    // 是否开启多语言
    'lang_switch_on'         => false,
    // 默认全局过滤方法 用逗号分隔多个
    'default_filter'         => '',
    // 默认语言
    'default_lang'           => 'zh-cn',
    // 是否启用控制器类后缀
    'controller_suffix'      => false,

    // +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------

    // 默认模块名
    'default_module'         => 'admin',
    // 禁止访问模块
    'deny_module_list'       => ['common'],
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    // 默认验证器
    'default_validate'       => '',
    // 默认的空控制器名
    'empty_controller'       => 'Error',
    // 操作方法后缀
    'action_suffix'          => '',
    // 自动搜索控制器
    'controller_auto_search' => false,

    // +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------

    // PATHINFO变量名 用于兼容模式
    'var_pathinfo'           => 's',
    // 兼容PATH_INFO获取
    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],
    // pathinfo分隔符
    'pathinfo_depr'          => '/',
    // URL伪静态后缀
    'url_html_suffix'        => 'html',
    // URL普通方式参数 用于自动生成
    'url_common_param'       => false,
    // URL参数方式 0 按名称成对解析 1 按顺序解析
    'url_param_type'         => 0,
    // 是否开启路由
    'url_route_on'           => true,
    // 是否强制使用路由
    'url_route_must'         => false,
    // 域名部署
    'url_domain_deploy'      => false,
    // 域名根，如.thinkphp.cn
    'url_domain_root'        => '',
    // 是否自动转换URL中的控制器和操作名
    'url_convert'            => true,
    // 默认的访问控制器层
    'url_controller_layer'   => 'controller',
    // 表单请求类型伪装变量
    'var_method'             => '_method',

    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------

    'template'               => [
        // 模板引擎类型 支持 php think 支持扩展
        'type'         => 'Think',
        // 模板路径
        'view_path'    => '',
        // 模板后缀
        'view_suffix'  => 'html',
        // 模板文件名分隔符
        'view_depr'    => DS,
        // 模板引擎普通标签开始标记
        'tpl_begin'    => '{',
        // 模板引擎普通标签结束标记
        'tpl_end'      => '}',
        // 标签库标签开始标记
        'taglib_begin' => '{',
        // 标签库标签结束标记
        'taglib_end'   => '}',
        //模板佈局配置
        'layout_on' => true,
        'layout_name' => '/public/template',
        'layout_item' => '{__HTMLCON__}'
    ],

    // 视图输出字符串内容替换
    'view_replace_str'       => [
        '__STATIC__' => '/public/static',
        '__ROOT__' => '/'
    ],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'    => THINK_PATH . 'tpl' . DS . 'dispatch_jump.tpl',

    // +----------------------------------------------------------------------
    // | 异常及错误设置
    // +----------------------------------------------------------------------

    // 异常页面的模板文件
    'exception_tmpl'         => THINK_PATH . 'tpl' . DS . 'think_exception.tpl',

    // 错误显示信息,非调试模式有效
    'error_message'          => '页面错误！请稍后再试～',
    // 显示错误信息
    'show_error_msg'         => false,
    // 异常处理handle类 留空使用 \think\exception\Handle
    'exception_handle'       => '',

    // +----------------------------------------------------------------------
    // | 日志设置
    // +----------------------------------------------------------------------

    'log'                    => [
        // 日志记录方式，支持 file socket
        'type' => 'File',
        // 日志保存目录
        'path' => LOG_PATH,
    ],

    // +----------------------------------------------------------------------
    // | Trace设置
    // +----------------------------------------------------------------------

    'trace'                  => [
        //支持Html Console
        'type' => 'Html',
    ],

    // +----------------------------------------------------------------------
    // | 缓存设置
    // +----------------------------------------------------------------------

    'cache'                  => [
        // 驱动方式
        'type'   => 'File',
        // 缓存保存目录
        'path'   => CACHE_PATH,
        // 缓存前缀
        'prefix' => '',
        // 缓存有效期 0表示永久缓存
        'expire' => 0,
    ],

    // +----------------------------------------------------------------------
    // | 会话设置
    // +----------------------------------------------------------------------

    'session'                => [
        'id'             => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix'         => 'qgs',
        // 驱动方式 支持redis memcache memcached
        'type'           => '',
        // 是否自动开启 SESSION
        'auto_start'     => true,
    ],

    // +----------------------------------------------------------------------
    // | Cookie设置
    // +----------------------------------------------------------------------
    'cookie'                 => [
        // cookie 名称前缀
        'prefix'    => '',
        // cookie 保存时间
        'expire'    => 0,
        // cookie 保存路径
        'path'      => '/',
        // cookie 有效域名
        'domain'    => '',
        //  cookie 启用安全传输
        'secure'    => false,
        // httponly设置
        'httponly'  => '',
        // 是否使用 setcookie
        'setcookie' => true,
    ],

    //分页配置
    'paginate'               => [
        'type'      => 'bootstrap',
        'var_page'  => 'page',
        'list_rows' => 12,
    ],

    //权限认证配置
    'auth_config'            => [
        'auth_on' => true,
        'auth_type' => 1,
        'auth_group' => 'qgs_auth_group',
        'auth_group_access' => 'qgs_auth_group_access',
        'auth_rule' => 'qgs_auth_rule',
        'auth_user' => 'qgs_members'
    ],

    //钩子类型
    'hooks_type'            => [1=>'视图',2=>'控制器'],
    //插件预览类型
    'codemirror_theme'      => 'ambiance',
    //系统信息文件路径
    'sys_info'              => './sysconfig.php',

    //又拍云配置
    'upyun_config'          => [
        'bucket'          => 'lvyangtian',
        'user'            => 'lvyangtian',
        'pwd'             => 'nba10399',
        'form_api'        => 'amFmx2v2/Giw8ZtUq6M+WERY5Hc=',
        'save_key'        => '/{year}/{mon}/{day}/{hour}/{min}/{sec}/upload_{filemd5}{.suffix}',
        'domain'          => 'https://file.green-f.cn',
        'notify'          => 'http://green-f.cn/public/index/uynotify/getnotify'
    ],

    //短信支付
    'yunpian_config'        => [
        'apikey'            => 'd45401f142ec39543a580be0cc55fcd4',
        'url_single'        => 'https://sms.yunpian.com/v2/sms/single_send.json'
    ],

    //微信浏览器header
    'wxheader'              => 'MicroMessenger',

    //支付异步通知地址
    'notify_url'            => [
        'wechat'          => 'http://green-f.cn/public/index/wxnotify/getwxnotify',
        'alipay'          => ''
    ],

    //验证码配置
    'captcha'  => [
        'seKey' => '',
        // 验证码字符集合
        'codeSet'  => '1234567890', 
        // 验证码字体大小(px)
        'fontSize' => 12, 
        // 是否画混淆曲线
        'useCurve' => false, 
         // 验证码图片高度
        'imageH'   => 30,
        // 验证码图片宽度
        'imageW'   => 100, 
        // 验证码位数
        'length'   => 5, 
        // 验证成功后是否重置        
        'reset'    => true
    ],

    //系统版本
    'app_version'           => '2.0.0',
    'queue' => [
        'type'  => 'Redis',         // Redis 驱动
        'expire'     => 60,             // 任务的过期时间，默认为60秒; 若要禁用，则设置为 null 
        'default'    => 'default',      // 默认的队列名称
        'host'       => '127.0.0.1',    // redis 主机ip
        'port'       => 6379,           // redis 端口
        'password'   => 'iFxjOaKyg5of53uN', // redis 密码
        'select'     => 0,              // 使用哪一个 db，默认为 db0
        'timeout'    => 0,              // redis连接的超时时间
        'persistent' => false,          // 是否是长连接
    ]
];
