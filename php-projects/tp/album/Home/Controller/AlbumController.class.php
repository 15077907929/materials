<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class AlbumController extends Controller {
  	public function photos(){
		$res['current_nav']='index';
		$db=M('imgs');
		
		$album=$_GET['album'];
        $page=$_GET['page'];
        if(!$page){
            $page = 1;
        }
		
		$res['info']=M('albums')->where('id='.$_GET['album'])->find();
		
		C('site_title',C('site_title').' - '.$res['info']['name']);
		
		$res['total']      = $db->where('album='.$album)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['imgs'] = $db->where('album='.$album)->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('res',$res);
		$this->display();	
	}	
}