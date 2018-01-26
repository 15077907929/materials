<?php
//内容管理控制器
namespace Admin\Controller;
use Think\Controller;
class ContentController extends CommonController{	
	public function index(){
		$this->display();
	}
	
	public function content(){
		$method=(I('get.method')=='')?'content':I('get.method');
		$db=M('cart_infos');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		switch($method){
			case 'content':
				$count=$db->count();	//总记录数
				$result_arr['content']=$db->page($p.',2')->select();
				foreach($result_arr['content'] as $key=>&$val){
					$val['category']=M('cart_menuitem')->field('name')->where('id='.$val['category_id'])->find()['name'];
				}
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