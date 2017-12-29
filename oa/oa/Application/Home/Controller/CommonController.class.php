<?php
//公共控制器
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
    public function __construct(){
		parent::__construct();
		header("Content-type:text/html;charset=utf-8");
		if(cookie('username')==''){	//验证登录
			redirect('index.php?m=Home&c=Login&a=index',3,'您还没有登录,请登录后再执行此操作,页面跳转中...');
		}
		$this->getHeader();	//获取公共头部
	}
	
	public function index(){
		
	}
	
	public function getHeader(){	//获取公共头部函数
		$db=M('oa_type');
		$header_nav=$db->field('id,name')->where('layerid=1')->order('id asc')->select();	//获取一级栏目
		foreach($header_nav as $key=>$value){
			$header_nav[$key]['sub_nav']=$db->field('id,name,actionurl')->where('isshow=1 and layerid=2 and uid='.$value['id'])->order('id asc')->select();	//获取二级栏目
			foreach($header_nav[$key]['sub_nav'] as $k=>$val){
				$third_nav=$db->field('id,name,actionurl')->where('layerid=3 and uid='.$val['id'])->order('id asc')->select();	//获取三级栏目
				if(!empty($third_nav))
					$header_nav[$key]['sub_nav'][$k]['third_nav']=$third_nav;
			}
		}
		// echo '<pre>';
		// print_r($header_nav);
		// echo '</pre>';
		$this->assign('header_nav', $header_nav);
	}
}