<?php
namespace app\index\controller;

use think\Request,think\Cache;
use app\index\controller\Home;
class Index extends RestBase
{
	public function __construct(){
        //继承父类构造方法
        parent::__construct();
    }

    //获取token
    private function wx_get_token($appid,$secret) {
        $token = Cache::get('access_token');
        if (!$token) {
            $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret);
            $res = json_decode($res, true);
            $token = $res['access_token'];
            // 注意：这里需要将获取到的token缓存起来（或写到数据库中）
            // 不能频繁的访问https://api.weixin.qq.com/cgi-bin/token ，每日有次数限制
            // 通过此接口返回的token的有效期目前为2小时。令牌失效后，JS-SDK也就不能用了。
            // 因此，这里将token值缓存1小时，比2小时小。缓存失效后，再从接口获取新的token，这样
            // 就可以避免token失效。
            $expires = $res['expires_in']-600;
            Cache::set('access_token',$token,$expires);
        }
        return $token;
    }

    //获取jsapi_ticket
    private function wx_get_jsapi_ticket(){
        $ticket = "";
        do{
            $ticket = Cache::get('wx_ticket');
            if (!empty($ticket)) {
                break;
            }
            $token = Cache::get('access_token');
            if (empty($token)){
                $this->wx_get_token();
            }
            $token = Cache::get('access_token');
            if (empty($token)) {
                break;
            }
            $url2 = sprintf("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi",$token);
            $res = file_get_contents($url2);
            $res = json_decode($res, true);
            $ticket = $res['ticket'];
            // 注意：这里需要将获取到的ticket缓存起来（或写到数据库中）
            // ticket和token一样，不能频繁的访问接口来获取，在每次获取后，我们把它保存起来。
            $expires = $res['expires_in']-600;
            Cache::set('wx_ticket',$ticket,$expires);
        }while(0);
        return $ticket;
    }

    //微信js分享
    public function wxShare(){
    	$request = Request::instance();
    	$info = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();

    	$wxtoken = $this->wx_get_token($info['appid'],$info['appsecret']);
        $wxticket = $this->wx_get_jsapi_ticket();

        $timestamp = time();
        $wxnonceStr = md5(time());
        $shareUrl = $request->server('http_referer');
        $wxOri = sprintf("jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s",
                $wxticket, $wxnonceStr, $timestamp,
                $shareUrl
                );
        $wxSha1 = sha1($wxOri);
        $share['appid'] = $info['appid'];
        $share['title'] = $info['share_word'];
        $share['desc'] = $info['share_desc'];
        $share['imgurl'] = $info['share_image'];
        $share['timestamp'] = $timestamp;
        $share['noncestr'] = $wxnonceStr;
        $share['signature'] = $wxSha1;
        return $this->response($share,'json',200);
    }
	
	//首页轮播图和栏目导航
	public function mainInfo(){
		switch($this->method){
			case 'get':
				$banners = db('product_banner')->where('status',1)->field('url,img,title')->order('sort desc,createtime desc')->limit(6)->select();
				/*$columns = db('product_classify')->where('status',1)->field('id,title as name,tag')->order('top desc,sort desc,createtime desc')->select();*/
				$data = [];
				if($banners) $data['banners'] = $banners;
				// if($columns) $data['columns'] = $columns;
				return $this->response($data,'json',200);
				break;
			default:
				break;
		}
	}

	//首页活动、热卖列表和文章
	public function productInfo(){
		switch($this->method){
			case 'get':
				$maincolumns = [
					['id'=>1,'name'=>'限时抢购','type'=>1,'img'=>'http://vue.wogoule.com/photos/banners/mcol1.jpg','url'=>'#','desc'=>'','time'=>120],
					['id'=>2,'name'=>'新品推荐','type'=>0,'img'=>'http://vue.wogoule.com/photos/banners/mcol2.jpg','url'=>'#','desc'=>'Pepperidge Farm 非凡农庄棋人形曲奇饼','time'=>''],
					['id'=>3,'name'=>'热卖产品','type'=>0,'img'=>'http://vue.wogoule.com/photos/banners/mcol3.jpg','url'=>'#','desc'=>'Pepperidge Farm 非凡农庄棋人形曲奇饼','time'=>'']
				];
				$hotproducts = db('product')->where('is_del',0)->where('is_sell',1)->where('store','gt',0)->field('id,name,description as sdesc,price as money,shotcut as img')->order('sale desc,createtime desc')->limit(5)->select();
				$articles = db('product_article')->where('status',1)->field('id,title,short_desc as sdesc,product as proname,price as proprice,visitor as reading,shotcut as img')->order('top desc,createtime desc')->select();
				$data = [];
				if($maincolumns) $data['maincolumns'] = $maincolumns;
				if($hotproducts){
					$data['hotproducts']['title'] = '热销排行榜';
					$data['hotproducts']['list'] = $hotproducts;
				}
				if($articles){
					$data['articles']['title'] = '精选编辑';
					$data['articles']['list'] = $articles;
				}
				return $this->response($data,'json',200);
				break;
			default:
				break;
		}
	}

	//首页栏目列表
	public function columnInfo(){
		$request = Request::instance();
		switch($this->method){
			case 'get':
				$id = intval($request->param('id'));
				$classify = db('product_classify');
				if(!$id){
					$id = $classify->where('status',1)->limit(1)->order('createtime desc')->value('id');
				}
				$img = $classify->where('id',$id)->where('status',1)->field('title as name,shotcut as src')->find();
				//查询正常产品和开启售罄产品
				$list = db('product')->where('(cid = :id AND is_sell = 1 AND is_del = 0 AND store > 0) OR (cid = :id2 AND is_sell = 1 AND is_del = 0 AND store <= 0 AND sold_out = 1)',['id'=>$id,'id2'=>$id])->field('id,name as title,shotcut as src,price')->order('is_top desc,sort desc,createtime desc')->select();
				$data = [];
				if($img) $data['imgmessage'] = $img;
				if($classify){
					$data['grouplist']['title'] = '热卖爆款';
					$data['grouplist']['list'] = $list;
				}
				return $this->response($data,'json',200);
				break;
			default:
				break;
		}
	}

	//分类列表
	public function columns(){
		switch($this->method){
			case 'get':
				$classify = db('product_classify')->where('status',1)->field('id,title as name,shotcut,tag')->order('top desc,sort desc,createtime desc')->select();
				$data = [];
				if($classify) $data['classify'] = $classify;
				return $this->response($data,'json',200);
				break;
			default:
				break;
		}
	}

	//分类下产品列表
	public function classifyList(){
		$request = Request::instance();
		switch($this->method){
			case 'get':
				$id = intval($request->param('cid'));
				$act = trim($request->param('action'));
				$skey = trim($request->param('search'));
				$sql = empty($skey) ? '' : ' AND name like "%'.$skey.'%"';
				$queryclass = db('product_classify')->where('id',$id)->field('shotcut')->find();
				switch($act){
					case 'new':
						/*$list = db('product')->where('(cid = :id AND is_sell = 1 AND is_del = 0 AND store > 0'.$sql.') OR (cid = :id2 AND is_sell = 1 AND is_del = 0 AND store <= 0 AND sold_out = 1'.$sql.')',['id'=>$id,'id2'=>$id])->field('id,name as title,shotcut as src,price,store,shotcut')->order('is_new desc,sort desc,createtime desc')->select();*/
						// lzc
						$order = 'is_new desc,sort desc,createtime desc';
						break;
					case 'price':
						/*$list = db('product')->where('(cid = :id AND is_sell = 1 AND is_del = 0 AND store > 0'.$sql.') OR (cid = :id2 AND is_sell = 1 AND is_del = 0 AND store <= 0 AND sold_out = 1'.$sql.')',['id'=>$id,'id2'=>$id])->field('id,name as title,shotcut as src,price,store,shotcut')->order('price asc,sort desc,createtime desc')->select();*/
						// lzc
						$order = 'price asc,sort desc,createtime desc';
						break;
					default:
						/*$list = db('product')->where('(cid = :id AND is_sell = 1 AND is_del = 0 AND store > 0'.$sql.') OR (cid = :id2 AND is_sell = 1 AND is_del = 0 AND store <= 0 AND sold_out = 1'.$sql.')',['id'=>$id,'id2'=>$id])->field('id,name as title,shotcut as src,price,store,shotcut')->order('is_hot desc,sort desc,createtime desc')->select();*/
						// lzc
						$order = 'is_hot desc,sort desc,createtime desc';
						break;
				}
				$list = db('product')->where('(cid = :id AND is_sell = 1 AND is_del = 0 AND store > 0'.$sql.') OR (cid = :id2 AND is_sell = 1 AND is_del = 0 AND store <= 0 AND sold_out = 1'.$sql.')',['id'=>$id,'id2'=>$id])->field('id,name as title,shotcut as src,price,store,deliverytime')->order($order)->select();
				$nowtime = time();
				foreach ($list as $key => &$value) {
					// lzc-限时抢购
					$querysale = Model('Sale')->query($nowtime,$value['id']);
					$value['sale'] = $saledata;

					// lzc-分享购买商品
					$queryshare = Model('ProductShare')->query($nowtime,$value['id']);
					$value['share'] = $queryshare;

					// lzc-配送时间
					if($value['deliverytime'] == 0){
						$stimedate = date('Y-m-d',$nowtime).'00:00';
						$etimedate = date('Y-m-d',$nowtime).'22:00';
						$stime = strtotime($stimedate);
						$etime = strtotime($etimedate);
						if($nowtime >= $stime && $nowtime <= $etime){
							$ciri = 1;
						}else{
							$ciri = 0;
						}
						$value['peisongok'] = $ciri;
					}else{
						$stimedate = date('Y-m-d',$nowtime).'00:00';
						$stime = strtotime($stimedate);
						$etimedate = date('Y-m-d',$nowtime).'13:00';
						$etime = strtotime($etimedate);
						if($nowtime >= $stime && $nowtime <= $etime){
							$dangtian = 1;
						}else{
							$dangtian = 0;
						}
						$value['peisongok'] = $dangtian;
					}
				}
				$result = makeResult(1,['list' => $list,'img'=>$queryclass['shotcut'],'background' => null]);
				return $this->response($result,'json',200);
				break;
			default:
				break;
		}
	}

	//文章详情
	public function articleDetail(){
		$request = Request::instance();
		switch($this->method){
			case 'get':
				$data = [];
				$id = intval($request->param('cid'));
				if(!$id){
					$data = makeResult(0,'参数错误');
					return $this->response($data,'json',200);
				}
				$info = db('product_article')->where('id',$id)->field('title,content')->find();
				if(!$info){
					$data = makeResult(0,'文章内容不存在');
				}else{
					$info['content'] = empty($info['content']) ? '' : htmlspecialchars_decode($info['content']);
					$data = makeResult(1,'ok',['content'=>$info]);
				}
				return $this->response($data,'json',200);
				break;
			default:
				break;
		}
	}

	//产品详情
	public function productDetail(){
		$request = Request::instance();
		switch($this->method){
			case 'get':
				$data = [];
				$id = intval($request->param('pid'));
				$uid = intval($request->param('uid'));
				if(!$id){
					$data = makeResult(0,'参数错误');
					return $this->response($data,'json',200);
				}
				
				$product = db('product');
				$info = $product->alias('p')->join('product_content c','p.id = c.pid','LEFT')->join('product_addition a','p.id = a.pid','LEFT')->where('p.id',$id)->field('p.id,name,description,price,store,shotcut,is_promote,promote_price,promote_start,promote_end,format,gallery,is_sell,content,notice,commend,sale,virtual_sale,deliverytime,starprice')->find();
				if(!empty($info['content'])) $info['content'] = htmlspecialchars_decode($info['content']);
				if(!empty($info['gallery'])){
					$info['gallery'] = json_decode($info['gallery'],true);
					if(count($info['gallery'])>0){
						foreach($info['gallery'] as $k=>$v){
							$info['gallery'][$k] = [];
							$info['gallery'][$k]['url'] = 'javascript:';
							$info['gallery'][$k]['img'] = $v;
						}
					}
				}
				if(!empty($info['format']))
					$info['format'] = json_decode($info['format'],true);
				if(!empty($info['notice']))
					$info['notice'] = db('product_notice')->where('id','in',$info['notice'])->field('title,sdesc')->select();
				$profile = db('profile')->where('id',1)->field('commend,detail')->find();
				$info['detail'] = htmlspecialchars_decode($profile['detail']);
				if(!empty($info['commend'])){
					$info['commend'] = $product->where('id','in',$info['commend'])->field('id,name as title,shotcut as src,price')->select();
				}else{
					$scom = $profile['commend'];
					if(!empty($scom)){
						$info['commend'] = $product->where('id','in',$scom)->field('id,name as title,shotcut as src,price')->select();
					}
				}
				//获取最新评论
				$info['comments'] = db('product_comments')->alias('c')
														->join('member m','c.uid = m.id','LEFT')
														->where('c.pid',$id)
														->where('c.top',0)
														->where('c.parent',0)
														->where('c.status',1)
														->order('c.createtime desc')
														->field('c.fname,c.stars,c.content,c.imgs,c.createtime,m.uname')
														->limit(3)
														->select();
				if(!empty($info['comments'])){
					foreach($info['comments'] as $k=>$v){
						$info['comments'][$k]['imgs'] = empty($v['imgs']) ? '' : json_decode($v['imgs'],true);
						$info['comments'][$k]['createtime'] = date('Y-m-d',$v['createtime']);
					}
				}else{
					$info['comments'] = [];
				}
				$collect = db('member_collect')->where('uid',$uid)->where('pid',$id)->find();
				$info['collect'] = $collect ? true : false;
				unset($collect);
				$freight = db('product_freight')->where('pid',$id)->order('freight asc')->value('freight');
				$info['freight'] = $freight===false ? 0 : $freight;
				unset($freight);
				
				// 活动时间计算
				$now = date('Y-m-d');
				$nowstime = strtotime($now);
				$nowetime = $nowstime + 86399;
				$nowtime = time();

				// lzc-限时抢购
				$querysale = Model('Sale')->query($nowtime,$id);
				$info['sale'] = $querysale;

				// lzc-分享购买商品
				$queryshare = Model('ProductShare')->query($nowtime,$id);
				$info['share'] = $queryshare;

				// lzc-配送时间
				if($info['deliverytime'] == 0){
					$stimedate = date('Y-m-d',$nowtime).'00:00';
					$etimedate = date('Y-m-d',$nowtime).'23:59';
					$stime = strtotime($stimedate);
					$etime = strtotime($etimedate);
					if($nowtime >= $stime && $nowtime <= $etime){
						$ciri = 1;
					}else{
						$ciri = 0;
					}
					$info['peisongok'] = $ciri;
				}else{
					$stimedate = date('Y-m-d',$nowtime).'00:00';
					$stime = strtotime($stimedate);
					$etimedate = date('Y-m-d',$nowtime).'13:00';
					$etime = strtotime($etimedate);
					if($nowtime >= $stime && $nowtime <= $etime){
						$dangtian = 1;
					}else{
						$dangtian = 0;
					}
					$info['peisongok'] = $dangtian;
				}

				// lzc-商品推荐记录点击量
				if(!empty($request->param('tuijianid'))){
					$tuijianid = $request->param('tuijianid');
					$querytuijian = db('product_tuijian')->where('id',$tuijianid)->find();
					if($querytuijian){
						$datatuijain = unserialize($querytuijian['data']);
						foreach ($datatuijain as $tjkey => &$tjvalue) {
							if($tjvalue['id'] == $id){
								$tjvalue['rate'] = $tjvalue['rate'] + 1;
							}
						}
						$update['data'] = serialize($datatuijain);
						$querytuijian = db('product_tuijian')->where('id',$tuijianid)->update($update);
					}
				}
				
				return $this->response($info,'json',200);
				break;
			default:
				break;
		}
	}

	//查询规格组合价格
	public function propertyPrice(){
		$request = Request::instance();
		switch($this->method){
			case 'get':
				$id = intval($request->param('pid'));
				$val = trim($request->param('val'),',');
				$data = [];
				if(!$id){
					$data = makeResult(0,'参数错误');
					return $this->response($data,'json',200);
				}else if(empty($val)){
					$data = makeResult(0,'未选择规格');
					return $this->response($data,'json',200);
				}
				$info = db('product_formlist')->where('pid',$id)->where('format',$val)->field('price,store')->find();
				if($info){
					$data = makeResult(1,'ok',$info);
					return $this->response($data,'json',200);
				}
				return;
				break;
			default:
				break;
		}
	}

	//评价列表
	public function commentList(){
		$request = Request::instance();
		switch($this->method){
			case 'get':
				$id = intval($request->param('pid'));
				$type = intval($request->param('type'));
				if(!$id){
					$result = makeResult(0,'参数错误');
					return $this->response($result,'json',200);
				}
				$commentDb = db('product_comments');
				$where = ['c.pid'=>$id,'c.top'=>0,'c.parent'=>0,'c.status'=>1];
				switch($type){
					case 1:
						$where['c.stars'] = ['gt',4];
						break;
					case 2:
						$where['c.stars'] = ['between','2,4'];
						break;
					case 3:
						$where['c.stars'] = ['lt',2];
						break;
					default:
						break;
				}
				$list = $commentDb->alias('c')
								->join('member m','c.uid = m.id','LEFT')
								->where($where)
								->order('c.createtime desc')
								->field('c.id,c.fname,c.stars,c.content,c.imgs,c.createtime,m.uname,m.shotcut')
								->select();
				$all = $commentDb->where('pid',$id)->where('top',0)->where('parent',0)->where('status',1)->count();
				$good = $commentDb->where('pid',$id)->where('top',0)->where('parent',0)->where('status',1)->where('stars','gt',4)->count();
				$common = $commentDb->where('pid',$id)->where('top',0)->where('parent',0)->where('status',1)->where('stars','between','2,4')->count();
				$bad = $commentDb->where('pid',$id)->where('top',0)->where('parent',0)->where('status',1)->where('stars','elt',1)->count();
				if(!$list){
					$list = [];
				}else{
					foreach($list as $k=>$v){
						$list[$k]['shotcut'] = empty($v['shotcut']) ? '' : $v['shotcut'];
						$list[$k]['imgs'] = empty($v['imgs']) ? '' : json_decode($v['imgs'],true);
						$list[$k]['createtime'] = date('Y-m-d',$v['createtime']);
						$subs = $commentDb->where('top',$v['id'])->where('pid',$id)->order('parent asc')->column('content');
						if(!$subs){
							$subs = [];
						}
						$list[$k]['subs'] = $subs;
					}
				}
				$result = makeResult(1,'ok',['all'=>$all,'good'=>$good,'common'=>$common,'bad'=>$bad,'list'=>$list]);
				return $this->response($result,'json',200);
				return;
				break;
			default:
				break;
		}
	}

	// 首页请求数组
	public function index(){
		$data = db('indexlayout')->order('id desc')->find();
		$json = unserialize($data['data']);
		$where['is_del'] = 0;
		$where['is_sell'] = 1;
		$where['gift'] = 0;
		foreach ($json as $key => &$value) {
			if($value['type'] == '1' || $value['type'] == '2' || $value['type'] == '3'){
				// 作出首页布局作出更改,所以要验证该字段是否存在,后期可删除这个判断!
				if($value['type'] == '1'){
					$nub = 3;
				}elseif($value['type'] == '2'){
					$nub = 6;
				}elseif($value['type'] == '3'){
					$nub = 9;
				}
				if(!empty($value['leibie'])){
					if($value['leibie'] == 2){
						$tuijian = db('product_tuijian')->where('id',$value['class'])->find();
						$morenshop = unserialize($tuijian['data']);
						if($morenshop){
							foreach ($morenshop as $key1 => $value1) {
								$newmoren[] = $value1['id'];
				 			}
				 			$where['id'] = array('in',$newmoren);
				 			$data = db('product')->where($where)->field('id,name,price,starprice,shotcut,sort')->limit($nub)->select();
				 			// 排序
				 			$number = array();
							foreach($data as $key=>$val){
				            	$number[] = $val['sort'];
				        	}
				        	array_multisort($number,SORT_DESC,$data);
				        	unset($newmoren);
				        	unset($number);
						}else{
							$data = null;
						}
					}else{
						$where['cid'] = $value['class'];
						$data = db('product')->where($where)->order('sort desc')->field('id,name,price,starprice,shotcut')->limit($nub)->select();
					}
				}else{
					$where['cid'] = $value['class'];
					$data = db('product')->where($where)->order('sort desc')->field('id,name,price,starprice,shotcut')->limit($nub)->select();
				}
				if($data){
                    foreach ($data as $key1 => $value1){
                        $tmp['shopid'] = $value1['id'];
                        $tmp['shopname'] = $value1['name'];
                        $tmp['shopprice'] = $value1['price'];
                        $tmp['shopstarprice'] = $value1['starprice'];
                        $tmp['shopshotcut'] = $value1['shotcut'];
                        $value['arr'][] = $tmp;
                    }
				}
			}
		}
		$result = makeResult(1,'ok',['index_data'=>$json]);
		return $this->response($result,'json',200); 
	}
	
	// 自提点关注
    public function sincestar(){
        $request = Request::instance();
        $get = $request->get();
        if(empty($get['openid'])){
            $result = makeResult(0,'参数错误');
            return $this->response($result,'json',200);
        }else{
            $querystar = db('member_sincestar')->where('openid',$get['openid'])->field('sid')->find();
            if(empty($querystar)){
                $data['sid'] = $get['since'];
                $data['openid'] = $get['openid'];
                $data['createtime'] = time();
                $addstar = db('member_sincestar')->insert($data);
                if($addstar){
                    $url = 'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI5OTQ5MjAxOQ==';
                    $result = makeResult(1,'累计自提点关注成功',$url);
                    return $this->response($result,'json',200);
                }
            }else{
                $result = makeResult(1,'已有关注的自提点');
                return $this->response($result,'json',200);
            }
        }
    }

    //检查是否关注公众号
    public function guanzhu(){
        $request = Request::instance();
        $get = $request->get();
        $openid = $get['openid'];
        $info = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();
        $wxtoken = $this->wx_get_token($info['appid'],$info['appsecret']);
        $Home = new Home();
        $result = $Home->get_user_full($openid,$wxtoken);
        if(!empty($result['errcode'])){
	        $this->tokenwarr('guanzhu',$openid);
	    }else{
	        if($result){
	        	// dump($result);
	            if(array_key_exists('subscribe',$result) && $result['subscribe'] != 1){
	                $url = 'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzI5OTQ5MjAxOQ==';
	            	$result = makeResult(0,'请关注',['url'=>$url]);
	                return $this->response($result,'json',200);
	            }else{
	            	$result = makeResult(1,'已关注');
	                return $this->response($result,'json',200);
	            }
	        }
	    }
    }

    // 搜索商品
    public function searchshop(){
    	$request = Request::instance();
        $get = $request->get();
        if(empty($get['shopname'])){
        	$result = makeResult(0,'请输入搜索关键词');
            return $this->response($result,'json',200);
        }
        $where['name'] = ['like','%'.$get['shopname'].'%'];
        $where['is_del'] = 0;
        $where['gift'] = 0;
        $where['is_sell'] = 1;
        $field = 'id,name,price,starprice,shotcut,deliverytime';
        $queryshop = db('product')->where($where)->field($field)->select();
        if($queryshop){
			$result = makeResult(1,['data'=>$queryshop]);
        }else{
        	$result = makeResult(0,'没有搜索到相关商品');
        }
        return $this->response($result,'json',200);
    }

    // 商品推荐
    public function tuijianclass(){
    	$request = Request::instance();
        $get = $request->get();
        $where['id'] = $get['id'];
        $querytuijian = db('product_tuijian')->where($where)->find();
        if($querytuijian){
        	$tuijianshop = unserialize($querytuijian['data']);
        	if($querytuijian['data']){
        		$array = $tuijianshop;
		        //创建一个存键值的值得数组
		        $number = array();
		        //创建一个存键值的数组
		        $letter = array();
		        //这个函数是自定义数组排序
		        if($get['action'] == 'hot'){
		        	foreach($array as $key => $val){
		            	$number[] = $val['pay'];
		        	}
		        	array_multisort($number,SORT_DESC,$array);
		        }elseif($get['action'] == 'new'){
		        	foreach($array as $key => $val){
		            	$number[] = $val['createtime'];
		        	}
		        	array_multisort($number,SORT_ASC,$array);
		        }else{
		        	foreach($array as $key => $val){
		            	$number[] = $val['price'];
		        	}
		        	array_multisort($number,SORT_ASC,$array);
		        }
		        $arraywhere['is_del'] = 0;
		        $arraywhere['is_sell'] = 1;
		        foreach ($array as $key1 => &$value1) {
		        	$arraywhere['id'] = $value1['id'];
		        	$queryproduct = db('product')->where($arraywhere)->field('price,shotcut,name')->find();
		        	$value1['price'] = $queryproduct['price'];
		        	$value1['src'] = $queryproduct['shotcut'];
		        	$value1['title'] = $queryproduct['name'];
		        }
	        	$result = makeResult(1,['list' => $array,'img'=>$querytuijian['shotcut'],'background' => $querytuijian['background']]);
        	}else{
				$result = makeResult(0,['mag' => '没有推荐商品','img' => $querytuijian['shotcut'],'background' => $querytuijian['background']]);
        	}
        }else{
			$result = makeResult(0,'没有这个推荐商品分类');
        }
 		return $this->response($result,'json',200);
    }

    // 获取微信个人资料
    public function get_weixin(){
    	$request = Request::instance();
        $get = $request->get();
        if(!empty($get['openid'])){
        	$weixin = new Home();
        	$weixinconfig = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();
	    	$access_token = $this->wx_get_token($weixinconfig['appid'],$weixinconfig['appsecret']);
	        $result = $weixin->get_user_full($get['openid'],$access_token);
	        if(!empty($result['errcode'])){
	        	$this->tokenwarr('get_weixin',$get['openid']);
	        	if($result['errcode'] == '40001'){
	        		Cache::rm('access_token');
	        		$access_token = $this->wx_get_token($weixinconfig['appid'],$weixinconfig['appsecret']);
	        	}
	        }
	        make_json(1, ['weixindata'=>$result]);
        }else{
        	make_json(0, '没有传入openid');
        }
    }

    // 分享购买
    public function addshare(){
    	$request = Request::instance();
        $get = $request->param();
        $where['uid'] = $get['uid'];
        $where['pid'] = $get['pid'];
        if($get['uid'] || $get['pid']){
        	return make_json(0, '用户id或商品id不存在');
        }
        $edit = db('product_sharelist')->where($where)->field('id')->count();
        if($edit){
        	$data['uid'] = $get['uid'];
        	$data['pid'] = $get['pid'];
        	$data['time'] = time();
        	$add = db('product_sharelist')->insert($data);
        	if($add){
        		make_json(0, '分享成功,请购买!');
        	}
        }else{
        	make_json(0, '您已分享过此商品,请购买!');
        }
    }

    //微信支付成功通知
    public function payoknotice($opid,$order){
    	$info = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();
        $access_token = $this->wx_get_token($info['appid'],$info['appsecret']);
        $field = 'l.name,o.amount';
        $list = db('member_orderlist o')->join('product l','l.id = o.pid')->where('oid',$order['orderid'])->field($field)->select();
        foreach ($list as $key => $value) {
        	$sp[] = $value['name'].'*'.$value['amount']; 
        }
        $sp = implode('\\n',$sp);
        $template=array(
            'touser'=> $opid,
            'template_id'=>"ZO9jMTiiIzHCYZ3_FKJ09mjrpSfvhhHURXfM_0TqiAg",
            'data'=>array(
	            'first'=>array('value'=>urlencode('您好,已成功下单!收到菜品请及时检查,如菜品有任何问题,12小时内请联系我们(020-39007485),谢谢您支持!')),
	            'keyword1'=>array('value'=>urlencode($order['orderid'])),
	            'keyword2'=>array('value'=>urlencode(date('Y-m-d H:i:s',$order['createtime']))),
	            'remark'=>array('value'=>urlencode('联系电话:'.$order['tel'].'\\n取货时间:'.date('Y-m-d H:i:s',$order['stime']).'\\n取货地址:'.$order['address'].'\\n总金额:'.$order['sum'].'\\n实付金额:'.$order['money'].'\\n商品:\\n'.$sp),'color'=>"#CC0000"),
        	));
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $res=curlPost(urldecode($json_template),$url);
        return $res;
        /*'微信昵称:'.$result['nickname'].*/
    }

    //微信发货通知
    public function fahuonotice($opid,$order){
    	$info = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();
        $access_token = $this->wx_get_token($info['appid'],$info['appsecret']);
        $field = 'l.name,o.amount';
        $list = db('member_orderlist o')->join('product l','l.id = o.pid')->where('oid',$order['orderid'])->field($field)->select();
        foreach ($list as $key => $value) {
        	$sp[] = $value['name'].'*'.$value['amount']; 
        }
        $sp = implode('\\n',$sp);
        $template=array(
            'touser'=> $opid,
            'template_id'=>"aVECM-AUR-6cJiNFCoKGUNcAkw_SnOvQBO2zmupjeIM",
            'data'=>array(
	            'first'=>array('value'=>urlencode('您好!您的商品已送达指定地点，请在2小时内提菜，以确保菜品新鲜')),
	            'keyword1'=>array('value'=>urlencode($order['address'])),
	            'keyword2'=>array('value'=>urlencode(substr($order['orderid'],14,6))),
	            'remark'=>array('value'=>urlencode('订单编号:'.$order['orderid'].'\\n取货时间:'.date('Y-m-d H:i:s',$order['stime']).'\\n订单详情:\\n'.$sp.'\\n收到商品后请及时检查，如有任何疑问，请12小时内联系我们')),
        	));
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $res=curlPost(urldecode($json_template),$url);
        return $res;
        /*'微信昵称:'.$result['nickname'].*/
    }

    // 微信退货通知
    public function tuihuonotice($opid,$order){
    	$info = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();
        $access_token = $this->wx_get_token($info['appid'],$info['appsecret']);
        $template=array(
            'touser'=> $opid,
            'template_id'=>"lvMsq8qScORa-NmAE1fe1C7PKCbfjX-6MfQ7bU_f9ic",
            'data'=>array(
	            'first'=>array('value'=>urlencode('绿秧田，提醒您，您有一笔退款成功，请留意。')),
	            'keyword1'=>array('value'=>urlencode($order['orderid'])),
	            'keyword2'=>array('value'=>urlencode($order['money'].'【因为没有订单部分退款，所以一退款就是订单总金额】')),
	            'remark'=>array('value'=>urlencode('如有任何疑问，请联系客服咨询!')),
        	));
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $res=curlPost(urldecode($json_template),$url);
        return $res;
    }

    // 错误token报警给趣果
    public function tokenwarr($functionname,$openid){
    	$info = db('profile')->where('id',1)->field('share_word,share_desc,share_image,appid,appsecret')->find();
        $access_token = $this->wx_get_token($info['appid'],$info['appsecret']);
        $opid = 'os0CqxEfIxSaX9Xqac1aQ640g3q0';
        $template=array(
            'touser'=> $opid,
            'template_id'=>"lvMsq8qScORa-NmAE1fe1C7PKCbfjX-6MfQ7bU_f9ic",
            'data'=>array(
	            'first'=>array('value'=>urlencode('绿秧田，token错误')),
	            'keyword1'=>array('value'=>urlencode('报错方法:'.$functionname)),
	            'keyword2'=>array('value'=>urlencode(date('Y-m-d H:i:s'))),
	            'remark'=>array('value'=>urlencode('问题openid'.$openid)),
        	));
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;
        $res=curlPost(urldecode($json_template),$url);
        return $res;
    }

}
