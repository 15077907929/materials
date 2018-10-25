<?php
//后台共公部分控制器
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();
		if(!cookie('user_name') || !cookie('id')){
			$this->redirect('Login/login');
		}
		//获取所有小程序
		$apps=M('wechat_app')->select();
		$this->assign('apps',$apps);
	}	
	
	public function uploadImg(){
		$ext=explode('/',$_FILES['upfile']['type'])[1];
		$filename=date('His').rand(100,999).'.'.$ext;
		$dir='/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		if(move_uploaded_file($_FILES['upfile']['tmp_name'],$dir.$filename)){
			$data=json_encode(['msg'=>'ok','status'=>1,'src'=>'uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename]);
		}else{
			$data=json_encode(['msg'=>'upload failed','status'=>0]);
		}
		echo $data;
	}	
	
	public function uploadAttachment(){
		$ext=explode('.',$_FILES['upfile2']['name'])[1];
		$filename=date('His').rand(100,999).'.'.$ext;
		$dir='/opt/data/web/news/admin/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/';
		if(!file_exists($dir)){
			mkdir($dir);
		}
		if(move_uploaded_file($_FILES['upfile2']['tmp_name'],$dir.$filename)){
			$data=json_encode(['msg'=>'ok','status'=>1,'src'=>'uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$filename]);
		}else{
			$data=json_encode(['msg'=>'upload failed','status'=>0]);
		}
		echo $data;
	}
}