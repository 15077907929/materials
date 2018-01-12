<?php
//新闻中心控制器
namespace Home\Controller;
use Think\Controller;
class NewsController extends CommonController{	
    public function news(){
		$db=M('web_news');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		$class_type=I('get.class_type');		
		switch($class_type){
			case 'base':
				$result_arr['news_list']=$db->field('id,title,hits,updatetime')->where('class1='.I('get.class1'))->page($p.',2')->select();
				$count=$db->where('class1='.I('get.class1'))->count();	//总记录数
			break;			
			case 'second':
				$result_arr['news_list']=$db->field('id,title,hits,updatetime')->where('class1='.I('get.class1').' and class2='.I('get.class2'))->page($p.',2')->select();
				$count=$db->where('class1='.I('get.class1').' and class2='.I('get.class2'))->count();	//总记录数
			break;
		}
		$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
		$result_arr['page']=$Page->show();	// 分页显示输出
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display('news');
	}
}