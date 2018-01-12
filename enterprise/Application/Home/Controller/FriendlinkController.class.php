<?php
//图片中心控制器
namespace Home\Controller;
use Think\Controller;
class FriendlinkController extends CommonController{	
    public function friendlink(){
		$db=M('web_link');
		$class_type=I('get.class_type');			
		switch($class_type){
			case 'base':
				$result_arr['link_img']=M('web_link')->field('id,name,url,logo')->where('type=0')->select();
				$result_arr['link_text']=M('web_link')->field('id,name,url')->where('type=1')->select();
			break;			
		}
				// echo '<pre>';
				// print_r($result_arr);
				// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display('friendlink');
	}
}