<?php
//数据库管理控制器
namespace Admin\Controller;
use Think\Controller;
class DatabaseController extends CommonController{	
	public function index(){
		$this->display();
	}
	
	public function backup(){
		$method=(I('get.method')=='')?'backup':I('get.method');
		switch($method){
			case 'backup':

			end;
		}		
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}	
}