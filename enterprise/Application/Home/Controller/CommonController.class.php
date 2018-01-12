<?php
//共公部分控制器
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		$db=M('web_column');
		$common_arr['nav_search']=$db->field('id,name')->where('(module=2 or module=3 or module=4 or module=5) and class_type=1')->select();	//搜索项
		$common_arr['header_nav']=$db->field('id,name,url')->where('nav=1 or nav=3')->select();	//头部导航
		$common_arr['footer_nav']=$db->field('id,name,url')->where('nav=2 or nav=3')->select();	//底部导航
		$common_arr['right_nav']=$db->field('id,name,url')->where('bigclass='.I('get.class1'))->select();	//右侧二级导航
		foreach($common_arr['right_nav'] as $key=>&$val){	//获取二级导航的子导航
			$val['sub']=$db->field('id,name,url')->where('bigclass='.$val['id'])->select();
		}
		$common_arr['base']=M('web_column')->field('id,name,url')->where('id='.I('get.class1'))->select()[0];
		$common_arr['second']=M('web_column')->field('id,name,url')->where('id='.I('get.class2'))->select()[0];
		$common_arr['third']=M('web_column')->field('id,name,url')->where('id='.I('get.class3'))->select()[0];
		// echo '<pre>';
		// print_r($common_arr['third']);
		// echo '</pre>';
		$this->assign('common_arr', $common_arr);
	}
}