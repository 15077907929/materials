<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		$admin=cookie('admin');
		if($admin!=''){
			redirect('index.php?m=Home&c=Index&a=index');
		}
		$this->display();	
	} 

	public function loginIn(){
		$db=M('admin');      
		$admin=$db->where('username=\''.$_POST['username'].'\' and password=\''.md5($_POST['password']).'\'')->find();
		if(!$admin){
			$res=[
				'code'=>0,
				'msg'=>'密码错误',
				'url'=>'',
				'wait'=>3
			];			
		}else{
			cookie('admin',$admin);
			$res=[
				'code'=>1,
				'msg'=>'登录成功',
				'url'=>'index.php?m=Home&c=Index&a=index',
				'wait'=>3
			];
		}	
		echo json_encode($res);
	}
	
	public function logout(){
		cookie('admin',null);
		cookie('flag',2);	//成功退出
		redirect('index.php?m=Home&c=Login&a=login');
	}
}