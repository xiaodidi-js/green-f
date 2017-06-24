<?php

namespace app\admin\controller;
use think\Controller,think\Request;

class Autoreply extends Base{
	public function replylist(){
		return $this->fetch();
	}
}
