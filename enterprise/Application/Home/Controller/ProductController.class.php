<?php
//产品中心控制器
namespace Home\Controller;
use Think\Controller;
class ProductController extends CommonController{	
    public function product(){
		$db=M('web_product');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页	
		$class_type=I('get.class_type');			
		switch($class_type){
			case 'base':
				$result_arr['product_list']=$db->field('id,title,imgurls,para2,para3,para4')->where('class1='.I('get.class1'))->page($p.',2')->select();
				$count=$db->where('class1='.I('get.class1'))->count();	//总记录数
			break;			
			case 'second':
				$result_arr['product_list']=$db->field('id,title,imgurls,para2,para3,para4')->where('class1='.I('get.class1').' and class2='.I('get.class2'))->page($p.',2')->select();
				$count=$db->where('class1='.I('get.class1').' and class2='.I('get.class2'))->count();	//总记录数
			break;
			case 'third':
				$result_arr['product_list']=$db->field('id,title,imgurls,para2,para3,para4')->where('class1='.I('get.class1').' and class2='.I('get.class2').' and class3='.I('get.class3'))->page($p.',2')->select();
				$count=$db->where('class1='.I('get.class1').' and class2='.I('get.class2').' and class3='.I('get.class3'))->count();	//总记录数
			break;
		}
		$Page=new \Think\Page($count,2);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
		$result_arr['page']=$Page->show();	// 分页显示输出
		$result_arr['product_para']=M('web_parameter')->field('id,name,mark')->where('type=3 and use_ok=1')->select();
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display('product');
	}
}