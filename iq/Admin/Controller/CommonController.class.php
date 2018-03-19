<?php
//后台共公部分控制器
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(!cookie('admin_name') || !cookie('admin_id')){
			$this->redirect('Login/login');
		}
	}
	public function top(){
		$common_arr['categories']=M('categories')->where('class_type=1 and status=1')->select();
		$this->assign('common_arr',$common_arr);
		$this->display('Public/top');	
	}	
	public function left(){
		if($_GET['id']!=''){
			$common_arr['categories']=M('categories')->where('class_type=2 and status=1 and bigclass='.$_GET['id'])->select();
			foreach($common_arr['categories'] as $key=>&$val){
				$val['sub']=M('categories')->where('class_type=3 and status=1 and bigclass='.$val['id'])->select();
			}
		}
		$common_arr['id']=$_GET['id'];
		$this->assign('common_arr',$common_arr);
		$this->display('Public/left');	
	}	
	public function left_switch(){
		$this->display('Public/left_switch');	
	}	
	public function bottom(){
		$this->display('Public/bottom');	
	}	
}