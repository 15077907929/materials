<?php
//首页控制器
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController{	
    public function index(){
		$result_arr['index']=M('web_index')->select()[0];	//首页
		$result_arr['news_list']=M('web_news')->field('id,title,updatetime')->select();	//首页新闻
		$result_arr['product_list']=M('web_product')->field('id,title,imgurls,updatetime')->select();	//推荐产品
		$result_arr['link_list']=M('web_link')->field('id,name,logo')->select();	//友情链接
		// echo '<pre>';
		// print_r($result_arr);
		// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
}