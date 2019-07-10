<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class PhotoController extends Controller {
	public function ajax_addhit(){
        M('imgs')->where('id='.$_GET['id'])->setInc('hits',1);
	}
	
  	public function view(){
		$res['current_nav']='index';
		$db=M('imgs');
		
		$res['total'] = $db->where('album='.$_GET['album'])->count();// 查询满足要求的总记录数
		$res['info']=M('albums')->where('id='.$_GET['album'])->find();
		$res['imgs'] = $db->where('album='.$_GET['album'])->select();
		
		C('site_title',C('site_title').' - 查看图片');
		
		$this->assign('res',$res);
		$this->display();	
	}	
}