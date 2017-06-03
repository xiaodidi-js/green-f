<?php

namespace app\admin\controller;

use think\Controller,think\Hook,think\Loader,think\Config;

class Addons extends Base{

	public function index(){
		$list = model('Addons')->getList();
		$Page = new \think\Page(count($list),config('paginate.list_rows'));
		$list = array_slice($list,$Page->firstRow,$Page->listRows);
		$show = $Page->show();
		$this->assign('list',$list);
		$this->assign('page',$show);
		return $this->fetch('index');
	}

	/**
	 * 插件安装
	 * @param $name 插件名称
	 */
	public function installAddon($name){
		$addon_name = trim($name);
		if(empty($addon_name)){
			$result = ['status'=>0,'info'=>'参数错误'];
			return $result;
		}
		$class = get_addon_class($addon_name);
		if(!class_exists($class)){
			$result = ['status'=>0,'info'=>'插件不存在'];
			return $result;
		}
		$addon = new $class();
		$info = isset($addon->info) ? $addon->info : '';
		if(!$info||!$addon->checkInfo()){
			$result = ['status'=>0,'info'=>'插件信息缺失'];
			return $result;
		}
		session('addons_install_error',null);
        $install_flag = $addon->install();
        if(!$install_flag){
            $result = ['status'=>0,'info'=>'执行插件预安装操作失败'.session('addons_install_error')];
			return $result;
        }
        $addon_model = model('Addons');
        if(file_exists(ADDON_PATH.$addon_name.'/config.php')){
        	$info['config'] = json_encode($addon->getConfig());
        }else{
        	$info['config'] = null;
        }
        $addon_model->data($info);
        if(is_array($addon->admin_list)&&$addon->admin_list!==array()){
        	$addon_model->has_adminlist = 1;
        }else{
        	$addon_model->has_adminlist = 0;
        }
        if($addon_model->allowField(true)->save()){
        	$mount_hooks = isset($addon->hooks) ? $addon->hooks : [];
        	$hook_update = $this->mountAddon($addon_name,$mount_hooks);
        	if($hook_update){
        		cache('hooks',null);
        		$result = ['status'=>1,'info'=>'插件安装成功'];
        	}else{
        		$result = ['status'=>0,'info'=>'钩子更新失败,请卸载插件后重试'];
        	}
        }else{
        	$result = ['status'=>0,'info'=>'插件数据写入失败'];
        }
        return $result;
	}

	/**
	 * 插件卸载
	 */
	public function uninstallAddon(){
		$id = intval($this->request->get('id'));
		if(!$id){
			$result = ['status'=>0,'info'=>'参数错误'];
			return $result;
		}
		$addon_db = db('addons');
		$info = $addon_db->where('id',$id)->find();
		$class = get_addon_class($info['name']);
		if(!$info||!class_exists($class)){
			$result = ['status'=>0,'info'=>'插件不存在'];
			return $result;
		}
		session('addons_uninstall_error',null);
        $addon = new $class();
        $uninstall_flag = $addon->uninstall();
        if(!$uninstall_flag){
            $result = ['status'=>0,'info'=>'执行插件预卸载操作失败'.session('addons_uninstall_error')];
			return $result;
        }
        $del = $addon_db->delete($id);
        if($del){
        	cache('hooks',null);
        	$mount_hooks = isset($addon->hooks) ? $addon->hooks : [];
        	$hook_del = $this->remountAddon($info['name'],$mount_hooks);
        	if($hook_del){
        		$result = ['status'=>1,'info'=>'插件卸载成功'];
        	}else{
        		$result = ['status'=>0,'info'=>'卸载插件所挂载的钩子数据失败'];
        	}
        	$result = ['status'=>1,'info'=>'插件卸载成功'];
        }else{
        	$result = ['status'=>0,'info'=>'插件卸载失败'];
        }
        return $result;
	}

	/**
	 * 启用插件
	 */
	public function enable($id){
		$id = intval($this->request->get('id'));
		if(!$id){
			$result = ['status'=>0,'info'=>'参数错误'];
			return $result;
		}
		$up = db('addons')->where('id',$id)->update(['status'=>1]);
		if($up){
			$result = ['status'=>1,'info'=>'插件启用成功'];
		}else{
			$result = ['status'=>1,'info'=>'插件启用失败'];
		}
		return $result;
	}

