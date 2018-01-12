<?php
//基本配置-热门标签控制器
namespace Admin\Controller;
use Think\Controller;
class StrContentController extends CommonController{	
	public function index(){	
		$method=(I('get.method')=='')?'show':I('get.method');	//请求方式
		$db=M('web_label');	
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		$count=$db->count();	//总记录数		
		switch($method){
			case 'show':				
				$result_arr['str']=$db->page($p.',2')->select();
				$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
				$result_arr['page']=$Page->show();	// 分页显示输出
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';				
			break;
		}
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}