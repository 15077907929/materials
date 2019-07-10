<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
use Admin\Model\AlbumsModel;
class IndexController extends Controller {
    public function index(){
		$res['current_nav']='index';
		$db=M('albums');
		$db2=M('imgs');
		
		$res['total']      = $db->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['albums'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach($res['albums'] as $key=>$val){
			$cover=AlbumsModel::get_cover($val['id'],$val['cover']);
			$res['albums'][$key]['cover'] = $cover?'Uploads/'.mkImgLink($cover['dir'],$cover['pickey'],$cover['ext'],'thumb'):'Public/images/nopic.jpg';
		}
		// echo '<pre>';
		// print_r($res);
		// echo '</pre>';
		C('site_title',C('site_title').' - 相册列表');
		$this->assign('res',$res);
		$this->display();
	}
	
	public function newphotos(){
		$res['current_nav']='newphotos';
		$db=M('imgs');
		
		$res['total']      = $db->order('create_time desc')->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['imgs'] = $db->order('create_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		// print_r($res);
		$this->assign('res',$res);
		$this->display();
	}	
	
	public function hotphotos(){
		$res['current_nav']='hotphotos';
		$db=M('imgs');
		
		$res['total']      = $db->order('hits desc')->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['imgs'] = $db->order('hits desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		// print_r($res);
		$this->assign('res',$res);
		$this->display();
	}
}