	/**
	 * 禁用插件
	 */
	public function disable($id){
		$id = intval($this->request->get('id'));
		if(!$id){
			$result = ['status'=>0,'info'=>'参数错误'];
			return $result;
		}
		$up = db('addons')->where('id',$id)->update(['status'=>0]);
		if($up){
			$result = ['status'=>1,'info'=>'插件禁用成功'];
		}else{
			$result = ['status'=>1,'info'=>'插件禁用失败'];
		}
		return $result;
	}

	/**
	 * 配置插件
	 * @param $id 插件id
	 */
	public function configAddon($id){
		$id = (int)$id;
		if(!$id)
			$this->error('参数错误');
		$addon = db('addons')->where('id',$id)->find();
		if(!$addon)
			$this->error('插件还没有安装');
		$class_name = get_addon_class($addon['name']);
		if(!class_exists($class_name))
			$this->error('插件实例化失败');
		$class = new $class_name();
		if(!$addon['config']){
			$this->error('插件没有配置');
		}else{
			$addon['config'] = include ADDON_PATH.$addon['name']."/config.php";
			$base = [];
			$group = [];
			foreach($addon['config'] as $k=>$v){
				if($v['type']!='group'){
					$base[$k] = $v;
				}else{
					$group[$k] = $v;
				}
			}
			$addon['config'] = array_merge($base,$group);
		}
		$this->assign('data',$addon);
		$custom_config = isset($class->custom_config) ? $class->custom_config : '';
		if($custom_config){
			return $this->fetch(ADDON_PATH.$addon['name'].'/'.$custom_config);
		}
		return $this->fetch('config');
	}

	/**
	 * 保存配置
	 * @param $data POST的配置数组
	 */
	public function saveConfig(){
		$data = $this->request->post();
		if(!$data){
			$result = ['status'=>0,'info'=>'未提交信息'];
			return $result;
		}
		$info = db('addons')->where('id',$data['id'])->find();
		if(!$info){
			$result = ['status'=>0,'info'=>'插件还没有安装'];
			return $result;
		}
		$config_path = ADDON_PATH.$info['name'].'/config.php';
		if(!file_exists($config_path)){
			$result = ['status'=>0,'info'=>'配置文件不存在'];
			return $result;
		}
		$config = include $config_path;
		$original = $config;
		if(!is_array($config)||count($config)==0){
			$result = ['status'=>0,'info'=>'配置文件格式不正确'];
			return $result;
		}
		foreach($config as $k => $v){
			if($v['type']!='group'){
				$config[$k]['value'] = $data[$k];
			}else{
				foreach($v['options'] as $ok => $ov){
					foreach($ov['options'] as $ook => $oov){
						$config[$k]['options'][$ok]['options'][$ook]['value'] = $data[$ook];
					}
				}
			}
		}
		$str_arr = "<?php\nreturn ".var_export($config,true).';';
		if(file_put_contents($config_path,$str_arr)){
			db('addons')->update(['id'=>$data['id'],'config'=>json_encode($data)]);
			$result = ['status'=>1,'info'=>'配置修改成功'];
		}else{
			$result = ['status'=>0,'info'=>'配置修改失败'];
		}
		return $result;
	}

	/**
	 * 添加插件
	 */
	public function makeAddon(){
		$request = request();
		if($request->isAjax()&&$request->isPost()){
			return $result;
		}
		if(!is_writable(ADDON_PATH))
            $this->error('您没有创建目录写入权限，无法使用此功能');
		$hooks = db('hooks')->order('id desc')->select();
		$this->assign('hooks',$hooks);
		return $this->fetch('make_addon');
	}

