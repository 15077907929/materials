<?php
//系统管理控制器
namespace Admin\Controller;
use Think\Controller;
class SystemController extends CommonController{	
	public function index(){
		$this->display();
	}
	
	public function user(){
		$method=(I('get.method')=='')?'show':I('get.method');
		$db=M('cart_users');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'show':
				$count=$db->count();	//总记录数
				$result_arr['user']=$db->page($p.',2')->select();
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
	
	public function role(){
		$method=(I('get.method')=='')?'show':I('get.method');
		$db=M('cart_role');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'show':
				$count=$db->count();	//总记录数
				$result_arr['role']=$db->page($p.',2')->select();
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
	
	public function menu(){
		$method=(I('get.method')=='')?'menu':I('get.method');
		$db=M('cart_menu');
		switch($method){
			case 'menu':
				$result_arr['menu']=$db->where('pid=0')->select();
				foreach($result_arr['menu'] as $key=>&$val){
					$val['sub']=$db->where('pid='.$val['id'])->select();
				}
			end;
		}		
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}
}