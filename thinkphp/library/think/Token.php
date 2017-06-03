<?php
//系统token类

namespace think;

class Token{
	//要检查的token
	private $checkStr = '';
	//传入检查的数组
	private $dataArr = [];
	//字段限制
	private $checkArr = ['id','utel','upwd'];

	public function __construct($arr=[],$str=''){
		$this->checkStr = $str;
		$this->dataArr = $arr;
	}

	private function checkArr(){
		if(!is_array($this->dataArr)||count($this->dataArr)<count($this->checkArr)){
			return false;
		}
		$check = true;
		foreach($this->dataArr as $k=>$v){
			if(!in_array($k,$this->checkArr)){
				$check = false;
				break;
			}
			$this->dataArr[$k] = strip_tags(trim($v));
		}
		return $check;
	}

	public function changeData($key='',$val=''){
		if(empty($key)||empty($val)){
			return false;
		}
		if(isset($this->dataArr[$key])){
			$this->dataArr[$key] = $val;
		}
		return false;
	}

	public function makeToken(){
		if(!$this->checkArr()){
			return false;
		}
		$sortArr = ['id'=>$this->dataArr['id'],'utel'=>$this->dataArr['utel'],'upwd'=>$this->dataArr['upwd']];
		$link = implode('*',$sortArr);
		if(empty($link)){
			return false;
		}
		return md5($link);
	}

	public function checkToken(){
		$make = $this->makeToken();
		if(!$make||empty($this->checkStr)){
			return false;
		}
		return $make===$this->checkStr ? true : false;
	}

}