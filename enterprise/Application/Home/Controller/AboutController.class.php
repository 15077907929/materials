<?php
//关于我们控制器
namespace Home\Controller;
use Think\Controller;
class AboutController extends CommonController{	
    public function about(){
		$class_type=I('get.class_type');
		switch($class_type){
			case 'base':
				$result_arr['about']=M('web_column')->field('id,name,content,url')->where('id='.I('get.class1'))->select()[0];
			break;			
			case 'second':
				$result_arr['about']=M('web_column')->field('id,name,content,url')->where('id='.I('get.class2'))->select()[0];
			break;
		}
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display('about');
	}
}