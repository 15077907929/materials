<?php
//系统设置控制器
namespace Admin\Controller;
use Think\Controller;
class ConfController extends CommonController{	
	public function index(){
		$this->display();
	}
	
	public function config(){
		$method=(I('get.method')=='')?'config':I('get.method');	
		switch($method){
			case 'config':
			end;
		}	
		$this->assign('result_arr',$result_arr);
		$this->display($method);		
	}	
}