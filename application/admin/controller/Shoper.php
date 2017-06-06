<?php

namespace app\admin\controller;
use think\Controller,think\Request,think\Loader;
use common\Category;
use app\admin\controller\Excel;
use app\admin\controller\Phpqrcode as PHPqrcode;
use app\index\controller\Index;
class Shoper extends Base{

	public function _initialize(){
		parent::_initialize();
		$this->reqdata = $this->request->param();
		$this->postdata = $this->request->post();
	}

	//商家配置
	public function config(){
		$profile = db('profile')->where('id',1)->find();
		$pay = db('pay_config')->where('id',1)->find();
		if(!empty($profile['commend'])){
			$profile['commend'] = db('product')->where('id','in',$profile['commend'])->column('name','id');
		}
		$this->assign('profile',$profile);
		$this->assign('pay',$pay);
		return $this->fetch('config');
	}

	public function profileConfig(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Profile');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
			}else{
				$profile = db('profile');
				if(empty($data['commend'])){
					$data['commend'] = null;
				}
				$check = $profile->where('id',1)->find();
				$data['detail'] = htmlspecialchars($data['detail']);
				if($check){
					$save = $profile->where('id',1)->update($data);
				}else{
					$save = $profile->insert($data);
				}
				if($save){
					$result['status'] = 1;
					$result['info'] = '资料保存成功';
				}else{
					$result['status'] = 0;
					$result['info'] = '资料保存失败';
				}
			}
			return $result;
		}
	}

	public function payConfig(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			if(!$data['handtake']&&!$data['express']){
				$result['status'] = 0;
				$result['info'] = '到店自提和快递配送必须至少启用一个';
				return $result;
			}
			$validate = validate('Pay');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
			}else{
				$pay = db('pay_config');
				$check = $pay->where('id',1)->find();
				if($check){
					$save = $pay->where('id',1)->update($data);
				}else{
					$save = $pay->insert($data);
				}
				if($save){
					$result['status'] = 1;
					$result['info'] = '配置保存成功';
				}else{
					$result['status'] = 0;
					$result['info'] = '配置保存失败';
				}
			}
			return $result;
		}
	}

	public function delResource(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			$type = trim($request->post('type'));
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = $this->unuseAttachment($url);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				if($type=='cross'){
					$check = db('profile')->where('share_image',$url)->find();
					if($check){
						db('profile')->where('id',$check['id'])->update(['share_image'=>'']);
					}
				}else{
					$check = db('pay_config')->where('rsa',$url)->find();
					if($check){
						db('pay_config')->where('id',$check['id'])->update(['rsa'=>'']);
					}
				}
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	//规格管理
	public function format(){
		$request = Request::instance();
		$key = trim($request->param('search_key'));
		if(!$key){
			$format = db('product_formkey')->order('id desc')->paginate();
		}else{
			$format = db('product_formkey')->where('key','like','%'.$key.'%')->order('id desc')->paginate();
		}
		$this->assign('format',$format);
		return $this->fetch('format');
	}

	public function addFormat(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$val = trim($request->post('value'));
			if(empty($val)){
				$result['status'] = 0;
				$result['info'] = '未填写规格名称';
				return $result;
			}
			$propkey = db('product_formkey');
			$check = $propkey->where('key',$val)->find();
			if($check){
				$result['status'] = 0;
				$result['info'] = '规格名称已存在';
				return $result;
			}
			$add = $propkey->insert(['key'=>$val]);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '添加成功';
			}
			return $result;
		}
		return $this->fetch('add_format');
	}

	public function editFormat(){
		$request = Request::instance();
		$propkey = db('product_formkey');
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('id'));
			$val = trim($request->post('value'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}else if(empty($val)){
				$result['status'] = 0;
				$result['info'] = '未填写规格名称';
				return $result;
			}
			$check = $propkey->where('key',$val)->where('id','neq',$id)->find();
			if($check){
				$result['status'] = 0;
				$result['info'] = '规格名称已存在';
				return $result;
			}
			$add = $propkey->where('id',$id)->update(['key'=>$val]);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $propkey->where('id',$id)->find();
		if(!$info){
			$this->error('规格名称不存在');
		}
		$this->assign('info',$info);
		return $this->fetch('edit_format');
	}

	public function delFormat(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product_formkey')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	//产品管理
	public function product(){
		$request = Request::instance();
		$where = [];
		// 这里添加条件
		$where['p.is_del'] = 0;
		$where['is_sell'] = 1;
		$where['gift'] = 0;
		$where['store'] = array('NEQ','0');
		$skey = trim($request->param('search_key'));
		if(!empty($skey)) $where['p.name'] = ['like','%'.$skey.'%'];
		$cid = intval($request->param('cid'));
		if($cid) $where['p.cid'] = $cid;
		$top = intval($request->param('is_top'));
		if($top) $where['p.is_top'] = 1;
		$hot = intval($request->param('is_hot'));
		if($hot) $where['p.is_hot'] = 1;
		$new = intval($request->param('is_new'));
		if($new) $where['p.is_new'] = 1;
		$list = db('product')->alias('p')->join('product_classify c','p.cid = c.id','LEFT')->where($where)->field('p.id,name,title,price,store,sale,supplier,warn_num,is_sell,p.updatetime,p.sort')->order('p.id desc')->paginate();
		$classify = db('product_classify')->field('id,title')->order('id desc')->select();
		foreach ($classify as $key => $value) {
			if($value['id'] == $cid){
				$classname = $value['title'];
			}
		}
		if(empty($classname)){
			$classname = null;
		}
		$this->assign('classname',$classname);
		$this->assign('cid',$cid);
		$this->assign('classify',$classify);
		$this->assign('list',$list);
		return $this->fetch('product');
	}

	public function productgift(){
		$request = Request::instance();
		$where = [];
		// 这里添加条件
		$where['p.is_del'] = 0;
		// $where['is_sell'] = 1;
		$where['gift'] = 1;
		$where['store'] = array('NEQ','0');
		$skey = trim($request->param('search_key'));
		if(!empty($skey)) $where['p.name'] = ['like','%'.$skey.'%'];
		$cid = intval($request->param('cid'));
		if($cid) $where['p.cid'] = $cid;
		$top = intval($request->param('is_top'));
		if($top) $where['p.is_top'] = 1;
		$hot = intval($request->param('is_hot'));
		if($hot) $where['p.is_hot'] = 1;
		$new = intval($request->param('is_new'));
		if($new) $where['p.is_new'] = 1;
		$list = db('product')->alias('p')->join('product_classify c','p.cid = c.id','LEFT')->where($where)->field('p.id,name,title,store,sale,supplier,warn_num,is_sell,p.updatetime')->order('p.id desc')->paginate();
		$classify = db('product_classify')->field('id,title')->order('id desc')->select();
		foreach ($classify as $key => $value) {
			if($value['id'] == $cid){
				$classname = $value['title'];
			}
		}
		if(empty($classname)){
			$classname = null;
		}
		$this->assign('classname',$classname);
		$this->assign('cid',$cid);
		$this->assign('classify',$classify);
		$this->assign('list',$list);
		return $this->fetch();
	}

	public function productRepertory(){
		$request = Request::instance();
		$where = [];
		$where['p.is_del'] = 0;
		$where['gift'] = 0;
		$skey = trim($request->param('search_key'));
		if(!empty($skey)) $where['p.name'] = ['like','%'.$skey.'%'];
		$cid = intval($request->param('cid'));
		if($cid) $where['p.cid'] = $cid;
		$top = intval($request->param('is_top'));
		if($top) $where['p.is_top'] = 1;
		$hot = intval($request->param('is_hot'));
		if($hot) $where['p.is_hot'] = 1;
		$new = intval($request->param('is_new'));
		if($new) $where['p.is_new'] = 1;
		$where['p.is_sell'] = 0;
		$list = db('product')->alias('p')->join('product_classify c','p.cid = c.id','LEFT')->where($where)->field('p.id,name,title,price,store,sale,supplier,warn_num,is_sell,p.updatetime,p.sort')->order('p.id desc')->paginate();
		$classify = db('product_classify')->field('id,title')->order('id desc')->select();
		foreach ($classify as $key => $value) {
			if($value['id'] == $cid){
				$classname = $value['title'];
			}
		}
		if(empty($classname)){
			$classname = null;
		}
		$this->assign('classname',$classname);
		$this->assign('cid',$cid);
		$this->assign('classify',$classify);
		$this->assign('list',$list);
		return $this->fetch('product');
	}

	public function addProduct(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Product');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
			}else{
				//产品轮播图处理
				$data['gallery'] = count($data['gallery'])>0 ? json_encode($data['gallery']) : null;
				if($data['qrcode'] == 1){
					$qrcode = new PHPqrcode;
					$content = 'http://m.green-f.cn/index_prod.html#!/detail/'.$id;
					$path = $qrcode->qrcodeshop($content);
					$data['qrcode'] = $path;
				}
				//优惠活动处理
				//lzc-不需要这个功能
				/*$data['is_promote'] = intval($data['is_promote']);
				if($data['is_promote']){
					$data['promote_price'] = floatval($data['promote_price']);
					if(empty($data['promote_time'])){
						$result['status'] = 0;
						$result['info'] = '请选择优惠活动日期';
						return $result;
					}
					$temp_time = explode(' - ',$data['promote_time']);
					$data['promote_start'] = isset($temp_time[0]) ? strtotime($temp_time[0]) : 0;
					$data['promote_end'] = isset($temp_time[1]) ? strtotime($temp_time[1]) : 0;;
					unset($data['promote_time']);
				}*/
				//产品规格组合存储处理
				if(isset($data['props'])){
					$data['format'] = [];
					foreach($data['props'] as $key=>$val){
						$split = [];
						$split = explode(',',$val);
						$tvalue = [];
						if(isset($data['pvals'.$key])&&count($data['pvals'.$key])>0){
							foreach($data['pvals'.$key] as $vk=>$vv){
								$split2 = [];
								$split2 = explode(',',$vv);
								$tvalue[] = ['id'=>$split2[0],'name'=>$split2[1]];
							}
							$data['format'][] = ['id'=>$split[0],'name'=>$split[1],'value'=>$tvalue];
						}else{
							$data['format'][] = ['id'=>$split[0],'name'=>$split[1]];
						}
					}
					if(count($data['format'])>0){
						$data['format'] = json_encode($data['format']);
					}else{
						unset($data['format']);
					}
				}
				if($data['taocan'] == 0){
					unset($data['pinzhong']);
					unset($data['pinzhongid']);
					$data['taocan'] = '';
				}else{
					foreach ($data['pinzhongid'] as $key => $value) {
						$allpinzhong[] = $value.'#'.$data['pinzhong'][$key];
					}
					$data['taocan'] = implode(',',$allpinzhong);
					unset($data['pinzhong']);
					unset($data['pinzhongid']);
				}
				//添加产品信息
				$product = model('Product');
				$add = $product->allowField(true)->save($data);
				if($add){
					//获取产品id
					$add = $product->id;
					//添加产品详情
					$pcontent = db('product_content');
					if($check=$pcontent->where('pid',$add)->find()){
						$pcontent->where('pid',$add)->update(['content'=>htmlspecialchars($data['content'])]);
					}else{
						$pcontent->insert(['pid'=>$add,'content'=>htmlspecialchars($data['content'])]);
					}
					unset($check);
					unset($pcontent);
					//添加产品附加信息
					$addition = db('product_addition');
					$check = $addition->where('pid',$add)->find();
					$data['notice'] = empty($data['notice']) ? null : implode(',',$data['notice']);
					if($check){
						$addition->where('pid',$add)->update(['notice'=>$data['notice']]);
					}else{
						$addition->insert(['pid'=>$add,'notice'=>$data['notice']]);
					}
					unset($check);
					unset($addition);
					//产品规格组合列表
					if(isset($data['skus'])&&isset($data['skuprices'])&&isset($data['skustores'])){
						$ldata = [];
						$store = 0;
						foreach($data['skus'] as $key=>$val) {
							$ldata[$key]['pid'] = $add;
							$ldata[$key]['format'] = $val;
							$ldata[$key]['price'] = isset($data['skuprices'][$key])&&floatval($data['skuprices'][$key]) ? floatval($data['skuprices'][$key]) : floatval($data['price']);
							$ldata[$key]['store'] = isset($data['skustores'][$key]) ? intval($data['skustores'][$key]) : 0;
							$store += $ldata[$key]['store'];
						}
						if(count($ldata)>0){
							db('product_formlist')->insertAll($ldata);
							$product->save(['store'=>$store],['id'=>$add]);
						}
						unset($ldata);
					}
					//产品地区运费处理
					if(isset($data['freights'])){
						$frlist = db('product_area')->order('id asc')->column('id');
						if(!empty($frlist)){
							$frdb = db('product_freight');
							$frdb->where('pid',$add)->delete();
							$frdata = [];
							foreach($frlist as $fk=>$fv){
								$frdata[$fk]['pid'] = $add;
								$frdata[$fk]['aid'] = $fv;
								$frdata[$fk]['freight'] = floatval($data['freights'][$fk]);
							}
							$frdb->insertAll($frdata);
						}
						unset($frdata);
						unset($frlist);
					}
					$result['status'] = 1;
					$result['info'] = '产品添加成功';
				}else{
					$result['status'] = 0;
					$result['info'] = '产品添加失败';
				}
				unset($data);
			}
			return $result;
		}
		$classify = db('product_classify')->field('id,title')->order('id desc')->select();
		$format = db('product_formkey')->order('id desc')->select();
		$notice = db('product_notice')->field('id,title')->order('id desc')->select();
		$freights = db('product_area')->order('id asc')->field('name')->select();
		$this->assign('classify',$classify);
		$this->assign('format',$format);
		$this->assign('sjnote',$notice);
		$this->assign('freights',$freights);
		return $this->fetch('add_product');
	}

	public function editProduct(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			$id = intval($data['id']);
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			unset($data['id']);
			//产品编码检测
			$sncheck = db('product')->where('id','neq',$id)->where('sn_code',$data['sn_code'])->field('id')->find();
			if($sncheck){
				$result['status'] = 0;
				$result['info'] = '产品编码已存在';
				return $result;
			}
			unset($sncheck);
			if(empty($data['weight']) || empty($data['unit'])){
				$result['status'] = 0;
				$result['info'] = '重量和单位不能为空';
				return $result;
			}
			//验证数据
			$validate = validate('Product');
			if(!$validate->scene('update')->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
			}else{
				//产品轮播图处理
				$data['gallery'] = count($data['gallery'])>0 ? json_encode($data['gallery']) : null;
				//优惠活动处理
				// lzc
				/*$data['is_promote'] = intval($data['is_promote']);
				if($data['is_promote']){
					$data['promote_price'] = floatval($data['promote_price']);
					if(empty($data['promote_time'])){
						$result['status'] = 0;
						$result['info'] = '请选择优惠活动日期';
						return $result;
					}
					$temp_time = explode(' - ',$data['promote_time']);
					$data['promote_start'] = isset($temp_time[0]) ? strtotime($temp_time[0]) : 0;
					$data['promote_end'] = isset($temp_time[1]) ? strtotime($temp_time[1]) : 0;
				}else{
					$data['promote_price'] = 0.00;
					$data['promote_start'] = 0;
					$data['promote_end'] = 0;
				}
				unset($data['promote_time']);*/
				//产品规格组合存储处理
				if(isset($data['props'])){
					$data['format'] = [];
					foreach($data['props'] as $key=>$val){
						$split = [];
						$split = explode(',',$val);
						$tvalue = [];
						if(isset($data['pvals'.$key])&&count($data['pvals'.$key])>0){
							foreach($data['pvals'.$key] as $vk=>$vv){
								$split2 = [];
								$split2 = explode(',',$vv);
								$tvalue[] = ['id'=>$split2[0],'name'=>$split2[1]];
							}
							$data['format'][] = ['id'=>$split[0],'name'=>$split[1],'value'=>$tvalue];
						}else{
							$data['format'][] = ['id'=>$split[0],'name'=>$split[1]];
						}
					}
					if(count($data['format'])>0){
						$data['format'] = json_encode($data['format']);
					}else{
						$data['format'] = null;
					}
				}else{
					$data['format'] = null;
				}

				// 二维码商品
				if($data['qrcode'] != 0){
					$queryqrcode = db('product')->where('id',$id)->value('qrcode');
					if($queryqrcode == '0'){
						$qrcode = new PHPqrcode;
						$content = 'http://m.green-f.cn/index_prod.html#!/detail/'.$id;
						$path = $qrcode->qrcodeshop($content);
						$data['qrcode'] = $path;
					}else{
						unset($data['qrcode']);
					}
				}

				// lzc套餐组合
				if($data['taocan'] == 0){
					unset($data['pinzhong']);
					unset($data['pinzhongid']);
					$data['taocan'] = '';
				}else{
					foreach ($data['pinzhongid'] as $key => $value) {
						$allpinzhong[] = $value.'#'.$data['pinzhong'][$key];
					}
					$data['taocan'] = implode(',',$allpinzhong);
					unset($data['pinzhong']);
					unset($data['pinzhongid']);
				}
				//添加产品信息
				$product = model('Product');
				$up = $product->allowField(true)->isUpdate(true)->save($data,['id'=>$id]);
				if($up){
					//添加产品详情
					$pcontent = db('product_content');
					if($check=$pcontent->where('pid',$id)->find()){
						$pcontent->where('pid',$id)->update(['content'=>htmlspecialchars($data['content'])]);
					}else{
						$pcontent->insert(['pid'=>$id,'content'=>htmlspecialchars($data['content'])]);
					}
					unset($check);
					unset($pcontent);
					//添加产品附加信息
					$addition = db('product_addition');
					$check = $addition->where('pid',$id)->find();
					$data['notice'] = empty($data['notice']) ? null : implode(',',$data['notice']);
					if($check){
						$addition->where('pid',$id)->update(['notice'=>$data['notice']]);
					}else{
						$addition->insert(['pid'=>$id,'notice'=>$data['notice']]);
					}
					unset($check);
					unset($addition);
					//产品规格组合列表
					if(isset($data['skus'])&&isset($data['skuprices'])&&isset($data['skustores'])){
						$ldata = [];
						$store = 0;
						foreach($data['skus'] as $key=>$val) {
							$ldata[$key]['pid'] = $id;
							$ldata[$key]['format'] = $val;
							$ldata[$key]['price'] = isset($data['skuprices'][$key])&&floatval($data['skuprices'][$key]) ? floatval($data['skuprices'][$key]) : floatval($data['price']);
							$ldata[$key]['store'] = isset($data['skustores'][$key]) ? intval($data['skustores'][$key]) : 0;
							$store += $ldata[$key]['store'];
						}
						if(count($ldata)>0){
							db('product_formlist')->where('pid',$id)->delete();
							db('product_formlist')->insertAll($ldata);
							$product->save(['store'=>$store],['id'=>$id]);
						}
						unset($ldata);
					}else{
						db('product_formlist')->where('pid',$id)->delete();
					}
					//产品地区运费处理
					if(isset($data['freights'])){
						$frlist = db('product_area')->order('id asc')->column('id');
						if(!empty($frlist)){
							$frdb = db('product_freight');
							$frdb->where('pid',$id)->delete();
							$frdata = [];
							foreach($frlist as $fk=>$fv){
								$frdata[$fk]['pid'] = $id;
								$frdata[$fk]['aid'] = $fv;
								$frdata[$fk]['freight'] = floatval($data['freights'][$fk]);
							}
							$frdb->insertAll($frdata);
						}
						unset($frdata);
						unset($frlist);
					}
					$result['status'] = 1;
					$result['info'] = '产品修改成功';
				}else{
					$result['status'] = 0;
					$result['info'] = '产品修改失败';
				}
				unset($data);
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$classify = db('product_classify')->field('id,title')->order('id desc')->select();
		$format = db('product_formkey')->order('id desc')->select();
		$notice = db('product_notice')->field('id,title')->order('id desc')->select();
		$addition = db('product_addition')->where('pid',$id)->find();
		$addition['notice'] = empty($addition['notice']) ? [] : explode(',',$addition['notice']);
		//查询运费配置
		$freights = db('product_area')->alias('a')->join('product_freight f','(a.id = f.aid) AND f.pid = '.$id,'LEFT')->order('a.id asc')->field('a.name,f.freight')->select();
		//查询产品信息
		$info = db('product')->alias('p')
						->where('p.id',$id)
						->join('product_content c','p.id = c.pid','LEFT')
						->field('p.id,p.name,p.cid,p.sn_code,p.description,p.price,p.is_promote,p.promote_price,p.promote_start,p.promote_end,p.format,p.store,p.virtual_sale,p.supplier,p.sold_out,p.warn_num,p.shotcut,p.gallery,p.is_top,p.is_hot,p.is_new,p.sort,p.is_sell,p.starprice,p.taocan,c.content,p.gift,p.deliverytime,p.weight,p.unit,p.caigouyuan,p.fenjianzu,p.qrcode')
							->find();

		// lzc-人员配对
		$staff[] = $info['caigouyuan'];
		$staff[] = $info['fenjianzu'];
		$staff[] = $info['supplier'];
		$querystaff = Model('Buyer')->Querystaff($staff);
		foreach ($querystaff as $one => $play) {
			if($play['class'] == 1){
                $staffname['fenjianzu'] = $play['name'];
            }elseif($play['class'] == 2){
                $staffname['caigouyuan'] = $play['name'];
            }elseif($play['class'] == 3){
                $staffname['supplier'] = $play['name'];
            }
		}
		if($info['fenjianzu'] == '0'){
            $staffname['fenjianzu'] = '暂无选择';
        }
        if($info['caigouyuan'] == '0'){
            $staffname['caigouyuan'] = '暂无选择';
        }
        if($info['supplier'] == '0'){
            $staffname['supplier'] = '暂无选择';
        }

		if(!empty($info['promote_start'])&&!empty($info['promote_end'])){
			$info['promote_time'] = date('Y/m/d h:i A',$info['promote_start']).' - '.date('Y/m/d h:i A',$info['promote_end']);
			unset($info['promote_start']);
			unset($info['promote_end']);
		}else{
			$info['promote_time'] = '';
		}
		if(!empty($info['format'])) $info['format'] = json_decode($info['format'],true);
            if(!empty($info['gallery'])) $info['gallery'] = json_decode($info['gallery'],true);
		if(!empty($info['content'])) $info['content'] = htmlspecialchars_decode($info['content']);
		$formlist = db('product_formlist')->where('pid',$id)->order('id asc')->select();
		if($formlist){
			$value = db('product_formvalue')->column('value','id');
			foreach($formlist as $key=>$val){
				$tname = [];
				$tarr = explode(',',$val['format']);
				foreach($tarr as $tk=>$tv){
					$tname[] = $value[$tv];
				}
				$formlist[$key]['tname'] = implode('-',$tname);
			}
			unset($value);
		}
		if($info['taocan'] != 0){
			$info['offtaocan'] = 1;
			$taocan = explode(',',$info['taocan']);
			foreach ($taocan as $key => $value) {
				$taocan = explode('#',$value);
				$oktaocan[] = $taocan;
			}
			foreach ($oktaocan as $key1 => $value1) {
				$where['id'] = $value1[0];
				$cxshop = db('product')->where($where)->find();
				$zuheok[$key1]['shopname'] = $cxshop['name'];
				$zuheok[$key1]['shopid'] = $cxshop['id'];
				$zuheok[$key1]['zhongliang'] = $value1[1];
				$this->assign('zuheok',$zuheok);
			}
		}else{
			$info['offtaocan'] = 0;
		}
		$this->assign('staffname',$staffname);
		$this->assign('classify',$classify);
		$this->assign('format',$format);
		$this->assign('sjnote',$notice);
		$this->assign('addition',$addition);
		$this->assign('freights',$freights);
		$this->assign('info',$info);
		$this->assign('formlist',$formlist);
		return $this->fetch('edit_product');
	}

	public function ajaxAddProperty(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$val = trim($request->post('val'));
			if(empty($val)){
				$result['status'] = 0;
				$result['info'] = '未填写属性值名称';
				return $result;
			}
			$propval = db('product_formvalue');
			$check = $propval->where('value',$val)->find();
			if($check){
				$result['status'] = 1;
				$result['id'] = $check['id'];
				$result['value'] = $check['value'];
				return $result;
			}
			$add = $propval->insertGetId(['value'=>$val]);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '属性值添加失败';
			}else{
				$result['status'] = 1;
				$result['id'] = $add;
				$result['value'] = $val;
			}
			return $result;
		}
	}

	public function delProductimg(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
            $del = $this->unuseAttachment($url);
            if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				db('product')->where('shotcut',$url)->update(['shotcut'=>'']);
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	public function delGallery(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			$id = intval($request->post('id'));
			$update = intval($request->post('up'));
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
            $del = $this->unuseAttachment($url);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				if($id&&$update){
					$product = db('product');
					$gallery = $product->where('id',$id)->value('gallery');
					if($gallery){
                        $gallery = substr($gallery,1,-1);
						$gallery = explode(',',$gallery);
						foreach ($gallery as $k =>$v){
                            $gallery[$k] = stripslashes($v);
                        }
						$index = array_search('"'.$url.'"',$gallery);
						if($index>=0){
							unset($gallery[$index]);
							$gallery = implode(',',$gallery);
							$product->where('id',$id)->update(['gallery'=>'['.$gallery.']']);
						}
					}
				}
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	public function delProduct(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product')->where('id',$id)->update(['is_del'=>1]);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	//自提点
	public function handtakePlace(){
		$handtake = db('handtake_place');
		$parents = $handtake->where('pid',0)->order('sort desc,id desc')->select();
		$list = array();
		if($parents){
			foreach($parents as $k=>$v){
				$list[$k] = $v;
				$list[$k]['sub'] = $handtake->where('pid',$v['id'])->order('sort desc,id desc')->select();
			}
		}
		$this->assign('list',$list);
		return $this->fetch('handtake');
	}

	public function addHandtake(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Handtake');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['pid'] = 0;
			$data['sort'] = intval($data['sort']);
			$add = db('handtake_place')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '地区添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '地区添加成功';
			}
			return $result;
		}
		return $this->fetch('add_handtake');
	}

	public function editHandtake(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Handtake');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['pid'] = 0;
			$data['sort'] = intval($data['sort']);
			$up = db('handtake_place')->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '地区修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '地区修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = db('handtake_place')->where('id',$id)->find();
		$this->assign('info',$info);
		return $this->fetch('edit_handtake');
	}

	public function addHandtakeArea(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Handtake');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$add = db('handtake_place')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '区域添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '区域添加成功';
			}
			return $result;
		}
		$id = intval($request->param('pid'));
		if(!$id){
			$this->error('参数错误');
		}
		$parent = db('handtake_place')->where('id',$id)->value('name');
		$this->assign('parent',$parent);
		return $this->fetch('add_handtake_area');
	}

	public function editHandtakeArea(){
		$handtake = db('handtake_place');
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Handtake');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$up = $handtake->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '区域修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '区域修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $handtake->where('id',$id)->find();
		$list = $handtake->where('pid',0)->order('sort desc,id desc')->select();
		$this->assign('info',$info);
		$this->assign('list',$list);
		return $this->fetch('edit_handtake_area');
	}

	public function handtakePoint(){
		$request = Request::instance();
		$pid = intval($request->param('pid'));
		if(!$pid){
			$this->error('参数错误');
		}
		$list = db('handtake_place')->where('pid',$pid)->order('sort desc,id desc')->paginate();
		foreach ($list as $key => $value) {
			$allid[] = $value['id'];
		}
		$this->assign('allid',json_encode($allid));
		$this->assign('list',$list);
		return $this->fetch('handtake_point');
	}

	public function addHandtakePoint(){
		$handtake = db('handtake_place');
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Handtake');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$pattern = '/^[\s\S]{1,75}$/u';
			$pattern2 = '/^[\d-]{1,15}$/';
			if(!preg_match($pattern,$data['address'])){
				$result['status'] = 0;
				$result['info'] = '自提点站点地址格式不正确';
				return $result;
			}else if(!preg_match($pattern2,$data['tel'])){
				$result['status'] = 0;
				$result['info'] = '自提点站点电话号码格式不正确';
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$up = $handtake->insertGetId($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '站点添加失败';
			}else{
				$qrcode = new PHPqrcode;
				$content = 'https://m.green-f.cn/index_prod.html?sinceid='.$up;
				$path = $qrcode->sinceqrcode($content);
				$update['qrcode'] = $path;
				$editqrcode = $handtake->where('id',$up)->update($update);
				$result['status'] = 1;
				$result['info'] = '站点添加成功';
			}
			return $result;
		}
		$pid = intval($request->param('pid'));
		if(!$pid){
			$this->error('参数错误');
		}
		$list = $handtake->where('pid',$pid)->order('sort desc,id desc')->select();
		$this->assign('list',$list);
		return $this->fetch('add_handtake_point');
	}

	public function editHandtakePoint(){
		$handtake = db('handtake_place');
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Handtake');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$pattern = '/^[\s\S]{1,75}$/u';
			$pattern2 = '/^[\d-]{1,15}$/';
			if(!preg_match($pattern,$data['address'])){
				$result['status'] = 0;
				$result['info'] = '自提点站点地址格式不正确';
				return $result;
			}else if(!preg_match($pattern2,$data['tel'])){
				$result['status'] = 0;
				$result['info'] = '自提点站点电话号码格式不正确';
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$up = $handtake->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '站点修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '站点修改成功';
			}
			return $result;
		}
		$pid = intval($request->param('pid'));
		$id = intval($request->param('id'));
		if(!$id||!$pid){
			$this->error('参数错误');
		}
		$parent = $handtake->where('id',$pid)->value('pid');
		$list = $handtake->where('pid',$parent)->order('sort desc,id desc')->select();
		$info = $handtake->where('id',$id)->find();
		if(empty($info['qrcode'])){
			$qrcode = new PHPqrcode;
			$content = 'http://m.green-f.cn/index_prod.html?sinceid='.$id;
			$path = $qrcode->sinceqrcode($content);
			$update['qrcode'] = $path;
			$edit = $handtake->where('id',$id)->update($update);
		}
		$this->assign('list',$list);
		$this->assign('info',$info);
		return $this->fetch('edit_handtake_point');
	}

	public function delHandtake(){
		$request = Request::instance();
		$handtake = db('handtake_place');
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$top = $handtake->where('id',$id)->value('pid');
			$del = $handtake->delete($id);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				if($top){
					$handtake->where('pid',$id)->delete();
				}else{
					$sub = $handtake->where('pid',$id)->column('id');
					if($sub){
						$sub[] = $id;
						$handtake->where('pid','in',$sub)->delete();
					}
				}
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	//分类管理
	public function classify(){
		$list = db('product_classify')->order('sort desc')->select();
		$category = new Category(array('id','class','title','cname'));
    	$tree = $category->getTree($list);
		$this->assign('list',$tree);
		return $this->fetch('classify');
	}

	public function addClassify(){
		$cxclass = db('product_classify')->order('createtime desc')->select();
		$category = new Category(array('id','class','title','cname'));
		$tree = $category->getTree($cxclass);
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Classify');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$data['createtime'] = time();
			$data['class'] = intval($data['class']);
			$add = db('product_classify')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '商品分类添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '商品分类添加成功';
			}
			return $result;
		}
		$this->assign('class',$tree);
		return $this->fetch('add_classify');
	}

	public function editClassify(){
		$cxclass = db('product_classify')->order('createtime desc')->select();
		$category = new Category(array('id','class','title','cname'));
		$tree = $category->getTree($cxclass);
		$request = Request::instance();
		$classify = db('product_classify');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!$data['id']){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$validate = validate('Classify');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$data['class'] = intval($data['class']);
			$up = $classify->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '商品分类修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '商品分类修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $classify->where('id',$id)->find();
		$infoclass = db('product_classify')->where('id',$id)->field('class,title,id')->find();
		if($infoclass['class'] == 0){
			$infoclass['title'] = NULL;
		}else{
			$infoclass = db('product_classify')->where('id',$infoclass['class'])->field('class,title,id')->find();
		}
		$this->assign('info',$info);
		$this->assign('infoclass',$infoclass);
		$this->assign('class',$tree);
		return $this->fetch('edit_classify');
	}

	public function delClassify(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = $request->post('did');
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$where['cid'] = $id;
			$where['is_del'] = 0;
			$check = db('product')->where($where)->count();
			if($check){
				$result['status'] = 0;
				$result['info'] = '分类下拥有所属商品,请先删除商品';
				return $result;
			}
//			lzc
			$checkclass = db('product_classify')->where('class',$id)->count();
			if($checkclass){
                $result['status'] = 0;
                $result['info'] = '分类下拥有所属的下级分类,请先删除下级分类';
                return $result;
            }
			$del = db('product_classify')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function delClassifyImg(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = $this->unuseAttachment($url);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				db('product_classify')->where('shotcut',$url)->update(['shotcut'=>'']);
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	//banner管理
	public function banner(){
		$list = db('product_banner')->order('createtime desc')->paginate();
		$this->assign('list',$list);
		return $this->fetch('banner');
	}

	public function addBanner(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$validate = validate('Banner');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$data['createtime'] = time();
			$add = db('product_banner')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = 'banner图添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = 'banner图添加成功';
			}
			return $result;
		}
		return $this->fetch('add_banner');
	}

	public function editBanner(){
		$request = Request::instance();
		$banner = db('product_banner');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!$data['id']){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$validate = validate('Banner');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$add = $banner->update($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = 'banner图添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = 'banner图添加成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $banner->where('id',$id)->find();
		if(!$info){
			$this->error('banner图不存在');
		}
		$this->assign('info',$info);
		return $this->fetch('edit_banner');
	}

	public function delBanner(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = $request->post('did');
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product_banner')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function delBannerImg(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = $this->unuseAttachment($url);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				db('product_banner')->where('img',$url)->update(['img'=>'']);
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	//文章管理
	public function article(){
		$list = db('product_article')->order('createtime desc')->paginate();
		$this->assign('list',$list);
		return $this->fetch('article');
	}

	public function addArticle(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$article = model('Article');
			$add = $article->validate(true)->save($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = $article->getError();
				return $result;
			}
			$result['status'] = 1;
			$result['info'] = '文章添加成功';
			return $result;
		}
		return $this->fetch('add_article');
	}

	public function editArticle(){
		$request = Request::instance();
		$article = db('product_article');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			$id = intval($data['id']);
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			unset($data['id']);
			$article = model('Article');
			$up = $article->validate(true)->save($data,['id'=>$id]);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = $article->getError();
				return $result;
			}
			$result['status'] = 1;
			$result['info'] = '文章修改成功';
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $article->where('id',$id)->find();
		if(!$info){
			$this->error('文章不存在');
		}
		$this->assign('info',$info);
		return $this->fetch('edit_article');
	}

	public function delArticle(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = $request->post('did');
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product_article')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function delArticleImg(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = $this->unuseAttachment($url);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				db('product_article')->where('shotcut',$url)->update(['shotcut'=>'']);
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	//商品公告
	public function notice(){
		$list = db('product_notice')->order('id desc')->paginate();
		$this->assign('list',$list);
		return $this->fetch('notice');
	}

	public function addNotice(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			$data['title'] = trim($data['title']);
			$data['sdesc'] = trim($data['sdesc']);
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!preg_match('/^[\s\S]{1,50}$/',$data['title'])){
				$result['status'] = 0;
				$result['info'] = '公告标题为1-50个字符';
				return $result;
			}else if(!empty($data['sdesc'])&&!preg_match('/^[\s\S]{1,150}$/',$data['sdesc'])){
				$result['status'] = 0;
				$result['info'] = '公告描述为1-150个字符';
				return $result;
			}
			$add = db('product_notice')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '添加失败';
				return $result;
			}
			$result['status'] = 1;
			$result['info'] = '添加成功';
			return $result;
		}
		return $this->fetch('add_notice');
	}

	public function editNotice(){
		$request = Request::instance();
		$notice = db('product_notice');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			$data['id'] = intval($data['id']);
			$data['title'] = trim($data['title']);
			$data['sdesc'] = trim($data['sdesc']);
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!$data['id']){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}else if(!preg_match('/^[\s\S]{1,50}$/',$data['title'])){
				$result['status'] = 0;
				$result['info'] = '公告标题为1-50个字符';
				return $result;
			}else if(!empty($data['sdesc'])&&!preg_match('/^[\s\S]{1,150}$/',$data['sdesc'])){
				$result['status'] = 0;
				$result['info'] = '公告描述为1-150个字符';
				return $result;
			}
			$up = db('product_notice')->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '修改失败';
				return $result;
			}
			$result['status'] = 1;
			$result['info'] = '修改成功';
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $notice->where('id',$id)->find();
		if(!$info){
			$this->error('公告不存在');
		}
		$this->assign('info',$info);
		return $this->fetch('edit_notice');
	}

	public function delNotice(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = $request->post('did');
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product_notice')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	//推荐组合
	public function commend(){
		$request = Request::instance();
		$product = db('product');
		$where = [];
		$skey = trim($request->param('search_key'));
		if(!empty($skey))
			$where['p.name'] = ['like','%'.$skey.'%'];
		$where['a.commend'] = ['neq',''];
		$count = $product->alias('p')->join('product_addition a','p.id = a.pid','RIGHT')->where($where)->count();
		$Page = new \think\Page($count,config('paginate.list_rows'));
		$list = $product->alias('p')->join('product_addition a','p.id = a.pid','RIGHT')->where($where)->field('p.id,p.name,a.commend')->limit($Page->firstRow,$Page->listRows)->select();
		foreach($list as $k=>$v){
			$group = $product->where('id','in',$v['commend'])->column('name');
			$list[$k]['commend'] = implode(',',$group);
		}
		$show = $Page->show();
		$this->assign('list',$list);
		$this->assign('show',$show);
		return $this->fetch('commend');
	}

	public function addCommend(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				return makeResult(0,'未提交数据');
			}else if(!intval($data['main'])){
				return makeResult(0,'未选择主商品');
			}else if(empty($data['commendgroup'])){
				return makeResult(0,'未选择推荐商品');
			}
			$addition = db('product_addition');
			$check = $addition->where('pid',$data['main'])->find();
			if($check){
				$up = $addition->where('id',$check['id'])->update(['commend'=>$data['commendgroup']]);
			}else{
				$up = $addition->insert(['pid'=>$data['main'],'commend'=>$data['commendgroup']]);
			}
			if($up){
				return makeResult(1,'添加成功');
			}else{
				return makeResult(0,'添加失败');
			}
		}
		$classify = db('product_classify')->field('id,title')->order('id desc')->select();
		$this->assign('classify',$classify);
		return $this->fetch('add_commend');
	}

	public function editCommend(){
		$request = Request::instance();
		$product = db('product');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				return makeResult(0,'未提交数据');
			}else if(!intval($data['id'])){
				return makeResult(0,'参数错误');
			}else if(empty($data['commendgroup'])){
				return makeResult(0,'未选择推荐商品');
			}
			$addition = db('product_addition');
			$check = $addition->where('pid',$data['id'])->find();
			if($check){
				$up = $addition->where('id',$check['id'])->update(['commend'=>$data['commendgroup']]);
			}else{
				$up = $addition->insert(['pid'=>$data['id'],'commend'=>$data['commendgroup']]);
			}
			if($up){
				return makeResult(1,'修改成功');
			}else{
				return makeResult(0,'修改失败');
			}
		}
		$id = intval($request->param('id'));
		if(!$id){
			return makeResult(0,'参数错误');
		}
		$info = $product->alias('p')->join('product_addition a','p.id = a.pid','RIGHT')->where('p.id',$id)->field('p.id,p.name,a.commend')->find();
		if(!empty($info['commend'])){
            $ids = explode(',', $info['commend']);
            $subs = $product->where('id','in',$ids)->column('name','id');
            $info['commend'] = $subs;
        }
		$this->assign('info',$info);
		return $this->fetch('edit_commend');
	}

	public function delCommend(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				return makeResult(0,'参数错误');
			}
			$del = db('product_addition')->where('pid',$id)->update(['commend'=>null]);
			if($del){
				return makeResult(1,'删除成功');
			}else{
				return makeResult(0,'删除失败');
			}
		}
	}

	//获取栏目下产品
	public function getMainProducts(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('id'));
			if(!$id){
				return makeResult(0,'参数错误');
			}
			$list = db('product')->where('cid',$id)->where('is_del',0)->column('name','id');
	        if (!$list) {
	            return makeResult(0,'搜索不到相关商品');
	        }
	        return makeResult(1,'ok',['list'=>$list]);
		}
	}

	public function searchProducts(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$key = trim($request->post('key'));
			if(empty($key)){
				return makeResult(0,'搜索商品名称不能为空');
			}
			$list = db('product')->where('is_sell',1)->where('store','gt',0)->where('is_del',0)->where('name','like',"%$key%")->column('name','id');
	        if (!$list) {
	            return makeResult(0,'搜索不到相关商品');
	        }
	        return makeResult(1,'ok',['list'=>$list]);
		}
	}

	//地区管理
	public function area(){
		$request = Request::instance();
		$key = trim($request->param('search_key'));
		if(!$key){
			$area = db('product_area')->order('id desc')->paginate();
		}else{
			$area = db('product_area')->where('name','like','%'.$key.'%')->order('id desc')->paginate();
		}
		$this->assign('area',$area);
		return $this->fetch('area');
	}

	public function addArea(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$val = trim($request->post('name'));
			if(empty($val)){
				$result['status'] = 0;
				$result['info'] = '未填写地区名称';
				return $result;
			}
			$area = db('product_area');
			$check = $area->where('name',$val)->find();
			if($check){
				$result['status'] = 0;
				$result['info'] = '地区名称已存在';
				return $result;
			}
			$add = $area->insert(['name'=>$val]);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '添加成功';
			}
			return $result;
		}
		return $this->fetch('add_area');
	}

	public function editArea(){
		$request = Request::instance();
		$area = db('product_area');
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('id'));
			$val = trim($request->post('name'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}else if(empty($val)){
				$result['status'] = 0;
				$result['info'] = '未填写地区名称';
				return $result;
			}
			$check = $area->where('name',$val)->where('id','neq',$id)->find();
			if($check){
				$result['status'] = 0;
				$result['info'] = '地区名称已存在';
				return $result;
			}
			$add = $area->where('id',$id)->update(['name'=>$val]);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $area->where('id',$id)->find();
		if(!$info){
			$this->error('地区名称不存在');
		}
		$this->assign('info',$info);
		return $this->fetch('edit_area');
	}

	public function delArea(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product_area')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	//优惠券管理
	public function coupon(){
		$list = db('coupon')->alias('c')->join('admin a','c.sid = a.id','LEFT')->field('c.id,c.title,c.type,c.minus_money,c.discount,c.stime,c.etime,c.status,c.createtime,a.name as sid')->order('c.createtime desc')->paginate();
		$this->assign('list',$list);
		return $this->fetch('coupon');
	}

	public function addCoupon(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '未提交数据';
				return $result;
			}
			$validate = validate('Coupon');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['collect_money'] = floatval($data['collect_money']);
			$data['minus_money'] = floatval($data['minus_money']);
			$data['discount'] = floatval($data['discount']);
			switch($data['type']){
				case 1:
					$data['collect_money'] = 0;
					if(!$data['minus_money']){
						$result['status'] = 0;
						$result['info'] = '优惠金额必须大于0';
						return $result;
					}
					$data['discount'] = 0;
					break;
				case 2:
					$data['collect_money'] = 0;
					if($data['discount']<=0||$data['discount']>=1){
						$result['status'] = 0;
						$result['info'] = '折扣范围需设定在区间(0,1)中';
						return $result;
					}
					$data['minus_money'] = 0;
					break;
				case 3:
					if(!$data['collect_money']){
						$result['status'] = 0;
						$result['info'] = '购买满金额必须大于0';
						return $result;
					}else if(!$data['minus_money']){
						$result['status'] = 0;
						$result['info'] = '优惠金额必须大于0';
						return $result;
					}
					$data['discount'] = 0;
					break;
				case 4:
					if(!$data['collect_money']){
						$result['status'] = 0;
						$result['info'] = '购买满金额必须大于0';
						return $result;
					}else if($data['discount']<=0||$data['discount']>=1){
						$result['status'] = 0;
						$result['info'] = '折扣范围需设定在区间(0,1)中';
						return $result;
					}
					$data['minus_money'] = 0;
					break;
			}
			$data['stime'] = strtotime($data['stime']);
			$data['etime'] = strtotime($data['etime'])+86399;
			if($data['etime']<=$data['stime']){
				$result['status'] = 0;
				$result['info'] = '开始时间不能大于结束时间';
				return $result;
			}
			$data['sid'] = session('aid');
			$data['createtime'] = time();
			$add = db('coupon')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '优惠券添加失败';
				return $result;
			}
			$result['status'] = 1;
			$result['info'] = '优惠券添加成功';
			return $result;
		}
		return $this->fetch('add_coupon');
	}

	public function editCoupon(){
		$request = Request::instance();
		$coupon = db('coupon');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			$data['id'] = intval($data['id']);
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '未提交数据';
				return $result;
			}else if(!$data['id']){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$validate = validate('Coupon');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}
			$data['collect_money'] = floatval($data['collect_money']);
			$data['minus_money'] = floatval($data['minus_money']);
			$data['discount'] = floatval($data['discount']);
			switch($data['type']){
				case 1:
					$data['collect_money'] = 0;
					if(!$data['minus_money']){
						$result['status'] = 0;
						$result['info'] = '优惠金额必须大于0';
						return $result;
					}
					$data['discount'] = 0;
					break;
				case 2:
					$data['collect_money'] = 0;
					if($data['discount']<=0||$data['discount']>=1){
						$result['status'] = 0;
						$result['info'] = '折扣范围需设定在区间(0,1)中';
						return $result;
					}
					$data['minus_money'] = 0;
					break;
				case 3:
					if(!$data['collect_money']){
						$result['status'] = 0;
						$result['info'] = '购买满金额必须大于0';
						return $result;
					}else if(!$data['minus_money']){
						$result['status'] = 0;
						$result['info'] = '优惠金额必须大于0';
						return $result;
					}
					$data['discount'] = 0;
					break;
				case 4:
					if(!$data['collect_money']){
						$result['status'] = 0;
						$result['info'] = '购买满金额必须大于0';
						return $result;
					}else if($data['discount']<=0||$data['discount']>=1){
						$result['status'] = 0;
						$result['info'] = '折扣范围需设定在区间(0,1)中';
						return $result;
					}
					$data['minus_money'] = 0;
					break;
			}
			$data['stime'] = strtotime($data['stime']);
			$data['etime'] = strtotime($data['etime'])+86399;
			if($data['etime']<=$data['stime']){
				$result['status'] = 0;
				$result['info'] = '开始时间不能大于结束时间';
				return $result;
			}
			$up = db('coupon')->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '优惠券修改失败';
				return $result;
			}
			$result['status'] = 1;
			$result['info'] = '优惠券修改成功';
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $coupon->where('id',$id)->find();
		if(!$info){
			$this->error('优惠券不存在');
		}
		$this->assign('info',$info);
		return $this->fetch('edit_coupon');
	}

	public function couponList(){
		$request = Request::instance();
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$where = '(m.uname like "%'.$key.'%" OR utel like "%'.$key.'%") AND c.cid = '.$id;
		}else{
			$where = 'c.cid = '.$id;
		}
		$list = db('coupon_list')->alias('c')
							->join('member m','c.uid = m.id','LEFT')
							->where($where)
							->order('c.usetime desc')
							->field('c.id,c.usetime,m.uname,m.utel')
							->paginate();
		$this->assign('id',$id);
		$this->assign('list',$list);
		return $this->fetch('coupon_list');
	}

	public function delCouponList(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('did'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('coupon_list')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function delCoupon(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('did'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('coupon')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function delCouponImg(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = $this->unuseAttachment($url);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				db('coupon')->where('shotcut',$url)->update(['shotcut'=>'']);
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	//订单处理
	public function orders(){
		$request = Request::instance();
		$get = $request->get();
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$or = 'o.orderid like "%'.$key.'%" OR m.uname like "%'.$key.'%" OR o.tel like "%'.$key.'%"';
		}else{
			$or = '';
		}
		$and['o.is_del'] = 0;
		if(!empty($get['time'])){
            $and['stime'] = strtotime($get['time']);
        }
		$field = 'o.id,o.person,o.tel,o.sum,o.money,o.paytype,o.pay,o.orderid,o.status,o.createtime,m.uname,o.send,o.receive,o.createtime,o.stime';
		$list = db('member_orders')->alias('o')->join('member m','o.uid = m.id','LEFT')->where($and)->where($or)->order('o.createtime desc')->field($field)->paginate();
		$this->assign('list',$list);
		return $this->fetch('orders');
	}

    // 快捷编辑查询
    public function getedit(){
        $request = Request::instance();
        $post = $request->post();
        $MemberOrders = Model('MemberOrders');
        if(!empty($post)){
            if($post['stype'] != 'parcel'){
                $edit = $MemberOrders->FastEdit($post,null);
            }else{
                $Querysince = Model('HandtakePlace')->QueryIdsince($post['addressid']);
                $edit = $MemberOrders->FastEdit($post,$Querysince);
            }
            if($edit){
            	if($post['send'] == 1){
            		$queryorder = $MemberOrders->queryidorder($post['id']);
            		$Index = new Index;
            		$wxorderfahuo = $Index->fahuonotice($queryorder['openid'],$queryorder);
            		$ok = json_decode($wxorderfahuo);
            		if($ok->errmsg == 'ok'){
            			$update['wxfahuo'] = 1;
						$MemberOrders->update($post['id'],$update);
            		}else{
            			\Log::DEBUG("fahuonotify: ".json_encode($wxorderfahuo));
            		}
            	}
                make_json(1,'编辑成功');
            }else{
                make_json(0,'内容没有修改');
            }
        }else{
            $get = $this->reqdata;
            $info = $MemberOrders->QueryFastEdit($get);
            make_json(1,['info'=>$info]);
        }
    }

    // 查询自提点
    public function Querysince(){
        $list = Model('HandtakePlace')->QuerySinceAll();
        make_json(1,['list'=>$list]);
    }

//    收货并收取积分
    public function Receiving(){
        $request = Request::instance();
        $post = $request->post();
        $MemberOrders = Model('MemberOrders');
        foreach ($post['id'] as $key =>$value){
            $QueryOrder = $MemberOrders->QueryOrder($value);
            $EditOrderReceive = $MemberOrders->EditReceive($QueryOrder['id']);
            if($EditOrderReceive){
                $JiFenReceiving = Model('Member')->AddJiFen($QueryOrder);
                if($JiFenReceiving){
                    make_json(1,'一键收货成功');
                }else{
                    make_json(0,'一键收货失败');
                }
            }
        }

    }

	public function orderDetail(){
		$request = Request::instance();
		$orderDb = db('member_orders');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			$data['id'] = intval($data['id']);
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '未提交数据';
				return $result;
			}else if(!$data['id']){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$data['send'] = intval($data['send']);
			if($data['send']){
				$tarr = explode(',',$data['scid']);
				$data['scid'] = $tarr[0];
				$data['scom'] = $tarr[1];
				$data['snum'] = trim($data['snum']);
				$data['stime'] = time();
			}else{
				$data['scid'] = '';
				$data['scom'] = '';
				$data['snum'] = '';
				$data['stime'] = 0;
			}
			$up = $orderDb->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '订单修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '订单修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
			// make_json(0,'参数错误,没有这个订单编号');
		}
		$getField = 'o.id,o.person,o.address,o.postcode,o.tel,o.pay,o.paytype,o.tips,o.sum,o.money,o.orderid,o.score,o.coupon,o.freight,o.paytime,o.createtime,o.send,o.stype,o.receive,o.reject,o.rtime,o.snum,o.scom,o.stime,o.status,m.uname as uid,o.wxoid,o.scid';
		$info = $orderDb->alias('o')->join('member m','o.uid = m.id','LEFT')->where('o.id',$id)->where('o.is_del',0)->field($getField)->find();
		if(!$info){
			$this->error('订单不存在或已删除');
			// make_json(0,'订单不存在或已删除');
		}
		if($info['send']==1&&!empty($info['scid'])&&!empty($info['scom'])){
			$info['scid'] = $info['scid'].','.$info['scom'];
		}
		$products = db('member_orderlist')->where('oid',$info['orderid'])->field('id,uid,oid,format',true)->select();
		if($products){
			$productDb = db('product');
			foreach($products as $k=>$v) {
				$products[$k]['pid'] = $productDb->where('id',$v['pid'])->value('name');
			}
		}
		$info['products'] = $products;
		$this->assign('info',$info);
		// make_json(1,['info'=>$info]);
		return $this->fetch('order_detail');
	}

	public function delOrder(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('did'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('member_orders')->where('id',$id)->update(['is_del'=>1]);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function rejectOrder(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('rid'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$up = db('member_orders')->where('id',$id)->update(['reject'=>1,'rtime'=>time()]);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '退货失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '退货成功';
				$queryorder = db('member_orders')->where('id',$id)->find();
				$Index = new Index;
                $wxorderok = $Index->tuihuonotice($queryorder['openid'],$queryorder);
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function quickOrderInfo(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isGet()){
			$id = intval($request->param('id'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$info = db('member_orders')->where('id',$id)->field('send,scid,scom,snum,status')->find();
			if(!$info){
				$result['status'] = 0;
				$result['info'] = '获取订单信息失败';
				return $result;
			}
			if($info['send']==1&&!empty($info['scid'])&&!empty($info['scom'])){
				$info['scid'] = $info['scid'].','.$info['scom'];
			}
			$result = makeResult(1,'ok',['mes'=>$info]);
			return $result;
		}
	}

	public function quickEditOrder(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->put();
			$id = intval($data['myoid']);
			unset($data['myoid']);
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			if($data['send']==1){
				$tarr = explode(',',$data['scid']);
				$data['scid'] = $tarr[0];
				$data['scom'] = $tarr[1];
				$data['stime'] = time();
			}else{
				$data['scid'] = '';
				$data['scom'] = '';
				$data['snum'] = '';
				$data['stime'] = 0;
			}
			$up = db('member_orders')->where('id',$id)->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '订单信息更新失败';
				return $result;
			}
			$result = makeResult(1,'ok');
			return $result;
		}
	}

	public function comment(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		$where = '';
		if(!empty($key)){
			$where = '(p.name like "%'.$key.'%" OR m.uname like "%'.$key.'%" OR m.utel like "%'.$key.'%") AND c.top = 0 AND c.parent = 0';
		}else{
			$where .= 'c.top = 0 AND c.parent = 0';
		}
		$field = 'c.id,p.name,c.fname,c.stars,c.content,c.createtime,c.status,k.orderid,k.createtime as cjtime';
		$list = db('product_comments')->alias('c')
								->join('product p','c.pid = p.id','LEFT')
								->join('member_orders k','c.oid = k.id','LEFT')
								->where($where)
								->order('c.createtime desc')
								->field($field)
								->paginate();
		$this->assign('list',$list);
		return $this->fetch('comment');
	}

	public function replyComment(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->put('top'));
			$content = trim($request->put('content'));
			if(!$id){
				$result = makeResult(0,'参数错误');
				return $result;
			}else if(empty($content)){
				$result = makeResult(0,'回复内容不能为空');
				return $result;
			}
			$commentDb = db('product_comments');
			$info = $commentDb->where('id',$id)->field('oid,pid')->find();
			$sid = $commentDb->where('top',$id)->where('pid',$info['pid'])->order('parent desc')->value('id');
			//构造回复数据
			$rdata = [];
			$rdata['uid'] = session('aid');
			$rdata['oid'] = $info['oid'];
			$rdata['pid'] = $info['pid'];
			$rdata['top'] = $id;
			$rdata['parent'] = 0;
			if($sid){
				$rdata['parent'] = $sid;
			}
			$rdata['content'] = $content;
			$rdata['status'] = 1;
			$rdata['createtime'] = time();
			//插入数据
			$add = $commentDb->insert($rdata);
			unset($info);
			unset($sid);
			unset($rdata);
			if(!$add){
				$result = makeResult(0,'回复评价失败');
				return $result;
			}
			$result = makeResult(1,'ok');
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$commentDb = db('product_comments');
		$info = $commentDb->alias('c')
							->join('member m','c.uid = m.id')
							->where('c.id',$id)
							->where('c.top',0)
							->where('c.parent',0)
							->field('m.uname,m.shotcut,c.id,c.content,c.imgs,c.createtime')
							->find();
		if(!$info){
			$this->error('评价信息不存在');
		}
		$info['shotcut'] = empty($info['shotcut']) ? '' : $info['shotcut'];
		$info['imgs'] = empty($info['imgs']) ? '' : json_decode($info['imgs'],true);
		$info['reply'] = $commentDb->alias('c')
							->join('admin a','c.uid = a.id')
							->where('c.top',$id)
							->order('c.parent asc')
							->field('a.name,a.headimg,c.id,c.content,c.imgs,c.createtime')
							->select();
		$info['nums'] = count($info['reply'])+1;
		$this->assign('info',$info);
		return $this->fetch('reply_comment');
	}

	public function delComment(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('did'));
			$type = intval($request->post('tp'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product_comments')->where('id',$id)->update(['status'=>$type]);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '操作失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '操作成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function service(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$where = '(o.orderid like "%'.$key.'%" OR m.uname like "%'.$key.'%" OR m.utel like "%'.$key.'%") AND s.top = 0 AND s.parent = 0';
		}else{
			$where = 's.top = 0 AND s.parent = 0';
		}
		$field = 's.id,o.orderid,m.uname,s.content,s.status,s.createtime';
		$list = db('product_service')->alias('s')
									->join('member_orders o','s.oid = o.id','LEFT')
									->join('member m','s.uid = m.id','LEFT')
									->where($where)
									->order('s.createtime desc')
									->field($field)
									->paginate();
		$this->assign('list',$list);
		return $this->fetch('service');
	}

	public function serviceDetail(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->put('top'));
			$content = trim($request->put('content'));
			if(!$id){
				$result = makeResult(0,'参数错误');
				return $result;
			}else if(empty($content)){
				$result = makeResult(0,'回复内容不能为空');
				return $result;
			}
			$serviceDb = db('product_service');
			$info = $serviceDb->where('id',$id)->value('oid');
			$sid = $serviceDb->where('top',$id)->where('oid',$info)->order('parent desc')->value('id');
			//构造回复数据
			$rdata = [];
			$rdata['uid'] = session('aid');
			$rdata['oid'] = $info;
			$rdata['top'] = $id;
			$rdata['parent'] = 0;
			if($sid){
				$rdata['parent'] = $sid;
			}
			$rdata['content'] = $content;
			$rdata['createtime'] = time();
			//插入数据
			$add = $serviceDb->insert($rdata);
			unset($info);
			unset($sid);
			unset($rdata);
			if(!$add){
				$result = makeResult(0,'回复申请失败');
				return $result;
			}
			$serviceDb->where('id',$id)->update(['status'=>1]);
			$result = makeResult(1,'ok');
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$serviceDb = db('product_service');
		$info = $serviceDb->alias('s')
							->join('member m','s.uid = m.id')
							->where('s.id',$id)
							->where('s.top',0)
							->where('s.parent',0)
							->field('m.uname,m.shotcut,s.id,s.content,s.imgs,s.createtime')
							->find();
		if(!$info){
			$this->error('申请信息不存在');
		}
		$info['shotcut'] = empty($info['shotcut']) ? '' : $info['shotcut'];
		$info['imgs'] = empty($info['imgs']) ? '' : json_decode($info['imgs'],true);
		$info['reply'] = $serviceDb->alias('s')
							->join('admin a','s.uid = a.id','LEFT')
							->where('s.top',$id)
							->order('s.parent asc')
							->field('a.name,a.headimg,s.id,s.uid,s.content,s.imgs,s.createtime')
							->select();
		$info['nums'] = count($info['reply'])+1;
		$this->assign('info',$info);
		return $this->fetch('service_detail');
	}

	public function closeService(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('id'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$serviceDb = db('product_service');
			$oid = $serviceDb->where('id',$id)->value('oid');
			$up = db('product_service')->where('id',$id)->update(['status'=>2]);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '操作失败';
			}else{
				db('member_orders')->where('id',$oid)->update(['status'=>1]);
				$result['status'] = 1;
				$result['info'] = '操作成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function delService(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('did'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$serviceDb = db('product_service');
			$oid = $serviceDb->where('id',$id)->value('oid');
			$where = '(id = '.$id.') OR (top = '.$id.')';
			$del = $serviceDb->where($where)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '操作失败';
			}else{
				db('member_orders')->where('id',$oid)->update(['status'=>1]);
				$result['status'] = 1;
				$result['info'] = '操作成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	//用户管理
	public function member(){
		$request = Request::instance();
		$key = trim($request->get('search_key'));
		if(!empty($key)){
			$where = '(uname like "%'.$key.'%" OR utel like "%'.$key.'%") AND is_del = 0';
		}else{
			$where['is_del'] = 0;
		}
		$list = db('member')->where($where)->field('id,uname,utel,sex,birthday,score,createtime')->order('createtime desc')->paginate();
		// 查询累计消费记录
		foreach ($list as $key => &$value) {
			$whereorder['is_del'] = 0;
			$whereorder['uid'] = $value['id'];
			$whereorder['pay'] = 1;
			$queryorder = db('member_orders')->where($whereorder)->field('money')->select();
			$data = $list->all();
			foreach ($data as $key1 => &$value1) {
				if(empty($value1['money'])){
					$value1['money'] = 0;
				}
				foreach ($queryorder as $key2 => $value2) {
					
					$value1['money'] = $value1['money'] + $value2['money'];
				}
			}
			$list[$key] = $data[$key];
		}
		$this->assign('list',$list);
		return $this->fetch('member');
	}

	public function addMember(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
            if(empty($data)){
                $result = makeResult(0,'用户信息不完整');
                return $result;
            }else if(empty($data['upwd'])){
            	$result = makeResult(0,'登录密码不能为空');
                return $result;
            }
            $validate = validate('Member');
            if(!$validate->check($data)){
                $result = makeResult(0,$validate->getError());
                return $result;
            }
            unset($data['cpwd']);
            if(!empty($data['upwd'])){
            	$data['upwd'] = md5($data['upwd']);
            }else{
            	unset($data['upwd']);
            }
            $data['createtime'] = time();
            $add = db('member')->insert($data);
            if(!$add){
            	$result = makeResult(0,'用户信息添加失败');
            }else{
            	$result = makeResult(1,'用户信息添加成功');
            }
            return $result;
		}
		return $this->fetch('add_member');
	}

	public function editMember(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
            if(empty($data)){
                $result = makeResult(0,'用户信息不完整');
                return $result;
            }
            $validate = validate('Member');
            if(!$validate->check($data)){
                $result = makeResult(0,$validate->getError());
                return $result;
            }
            unset($data['cpwd']);
            if(!empty($data['upwd'])){
            	$data['upwd'] = md5($data['upwd']);
            }else{
            	unset($data['upwd']);
            }
            $up = db('member')->update($data);
            if(!$up){
            	$result = makeResult(0,'用户信息编辑失败');
            }else{
            	$result = makeResult(1,'用户信息编辑成功');
            }
            return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = db('member')->where('id',$id)->where('is_del',0)->field('id,uname,utel,sex,birthday,score,shotcut')->find();
		if(!$info){
			$this->error('用户信息不存在');
		}
		$info['birthday'] = $info['birthday']=='0000-00-00' ? date('Y-m-d') : $info['birthday'];
		$this->assign('info',$info);
		return $this->fetch('edit_member');
	}

	public function delMember(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = intval($request->post('del'));
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('member')->where('id',$id)->update(['is_del'=>1]);
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}

	public function delMemberImg(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$url = $request->post('durl');
			if(!$url){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = $this->unuseAttachment($url);
			if($del!==true){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				db('coupon')->where('shotcut',$url)->update(['shotcut'=>'']);
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}
	}

	private function unuseAttachment($url=''){
		$url = str_replace(config('upyun_config.domain'),'',$url);
		if(empty($url)){
			return false;
		}
        $data = db('attachment')->where('url',$url)->where('status',0)->find();
		if(!empty($data)){
            $up = db('attachment')->where('url',$url)->update(['status'=>0]);
            if(!$up){
                return false;
            }
        }
		return true;
	}

	// lzc

	// 快捷编辑
	public function editstore(){
		$post = $this->postdata;
		$Product = Model('Product');
		$editstore = $Product->editstore($post);
		if($editstore){
			make_json(1,'编辑成功');
		}else{
			make_json(0,'编辑失败');
		}
	}

	// 多选删除
	public function alldel(){
		$post = $this->postdata;
		$Product = Model('Product');
		$del = $Product->alldel($post);
		if($del){
			make_json(1,'删除成功');
		}else{
			make_json(0,'删除失败');
		}
	}

	// 多选上下架
	public function alldownup(){
		$post = $this->postdata;
		$Product = Model('Product');
		$downorup = $Product->alldownup($post);
		if($downorup){
			make_json(1,'上下架成功');
		}else{
			make_json(0,'上下架失败');
		}
	}

	// 查询商品
	public function selectshop(){
		$post = $this->postdata;
		$Product = Model('Product');
		$cx = $Product->where('is_del',0)->field('id,name')->select();
		make_json(1,['shopmuen' => $cx]);
	}

	// 查询商品
	public function infoshop(){
		$post = $this->postdata;
		$Product = Model('Product');
		foreach ($post['id'] as $key => $value) {
			$cx = $Product->where('id',$value)->field('id,name')->find();
			$name[]= $cx['name'];
		}
		make_json(1,['shopname' => $name]);
	}

	// 查询人员
	public function selectcaigou(){
		$post = $this->postdata;
		$maa['is_del'] = 0;
		$maa['class'] = $post['pid'];
		$cx = db('buyer')->where($maa)->select();
		make_json(1,['shuju' => $cx]);
	}

	// 积分配置
	public function jifenconfig(){
		$cx = db('jifen')->find();
		if($cx['off'] == 0){
			$cx['off'] = 'true';
		}else{
			$cx['off'] = 'false';
		}
		$post = $this->postdata;
		$get = $this->reqdata;
		if(!empty($post)){
			if($post['stu'] == 'true'){
				$post['off'] = 0;
			}else{
				$post['off'] = 1;
			}
			unset($post['stu']);
			$add = db('jifen')->where('id',1)->update($post);
			if($add){
				make_json(1,'更新成功');
			}else{
				make_json(0,'更新失败');
			}
		}
		$this->assign('info',$cx);
		return $this->fetch();
	}

	// 用户消费
	public function memberxiaofei(){
		$get = $this->reqdata;
		if(!empty($get['time'])){
			$stime = strtotime($get['time']);
			$etime = $get['time'].'23:59';
			$etime = strtotime($etime);
			$where['o.createtime'] = array('between',[$stime,$etime]);
			$this->assign('stime',$get['time']);
		}
		$Orders = Model('Orders');
		$where['m.id'] = $get['id'];
		$where['o.pay'] = 1;
		$field = 'o.id,o.person,o.tel,o.sum,o.money,o.pay,o.orderid,o.createtime,m.uname,o.send,o.receive,o.reject,o.createtime,o.stime,o.address,o.paytime';
		$list = db('member_orders')->alias('o')->join('member m','o.uid = m.id','LEFT')->where($where)->order('o.createtime desc')->field($field)->paginate();
		$this->assign('list',$list);
		$this->assign('id',$get['id']);
		return $this->fetch();
	}

	// 自提点销售表
	public function sinceExcel(){
		$post = $this->postdata;
		if($post['miao'] == '0'){
			$group = $post['time'].'10:30';
		}else{
			$group = $post['time'].'16:30';
		}
        $sjcgroup = strtotime($group);
		$cxsince = db('handtake_place')->where('id','in',$post['id'])->field('name,address')->select();
		foreach ($cxsince as $key => $value) {
			$where['stype'] = 'parcel';
			$where['address'] = $value['address'];
			$where['pay'] = 1;
			$where['reject'] = 0;
			$where['stime'] = $sjcgroup;
			$cxorder = db('member_orders')->where($where)->field('orderid,id,sum,createtime')->select();
			$orderall[] = $cxorder;
		}
		if(!$orderall){
			make_json(0,'没有数据');
			exit();
		}
    	$excel = new Excel();
    	$result = $excel->sincewriter($orderall,$cxsince);
	}

	// 人员配置页面
	public function staffconfig(){
		return $this->fetch();
	}

	// 人员列表
	public function stafflist(){
		$get = $this->reqdata;
		$where['is_del'] = 0;
		$where['class'] = $get['id'];
		$list = db('buyer')->where($where)->field('id,name,tel,ctime,class')->select();
		$this->assign('id',$get['id']);
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 软删除人员
	public function delstaff(){
		$post = $this->postdata;
		$data['is_del'] = 1;
		$del = db('buyer')->where('id',$post['id'])->update($data);
		if($del){
			make_json(1,'删除成功');
		}else{
			make_json(0,'删除失败');
		}
	}

	// 新增人员
	public function addstaff(){
		$request = Request::instance();
		$get = $this->reqdata;
		if($request->isAjax()&&$request->isPost()){
			$post = $request->post();
			if(empty($get['id'])){
				$post = $this->postdata;
				$data['name'] = $post['name'];
				$data['tel'] = $post['tel'];
				$data['ctime'] = time();
				$data['class'] = $post['class'];
				$editoradd = db('buyer')->insert($data);
			}else{
				$data['name'] = $post['name'];
				$data['tel'] = $post['tel'];
				$editoradd = db('buyer')->where('id',$get['id'])->update($data);
			}
			if($editoradd){
				make_json(1,'新增成功');
			}else{
				make_json(0,'新增失败');
			}
		}else{
			if(!empty($get['id'])){
				$info = db('buyer')->where('id',$get['id'])->find();
				$this->assign('id',$get['id']);
				$this->assign('info',$info);
				$this->assign('class',$get['class']);
				return $this->fetch('editstaff');
			}else{
				$this->assign('class',$get['class']);
				return $this->fetch();
			}
		}
	}

	// 确认发货
	public function fahuook(){
		$request = Request::instance();
		$post = $request->post();
		if(empty($post['id'])){
			make_json(0,'请选择自提点');
			return;
		}
		$id = $post['id'];
		if($post['miao'] == '0'){
			$group = $post['time'].'10:30';
		}else{
			$group = $post['time'].'16:30';
		}
		$group = strtotime($group);
        $querycaigou = db('caigou')->where('time',$group)->find();
        if($querycaigou){
        	$update['send'] = 1;
	    	$where['l.id'] = array('in',$id);
	    	$where['o.stime'] = $group;
	    	$where['o.pay'] = 1;
	    	$where['o.send'] = 0;
			$fahuo = db('member_orders o')->join('qgs_handtake_place l','l.address=o.address')->where($where)->update($update);
			unset($where['o.send']);
			if($fahuo){
				$where['o.wxfahuo'] = 0;
				$where['o.send'] = 1;
				$queryorders = db('member_orders o')->join('qgs_handtake_place l','l.address=o.address')->where($where)->field('o.id,o.tel,o.address,o.orderid,o.stime,o.openid')->select();
				$Index = new Index;
				foreach ($queryorders as $key => $value) {
            		$wxorderfahuo = $Index->fahuonotice($value['openid'],$value);
            		$ok = json_decode($wxorderfahuo);
            		if($ok->errmsg == 'ok'){
						$allid[] = $value['id'];
            		}else{
            			\Log::DEBUG("fahuonotify: ".json_encode($value));
            		}
				}
				$gengxin['wxfahuo'] = 1;
				$editwxfahuo = db('member_orders')->where('id','in',$allid)->update($gengxin);
				make_json(1,'发货成功');
			}else{
				make_json(0,'自提点没有订单可发货');
			}
        }else{
        	make_json(0,'您选择的日期还没完成当天采购');
        }
	}

	// 商品推荐
	public function shoptuijian(){
		$list = db('product_tuijian')->order('sort desc')->paginate();
		$this->assign('list',$list);
		return $this->fetch();
	}

	// 添加商品推荐
	public function addshoptuijian(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}
			if(empty($data['title'])){
				$result['status'] = 0;
				$result['info'] = '请填写所需内容';
				return $result;
			}
			/*$validate = validate('Classify');
			if(!$validate->check($data)){
				$result['status'] = 0;
				$result['info'] = $validate->getError();
				return $result;
			}*/
			$data['sort'] = intval($data['sort']);
			$data['createtime'] = time();
			$add = db('product_tuijian')->insert($data);
			if(!$add){
				$result['status'] = 0;
				$result['info'] = '商品推荐添加失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '商品推荐添加成功';
			}
			return $result;
		}else{
			return $this->fetch();
		}
	}

	// 编辑推荐商品
	public function editshoptuijian(){
		$request = Request::instance();
		$classify = db('product_tuijian');
		if($request->isAjax()&&$request->isPost()){
			$data = $request->post();
			if(!$data){
				$result['status'] = 0;
				$result['info'] = '没有提交数据';
				return $result;
			}else if(!$data['id']){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			if(empty($data['title'])){
				$result['status'] = 0;
				$result['info'] = '请填写所需内容';
				return $result;
			}
			$data['sort'] = intval($data['sort']);
			$up = $classify->update($data);
			if(!$up){
				$result['status'] = 0;
				$result['info'] = '商品推荐修改失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '商品推荐修改成功';
			}
			return $result;
		}
		$id = intval($request->param('id'));
		if(!$id){
			$this->error('参数错误');
		}
		$info = $classify->where('id',$id)->find();
		$this->assign('info',$info);
		return $this->fetch();
	}

	// 推荐商品增加
	public function addtuijian(){
		$get = $this->reqdata;
		$where['is_del'] = 0;
		$where['gift'] = 0;
		$cxsince = db('product_tuijian')->where('id',$get['id'])->field('data,title')->find();
		if($cxsince['data']){
			$morenshop = unserialize($cxsince['data']);
			foreach ($morenshop as $key1 => $value1) {
				$newmoren[] = $value1['id'];
 			}
			$list = db('product')->where($where)->where('id','not in',$newmoren)->field('id,shotcut,name,cid,price,sort')->select();
			$array = $list;
	        //创建一个存键值的值得数组
	        $number = array();
	        //创建一个存键值的数组
	        $letter = array();
	        //这个函数是自定义数组排序
			foreach($array as $key=>$val){
            	$number[] = $val['sort'];
        	}
        	array_multisort($number,SORT_DESC,$array);
		}else{
			$array = db('product')->where($where)->field('id,shotcut,name,cid,price')->select();
		}
		$this->assign('name',$cxsince['title']);
		$this->assign('id',$get['id']);
		$this->assign('list',json_encode($array));
		return $this->fetch();
	}

	// 推荐商品修改
	public function edittuijian(){
		$post = $this->postdata;
		$where['id'] = $post['id'];
		if(!empty($post['tianjia'])){
			$data['data'] = serialize($post['tianjia']);
		}else{
			$data['data'] = null;
		}
		$editsince = db('product_tuijian')->where($where)->update($data);
		if($editsince){
			make_json(1,'更新成功');
		}else{
			make_json(0,'更新失败');
		}
	}

	// 已选推荐商品
	public function tuijianmoren(){
		$post = $this->postdata;
		$cxsince = db('product_tuijian')->where('id',$post['id'])->field('data')->find();
		$where['gift'] = 0;
		if($cxsince['data']){
			$morenshop = unserialize($cxsince['data']);
			foreach ($morenshop as $key1 => $value1) {
				$newmoren[] = $value1['id'];
 			}
			$list = db('product')->where($where)->where('id','in',$newmoren)->field('id,shotcut,name,cid,price,createtime,is_del')->select();
			foreach ($list as $key2 => &$value2) {
				foreach ($morenshop as $key3 => $value3) {
					if($value2['id'] == $value3['id']){
						if($value2['is_del'] == 1){
							unset($morenshop[$key3]);
						}else{
							$value2['sort'] = $value3['sort'];
							$value2['rate'] = $value3['rate'];
							$value2['pay'] = $value3['pay'];
							$value2['price'] = $value2['price'];
							$value2['createtime'] = $value2['createtime'];
						}
					}
				}
			}
			$array = $list;
	        $number = array();
			foreach($array as $key=>$val){
            	$number[] = $val['sort'];
        	}
        	array_multisort($number,SORT_DESC,$array);
		}else{
			$array = null;
		}
		make_json(1,['info'=>$array]);
	}

	// 商品推荐删除
	public function deltuijain(){
		$request = Request::instance();
		if($request->isAjax()&&$request->isPost()){
			$id = $request->post('did');
			if(!$id){
				$result['status'] = 0;
				$result['info'] = '参数错误';
				return $result;
			}
			$del = db('product_tuijian')->where('id',$id)->delete();
			if(!$del){
				$result['status'] = 0;
				$result['info'] = '删除失败';
			}else{
				$result['status'] = 1;
				$result['info'] = '删除成功';
			}
			return $result;
		}else{
			$result['status'] = 0;
			$result['info'] = '非法操作';
			return $result;
		}
	}
}