	/**
	 * 预览插件
	 */
	public function preview(){
		$data                   =   $this->request->post();
        $data['status'] =   (int)$data['status'];
        $extend                 =   array();
        $custom_config          =   trim($data['custom_config']);
        if($data['has_config'] && $custom_config){
            $custom_config = <<<str

        public \$custom_config = "$custom_config";

str;
            $extend[] = $custom_config;
        }

        $admin_list = trim($data['admin_list']);
        if($data['has_adminlist'] && $admin_list){
            $admin_list = <<<str

        public \$admin_list = array(
            {$admin_list}
        );

str;
           $extend[] = $admin_list;
        }

        $custom_adminlist = trim($data['custom_adminlist']);
        if($data['has_adminlist'] && $custom_adminlist){
            $custom_adminlist = <<<str

        public \$custom_adminlist = "$custom_adminlist";
str;
            $extend[] = $custom_adminlist;
        }

        $extend = implode('', $extend);
        $hook = '';
        $hksarr = '';
        if(isset($data['hook'])){
        	$hksarr = 'public $hooks = [';
        	foreach ($data['hook'] as $value) {
        		$hksarr .= '"'.$value.'",';
            	$hook .= <<<str
		//实现的{$value}钩子方法
        public function {$value}(\$param){

        }


str;
        	}
        	$hksarr = rtrim($hksarr,",").'];';
        }
        $tpl = <<<str
<?php

namespace addons\\{$data['name']};
use app\common\controller\Addons;

/**
 * {$data['title']}插件
 * @author {$data['author']}
 */

    class {$data['name']} extends Addons{

        public \$info = array(
            'name'=>'{$data['name']}',
            'title'=>'{$data['title']}',
            'description'=>'{$data['description']}',
            'status'=>{$data['status']},
            'author'=>'{$data['author']}',
            'version'=>'{$data['version']}'
        );

        {$hksarr}
        {$extend}

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

{$hook}
    }
str;

            return $tpl;
	}

	/**
	 * 构建插件文件
	 */
    public function build(){
        $data           =   $this->request->post();
        $data['name']   =   trim($data['name']);
        $addons_dir     =   ADDON_PATH;
        //构建插件文件前检测
        if(!$data['name']){
            $result = ['status'=>0,'info'=>'插件标识不能为空'];
            return $result;
        }
        if(file_exists("{$addons_dir}{$data['name']}")){
            $result = ['status'=>0,'info'=>'插件已经存在了'];
            return $result;
        }
        $addonFile              =   $this->preview();
        //创建目录结构
        $files          =   array();
        $addon_dir      =   "{$addons_dir}{$data['name']}/";
        $files[]        =   $addon_dir;
        $addon_name     =   "{$data['name']}.php";
        $files[]        =   "{$addon_dir}{$addon_name}";
        if($data['has_config'] == 1)//如果有配置文件
            $files[]    =   $addon_dir.'config.php';

        if($data['has_outurl']){
            $files[]    =   "{$addon_dir}controller/";
            $files[]    =   "{$addon_dir}controller/{$data['name']}.php";
            $files[]    =   "{$addon_dir}model/";
            $files[]    =   "{$addon_dir}model/{$data['name']}.php";
        }
        $custom_config  =   trim($data['custom_config']);
        if($custom_config)
            $data[]     =   "{$addon_dir}{$custom_config}";

        $custom_adminlist = trim($data['custom_adminlist']);
        if($custom_adminlist)
            $data[]     =   "{$addon_dir}{$custom_adminlist}";

        create_dir_or_files($files);

        //写文件
        file_put_contents("{$addon_dir}{$addon_name}", $addonFile);
        if($data['has_outurl']){
            $addonController = <<<str
<?php

namespace addons\\{$data['name']}\controller;
use app\index\controller\Addons;

class {$data['name']} extends Addons{

}

str;
            file_put_contents("{$addon_dir}controller/{$data['name']}.php", $addonController);
            $addonModel = <<<str
<?php

namespace addons\\{$data['name']}\model;
use think\Model;

/**
 * {$data['name']}模型
 */
class {$data['name']} extends Model{

}

str;
            file_put_contents("{$addon_dir}model/{$data['name']}.php", $addonModel);
        }

        if($data['has_config'] == 1)
            file_put_contents("{$addon_dir}config.php", $data['config']);

        $result = ['status'=>1,'info'=>'创建成功'];
        return $result;
    }


	/**
	 * 钩子管理
	 */
	public function hooks(){
		$list = model('Hooks')->paginate();
		$hooks_type = config('hooks_type');
		$this->assign('list',$list);
		$this->assign('type',$hooks_type);
		return $this->fetch('hooks');
	}

