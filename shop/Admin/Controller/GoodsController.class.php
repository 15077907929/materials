<?php
//购物管理控制器
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController{	
	public function index(){
		$this->display();
	}
	
	public function category(){
		$method=(I('get.method')=='')?'category':I('get.method');
		$db=M('cart_category');
		switch($method){
			case 'category':
				$count=$db->count();	//总记录数
				$result_arr['category']=$db->where('pid=0')->select();
				foreach($result_arr['category'] as $key=>&$val){
					$val['sub']=$db->where('pid='.$val['id'])->select();
				}
			end;
		}		
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}
	
	public function info(){
		$method=(I('get.method')=='')?'info':I('get.method');
		$db=M('cart_product');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'info':
				$count=$db->count();	//总记录数
				$result_arr['product']=$db->page($p.',2')->select();
			end;
		}	
		$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
		$result_arr['page']=$Page->show();	// 分页显示输出		
		$this->assign('result_arr',$result_arr);
		$this->display($method);		
	}	
	
	public function orders(){
		$method=(I('get.method')=='')?'orders':I('get.method');
		$db=M('cart_order');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'orders':
				$count=$db->count();	//总记录数
				$result_arr['orders']=$db->page($p.',2')->select();
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
}