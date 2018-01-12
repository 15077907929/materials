<?php
//基本配置-基本信息控制器
namespace Admin\Controller;
use Think\Controller;
class SEOController extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'show':I('get.method');	//请求方式
		$db=M('web_admin_table');	
		switch($method){
			case 'show':				
				$result_arr['users']=$db->field('id')->select();
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';				
			break;
		}
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}