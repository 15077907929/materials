<?php
//基本配置-静态页面生成控制器
namespace Admin\Controller;
use Think\Controller;
class HtmlController extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'show':I('get.method');	//请求方式
		$db=M('web_admin_table');	
		switch($method){
			case 'show':				
				$this->error('静态页面功能尚未开启');				
			break;
		}
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}