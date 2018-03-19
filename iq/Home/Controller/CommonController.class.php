<?php
//前台共公部分控制器
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(!cookie('user')){
			$this->redirect('Login/login');
		}
	}
}