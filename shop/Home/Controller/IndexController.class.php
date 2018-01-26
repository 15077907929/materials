<?php
//	商城首页
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){

		$result_arr['products']=M('cart_product')->field('id,category,name,market_price,price,picture')->select();
		// echo '<pre>';
		// print_r($result_arr);
		// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}