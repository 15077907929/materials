<?php
//	公共控制器
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		$common_arr['cart_category']=M('cart_category')->field('id,name')->where('pid=0')->select();
		foreach($common_arr['cart_category'] as $key=>&$val){
			$val['sub']=M('cart_category')->field('id,name')->where('pid='.$val['id'])->select();
		}		
		$this->assign('common_arr', $common_arr);
	}  
}