<?php
//菜单管理控制器
namespace Admin\Controller;
use Think\Controller;
class MenuController extends CommonController{	
	public function index(){
		$this->display();
	}
	
	public function mainMenu(){
		$method=(I('get.method')=='')?'mainmenu':I('get.method');
		$db=M('cart_mainmenu');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'mainmenu':
				$count=$db->count();	//总记录数
				$result_arr['mainmenu']=$db->page($p.',2')->select();
			end;
		}	
		$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
		$result_arr['page']=$Page->show();	// 分页显示输出		
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}
	
	public function column(){
		$method=(I('get.method')=='')?'show':I('get.method');
		$db=M('cart_menuitem');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'show':
				$count=$db->count();	//总记录数
				$result_arr['column']=$db->page($p.',2')->select();
			end;
		}	
		$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
		$result_arr['page']=$Page->show();	// 分页显示输出		
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display();		
	}
}