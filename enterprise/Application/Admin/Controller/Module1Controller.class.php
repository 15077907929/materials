<?php
//简介模块控制器
namespace Admin\Controller;
use Think\Controller;
class Module1Controller extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'show':I('get.method');	//请求方式
		$db=M('web_column');	
		switch($method){
			case 'show':				
				$result_arr['data']=$db->field('id,name,keywords,description,content')->where('id='.I('get.id'))->select()[0];
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';				
			break;
		}
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}