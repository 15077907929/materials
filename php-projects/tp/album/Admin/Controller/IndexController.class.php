<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		$res['current_nav']='all';
		$db=M('imgs');
		
		$res['total_num']      = $db->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['imgs'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
		
		
		$this->assign('res',$res);
		$this->display();
	}    
	
	public function album(){
		$res['current_nav']='album';
		$db=M('albums');
		
		$res['total_num']      = $db->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['albums'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
		
		
		$this->assign('res',$res);
		$this->display();
	}
}