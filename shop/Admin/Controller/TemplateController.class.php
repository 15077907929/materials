<?php
//模板管理控制器
namespace Admin\Controller;
use Think\Controller;
class TemplateController extends CommonController{	
	public function index(){
		$this->display();
	}
	
	public function template(){
		$method=(I('get.method')=='')?'template':I('get.method');
		$db=M('cart_templates');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'template':
				$count=$db->count();	//总记录数
				$result_arr['template']=$db->page($p.',2')->select();
			end;
		}	
		$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
		$result_arr['page']=$Page->show();	// 分页显示输出		
		$this->assign('result_arr',$result_arr);
		$this->display($method);		
	}	
	
	public function modules(){
		$method=(I('get.method')=='')?'modules':I('get.method');
		$db=M('cart_modules');
		switch($method){
			case 'modules':
				$count=$db->count();	//总记录数
				$result_arr['modules']=$db->where('pid=0')->select();
				foreach($result_arr['modules'] as $key=>&$val){
					$val['sub']=$db->where('pid='.$val['id'])->select();
				}
			end;
		}		
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}
}