	/**
	 * 添加钩子
	 */
	public function addHooks(){
		$request = request();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result = ['status'=>0,'info'=>'未提交信息'];
				return $result;
			}
			$hooks = model('Hooks');
			$add = $hooks->validate(true)->save($data);
			if($add===false){
				$result = ['status'=>0,'info'=>$hooks->getError()];
			}else{
				$result = ['status'=>1,'info'=>'钩子添加成功'];
			}
			return $result;
		}
		$hooks_type = config('hooks_type');
		$this->assign('type',$hooks_type);
		return $this->fetch('add_hooks');
	}

	/**
	 * 编辑钩子
	 */
	public function editHooks(){
		$request = request();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result = ['status'=>0,'info'=>'未提交信息'];
				return $result;
			}
			$id = $data['id'];
			unset($data['id']);
            $hooks = model('Hooks');
			$add = $hooks->validate(true)->save($data,['id'=>$id]);
			if($add===false){
				$result = ['status'=>0,'info'=>$hooks->getError()];
			}else{
				$result = ['status'=>1,'info'=>'钩子修改成功'];
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = db('hooks')->where('id',$id)->find();
		$hooks_type = config('hooks_type');
		$this->assign('info',$info);
		$this->assign('type',$hooks_type);
		return $this->fetch('edit_hooks');
	}

	/**
	 * 删除钩子
	 */
	public function delHooks(){
		$request = request();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result = ['status'=>0,'info'=>'参数错误'];
				return $result;
			}
			$del = db('hooks')->delete($id);
			if($del){
				$result = ['status'=>1,'info'=>'钩子删除成功'];
			}else{
				$result = ['status'=>0,'info'=>'钩子删除失败'];
			}
			return $result;
		}
	}

	/**
	 * 更新钩子挂载的插件
	 * @param $name string 插件名称
	 * @param $hks array 钩子名称数组
	 */
	public function mountAddon($name,$hks){
		if(empty($name)||!is_array($hks)){
			return false;
		}else if(count($hks)==0){
			return true;
		}
		$hooks = db('Hooks')->where('name','in',$hks)->select();
		if(!$hooks){
			return true;
		}
		foreach($hooks as $k=>$v){
			$addons = $v['addons'];
			$temp = array();
			if($addons){
				$temp = explode(',',$addons);
				if(!in_array($name,$temp))
					$temp[] = $name;
				db('Hooks')->update(['id'=>$v['id'],'addons'=>implode(',',$temp)]);
			}else{
				db('Hooks')->update(['id'=>$v['id'],'addons'=>$name]);
			}
		}
		return true;
	}

	/**
	 * 移除钩子挂载的插件
	 * @param $name string 插件名称
	 * @param $hks array 钩子名称数组
	 */
	public function remountAddon($name,$hks){
		if(empty($name)||!is_array($hks)){
			return false;
		}else if(count($hks)==0){
			return true;
		}
		$hooks = db('Hooks')->where('name','in',$hks)->select();
		if(!$hooks){
			return true;
		}
		foreach($hooks as $k=>$v){
			$addons = $v['addons'];
			$temp = array();
			if($addons){
				$temp = explode(',',$addons);
				$search = array_search($name,$temp);
				if($search!==false){
					unset($temp[$search]);
					db('Hooks')->update(['id'=>$v['id'],'addons'=>implode(',',$temp)]);
				}
			}
		}
		return true;
	}

	/**
	 * 插件配置上传图片
	 * @param $upimg 上传的文件对象
	 */
	public function uploadImage(){
		$img = $this->request->file('upimg');
		if(!$img){
			$result = ['status'=>0,'info'=>'没有上传文件'];
			echo json_encode($result);
			exit;
		}
		$base_path = STATIC_PATH.'uploads/image/';
		if(!file_exists($base_path)){
			mkdir($base_path);
		}
		$info = $img->rule('uniqid')->move($base_path);
		if($info){
			$url = $base_path.$info->getSaveName();
			@chmod($url,0644);
			Loader::import('upyun.Upform',EXTEND_PATH);
			@$upyun = new \UpYun(Config::get('upyun_config.bucket'),Config::get('upyun_config.form_api'));
			$opts = array();
			$opts['save-key'] = '/{year}/{mon}/{day}/{hour}/{min}/{sec}/upload_{filemd5}{.suffix}';
			$opts['allow-file-type'] = 'jpg,jpeg,png,gif';
			$opts['content-length-range'] = '1,3072000';
			$opts['notify-url'] = '';
			$opts['ext-param'] = 'addons';
			$policy = $upyun->policyCreate($opts);
			$sign = $upyun->signCreate($opts);
			$action = $upyun->action();

			//提交数据
			$data = array();
			if(@function_exists('curl_file_create')){
				//php版本5.5以上
				$cfile = curl_file_create($url,$info->getExtension(),$info->getFilename());
				$data['file'] = $cfile;
			}else{
				$data['file'] = '@'.$url;
			}
			$data['policy'] = $policy;
			$data['signature'] = $sign;

			//curl构造
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$action);
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch,CURLOPT_HEADER,false);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			$res = curl_exec($ch);
			curl_close($ch);
			$jsdata = json_decode($res);
			if($jsdata->code == 200){
				//删除上传对象
				unset($info);
				//删除服务器文件
				unlink($url);
				$result = ['status'=>1,'info'=>'上传成功','url'=>Config::get('upyun_config.domain').$jsdata->url];
			}else{
				$result = ['status'=>0,'info'=>'上传失败'];
			}
		}else{
			$result = ['status'=>0,'info'=>$img->getError()];
		}
		echo json_encode($result);
		exit;
	}

	/**
	 * 删除上传的图片
	 * @param $purl 要删除的图片路径 
	 */
	public function delImage(){
		$aid = intval($this->request->post('aid'));
		$group = intval($this->request->post('group'));
		$topkey = trim($this->request->post('topkey'));
		$key = trim($this->request->post('key'));
		$purl = trim($this->request->post('purl'));
		if(!$aid||empty($key)||empty($purl)){
			$result = ['status'=>0,'info'=>'参数错误'];
			echo json_encode($result);
			exit;
		}else if($group===1&&empty($topkey)){
			$result = ['status'=>0,'info'=>'参数错误'];
			echo json_encode($result);
			exit;
		}
		Loader::import('upyun.Uprest',EXTEND_PATH);
		$uconfig = config('upyun_config');
		$upyun = new \UpYun($uconfig['bucket'],$uconfig['user'],$uconfig['pwd']);
		$path = str_replace($uconfig['domain'],'',$purl);
		$del = $upyun->delete($path);
		$del = true;
		if($del!==true){
			$result = ['status'=>0,'info'=>'删除失败'];
			echo json_encode($result);
			exit;
		}else{
			$info = db('addons')->where('id',$aid)->find();
			if(!$info){
				$result = ['status'=>0,'info'=>'插件还没有安装'];
				echo json_encode($result);
				exit;
			}
			$config_path = ADDON_PATH.$info['name'].'/config.php';
			if(!file_exists($config_path)){
				$result = ['status'=>0,'info'=>'配置文件不存在'];
				echo json_encode($result);
				exit;
			}
			$config = include $config_path;
			if(is_array($config)&&count($config)>0){
				$pconfig = $group ? $config['group']['options'][$topkey]['options'][$key]['value'] : $config[$key]['value'];
				$keyArr = explode(',',$pconfig);
				$index = array_search($purl,$keyArr);
				if($index!==false){
					unset($keyArr[$index]);
					if($group){
						$config['group']['options'][$topkey]['options'][$key]['value'] = implode(',',$keyArr);
					}else{
						$config[$key]['value'] = implode(',',$keyArr);
					}
					$str_arr = "<?php\nreturn ".var_export($config,true).';';
					if(file_put_contents($config_path,$str_arr)){
						db('addons')->where('id',$aid)->update(['id'=>$aid,'config'=>json_encode($config)]);
						$result = ['status'=>1,'info'=>'删除成功'];
						echo json_encode($result);
						exit;
					}else{
						$result = ['status'=>0,'info'=>'删除失败'];
						echo json_encode($result);
						exit;
					}
				}
			}
		}
		$result = ['status'=>0,'info'=>'删除失败'];
		echo json_encode($result);
		exit;
	}

	/**
	 * 后台列表首页
	 */
	public function adminlist(){
		$list = db('addons')->where('has_adminlist',1)->order('id desc')->paginate();
        $this->assign('list', $list);
		return $this->fetch('adminlist');
	}

	/**
	 * 插件后台列表页
	 * @param $id 插件id
	 */
	public function getAdminList($id,$search_key=''){
		$id = intval($id);
		if(!$id){
			$this->error('参数错误');
		}else if($search_key!=''){
			$search_key = trim(strip_tags($search_key));
		}
		$name = db('addons')->where('id',$id)->value('name');
		$class = get_addon_class($name);
        if(!class_exists($class))
            $this->error('插件不存在');
        $addon  =   new $class();
        $this->assign('addon', $addon->info);
        $lopts  =   $addon->admin_list;
        if(!$lopts)
            $this->error('插件列表信息不正确');
        extract($lopts);
        $this->assign('lopts',$lopts);
        if(!isset($map))
            $map = [];
        if(!isset($order))
        	$order = '';
        if(isset($table)){
        	if(isset($search_key)&&!empty($search_key)){
        		$map_key = $addon->admin_list['searchKey'];
        		if(is_array($map_key)&&count($search_key)>0){
        			$map_key = implode('|',$map_key);
        			$map[$map_key] = array('like','%'.$search_key.'%');
        		}
        	}
        	$count = db($table)->where($map)->count();
        	$Page = new \think\Page($count,config('paginate.list_rows'),array('id'=>$id));
            $list = db($table)->where($map)->order($order)->limit($Page->firstRow,$Page->listRows)->select();
            if(isset($field)&&$field!='*'){
            	$field = explode(',',$field);
            	$list = array_get_columns($list,$field);
            }
            $show = $Page->show();
        }else{
        	$list = array();
        }
        $this->assign('id',$id);
        $this->assign('list',$list);
        $this->assign('page',$show ? $show : '');
        if(isset($addon->custom_adminlist)){
        	return $this->fetch(ADDON_PATH.$name.'/'.$addon->custom_adminlist);
        }
        return $this->fetch(ADDON_PATH.$name.'/adminlist.html');
	}

	/**
	 * 插件后台详情页
	 * @param $id 插件id
	 * @param $controller 插件controller名
	 * @param $action 插件controller方法名
	 * @param $template 插件模板名
	 * @param $params 传入参数
	 */
	public function detailPage($id = 0,$controller = '',$action = '',$template = '',$params = ''){
		$id = intval($id);
		if(!$id){
			$this->error('参数错误');
		}else if(!is_string($controller)||$controller==''){
			$this->error('未指定控制器名');
		}else if(!is_string($action)||$action==''){
			$this->error('未指定方法名');
		}else if(!is_string($template)||$template==''){
			$this->error('未指定模板名');
		}else if(!is_string($params)){
			$this->error('传入参数错误');
		}
		$name = db('addons')->where('id',$id)->value('name');
		if(!$name)
			$this->error('插件未安装或已禁用');
		$class = "\addons\\$name\controller\\$controller";
		if(!class_exists($class))
			$this->error('控制器不存在');
		$Addons = new $class();
		if($params!=''){
			$tmp_params = explode(',',$params);
			$parr = array();
			foreach($tmp_params as $k=>$v){
				$tval = array();
				$tval = explode('=',$v);
				$tk = $tval[0];
				$tv = isset($tval[1]) ? $tval[1] : '';
				$parr[$tk] = $tv;
			}
			$params = $parr;
		}else{
			$params = array();
		}
		$Addons->$action($params);
		return $this->fetch(ADDON_PATH.$name.'/view/'.$template.'.'.config('template.view_suffix'));
	}

	/**
	 * 外部访问方法
	 */
	public function execute($addons = null, $controller = null, $action = null, $params = ''){

		if(!empty($addons) && !empty($controller) && !empty($action)){
			$check = db('addons')->where('name',$addons)->value('status');
			if(!$check)
				$this->error('插件未安装或已禁用');
			$class = "\addons\\$addons\controller\\$controller";
			$Addons = new $class();
			if($params!=''){
				$tmp_params = explode(',',$params);
				$parr = array();
				foreach($tmp_params as $k=>$v){
					$tval = array();
					$tval = explode('=',$v);
					$tk = $tval[0];
					$tv = isset($tval[1]) ? $tval[1] : '';
					$parr[$tk] = $tv;
				}
				$params = $parr;
			}else{
				$params = array();
			}
			$Addons->$action($params);
		} else {
			$this->error('没有指定插件名称，控制器或操作！');
		}

	}
	
}