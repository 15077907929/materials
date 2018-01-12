<?php
//基本配置-参数配置控制器
namespace Admin\Controller;
use Think\Controller;
class ParameterController extends CommonController{	
	public function index(){	
		$type=(I('get.type')=='')?'show':I('get.type');	//请求方式
		$db=M('web_parameter');	
		switch($type){
			case 'product':				
				$result_arr['para']=$db->where('type=3')->order('no_order asc')->select();
			break;			
			case 'download':				
				$result_arr['para']=$db->where('type=4')->order('no_order asc')->select();
			break;			
			case 'img':				
				$result_arr['para']=$db->where('type=5')->order('no_order asc')->select();
			break;
		}
		foreach($result_arr['para'] as $key=>&$val){
			if($val['maxsize']==0){
				$val['maxsize']='不限';
			}			
			if($val['use_ok']==0){
				$val['use_ok']='checked';
			}
		}
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}