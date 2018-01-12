<?php
//后台共公部分控制器
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(cookie('username')==''){	//验证登录
			redirect('index.php?m=Admin&c=Login&a=index',3,'您还没有登录,请登录后再执行此操作,页面跳转中...');
		}
		$db=M('web_column');
		//简介模型
		$common_arr['module1']=$db->field('id,name')->where('module=1 and bigclass=0')->select();
		foreach($common_arr['module1'] as $key=>&$val){
			$val['sub']=$db->field('id,name')->where('module=1 and bigclass='.$val['id'])->select();
		}		
		//文章模型
		$common_arr['module2']=$db->field('id,name')->where('module=2 and bigclass=0')->select();	
		//产品模型
		$common_arr['module3']=$db->field('id,name')->where('module=3 and bigclass=0')->select();		
		//下载模型
		$common_arr['module4']=$db->field('id,name')->where('module=4 and bigclass=0')->select();
		//图片模型
		$common_arr['module5']=$db->field('id,name')->where('module=5 and bigclass=0')->select();		
		//招聘模型
		$common_arr['module6']=$db->field('id,name')->where('module=6 and bigclass=0')->select();		
		//留言模型
		$common_arr['module7']=$db->field('id,name')->where('module=7 and bigclass=0')->select();		
		// echo '<pre>';
		// print_r($common_arr);
		// echo '</pre>';
		$this->assign('common_arr', $common_arr);
	}
}