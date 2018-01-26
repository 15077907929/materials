<?php
//后台共公部分控制器
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(cookie('username')==''){	//验证登录
			redirect('index.php?m=Admin&c=Login&a=login',3,'您还没有登录,请登录后再执行此操作,页面跳转中...');
		}	
		$common_arr['menu']=M('cart_menu')->where('pid=0')->select();
		foreach($common_arr['menu'] as $key=>&$val){
			$val['sub']=M('cart_menu')->where('pid='.$val['id'])->select();
		}
		$common_arr['sub_menu']=M('cart_menu')->where('pid='.I('get.menuid'))->select();
		$this->assign('common_arr', $common_arr);
		
		// echo '<pre>';
		// print_r($common_arr);
		// echo '</pre>';
	}
}